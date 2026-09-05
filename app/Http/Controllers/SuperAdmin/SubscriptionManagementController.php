<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SubscriptionManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || !in_array($user->role, ['super_admin', 'superadmin'])) {
                abort(403, 'Unauthorized access to Subscription Management.');
            }
            return $next($request);
        });
    }

    /**
     * Display all plan purchase requests with filter tabs
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $query = Subscription::with(['user', 'plan', 'approver'])->latest();

        // Update auto-expired records
        if (Schema::hasTable('subscriptions')) {
            Subscription::where('subscription_status', 'active')
                ->whereNotNull('expiry_date')
                ->where('expiry_date', '<', Carbon::today()->toDateString())
                ->update(['subscription_status' => 'expired']);
        }

        // Apply status filter
        if ($status === 'pending') {
            $query->where('payment_status', 'pending');
        } elseif ($status === 'active') {
            $query->where('subscription_status', 'active')
                  ->where('payment_status', 'approved')
                  ->where('expiry_date', '>=', Carbon::today()->toDateString());
        } elseif ($status === 'expired') {
            $query->where('subscription_status', 'expired')
                  ->orWhere(function ($q) {
                      $q->where('payment_status', 'approved')
                        ->where('expiry_date', '<', Carbon::today()->toDateString());
                  });
        } elseif ($status === 'rejected') {
            $query->where('payment_status', 'rejected');
        }

        // Apply search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhere('plan_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $subscriptions = $query->paginate(15)->withQueryString();

        // Count metrics for tabs
        $counts = [
            'all' => Subscription::count(),
            'pending' => Subscription::where('payment_status', 'pending')->count(),
            'active' => Subscription::where('subscription_status', 'active')->where('expiry_date', '>=', Carbon::today()->toDateString())->count(),
            'expired' => Subscription::where('subscription_status', 'expired')->orWhere(function ($q) {
                $q->where('payment_status', 'approved')->where('expiry_date', '<', Carbon::today()->toDateString());
            })->count(),
            'rejected' => Subscription::where('payment_status', 'rejected')->count(),
        ];

        return view('superadmin.subscriptions.index', compact('subscriptions', 'counts', 'status', 'search'));
    }

    /**
     * Approve a payment and activate subscription with auto-computed expiry date
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'admin_notes' => 'nullable|string',
        ]);

        $subscription = Subscription::with('user')->findOrFail($id);

        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::today()->startOfDay();

        // Calculate expiry date based on plan duration
        $durationMonths = (int) $subscription->duration_months;
        if ($durationMonths === 1) {
            $expiryDate = (clone $startDate)->addMonth();
        } elseif ($durationMonths === 6) {
            $expiryDate = (clone $startDate)->addMonths(6);
        } elseif ($durationMonths === 12) {
            $expiryDate = (clone $startDate)->addMonths(12);
        } else {
            $expiryDate = (clone $startDate)->addMonths($durationMonths ?: 1);
        }

        // Update subscription record
        $subscription->update([
            'payment_status' => 'approved',
            'subscription_status' => 'active',
            'start_date' => $startDate->toDateString(),
            'expiry_date' => $expiryDate->toDateString(),
            'admin_notes' => $request->admin_notes,
            'action_by' => auth()->id(),
            'action_at' => Carbon::now(),
        ]);

        // Update user record
        if ($subscription->user) {
            $subscription->user->update([
                'plan_id' => $subscription->plan_id,
                'plan_status' => 'active',
                'plan_expires_at' => $expiryDate->toDateString(),
            ]);
        }

        return redirect()->back()->with('success', "Subscription for {$subscription->user->name} approved successfully! Active until {$expiryDate->format('d/m/Y')}.");
    }

    /**
     * Reject a payment request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ], [
            'admin_notes.required' => 'Please provide a reason for rejecting this payment request.',
        ]);

        $subscription = Subscription::with('user')->findOrFail($id);

        $subscription->update([
            'payment_status' => 'rejected',
            'subscription_status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'action_by' => auth()->id(),
            'action_at' => Carbon::now(),
        ]);

        // If user has no active subscription, set status to inactive/rejected
        if ($subscription->user) {
            $hasOtherActive = Subscription::where('user_id', $subscription->user_id)
                ->where('subscription_status', 'active')
                ->where('id', '!=', $id)
                ->where('expiry_date', '>=', Carbon::today()->toDateString())
                ->exists();

            if (!$hasOtherActive) {
                $subscription->user->update([
                    'plan_status' => 'rejected',
                ]);
            }
        }

        return redirect()->back()->with('success', "Payment request #{$id} rejected.");
    }
}

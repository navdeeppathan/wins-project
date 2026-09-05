<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SubscriptionController extends Controller
{
    /**
     * Show subscription plans, current status and payment history
     */
    public function index()
    {
        $user = auth()->user();

        // Target user (if staff, look up parent admin)
        $targetUserId = ($user->parent_id && in_array($user->role, ['staff', 'employee', 'user'])) ? $user->parent_id : $user->id;
        $targetUser = User::find($targetUserId) ?? $user;

        // Fetch active plans from DB or use defaults
        $plans = collect([]);
        if (Schema::hasTable('plans') && Plan::count() > 0) {
            $plans = Plan::where('is_active', true)->orderBy('sort_order')->get();
        }

        if ($plans->isEmpty()) {
            $plans = collect(Plan::defaultPlans())->map(function ($item) {
                return (object) $item;
            });
        }

        // Active subscription
        $activeSubscription = null;
        if (Schema::hasTable('subscriptions')) {
            $activeSubscription = $targetUser->activeSubscription();
        }

        // Pending subscription
        $pendingSubscription = null;
        if (Schema::hasTable('subscriptions')) {
            $pendingSubscription = Subscription::where('user_id', $targetUserId)
                ->where('payment_status', 'pending')
                ->latest()
                ->first();
        }

        // Subscription history
        $history = collect([]);
        if (Schema::hasTable('subscriptions')) {
            $history = Subscription::where('user_id', $targetUserId)
                ->latest()
                ->paginate(10);
        }

        return view('admin.subscription.index', compact('plans', 'activeSubscription', 'pendingSubscription', 'history', 'targetUser'));
    }

    /**
     * Submit payment proof for plan purchase
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_slug' => 'required|string',
            'transaction_number' => 'required|string|max:191',
            'reference_number' => 'required|string|max:191',
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg,webp,pdf|max:6144',
        ], [
            'plan_slug.required' => 'Please select a subscription plan.',
            'transaction_number.required' => 'Please provide the UPI Transaction ID / UTR Number.',
            'reference_number.required' => 'Please provide the Reference / Order Number.',
            'payment_screenshot.required' => 'Please upload a screenshot of your completed payment.',
            'payment_screenshot.max' => 'The payment screenshot must not exceed 6MB.',
        ]);

        $user = auth()->user();
        $targetUserId = ($user->parent_id && in_array($user->role, ['staff', 'employee', 'user'])) ? $user->parent_id : $user->id;

        // Resolve plan
        $planSlug = $request->input('plan_slug');
        $planModel = null;
        if (Schema::hasTable('plans')) {
            $planModel = Plan::where('slug', $planSlug)->first();
        }

        if ($planModel) {
            $planId = $planModel->id;
            $planName = $planModel->name;
            $durationMonths = $planModel->duration_months;
            $amount = $planModel->total_price;
        } else {
            // Default plan matching
            $defaultPlans = collect(Plan::defaultPlans())->keyBy('slug');
            $selected = $defaultPlans->get($planSlug, $defaultPlans->get('yearly'));

            $planId = null;
            $planName = $selected['name'];
            $durationMonths = $selected['duration_months'];
            $amount = $selected['total_price'];
        }

        // Handle screenshot upload
        $screenshotPath = '';
        if ($request->hasFile('payment_screenshot')) {
            $file = $request->file('payment_screenshot');
            $filename = 'pay_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/subscriptions');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $screenshotPath = 'uploads/subscriptions/' . $filename;
        }

        // Save subscription request
        $subscription = Subscription::create([
            'user_id' => $targetUserId,
            'plan_id' => $planId,
            'plan_name' => $planName,
            'duration_months' => $durationMonths,
            'amount' => $amount,
            'transaction_number' => $request->transaction_number,
            'reference_number' => $request->reference_number,
            'payment_screenshot' => $screenshotPath,
            'payment_status' => 'pending',
            'subscription_status' => 'pending',
        ]);

        // Update user plan status
        User::where('id', $targetUserId)->update([
            'plan_status' => 'pending',
        ]);

        return redirect()->route('subscription.index')
            ->with('success', 'Your payment proof has been submitted successfully! Super Admin will verify your transaction and activate your plan shortly.');
    }
}

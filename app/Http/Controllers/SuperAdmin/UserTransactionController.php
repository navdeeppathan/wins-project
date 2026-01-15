<?php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserTransaction;
use Illuminate\Http\Request;

class UserTransactionController extends Controller
{
    public function index(User $user)
    {
        $transactions = UserTransaction::where('user_id', $user->id)->latest()->get();
        return view('superadmin.users.transactions', compact('user', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id.*'           => 'required|exists:users,id',
            'amount.*'            => 'required|numeric|min:0',
            'transaction_date.*'  => 'required|date',
            'expiry_date.*'       => 'nullable|date|after_or_equal:transaction_date.*',
            'transaction_number.*' => 'nullable|string',
        ]);

        foreach ($request->amount as $index => $amount) {
            UserTransaction::create([
                'user_id'           => $request->user_id[$index],
                'amount'            => $amount,
                'transaction_type'  => 'manual',
                'transaction_number'=> $request->transaction_number[$index] ?? null,
                'transaction_date'  => $request->transaction_date[$index],
                'expiry_date'       => $request->expiry_date[$index] ?? null,
                'note'              => $request->note[$index] ?? null,
                'created_by'        => auth()->id(),
            ]);
        }

        return back()->with('success', 'Transaction(s) added successfully.');
    }
}

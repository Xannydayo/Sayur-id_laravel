<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.balance', compact('user'));
    }

    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->balance += $request->amount;
        $user->save();

        return redirect()->back()->with('success', 'Balance has been topped up successfully');
    }

    public function useBalance(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        
        if ($user->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance');
        }

        $user->balance -= $request->amount;
        $user->save();

        return back()->with('success', 'Balance has been deducted successfully');
    }
} 
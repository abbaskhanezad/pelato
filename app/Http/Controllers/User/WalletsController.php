<?php

namespace App\Http\Controllers\User;

use App\Wallet;
use App\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletsController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $sum_wallet_money = WalletLog::where('user_id', $user_id)->where('method_create', WalletLog::MONEY)->sum('price');
        $sum_wallet_point = WalletLog::where('user_id', $user_id)->where('method_create', WalletLog::POINT)->sum('price');
        $sum_wallet_increment = WalletLog::where('user_id', $user_id)->where('wallet_operation', WalletLog::INCREMENT)->sum('price');
        $sum_wallet_decrement = WalletLog::where('user_id', $user_id)->where('wallet_operation', WalletLog::DECREMENT)->sum('price');
        $sum_wallet = $sum_wallet_increment - $sum_wallet_decrement;


        //put data in wallet table and if exist , update data
        $wallet_user = Wallet::where('wallet_user_id',$user_id)->first();
        if(is_null($wallet_user)){
            Wallet::create([
                'wallet_user_id' =>$user_id,
                'wallet_sum' =>$sum_wallet,
            ]);
        }else{
            $wallet_user->update([
                'wallet_sum' =>$sum_wallet,
            ]);
        }

        return view('users.wallets.sumWallet', compact('sum_wallet', 'sum_wallet_decrement', 'sum_wallet_increment', 'sum_wallet_money', 'sum_wallet_point'));

    }
}

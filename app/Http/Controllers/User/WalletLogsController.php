<?php

namespace App\Http\Controllers\User;

use App\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletLogsController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $walletLogs = WalletLog::where('user_id',$user_id)->get();
        $walletOperations = WalletLog::getWalletOperation();
        $methodsCreateWallet = WalletLog::getMethodWalletCreate();
        return view('users.wallets.walletLogs.index',compact('walletLogs','methodsCreateWallet','walletOperations'));
    }
}

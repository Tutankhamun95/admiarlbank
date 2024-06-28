<?php

namespace App\Http\Services;

use App\Http\Controllers\TransactionController;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TransactionService
{
    protected $request;
    protected $transaction;
    protected $accountRequest;
    protected $account;


    public function __construct(Request $request, Transaction $transaction, AccountRequest $accountRequest, Account $account)
    {
        $this->request = $request;
        $this->transaction = $transaction;
        $this->accountRequest = $accountRequest;
        $this->account = $account;
    }

    public function transactions()
    {
        // dd($this->userId());
        $transactions = $this->transaction::where('from_account_id', $this->accountNumber())->get();
        return Inertia::render('Transactions', [
            'transactions' => $transactions
        ]);
    }

    public function accountNumber()
    {
        $account = $this->getUserAccount();
        return $account ? $account->id : null;
    }

    private function getUserAccount()
    {
        return $this->account::where('user_id', $this->userId())->first();
    }

    private function userId()
    {
        return $this->accountRequest->user()->id;
    }
}

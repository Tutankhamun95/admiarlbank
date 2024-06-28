<?php

namespace App\Http\Services;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TestRequest;
use App\Http\Requests\TransferRequest;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AccountService
{
    protected $account;
    protected $accountRequest;
    protected $transaction;


    public function __construct(Account $account, AccountRequest $accountRequest, Transaction $transaction)
    {
        $this->account = $account;
        $this->accountRequest = $accountRequest;
        $this->transaction = $transaction;
    }
    private function userId()
    {
        return $this->accountRequest->user()->id;
    }

    private function getUserAccount()
    {
        return $this->account::where('user_id', $this->userId())->first();
    }

    public function accountBalance()
    {
        $account = $this->getUserAccount();
        return $account ? $account->balance : 0;
    }

    public function accountNumber()
    {
        $account = $this->getUserAccount();
        return $account ? $account->account_number : null;
    }

    public function lastModified()
    {
        $account = $this->getUserAccount();
        return $account ? $account->updated_at : null;
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'accountNumber' => $this->accountNumber(),
            'accountName' => $this->accountRequest->user()->name,
            'accountBalance' => $this->accountBalance(),
            'lastModified' => $this->lastModified() ? Carbon::parse($this->lastModified())->format('Y-m-d H:i:s') : null
        ]);
    }

    public function showDepositForm()
    {
        return Inertia::render('Deposit', [
            'accountBalance' => $this->accountBalance()
        ]);
    }

    public function store(DepositRequest $depositRequest)
    {
        $account = $this->getUserAccount();

        if ($account) {
            $account->balance += $depositRequest->validated()['amount'];
            $account->save();

            return redirect()->back()->with('success', 'Deposit successful!');
        } else {
            return redirect()->back()->with('error', 'Account not found!');
        }
    }

    public function transfer()
    {
        return Inertia::render('Transfer', [
            'fromAccount' => $this->accountNumber(),
            'fromBalance' => $this->accountBalance()
        ]);
    }

    public function send(TransferRequest $transferRequest)
    {
        if (!$this->userId()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $amount = $transferRequest->amount;
        $fromAccountNumber = $this->accountNumber();
        $toAccountNumber = $transferRequest->toAccount;

        DB::transaction(function () use ($fromAccountNumber, $toAccountNumber, $amount) {
            $fromAccount = $this->account::where('account_number', $fromAccountNumber)->lockForUpdate()->first();
            $toAccount = $this->account::where('account_number', $toAccountNumber)->lockForUpdate()->first();

            if ($fromAccount->balance < $amount) {
                throw new \Exception('Insufficient funds');
            }

            if ($fromAccount == $toAccount) {
                throw new \Exception('You cannot send money to yourself b');
            }

            $fromAccount->balance -= $amount;
            $toAccount->balance += $amount;

            $fromAccount->save();
            $toAccount->save();
            // Record the transaction

            $this->transaction::create([
                'from_account_id' => $fromAccount->id,
                'to_account_id' => $toAccount->id,
                'amount' => $amount,
            ]);
        });

        Log::info('Money sent', [
            'from_account' => $fromAccountNumber,
            'to_account' => $toAccountNumber,
            'amount' => $amount,
            'user_id' => $this->userId(),
            'timestamp' => now(),
        ]);
    }

    public function transactions()
    {
        return Inertia::render('Transactions');
    }
}

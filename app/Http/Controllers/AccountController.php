<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Services\AccountService;

class AccountController extends Controller
{

    protected $accountService;
    protected $transactionController;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function dashboard()
    {
       return $this->accountService->dashboard();
    }

    public function showDepositForm()
    {
        return $this->accountService->showDepositForm();
    }

    public function store(DepositRequest $depositRequest)
    {
        return $this->accountService->store($depositRequest);
    }

    public function transfer()
    {
       return $this->accountService->transfer();
    }

    public function send(TransferRequest $transferRequest)
    {
        $this->accountService->send($transferRequest);
    }

    public function transactions()
    {
        return $this->accountService->transactions();
    }
}

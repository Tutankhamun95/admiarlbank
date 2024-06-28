<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Services\TransactionService;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    public function store(TransactionRequest $request)
    {
        $transaction = Transaction::create($request->validated());
        return new TransactionResource($transaction);
    }

    public function transactions()
    {
        return $this->transactionService->transactions();
    }
}

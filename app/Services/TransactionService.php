<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionType;
use App\Repositories\TransactionRepository;
use Auth;

class TransactionService
{
    protected $TransactionRepository;

    public function __construct(TransactionRepository $TransactionRepository)
    {
        $this->TransactionRepository = $TransactionRepository;
    }

    public function query($query)
    {
        return $this->TransactionRepository->query(Transaction::class, $query, function ($query) {
            $query->where('user_id', Auth::user()->id);

            return $query;
        });
    }

    public function queryAll($query)
    {
        return $this->TransactionRepository->query(Transaction::class, $query, null);
    }

    public function swap($data)
    {
        return $this->TransactionRepository->swap($data);
    }

    public function checkIfExists($hash, $index)
    {
        return $this->TransactionRepository->checkIfExists($hash, $index);
    }
}

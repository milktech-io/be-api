<?php

namespace App\Services;

use App\Models\Blockchain\Purchase;
use App\Models\Blockchain\Swap;
use App\Models\Blockchain\Transaction;
use App\Repositories\BlockchainRepository;

class BlockchainService
{
    protected $BlockchainRepository;

    public function __construct(BlockchainRepository $BlockchainRepository)
    {
        $this->BlockchainRepository = $BlockchainRepository;
    }

    public function swap($data)
    {
        return $this->BlockchainRepository->query(Swap::class, $data);
    }

    public function transactions($data)
    {
        return $this->BlockchainRepository->query(Transaction::class, $data);
    }

    public function purchases($data)
    {
        return $this->BlockchainRepository->query(Purchase::class, $data);
    }
}

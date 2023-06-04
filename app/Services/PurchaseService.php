<?php

namespace App\Services;

use App\Models\Purchase;
use App\Repositories\PurchaseRepository;
use Auth;

class PurchaseService
{
    protected $PurchaseRepository;

    public function __construct(PurchaseRepository $PurchaseRepository)
    {
        $this->PurchaseRepository = $PurchaseRepository;
    }

    public function setComissions($purchase)
    {
        return $this->PurchaseRepository->setComissions($purchase);
    }

    public function query($query)
    {
        return $this->PurchaseRepository->query(Purchase::class, $query, function ($query) {
            $query->where('user_id', Auth::user()->id);

            return $query;
        });
    }

    public function queryAll($query)
    {
        return $this->PurchaseRepository->query(Purchase::class, $query, function($query) {
            return $query->with('user');
        });
    }

    public function store($data)
    {
        return $this->PurchaseRepository->store($data);
    }

    public function storeFree($data)
    {
        return $this->PurchaseRepository->storeFree($data);
    }

    public function update($product, $data)
    {
        return $this->PurchaseRepository->update($product, $data);
    }

    public function purchaseAdmin($data)
    {
        return $this->PurchaseRepository->store($data);
    }
}

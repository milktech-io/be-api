<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    protected $ProductRepository;

    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function query($query)
    {
        return $this->ProductRepository->query(Product::class, $query);
    }

    public function search($query)
    {
        return $this->ProductRepository->search($query);
    }

    public function store($data)
    {
        return $this->ProductRepository->store($data);
    }

    public function update($product, $data)
    {
        return $this->ProductRepository->update($product, $data);
    }

    public function variants($product)
    {
        return $this->ProductRepository->variants($product);
    }

    public function nextContractId($variant)
    {
        return $this->ProductRepository->nextContractId($variant);
    }

    public function setContractId($data)
    {
        return $this->ProductRepository->setContractId($data);
    }
}

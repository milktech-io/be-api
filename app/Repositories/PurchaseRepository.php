<?php

namespace App\Repositories;

use App\Models\BondPackage;
use App\Models\Product;
use App\Models\Purchase;
use App\Repositories\Purchase\MultiplierRepository;

use App\Services\TransactionService;
use App\Traits\PaginateRepository;

class PurchaseRepository
{
    use PaginateRepository;

    public function __construct(
        TransactionService $TransactionService,
        MultiplierRepository $MultiplierRepository,

    ) {

        $this->TransactionService = $TransactionService;
        $this->MultiplierRepository = $MultiplierRepository;
    }

    public function setComissions($purchase)
    {

        $notX3 = $purchase->product->slug != 'multiplicador-x3';
        $static = $purchase->product->static;
        $generated = $purchase->comissions->count();
        $message = '';


        return ok($message, BondPackage::where('purchase_id', $purchase->id)->get());
    }

    public function store($data)
    {
        $exists = $this->TransactionService->checkIfExists(
            $data['transactionHash'],
            $data['transactionIndex'] ?? true,
        );

        if (! $exists) {
            return bad_request('El hash o el index no existen en la blockchain');
        }

        $product = Product::find($data['product_id']);
        $purchase = [];
        $variant = (new $product->variant)->find($data['variant_id']) ?? false;

        $errorVariant = false;
        if (! $variant) {
            $errorVariant = not_found('Variante no encontrada');
        } elseif ($variant->stock != null && $variant->stock < $data['sold']) {
            $errorVariant = bad_request('No hay stock suficiente');
        } elseif (str_contains($product->slug, 'collective')) {
            $errorVariant = $this->CollectiveService->checkCollective($data);
        }

        if ($errorVariant) {
            return $errorVariant;
        }

        if ($product->multiplier) {
            $purchase = $this->MultiplierRepository->store($data, $product, $variant);
        }

        if (str_contains($product->slug, 'statics') || str_contains($product->slug, 'collective')) {
            $purchase = $this->StaticRepository->store($data, $product, $variant);
        }
        if ($product->slug == 'newland') {
            $purchase = $this->NewlandRepository->store($data, $product, $variant);
        }

        if (str_contains($product->slug, 'crop')) {
            $purchase = $this->ChaincropRepository->store($data, $product, $variant);
        }

        $product->sold++;
        $product->save();

        return ok('Compra creada correctamente', $purchase);
    }

    public function storeFree($data)
    {
        return $this->MultiplierRepository->storeFree($data);
    }

    public function update(Purchase $purchase, $data)
    {
        $purchase->status = $data['status'];

        $purchase->save();

        return ok('Actualizado correctamente', $purchase);
    }
}

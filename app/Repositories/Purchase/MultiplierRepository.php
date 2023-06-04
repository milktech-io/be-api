<?php

namespace App\Repositories\Purchase;

use App\Models\Package;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\TransactionType;


use Auth;
use Carbon\Carbon;

class MultiplierRepository
{

    public function __construct(    ) {
    }

    private function savePurchase($variant, $data, $product)
    {
        if (isset($data['user_id'])) {
            $user_id = $data['user_id'];
        } else {
            $user_id = Auth::user()->id;
        }

        $detail = [
            'name' => $variant->name,
            'price' => $variant->price,
            'model' => get_class($variant),
        ];

        $transaction = Transaction::create([
            'user_id' => $user_id,
            'requested_user_id' => Auth::user()->id,
            'quantity' => $data['sold'] * $variant->price,
            'currency' => $variant->currency,
            'type_id' => TransactionType::getId('Purchase'),
            'transaction_hash' => $data['transactionHash'] ?? null,
            'transaction_index' => $data['transactionIndex'] ?? null,
        ]);

        $purchase = Purchase::create([
            'product_id' => $data['product_id'],
            'category_id' => $product->category_id,
            'user_id' => $user_id,
            'variant_id' => $data['variant_id'],
            'transaction_id' => $transaction->id,
            'variant' => $product->variant,
            'price' => $variant->price,
            'currency' => $variant->currency,
            'sold' => $data['sold'],
            'total' => $data['sold'] * $variant->price,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'purchased_by' => Auth::user()->id,
            'status' => 'Pagado',
            'detail' => ($detail),
        ]);

        $data['purchase_id'] = $purchase->id;
        $data['price'] = $purchase->total;

        return $purchase;
    }

    private function savePurchaseFree($user, $variant, $data, $product)
    {
        $detail = [
            'name' => $variant->name,
            'price' => $variant->price,
            'model' => get_class($variant),
        ];

        return Purchase::create([
            'product_id' => $data['product_id'],
            'category_id' => $product->category_id,
            'user_id' => $user->id,
            'variant_id' => $data['variant_id'],
            'variant' => $product->variant,
            'price' => $variant->price,
            'currency' => $variant->currency,
            'sold' => 1,
            'total' => 0,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'free' => 1,
            'transactionIndex' => null,
            'status' => 'Pagado',
            'detail' => ($detail),
            'purchased_by' => Auth::user()->id,
        ]);
    }

    public function store($data, $product, $variant)
    {
        $fecha = Carbon::now();
        $metadata = json_decode($product->metadata);

        $purchase = $this->savePurchase($variant, $data, $product);

        if (isset($data['user_id'])) {
            $user_id = $data['user_id'];
        } else {
            $user_id = Auth::user()->id;
        }

        $package = Package::create([
            'user_id' => $user_id,
            'plan_id' => $data['variant_id'],
            'date' => $fecha,
            'end_date' => Carbon::now()->addMonths($metadata->months),
            'price' => $variant->price,
            'months' => $metadata->months,
            'plus_comission' => $variant->plus_comission,
            'generate_roi' => $variant->generate_roi,
            'interest' => $variant->interest,
            'currency' => $variant->currency,
            'purchase_id' => $purchase->id,
            'automatically_ends' => $variant->automatically_ends,
        ]);

        $variant->stock = $variant->stock - $data['sold'];
        $variant->save();

        return $purchase;
    }

    public function storeFree($data)
    {
        $product = Product::find($data['product_id']);
        $purchase = [];
        $variant = (new $product->variant)->find($data['variant_id']) ?? false;
        if (! $variant) {
            return not_found('Variante no encontrada');
        }

        if ($variant->stock != null && $variant->stock < 1) {
            return bad_request('No hay stock suficiente');
        }
        $fecha = Carbon::now();

        $user = json_decode($data['user']);
        $metadata = json_decode($product->metadata);

        $purchase = $this->savePurchaseFree($user, $variant, $data, $product);

        $package = Package::create([
            'user_id' => $user->id,
            'plan_id' => $data['variant_id'],
            'date' => $fecha,
            'generate_roi' => 0,
            'end_date' => Carbon::now()->addMonths($metadata->months),
            'price' => $variant->price,
            'months' => $metadata->months,
            'plus_comission' => $variant->plus_comission,
            'interest' => $variant->interest,
            'currency' => $variant->currency,
            'purchase_id' => $purchase->id,
            'automatically_ends' => $variant->automatically_ends,
        ]);


        $variant->stock = $variant->stock - 1;
        $variant->save();


        if ($package->price > $advance->investment_plan) {
            $advance->investment_plan = $package->price;
            $advance->save();
        }

        $product->sold++;
        $product->save();

        return ok('Compra creada correctamente', $purchase);
    }
}

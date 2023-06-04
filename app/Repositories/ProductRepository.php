<?php

namespace App\Repositories;

use App\Models\Chaincrop\Stock as StockChaincrop;
use App\Models\Newland\Stock as StockNewland;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Static\StaticProducts;
use App\Traits\PaginateRepository;
use Illuminate\Support\Facades\Schema;

class ProductRepository
{
    use PaginateRepository;

    public function search($data)
    {
        $products = Product::with('category:image_url,id')->select('id', 'category_id', 'name', 'slug', 'image_url');

        foreach ($data as $key => $value) {
            if (Schema::hasColumn('products', $key)) {
                $products->where($key, $value);
            } else {
                return bad_request('La columna '.$key.' no existe', $data);
            }
        }

        return  ok('', $products->get());
    }

    public function store($data)
    {
        $product = Product::create($data);

        return ok('Producto creado correctamente', $product);
    }

    public function update(Product $product, $data)
    {
        foreach ($data as $key => $data) {
            $product->$key = $data;
        }

        $product->save();

        return ok('Actualizado correctamente', $product);
    }

    public function variants($product)
    {
        if ($product->statics->count()) {
            return ok('', $product->statics);
        }
        try {
            return ok('Variantes', (new $product->variant)->where('product_id', $product->id)->get());
        } catch (\Illuminate\Database\QueryException $e) {
            return ok('Variantes', (new $product->variant)->all());
        }
    }

    protected function findVariant($variant)
    {
        if ($variant == 'plan') {
            return new Plan;
        }
        if ($variant == 'static') {
            return new StaticProducts;
        }
        if ($variant == 'newland') {
            return new StockNewland;
        }
        if ($variant == 'chaincrop') {
            return new StockChaincrop;
        } else {
            return false;
        }
    }

    public function nextContractId($variant)
    {
        $blockchainBase = env('BLOCKCHAIN_BASE', false);

        $model = false;
        $error = false;
        $model = $this->findVariant($variant);

        if (! $model) {
            return not_found('La variante no existe');
        }
        if (! $blockchainBase) {
            $error = server_error('No hay asignado un BLOCKCHAIN_BASE en el servidor');
        } else {
            $blockchainPrefix = ($model)->blockchainPrefix ?? false;

            if (! $blockchainPrefix) {
                $error = server_error('No hay asignado un blockchainPrefix en la variante');
            }
        }

        if ($error) {
            return $error;
        }

        $last = ($model)->where('contract_id', '!=', null)
            ->orderBy('contract_id', 'desc')
            ->first() ?? (object) ['contract_id' => false];

        $id = $last->contract_id;

        if ($id) {
            $id++;
        } else {
            $id = intval(
                strval($blockchainBase).
                strval($blockchainPrefix).
                '001'
            );
        }

        return ok('', $id);
    }

    public function setContractId($data)
    {
        $model = $this->findVariant($data['variant']);

        if (! $model) {
            return not_found('La variante no existe');
        }

        $variant = ($model)::find($data['id']) ?? false;

        $errorMessage = false;

        if (! $variant) {
            $errorMessage = 'Variante No encontrada';
        } elseif ($variant->contract_id != null) {
            $errorMessage = 'Esta variante ya cuenta con un contract_id';
        }

        if (($model)::where('contract_id', $data['contract_id'])->first()) {
            $errorMessage = 'Ya existe una variante con este id';
        }

        if ($errorMessage) {
            return bad_request($errorMessage);
        }

        $variant->contract_id = $data['contract_id'];
        $variant->save();

        return ok('Contract id guardado correctamente', $variant);
    }
}

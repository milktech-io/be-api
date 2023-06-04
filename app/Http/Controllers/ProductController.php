<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductController\SetContractIdRequest;
use App\Http\Requests\ProductController\StoreRequest;
use App\Http\Requests\ProductController\UpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\PaginateRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use PaginateRepository;

    protected $ProductService;

    public function __construct(ProductService $ProductService)
    {
        $this->ProductService = $ProductService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->ProductService->query($request->query());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->ProductService->store($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function showMore($product)
    {
        return ok('',
            $this->toTranslate(Product::with('gallery', 'banner', 'logo', 'documents', 'current_version', 'reviews')->findOrFail($product))
        );
    }

    public function show($product)
    {
        return ok('', $this->toTranslate(Product::select('id', 'variant', 'description', 'content')->find($product)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        return $this->ProductService->update($product, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->drop();

        return ok('Producto eliminado correctamente');
    }

    public function variants(Product $product)
    {
        return $this->ProductService->variants($product);
    }

    public function nextContractId($variant)
    {
        return $this->ProductService->nextContractId($variant);
    }

    public function setContractId(SetContractIdRequest $request)
    {
        return $this->ProductService->setContractId($request->validated());
    }
}

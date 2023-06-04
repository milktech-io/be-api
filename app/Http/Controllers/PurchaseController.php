<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseController\StoreAdminRequest;
use App\Http\Requests\PurchaseController\StoreFreeRequest;
use App\Http\Requests\PurchaseController\StoreRequest;
use App\Http\Requests\PurchaseController\UpdateRequest;
use App\Models\Purchase;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $PurchaseService;

    public function __construct(PurchaseService $PurchaseService)
    {
        $this->PurchaseService = $PurchaseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->PurchaseService->query($request->query());
    }

    public function comissions(Purchase $purchase)
    {
        return ok('', $purchase->comissions);
    }

    public function setComissions(Purchase $purchase)
    {
        return $this->PurchaseService->setComissions($purchase);
    }

    public function indexAll(Request $request)
    {
        return $this->PurchaseService->queryAll($request->query());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->PurchaseService->store($request->validated());
    }

    public function storeFree(StoreFreeRequest $request)
    {
        return $this->PurchaseService->storeFree($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($purchase)
    {
        $purchase = Purchase::variants()->with(
            'product.banner',
            'product.logo',
            'myReview'
        )->findOrFail($purchase);
        $purchase->variant;

        return ok('', $purchase);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Purchase $purchase)
    {
        return $this->PurchaseService->update($purchase, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return ok('Compra eliminada correctamente');
    }

    public function purchaseAdmin(StoreAdminRequest $request)
    {
        return $this->PurchaseService->purchaseAdmin($request->validated());
    }
}

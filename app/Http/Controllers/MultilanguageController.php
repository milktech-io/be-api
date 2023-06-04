<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultilanguageController\StoreRequest;
use App\Http\Requests\MultilanguageController\UpdateRequest;
use App\Models\Multilanguage;
use App\Services\MultilanguageService;
use Illuminate\Http\Request;
use Storage;

class MultilanguageController extends Controller
{
    protected $MultilanguageService;

    public function __construct(MultilanguageService $MultilanguageService)
    {
        $this->MultilanguageService = $MultilanguageService;
    }

    public function index(Request $request)
    {
        return $this->MultilanguageService->query($request->query());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->MultilanguageService->store($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Multilanguage $multilanguage)
    {
        return $this->MultilanguageService->show($multilanguage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Multilanguage $multilanguage)
    {
        return $this->MultilanguageService->update($multilanguage, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Multilanguage $multilanguage)
    {
        Storage::disk('s3')->delete($multilanguage->url);
        $multilanguage->delete();

        return ok('Eliminado correctamente');
    }
}

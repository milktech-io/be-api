<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Services\{TokenService};

class TokenController extends Controller
{
    protected $TokenService;

    /**
     * Constructor of Board Task Controller
     */
    public function __construct(TokenService $TokenService)
    {
        $this->TokenService = $TokenService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->TokenService->getActives();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Token $token)
    {
        return $this->TokenService->revoke($token);
    }
}

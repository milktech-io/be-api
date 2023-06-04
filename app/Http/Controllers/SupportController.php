<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportController\CreateTicketClientRequest;
use App\Http\Requests\SupportController\CreateTicketRequest;
use App\Http\Requests\SupportController\ReplyTicketRequest;
use App\Http\Requests\SupportController\ViewTicketRequest;
use App\Services\SupportService;

class SupportController extends Controller
{
    protected $SupportService;

    public function __construct(SupportService $SupportService)
    {
        $this->SupportService = $SupportService;
    }

    public function createTicket(CreateTicketRequest $request)
    {
        return $this->SupportService->createTicket($request->validated());
    }

    public function createTicketClient(CreateTicketClientRequest $request)
    {
        return $this->SupportService->createTicketClient($request->validated());
    }

    public function viewTicket(ViewTicketRequest $request)
    {
        return $this->SupportService->viewTicket($request->validated());
    }

    public function replyTicket(ReplyTicketRequest $request)
    {
        return $this->SupportService->replyTicket($request->validated());
    }

    public function listTicket()
    {
        return $this->SupportService->listTicket();
    }
}

<?php

namespace App\Services;

use App\Repositories\SupportRepository;

class SupportService
{
    protected $SupportRepository;

    public function __construct(SupportRepository $SupportRepository)
    {
        $this->SupportRepository = $SupportRepository;
    }

    public function createTicket($data)
    {
        return $this->SupportRepository->createTicket($data);
    }

    public function createTicketClient($data)
    {
        return $this->SupportRepository->createTicketClient($data);
    }

    public function viewTicket($data)
    {
        return $this->SupportRepository->viewTicket($data);
    }

    public function replyTicket($data)
    {
        return $this->SupportRepository->replyTicket($data);
    }

    public function listTicket()
    {
        return $this->SupportRepository->listTicket();
    }
}

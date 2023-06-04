<?php

namespace App\Console\Commands;

use App\Models\Support;
use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class TicketStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'freshdesk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->BusService = '';
        parent::__construct();
        $this->client = new Client(['verify' => false]);
        $this->api_key = env('FRESHDESK_API_KEY', '');
        $this->domain = env('FRESHDESK_DOMAIN', '').env('FRESHDESK_ENDPOINT', '');
    }

    protected function checkTickets($supports, $page)
    {
        $url = $this->domain.'?updated_since=2023-01-01T02:00:00Z&page='.$page;

        $response = $this->client->get($url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'auth' => [
                $this->api_key,
                'x',
            ],
        ]);

        $tickets = json_decode($response->getBody());

        $close = [];
        $open = [];

        if (count($tickets) <= 0) {
            return false;
        }

        foreach ($tickets as $ticket) {
            $support = $supports[$ticket->id][0] ?? false;

            if (! $support) {
                continue;
            }

            if ($ticket->status == 2 || $ticket->status == 3) {
                $open[] = $support->id;
            } elseif ($ticket->status == 5 || $ticket->status == 4) {
                $close[] = $support->id;
            }
        }

        if (count($close)) {
            DB::table('supports')->whereIn('id', $close)->update(['status' => 'Cerrado']);
        }

        if (count($open)) {
            DB::table('supports')->whereIn('id', $open)->update(['status' => 'Abierto']);
        }

        return true;
    }

    protected function start()
    {
        $page = 1;
        $supports = Support::all()->groupby('ticket_id');

        $continue = true;
        while ($continue) {
            $continue = $this->checkTickets($supports, $page);
            $page++;
            sleep(1);
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $error = '';
        try {
            $this->start();
        } catch (\Exception $e) {
            $error = $e;
            error_log($e);
        }

        return;
        $data = [
            'emails' => json_encode([
                [
                    'subject' => 'Ejecutado ticket status',
                    'email' => 'monitoreo@eonnet.io',
                    'data' => [
                        'name' => 'fer',
                        'tag' => 'Bienvenido',
                        'text' => 'se ha Ejecutadoe el comando TicketStatus: '.$error,
                    ],
                    'view' => 'base',

                ],
            ]),

        ];

        becomeAdmin();
        $this->BusService->dispatch('post', 'email', '/send', $data);
    }
}

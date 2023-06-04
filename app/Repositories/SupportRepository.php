<?php

namespace App\Repositories;

use App\Models\Support;
use App\Services\{BusService};
use App\Traits\PaginateRepository;
use Auth;

class SupportRepository
{
    use PaginateRepository;

    protected $BusService;

    public function __construct()
    {
        $this->api_key = env('FRESHDESK_API_KEY', '');
        $this->domain = env('FRESHDESK_DOMAIN', '');
        $this->APPLICATION_JSON = 'Content-type: application/json';
    }

   

    public function createTicketClient($data)
    {
        $data['ticket_type'] = 1;

        return $this->createTicket($data);
    }

    public function createTicket($data)
    {
        $user = Auth::user();
        if (intval($data['ticket_type']) == 1) {  //servicio al cliente
            $group_id = 150000013521;
        } elseif (intval($data['ticket_type']) == 2) { //soporte eon
            $group_id = 150000022216;
        }

        $ticket_data = json_encode([
            'description' => $data['description'],
            'subject' => $data['subject'],
            'email' => $data['email'],
            'priority' => 1,
            'status' => 2,
            'group_id' => $group_id,
        ]);

        $tickets_url = env('FRESHDESK_ENDPOINT', '');
        $url = $this->domain.$tickets_url;
        $ch = curl_init($url);

        $header[] = $this->APPLICATION_JSON;
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);


        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = json_decode(substr($result, $header_size));

        if ($info['http_code'] == 201) {
            if ($user) {
                Support::create([
                    'user_id' => $user->id,
                    'ticket_id' => $body->id,
                    'title' => $data['subject'],
                    'status' => 'Abierto',
                ]);
            }

            return ok('Ticket created successfully');
        } else {
            if ($info['http_code'] == 404) {
                return not_found('Error, Please check the end point');
            } else {
                return bad_request('Error, HTTP Status Code : '.$info['http_code']);
            }
        }
    }

    public function viewTicket($data)
    {
        $tickets_url = env('FRESHDESK_ENDPOINT', '');
        $url = $this->domain.$tickets_url.'/'.$data['ticket_id'].'?include=conversations';
        $ch = curl_init($url);

        $header[] = $this->APPLICATION_JSON;
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_getinfo($ch);

        curl_close($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = json_decode(substr($result, $header_size));

        return ok('Ticket', $body);
    }

    public function replyTicket($data)
    {
        $reply_data = json_encode([
            'body' => $data['body'],
        ]);

        $tickets_url = env('FRESHDESK_ENDPOINT', '');
        $url = $this->domain.$tickets_url.'/'.$data['ticket_id'].'/reply';
        $ch = curl_init($url);

        $header[] = $this->APPLICATION_JSON;
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $reply_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_getinfo($ch);

        curl_close($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = json_decode(substr($result, $header_size));

        return ok('Mensaje enviado', $body);
    }

    public function listTicket()
    {
        $user = Auth::user();

        $tickets = Support::where('user_id', $user->id)->get();

        return ok('Tickets', $tickets);
    }
}

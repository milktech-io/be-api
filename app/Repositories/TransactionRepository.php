<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\TransactionType;
use App\Traits\PaginateRepository;
use Auth;

class TransactionRepository
{
    use PaginateRepository;

    public function checkIfExists($hash, $index)
    {
        return $hash && $index;
    }

    public function checkIfExists2($hash, $index)
    {
        return \DB::connection('blockchain')
            ->table('transactions')
            ->where('payload', 'like', '%'.$hash.'%')
            ->orWhere('payload', 'like', '%'.$index.'%')
            ->count() ? true : false;
    }

    public function swap($data)
    {
        if (! $this->checkIfExists($data['transaction_hash'], $data['transaction_index'])) {
            return bad_request('El hash o el index no existe en la blockchain');
        }

        $user = Auth::user();
        $swap = Transaction::create([
            'user_id' => $user->id,
            'requested_user_id' => $user->id,
            'quantity' => $data['quantity_to'],
            'currency' => $data['currency_to'],
            'type_id' => TransactionType::getId('Swap'),
            'transaction_hash' => $data['transaction_hash'],
            'transaction_index' => $data['transaction_index'],
            'metadata' => json_encode([
                'quantity_from' => $data['quantity_from'],
                'currency_from' => $data['currency_from'],
            ]),
        ]);

        return ok('Swap guardado exitosamente', $swap);
    }
}

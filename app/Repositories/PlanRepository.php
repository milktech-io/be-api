<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Traits\PaginateRepository;
use Auth;

class PlanRepository
{
    use PaginateRepository;

    public function search($data)
    {
        $plans = Plan::select('*')->distinct('id');

        foreach ($data as $key => $value) {
            if (Schema::hasColumn('plans', $key)) {
                $plans->where($key, $value);
            } else {
                return bad_request('La columna '.$key.' no existe', $data);
            }
        }

        return  ok('', $plans->get());
    }

    public function store($data)
    {
        $data['created_by'] = Auth::user()->id;
        $plan = Plan::create($data);

        $plan->storeImage($data['image'], 'image_url');

        return ok('', $plan->getFresh());
    }

    public function updateImage($plan, $data)
    {
        $plan->unlink('image_url');
        $plan->storeImage($data['image'], 'image_url');

        return ok('Imagen cambiada correctamente', $plan);
    }

    public function update(Plan $plan, $data)
    {
        foreach ($data as $key => $data) {
            $plan->$key = $data;
        }

        $plan->save();

        return ok('Actualizado correctamente', $plan);
    }
}

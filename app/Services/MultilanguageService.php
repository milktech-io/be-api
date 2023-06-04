<?php

namespace App\Services;

use App\Models\Multilanguage;
use App\Repositories\MultilanguageRepository;

class MultilanguageService
{
    protected $MultilanguageRepository;

    public function __construct(MultilanguageRepository $MultilanguageRepository)
    {
        $this->MultilanguageRepository = $MultilanguageRepository;
    }

    public function query($query)
    {
        return $this->MultilanguageRepository->query(Multilanguage::class, $query);
    }

    public function store($data)
    {
        return $this->MultilanguageRepository->store($data);
    }

    public function update($multilanguage, $data)
    {
        return $this->MultilanguageRepository->update($multilanguage, $data);
    }

    public function show($multilanguage)
    {
        return $this->MultilanguageRepository->show($multilanguage);
    }
}

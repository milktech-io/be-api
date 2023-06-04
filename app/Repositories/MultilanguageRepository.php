<?php

namespace App\Repositories;

use App\Models\Multilanguage;
use App\Traits\PaginateRepository;
use DB;
use Storage;

class MultiLanguageRepository
{
    use PaginateRepository;

    public function __construct()
    {
        $this->tables = [
            'categories',
            'products',
            'plans',
            'versions',
        ];

        $this->columns = [
            'name',
            'content',
            'description',
            'short_description',
            'features',
            'news',
        ];
    }

    public function store($data)
    {
        $translate = [];

        foreach ($this->tables as $table) {
            $datas = DB::table($table)->whereNull('deleted_at')->get();
            foreach ($datas as $row) {
                $row = (array) $row;
                foreach ($row as $key => $value) {
                    if (in_array($key, $this->columns) && ! in_array($value, $translate)) {
                        $translate[$value] = $value;
                    }
                }
            }
        }

        $multilanguage = Multilanguage::create([
            'name_long' => $data['name_long'],
            'name_short' => $data['name_short'],
            'url' => '/lang/'.$data['name_short'].'.json',
        ]);

        Storage::disk('s3')->put($multilanguage->url, json_encode($translate));

        return ok('Archivo de traduccion creado correctamente', $multilanguage);
    }

    public function update(Multilanguage $multilanguage, $data)
    {
        $json = json_encode($data['json']);
        Storage::disk('s3')->put($multilanguage->url, $json);
        $translate = Storage::disk('s3')->get($multilanguage->url);

        return ok('Traduccion actualizada correctamente', json_decode($translate));
    }

    public function show($multilanguage)
    {
        $translation = Storage::disk('s3')->get($multilanguage->url);
        $translation = json_decode($translation);

        $translate = [];

        foreach ($this->tables as $table) {
            $data = DB::table($table)->whereNull('deleted_at')->get();
            foreach ($data as $row) {
                $row = (array) $row;
                foreach ($row as $key => $value) {
                    if (in_array($key, $this->columns) && ! in_array($value, $translate)) {
                        $translate[$value] = $translation->$value ?? $value;
                    }
                }
            }
        }

        return ok('', $translate);
    }
}

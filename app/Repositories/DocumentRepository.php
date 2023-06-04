<?php

namespace App\Repositories;

use App\Models\Document;
use App\Models\Rangue;
use App\Traits\PaginateRepository;
use Storage;

class DocumentRepository
{
    use PaginateRepository;

    protected $storageRoute = 'documents';

    public function store($data)
    {
        $document = Document::create($data);
        $document->storeDocument($data['file'], 'file_url');
        $document->rangue;

        return ok('documento creadao correctamente', $document);
    }

    public function update($data, $document)
    {
        $document->unlink('file_url');
        $input_file = $data['file']->getClientOriginalName();
        $extension = '.'.pathinfo($input_file, PATHINFO_EXTENSION);

        $newfile = Storage::disk('s3')->put($this->storageRoute, $data['file'], 'public');

        $document->extension = $extension;
        $document->file_url = $newfile;
        $document->name = $data['name'];
        $document->rangue_id = $data['rangue_id'];
        $document->save();

        return ok('Documento actualizado correctamente');
    }

    public function download($data)
    {
        $attachment = $data['file'];

        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Type' => 'image/png',
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$attachment.'"',
        ];
        ob_end_clean();

        return \Response::make(Storage::disk('s3')->get($attachment), 200, $headers);
    }

    public function publicName($name)
    {
        $sinRango = Rangue::whereNull('number')->first();

        $document = Document::where('name', $name)->whereNull('rangue_id')->orWhere('rangue_id', $sinRango->id)->first() ?? false;

        return $document ? ok('', $document->file) : not_found('El documento no existe');
    }
}

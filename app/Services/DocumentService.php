<?php

namespace App\Services;

use App\Models\Document;
use App\Repositories\DocumentRepository;

class DocumentService
{
    protected $DocumentRepository;

    public function __construct(DocumentRepository $DocumentRepository)
    {
        $this->DocumentRepository = $DocumentRepository;
    }

    public function query($query)
    {
        return $this->DocumentRepository->query(Document::class, $query);
    }

    public function store($data)
    {
        return $this->DocumentRepository->store($data);
    }

    public function update($data, $document)
    {
        return $this->DocumentRepository->update($data, $document);
    }

    public function download($data)
    {
        return $this->DocumentRepository->download($data);
    }

    public function publicName($name)
    {
        return $this->DocumentRepository->publicName($name);
    }
}

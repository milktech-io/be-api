<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentController\StoreRequest;
use App\Http\Requests\DocumentController\UpdateRequest;
use App\Http\Requests\DownloadRequest;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $DocumentService;

    public function __construct(DocumentService $DocumentService)
    {
        $this->DocumentService = $DocumentService;
    }

    public function index(Request $request)
    {
        return $this->DocumentService->query($request->query());
    }

    public function store(StoreRequest $request)
    {
        return $this->DocumentService->store($request->validated());
    }

    public function destroy(Document $document)
    {
        $document->unlink('file_url');
        $document->delete();

        return ok('Documento eliminado correctamente');
    }

    public function update(UpdateRequest $request, Document $document)
    {
        return $this->DocumentService->update($request->validated(), $document);
    }

    public function download(DownloadRequest $request)
    {
        return $this->DocumentService->download($data);
    }

    public function publicName($name)
    {
        return $this->DocumentService->publicName($name);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRemoveRequest;
use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DocumentUploadRequest;
use App\Models\Document;
use App\Services\DocumentService;
use App\Services\MediaContentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $document, $content;

    public function __construct(DocumentService $document, MediaContentService $content)
    {
        $this->document = $document;
        $this->content = $content;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->document->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentStoreRequest $request)
    {
        return $this->document->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return $this->document->show($document);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return $this->document->edit($document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentStoreRequest $request, Document $document)
    {
        return $this->document->update($request, $document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        return $this->document->destroy($document);
    }

    public function search(Request $request)
    {
        return $this->document->search($request);
    }

    /** Загрука документа */
    public function upload(DocumentUploadRequest $request)
    {
        return $this->content->upload($request);
    }

    /** Удаление файла документа */
    public function remove(DocumentRemoveRequest $request)
    {
        return $this->content->remove($request->url);
    }

    /** Выгрузка файла документа */
    public function download(DocumentRemoveRequest $request)
    {
        return $this->content->download($request->url);
    }
}

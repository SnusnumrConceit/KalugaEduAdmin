<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: snusnumr1996
 * Date: 20.12.19
 * Time: 13:24
 */

namespace App\Services;


use App\Http\Requests\DocumentStoreRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) : JsonResponse
    {
        $docs = Document::with('category')->paginate();

        return response()->json([
            'docs' => $docs
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() : JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentStoreRequest $request) : JsonResponse
    {
        Document::create($request->validated());

        return response()->json([
            'status' => 'success',
            'msg' => __('document_msg_success_create')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document) : JsonResponse
    {
        return response()->json([
            'document' => new DocumentResource($document->load('category'))
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document) : JsonResponse
    {
        $file['size'] = Storage::disk('local')->size($document->url);
        $file['last_modified'] = Storage::disk('local')->lastModified($document->url);

        return response()->json([
            'doc' => $document,
            'file' => $file
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentStoreRequest $request, Document $document) : JsonResponse
    {
        $document->update($request->validated());

        return response()->json([
            'status' => 'success',
            'msg' => __('document_msg_success_update')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document) : JsonResponse
    {
        $document->delete($document->id);

        return response()->json([
            'status' => 'success',
            'msg' => __('document_msg_success_delete')
        ]);
    }

    public function search(Request $request) : JsonResponse
    {
        $docs = Document::when(! empty($request->keyword), function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%'. $request->keyword. '%');
        })->with('category')->paginate();

        return response()->json([
            'docs' => $docs
        ], 200);
    }
}
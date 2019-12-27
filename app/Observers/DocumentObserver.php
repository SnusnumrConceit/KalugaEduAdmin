<?php

namespace App\Observers;

use App\Models\Document;
use App\Services\MediaContentService;

class DocumentObserver
{
    private $content;

    public function __construct(MediaContentService $content)
    {
        $this->content = $content;
    }

    public function creating(Document $document)
    {
//        dd(__METHOD__, 'creating', $document);
        $document->url = $this->content->move($document->url);
    }

    /**
     * Handle the document "created" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function created(Document $document)
    {
        //
    }

    public function updating(Document $document)
    {
//        $document->url = $this->content->move($document->url);
    }

    /**
     * Handle the document "updated" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function updated(Document $document)
    {
        //
    }

    /**
     * Handle the document "deleted" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function deleted(Document $document)
    {
        //
    }

    /**
     * Handle the document "restored" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function restored(Document $document)
    {
        //
    }

    /**
     * Handle the document "force deleted" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function forceDeleted(Document $document)
    {
        //
    }
}

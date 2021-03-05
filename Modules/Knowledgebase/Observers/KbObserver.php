<?php

namespace Modules\Knowledgebase\Observers;

use Modules\Knowledgebase\Entities\Knowledgebase;

class KbObserver
{

    /**
     * Listen to article creating event.
     *
     * @param Knowledgebase $article
     */
    public function creating(Knowledgebase $article)
    {
        $article->slug = slugify(strtolower($article->subject));
    }

    /**
     * Listen to the article deleting event.
     *
     * @param Knowledgebase $article
     */
    public function deleting(Knowledgebase $article)
    {
        foreach ($article->comments as $comment) {
            $comment->delete();
        }
        $article->reviews()->delete();
        $article->detag();
    }
}

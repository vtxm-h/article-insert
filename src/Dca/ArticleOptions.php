<?php

namespace ArticleInsert\Dca;

use Contao\ArticleModel;
use Contao\DataContainer;

class ArticleOptions
{
    public function getArticlesByPage(DataContainer $dc): array
    {
        $options = [];

        if (!$dc->activeRecord || !$dc->activeRecord->page) {
            return $options;
        }

        $articles = ArticleModel::findBy(
            ['pid=?'],
            [$dc->activeRecord->page],
            ['order' => 'sorting']
        );

        if (null === $articles) {
            return $options;
        }

        foreach ($articles as $article) {
            $options[$article->id] = $article->title;
        }

        return $options;
    }
}

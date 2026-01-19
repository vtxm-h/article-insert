<?php

namespace ArticleInsert\Dca;

use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;

class ArticleInsertArticleOptions extends Backend
{
    public function getArticlesByPage(DataContainer $dc): array
    {
        if (!$dc->activeRecord || (int) $dc->activeRecord->page <= 0) {
            return [];
        }

        $pageId = (int) $dc->activeRecord->page;

        $stmt = Database::getInstance()
            ->prepare('SELECT id, title, inColumn FROM tl_article WHERE pid=? ORDER BY sorting')
            ->execute($pageId);

        $options = [];

        while ($stmt->next()) {
            $label = $stmt->title;

            if ($stmt->inColumn) {
                $label .= ' [' . $stmt->inColumn . ']';
            }

            $options[(int) $stmt->id] = $label;
        }

        return $options;
    }
}

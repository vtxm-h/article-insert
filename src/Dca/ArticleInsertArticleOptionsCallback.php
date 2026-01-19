<?php

namespace ArticleInsert\Dca;

use Contao\Backend;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\Database;
use Contao\DataContainer;

class ArticleInsertArticleOptionsCallback extends Backend
{
    public function getArticlesByPage(DataContainer $dc): array
    {
        if (!$dc->activeRecord) {
            return [];
        }

        $pageId = (int) ($dc->activeRecord->page ?? 0);
        if ($pageId <= 0) {
            return [];
        }
        
        $stmt = Database::getInstance()->prepare("
            SELECT a.id, a.title, a.inColumn, p.title AS pageTitle
            FROM tl_article a
            INNER JOIN tl_page p ON p.id = a.pid
            WHERE p.rootId = ?
            ORDER BY p.sorting, a.sorting
        ")->execute($pageId);

        $options = [];

        while ($stmt->next()) {
            $label = $stmt->pageTitle . ' → ' . $stmt->title;

            if ($stmt->inColumn) {
                $label .= ' [' . $stmt->inColumn . ']';
            }

            $options[(int) $stmt->id] = $label;
        }

        return $options;
    }
}

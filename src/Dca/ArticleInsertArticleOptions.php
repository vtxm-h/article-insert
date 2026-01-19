<?php

namespace ArticleInsert\Dca;

use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;
use Contao\Input;

class ArticleInsertArticleOptions extends Backend
{
    public function getArticlesByPage(DataContainer $dc): array
    {
        $rootPageId = 0;

        if ($dc->activeRecord && (int) ($dc->activeRecord->page ?? 0) > 0) {
            $rootPageId = (int) $dc->activeRecord->page;
        }

        if ($rootPageId <= 0) {
            $rootPageId = (int) Input::post('page', true);
        }

        if ($rootPageId <= 0) {
            return [];
        }

        $stmt = Database::getInstance()
            ->prepare("
                SELECT a.id, a.title, a.inColumn, p.title AS pageTitle
                FROM tl_article a
                INNER JOIN tl_page p ON p.id = a.pid
                WHERE (p.id = ? OR p.rootId = ?)
                ORDER BY p.sorting, a.sorting
            ")
            ->execute($rootPageId, $rootPageId);

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

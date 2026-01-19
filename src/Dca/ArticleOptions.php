<?php

use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;
use Contao\Input;

class ArticleOptions extends Backend
{
    public function getArticlesByPage(DataContainer $dc): array
    {
        $pageId = 0;

        // 1) bestehender Datensatz (Modul bearbeiten)
        if ($dc->activeRecord && $dc->activeRecord->page) {
            $pageId = (int) $dc->activeRecord->page;
        }

        // 2) neuer Datensatz / submitOnChange
        if ($pageId <= 0) {
            $pageId = (int) Input::post('page', true);
        }

        if ($pageId <= 0) {
            return [];
        }

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

<?php

namespace Vendor\ArticleInsertBundle\Dca;

use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;

class ArticleOptions extends Backend
{
    public function getArticlesByPage(DataContainer $dc): array
    {
        if (!$dc->activeRecord || !$dc->activeRecord->page) {
            return [];
        }

        $stmt = Database::getInstance()
            ->prepare('SELECT id, title, inColumn FROM tl_article WHERE pid=? ORDER BY sorting')
            ->execute((int) $dc->activeRecord->page);

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

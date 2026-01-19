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
        $pageId = $this->extractPageId($dc);

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

    private function extractPageId(DataContainer $dc): int
    {
        $val = null;

        if ($dc->activeRecord && isset($dc->activeRecord->page)) {
            $val = $dc->activeRecord->page;
        }

        if (empty($val)) {
            $val = Input::post('page', true);
        }

        if (is_array($val)) {
            $val = $val[0] ?? 0;
        }

        if (is_string($val) && str_starts_with($val, 'a:')) {
            $tmp = @unserialize($val, ['allowed_classes' => false]);
            if (is_array($tmp)) {
                $val = $tmp[0] ?? 0;
            }
        }

        return (int) $val;
    }
}

<?php

namespace Vendor\ArticleInsertBundle\Module;

use Contao\ArticleModel;
use Contao\ContentModel;
use Contao\Module;

class ModuleArticleInsert extends Module
{
    protected $strTemplate = 'mod_article_insert';

    protected function compile(): void
    {
        $articleId = (int) ($this->article ?? 0);

        if ($articleId <= 0) {
            $this->Template->content = '';
            return;
        }

        $article = ArticleModel::findByPk($articleId);

        if (null === $article) {
            $this->Template->content = '';
            return;
        }

        $elements = ContentModel::findPublishedByPidAndTable($article->id, 'tl_article');
        $buffer = '';

        if (null !== $elements) {
            while ($elements->next()) {
                $buffer .= $this->getContentElement($elements->id);
            }
        }

        $this->Template->content = $buffer;
    }
}

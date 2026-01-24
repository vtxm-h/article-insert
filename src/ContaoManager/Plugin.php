<?php

namespace Vendor\ArticleInsertBundle\ContaoManager;

use Vendor\ArticleInsertBundle\ArticleInsertBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ArticleInsertBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}

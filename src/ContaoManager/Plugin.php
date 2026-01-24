<?php

namespace Vendor\ArticleInsertBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Vendor\ArticleInsertBundle\ArticleInsertBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ArticleInsertBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}

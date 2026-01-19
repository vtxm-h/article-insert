<?php

use ArticleInsert\Dca\ArticleOptions;

$GLOBALS['TL_DCA']['tl_module']['palettes']['article_insert']
= '{title_legend},name,headline,type;{config_legend},page,article;{template_legend:hide},customTpl';

$GLOBALS['TL_DCA']['tl_module']['fields']['page'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['page'],
    'inputType' => 'pageTree',
    'eval'      => [
        'mandatory' => true,
        'fieldType' => 'radio',
        'tl_class'  => 'w50',
        'submitOnChange' => true, // wichtig
    ],
    'sql'       => "int(10) unsigned NOT NULL default 0",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['article'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['article'],
    'inputType' => 'select',
    'options_callback' => [ArticleOptions::class, 'getArticlesByPage'],
    'eval'      => [
        'mandatory' => true,
        'chosen'    => true,
        'tl_class'  => 'w50',
        'includeBlankOption' => true,
    ],
    'sql'       => "int(10) unsigned NOT NULL default 0",
];

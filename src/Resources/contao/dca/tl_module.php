<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['article_insert']
    = '{title_legend},name,headline,type;{config_legend},article;{template_legend:hide},customTpl';

$GLOBALS['TL_DCA']['tl_module']['fields']['article'] = [
    'label'      => &$GLOBALS['TL_LANG']['tl_module']['article'],
    'inputType'  => 'select',
    'foreignKey' => 'tl_article.title',
    'eval'       => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
    'sql'        => "int(10) unsigned NOT NULL default 0",
];

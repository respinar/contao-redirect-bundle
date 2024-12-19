<?php
declare(strict_types=1);
// src/Resources/contao/dca/tl_redirect.php

use Contao\DataContainer;
use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_redirect'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    'list' => [
        'sorting' => [
            'fields'       => ['tstamp'],
			'flag'         => DataContainer::SORT_DESC,
			'panelLayout'  => 'filter;sort,search,limit'
        ],
        'label' => [
            'fields'       => ['tstamp','source_url','target_url','status_code'],
			'showColumns'  => true,
        ],
        'operations' => [
            'edit' => ['href' => 'act=edit', 'icon' => 'edit.svg'],
            'delete' => ['href' => 'act=delete', 'icon' => 'delete.svg'],
        ],
    ],
    'palettes' => [
        'default' => '{redirect_legend},source_url,target_url;{settings_legend},status_code,active',
    ],
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'source_url' => [
            'label' => ['Source URL', 'The URL to redirect from'],
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'target_url' => [
            'label' => ['Target URL', 'The URL to redirect to (ignored for 410)'],
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'status_code' => [
            'label' => ['HTTP Status', 'The redirect status code'],
            'inputType' => 'select',
            'options' => [
                '301' => '301 Permanent Redirect',
                '302' => '302 Temporary Redirect',
                '410' => '410 Gone', // Added 410 option
            ],
            'eval' => ['tl_class' => 'w50'],
            'sql' => "varchar(3) NOT NULL default '301'",
        ],
        'active' => [
            'label' => ['Active', 'Enable this redirect'],
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default '1'",
        ],
    ],
];
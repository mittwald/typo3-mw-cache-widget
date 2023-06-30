<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Mittwald Cache Widget (APCu & OpCodeCache)',
    'description' => 'Dashboard widget that displays the current memory usage of OpCodeCache or APCu',
    'category' => 'be',
    'author' => 'Mittwald CM Service GmbH',
    'author_email' => 'support@mittwald.de',
    'author_company' => 'Mittwald CM Service GmbH',
    'state' => 'stable',
    'version' => '3.0.0-dev',
    'uploadfolder' => false,
    'constraints' => [
        'depends' =>
            [
                'typo3' => '12.4.0-12.4.99',
            ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

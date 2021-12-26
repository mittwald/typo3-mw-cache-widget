<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Mittwald Cache Widget (APCu & OpCodeCache)',
    'description' => 'Dashboard widget that displays the current memory usage of OpCodeCache or APCu',
    'category' => 'be',
    'author' => 'Mittwald CM Service GmbH',
    'author_email' => 'support@mittwald.de',
    'author_company' => 'Mittwald CM Service GmbH',
    'state' => 'stable',
    'version' => '2.0.0',
    'uploadfolder' => false,
    'constraints' => [
        'depends' =>
            [
                'typo3' => '11.5.0-11.5.99',
                'php' => '7.4.0-8.1.99',
            ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mw_cache_widget".
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Mittwald Cache Widget (APCu & OpCodeCache)',
  'description' => 'Dashboard widget that displays the current memory usage of OpCodeCache or APCu',
  'category' => 'be',
  'author' => 'Mittwald CM Service GmbH',
  'author_email' => 'support@mittwald.de',
  'author_company' => 'Mittwald CM Service GmbH',
  'state' => 'beta',
  'version' => '1.1.0',
  'autoload' => 
  array (
    'psr-4' => 
    array (
      'Mittwald\\CacheStatsWidget\\' => 'Classes',
    ),
  ),
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '10.3.0-10.4.99',
      'php' => '7.2.0-7.4.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'uploadfolder' => false,
);


<?php
declare(strict_types=1);
namespace Mittwald\CacheStatsWidget\Widgets;

/* * *************************************************************
 *  Copyright notice
 *
 *  (C) 2020 Mittwald CM Service GmbH & Co. KG <opensource@mittwald.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either any later version.
 *
 *  The GNU General Public License can be found at
 *  https://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use http\Exception;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Dashboard\Widgets\AbstractDoughnutChartWidget;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * The AbstractExtensionsWidget class is a base class
 * for our Typo3 AbstractDoughnutChart widgets.
 */
class AbstractExtensionsWidget extends AbstractDoughnutChartWidget
{
    const LANG_FILE = 'LLL:EXT:mw_cache_widget/Resources/Private/Language/locallang.xlf';

    /**
     * @var string
     */
    protected $extensionKey = 'mw_cache_widget';

    protected $apiEndpoint30days = '';
    protected $apiEndpoint1day = '';
    protected $height = 4;
    protected $width = 2;
    protected $limit = 8;
    protected $notActiveText = '';
    protected $iconIdentifier = 'tx-mw_cache_widget-widget-icon';
    protected $widgetEnabled = False;
    protected $usedMemory = 0;
    protected $freeMemory = 0;
    protected $sumMemory = 0;


    /**
     * AbstractExtensionsWidget constructor.
     * @param string $identifier
     */
    public function __construct(string $identifier)
    {
        AbstractDoughnutChartWidget::__construct($identifier);
    }

    /*
     * Sets the chart data
     */
    protected function prepareChartData(): void
    {
        $this->loadData();
        $this->chartData = [
            'labels' => [
                "Belegter Speicher",
                "Freier Speicher"
            ],
            'datasets' => [
                [
                    'backgroundColor' => ["#1A568F", "#93C481"],
                    'data' => [$this->usedMemory, $this->freeMemory]
                ]
            ],
        ];
    }



    /**
     * Sets the view components
     */
    protected function initializeView(): void
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $path = ExtensionManagementUtility::extPath($this->extensionKey) . 'Resources/Private/';
        $this->view->getTemplatePaths()->setTemplateRootPaths([$path . 'Templates/']);
        $this->view->getTemplatePaths()->setLayoutRootPaths([$path . 'Layouts/']);
        $this->view->getTemplatePaths()->setPartialRootPaths([$path . 'Partials/']);
        $this->view->setTemplate('Widget/ChartWidget');
    }

    /**
     * Assigns the title and description to the view
     * @return string
     */
    public function renderWidgetContent(): string
    {
        $this->view->assign('title', $this->getTitle());
        $this->view->assign('description', $this->getDescription());
        $this->view->assign('notActive', $this->notActiveText);
        $this->view->assign('sumMemory', $this->sumMemory);
        $this->view->assign('usedMemory', $this->usedMemory);
        $this->view->assign('widgetEnabled', $this->widgetEnabled);
        return $this->view->render();
    }

    /**
     * Gets the data from a data resource
     */
    protected function loadData(): void
    {
        $this->usedMemory = 0;
        $this->freeMemory = 0;
        $this->sumMemory = 0;
    }

    /**
     * @param string $string
     * @return bool if string is in json syntax
     */
    private function isJson(string $string): bool
    {
        @json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

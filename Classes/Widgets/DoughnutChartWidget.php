<?php

declare(strict_types=1);

/****************************************************************
 *  Copyright notice
 *
 *  (C) Mittwald CM Service GmbH & Co. KG <opensource@mittwald.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace Mittwald\CacheStatsWidget\Widgets;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\View\BackendViewFactory;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Dashboard\Widgets\AdditionalCssInterface;
use TYPO3\CMS\Dashboard\Widgets\ButtonProviderInterface;
use TYPO3\CMS\Dashboard\Widgets\ChartDataProviderInterface;
use TYPO3\CMS\Dashboard\Widgets\EventDataInterface;
use TYPO3\CMS\Dashboard\Widgets\JavaScriptInterface;
use TYPO3\CMS\Dashboard\Widgets\RequestAwareWidgetInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;

class DoughnutChartWidget implements WidgetInterface, RequestAwareWidgetInterface, EventDataInterface, AdditionalCssInterface, JavaScriptInterface
{
    private ServerRequestInterface $request;

    public function __construct(
        private readonly WidgetConfigurationInterface $configuration,
        private readonly ChartDataProviderInterface $dataProvider,
        private readonly BackendViewFactory $backendViewFactory,
        private readonly ?ButtonProviderInterface $buttonProvider = null,
        private readonly array $options = [],
    ) {
    }

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    public function renderWidgetContent(): string
    {
        /** @var AbstractCacheWidget $dataProvider */
        $dataProvider = $this->dataProvider;
        $view = $this->backendViewFactory->create($this->request, ['mittwald/mw-cache-widget']);
        $view->assignMultiple([
            'button' => $this->buttonProvider,
            'options' => $this->options,
            'configuration' => $this->configuration,
            'widgetEnabled' => $dataProvider->getWidgetEnabled(),
            'sumMemory' => $dataProvider->getSumMemory(),
            'usedMemory' => $dataProvider->getSumMemory() - $dataProvider->getFreeMemory(),
        ]);
        return $view->render('Widget/ChartWidget');
    }

    public function getEventData(): array
    {
        return [
            'graphConfig' => [
                'type' => 'doughnut',
                'options' => [
                    'maintainAspectRatio' => false,
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                    ],
                    'cutoutPercentage' => 60,
                ],
                'data' => $this->dataProvider->getChartData(),
            ],
        ];
    }

    public function getCssFiles(): array
    {
        return [];
    }

    public function getJavaScriptModuleInstructions(): array
    {
        return [
            JavaScriptModuleInstruction::create('@typo3/dashboard/contrib/chartjs.js'),
            JavaScriptModuleInstruction::create('@typo3/dashboard/chart-initializer.js'),
        ];
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}

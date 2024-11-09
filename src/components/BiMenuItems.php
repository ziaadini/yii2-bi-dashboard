<?php

namespace ziaadini\bidashboard\components;

use Yii;

class BiMenuItems
{
    public static function items()
    {
        return [
            [
                'group' => 'Dashboard',
                'label' => Yii::t('biDashboard', 'Dashboards'),
                'icon' => '	fal fa-table',
                'url' => ['/bidashboard/report-dashboard']
            ],
            [
                'group' => 'Widget',
                'label' => Yii::t('biDashboard', 'Widget'),
                'icon' => 'fal fa-cogs',
                'url' => ['/bidashboard/report-widget']
            ],
            [
                'group' => 'Alerts',
                'label' => Yii::t('biDashboard', 'Alerts'),
                'icon' => 'fal fa-bells',
                'url' => ['/bidashboard/report-alert']
            ],
            [
                'group' => 'Users',
                'label' => Yii::t('biDashboard', 'Users'),
                'icon' => 'fal fa-users',
                'url' => ['/bidashboard/report-user']
            ],
            [
                'group' => 'Page',
                'label' => Yii::t('biDashboard', 'Page'),
                'icon' => 'fal fa-building',
                'url' => ['/bidashboard/report-page']
            ],
            [
                'group' => 'Year',
                'label' => Yii::t('biDashboard', 'Year'),
                'icon' => 'fal fa-calendar',
                'url' => ['/bidashboard/report-year']
            ],
            [
                'group' => 'Sharing',
                'label' => Yii::t('biDashboard', 'Sharing'),
                'icon' => 'fal fa-share',
                'url' => ['/bidashboard/sharing-page']
            ],
            [
                'group' => 'External Data',
                'label' => Yii::t('biDashboard', 'External Data'),
                'icon' => 'fal fa-file-excel',
                'url' => ['/bidashboard/external-data']
            ],
            [
                'group' => 'Model Class',
                'label' => Yii::t('biDashboard', 'Model Class'),
                'icon' => 'fal fa-at',
                'url' => ['/bidashboard/report-model-class']
            ],

        ];

    }

}
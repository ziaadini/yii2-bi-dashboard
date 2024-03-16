<?php

namespace sadi01\bidashboard\helpers;
use Yii;

class FormatHelper
{
    public static function formatNumber($number)
    {
        return number_format($number, 0, '.', ',');
    }

    public static function formatCurrency($number)
    {
        return number_format($number) . ' ' .Yii::t('biDashboard', 'Rials');
    }

    public static function formatGram($number)
    {
        return number_format($number) . ' ' . Yii::t('biDashboard', 'Gram');
    }

    public static function formatKiloGram($number)
    {
        return $number/1000 . ' ' . Yii::t('biDashboard', 'Kilo Gram');
    }
}
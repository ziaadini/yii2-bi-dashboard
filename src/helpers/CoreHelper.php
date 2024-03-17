<?php


namespace sadi01\bidashboard\helpers;

use sadi01\bidashboard\models\ReportBox;
use sadi01\bidashboard\traits\CoreTrait;
use Yii;

/**
 * @author SADi <sadshafiei.01@gmail.com>
 */
class CoreHelper
{
    use CoreTrait;

    public static function getInstance()
    {
        return new self();
    }
    public static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    public static function getStartAndEndOfDay($time_zone = 'Asia/Tehran', $time = null)
    {
        date_default_timezone_set($time_zone);
        $time = $time ?: time();
        $start = strtotime("today", $time);
        $end   = strtotime("tomorrow", $start) - 1;

        return [
            'start' => $start,
            'end'   => $end,
        ];
    }

    public static function getMonthsCountBetweenTwoDays($min_day, $max_day)
    {
        $min_day_parse = date_parse($min_day);
        $max_day_parse = date_parse($max_day);

        $min_year = $min_day_parse['year'];
        $max_year = $max_day_parse['year'];

        $min_month = $min_day_parse['month'];
        $max_month = $max_day_parse['month'];

        return (($max_year - $min_year) * 12) + ($max_month - $min_month);
    }

    public static function getMonth($time = null)
    {
        return Yii::$app->pdate->jdate('m', $time ?: time(), '', 'Asia/Tehran', 'en');
    }

    public static function getCurrentMonth()
    {
        return self::getMonth();
    }

    public static function getYear($time = null)
    {
        return Yii::$app->pdate->jdate('Y', $time ?: time(), '', 'Asia/Tehran', 'en');
    }

    public static function getCurrentYear()
    {
        return self::getYear();
    }

    public static function getDay($time = null)
    {
        return Yii::$app->pdate->jdate('d', $time ?: time(), '', 'Asia/Tehran', 'en');
    }

    public static function getCurrentDay()
    {
        return self::getDay();
    }

    /**
     * @param $dateType //e.g. ReportBox::DATE_TYPE_TODAY = 1 and 2,3,4,5,6,7,8
     * @return array
     */
    public static function getStartAndEndTimeStampsForStaticDate(int $dateType) : array
    {
        $instance = self::getInstance();

        $date_array = [];
        $secondsInDay = 60 * 60 * 24;
        $secondsInMonth = 60 * 60 * 24 * 30;
        $secondsInYear = 60 * 60 * 24 * 365;

        switch ($dateType) {
            case 1:
                $date_array = self::getStartAndEndOfDay();
                break;
            case 2:
                $date_array = self::getStartAndEndOfDay(time: time() - $secondsInDay);
                break;
            case 3:
                $date_array = $instance->getStartAndEndOfCurrentWeek();
                break;
            case 4:
                $date_array = $instance->getStartAndEndOfLastWeek();
                break;
            case 5:
                $date_array = $instance->getStartAndEndOfMonth();
                break;
            case 6:
                $date_array = $instance->getStartAndEndOfMonth(timestamp: time() - $secondsInMonth);
                break;
            case 7:
                $date_array = $instance->getStartAndEndOfYear();
                break;
            case 8:
                $date_array = $instance->getStartAndEndOfYear(timestamp: time() - $secondsInYear);
                break;
        }
        return $date_array;
    }
}
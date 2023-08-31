<?php

namespace sadi01\bidashboard;

/**
 *
 * ```php
 * 'modules' => [
 *     'bidashboard' => [
 *          'class' => 'sadi01\bidashboard\Module'
 *     ]
 * ]
 * ```
 *
 * @author Sadegh shafii <sadshafiei.01@gmail.com>
 * @since  1.0
 */
class Module extends \yii\base\Module
{
    /**
     * The module name
     */
    const MODULE = "bidashboard";
    public $layout="bid_main.php";
}
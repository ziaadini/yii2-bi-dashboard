<?php

namespace ziaadini\bidashboard;

/**
 *
 * ```php
 * 'modules' => [
 *     'bidashboard' => [
 *          'class' => 'ziaadini\bidashboard\Module'
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
    public $layout = "bid_main";
}

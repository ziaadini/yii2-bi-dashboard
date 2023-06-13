<?php

use  yii\helpers\Url;

/**@var $url string */
?>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-av-timer"></i>
                        <span class="hide-menu">داشبورد</span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item">
                            <a href="<?= Url::to(['/bidashboard']) ?>" class="sidebar-link">
                                <i class="mdi mdi-adjust"></i>
                                <span class="hide-menu"> هوش تجاری </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <div class="devider"></div>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-format-color-fill"></i>
                        <span class="hide-menu">ویجت‌</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="<?= Url::toRoute(['/bidashboard/report-widget']) ?>" class="sidebar-link">
                                <i class="mdi mdi-toggle-switch"></i>
                                <span class="hide-menu">ویجت‌ها</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <div class="devider"></div>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-format-color-fill"></i>
                        <span class="hide-menu">صفحه‌ها</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="<?= Url::toRoute(['/bidashboard/report-page']) ?>" class="sidebar-link">
                                <i class="mdi mdi-toggle-switch"></i>
                                <span class="hide-menu">لیست</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <div class="devider"></div>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false">
                        <i class="mdi mdi-adjust text-info"></i>
                        <span class="hide-menu">خروج</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

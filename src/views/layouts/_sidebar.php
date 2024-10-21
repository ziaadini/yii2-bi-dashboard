<?php


use ziaadini\bidashboard\components\Menu;

$menu_items = [];
$menu_items = [
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
?>
<aside class="left-sidebar">

    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <?php if (Yii::$app->user->identity): ?>
                <?= Menu::widget(
                    [
                        'options' => ['id' => 'sidebarnav'],
                        'itemOptions' => ['class' => 'sidebar-item'],
                        'items' => $menu_items,
                    ]
                ) ?>
            <?php endif; ?>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

<?php
$script = <<<JS
$.extend($.expr[":"], {
"containsIN": function(elem, i, match, array) {
return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
}
});

 $('#search').keyup(function(){
     // Search text
  var text = $(this).val();
 
  // Hide all content class element
  $('.sidebar-item').hide();
  $('.devider').hide(); 

  var sidebar_item_contains_text = $('.sidebar-item:containsIN("'+text+'")');
  // Search and show
  //show sidebar item contains text + nex div.devider
  sidebar_item_contains_text.show().next('.devider').show();
  
  sidebar_item_contains_text.parent().addClass('in');
  
  sidebar_item_contains_text.parent().prev().addClass('active');

    if(text.length === 0){
          $("#sidebarnav ul").removeClass('in');
          $("#sidebarnav a").removeClass('active');
    }
 });
JS;
$this->registerJs($script);

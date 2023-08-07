<?php


use sadi01\bidashboard\components\Menu;

$menu_items = [];
$menu_items = [
    [
        'group' => 'Widget',
        'label' => Yii::t('app', 'Widget'),
        'icon' => 'fa fa-cogs',
        'url' => ['/bidashboard/report-widget']
    ],
    [
        'group' => 'Page',
        'label' => Yii::t('app', 'Page'),
        'icon' => 'fas fa-building',
        'url' => ['/bidashboard/report-page']
    ],
    [
        'group' => 'Year',
        'label' => Yii::t('app', 'Year'),
        'icon' => 'fa fa-calendar',
        'url' => ['/bidashboard/report-year']
    ],
    [
        'group' => 'Sharing',
        'label' => Yii::t('app', 'Sharing'),
        'icon' => 'fas fa-share',
        'url' => ['/bidashboard/sharing-page']
    ],
    [
        'group' => 'External Data',
        'label' => Yii::t('app', 'External Data'),
        'icon' => 'fas fa-share',
        'url' => ['/bidashboard/external-data']
    ],
];
?>
    <aside class="left-sidebar">

        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">

                <?= Menu::widget(
                    [
                        'options' => ['id' => 'sidebarnav'],
                        'itemOptions' => ['class' => 'sidebar-item'],
                        'items' => $menu_items,
                    ]
                ) ?>
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
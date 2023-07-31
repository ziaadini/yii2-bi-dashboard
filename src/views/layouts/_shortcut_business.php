<?php

use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this View */
/* @var $base_url string */
?>
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>

<?php
$script = <<< JS
$('#shortcutBusiness').on('change', function(e) {
    e.preventDefault();
    var id=$(this).val().split("#")[0];
    var actionUrl=$(this).val().split("#")[2];
    var baseUrl=$(this).data('base-url');
    window.location.href = baseUrl+actionUrl+'?id='+id;
});
JS;
$this->registerJs($script);

?>
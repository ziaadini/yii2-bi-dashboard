<?php
use yii\helpers\Html;
use yii\web\View;
use sadi01\bidashboard\models\ReportBoxWidgets;
use sadi01\bidashboard\models\ReportYear;
use sadi01\bidashboard\models\ReportBox;
use yii\helpers\Url;

$script = <<< JS
    $(document).ready(function() {
        $("#select_year_$box->id, #select_month_$box->id, #select_day_$box->id").on("change", function() {
            
            const selectedYear = $("#select_year_$box->id").val();
            const selectedMonth = $("#select_month_$box->id").val();
            const selectedDay = $("#select_day_$box->id").val();
            
            // Construct the URL based on the selected values
            const constructedUrl = '/bidashboard/report-box/run-box?id='+$box->id+'&'+'year='+selectedYear+'&month='+selectedMonth+'&day='+selectedDay;
        
            // Update the data-url attribute
            $("#sync_btn_$box->id").attr("data-url", constructedUrl);
        });
    });
JS;
$this->registerJs($script);


$pdate = Yii::$app->pdate;

?>

<div class="card text-center table-responsive border rounded-md shadow mb-5">
    <div class="card-header d-flex align-items-center justify-content-between px-3">
        <span><?= $box->title ?? 'عنوان باکس' ?> | <span class="font-12 font-normal">(<?= ReportBox::itemAlias('RangeType', $box->range_type) ?>)</span></span>
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center">
                <div class="d-flex mr-1">
                    <?php if ($box->range_type == ReportBox::RANGE_TYPE_DAILY): ?>
                        <div>
                            <select name="month" class="form-control rounded-md" id="select_month_<?= $box->id ?>">
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>" <?= $box->lastRunDate['month'] == $i ? 'selected' : '' ?> ><?= $pdate->jdate_words(['mm' => $i])['mm'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="px-1">
                            <select name="year" class="form-control rounded-md" id="select_year_<?= $box->id ?>">
                                <?php foreach (ReportYear::itemAlias('List') as $Year): ?>
                                    <option <?= $Year ?> <?= $box->lastRunDate['year'] == $Year ? 'selected' : '' ?> ><?= $Year ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php elseif ($box->range_type == ReportBox::RANGE_TYPE_MONTHLY): ?>
                        <div class="px-1">
                            <select name="year" class="form-control rounded-md" id="select_year_<?= $box->id ?>">
                                <?php foreach (ReportYear::itemAlias('List') as $Year): ?>
                                    <option <?= $Year ?> <?= $box->lastRunDate['year'] == $Year ? 'selected' : '' ?> ><?= $Year ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <?= Html::a('<i class="fas fa-sync text-success font-18"></i>', "javascript:void(0)",
                    [
                        'id' => 'sync_btn_'.$box->id,
                        'title' => Yii::t('biDashboard', 'Update Box'),
                        'aria-label' => Yii::t('yii', 'Update Box'),
                        'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                        'data-pjax' => '0',
                        'data-url' => Url::to(['/bidashboard/report-box/run-box', 'id' => $box->id, 'year' => $box->lastRunDate['year'], 'month' => $box->lastRunDate['month'], 'day' => $box->lastRunDate['day']]),
                        'class' => "p-jax-btn d-flex",
                        'data-title' => Yii::t('biDashboard', 'Update Box'),
                        'data-toggle' => 'tooltip',
                    ]) ?>
                <span class="font-bold mx-3 mt-1 text-secondary">|</span>
            </div>
            <?= Html::a('<i class="fas fa-edit text-info font-18"></i>', "javascript:void(0)",
                [
                    'data-pjax' => '0',
                    'class' => "d-flex mr-2",
                    'data-size' => 'modal-xl',
                    'data-title' => Yii::t('biDashboard', 'Edit Box'),
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-pjax-bi',
                    'data-url' => Url::to(['report-box/update', 'id' => $box->id]),
                    'data-handle-form-submit' => 1,
                    'data-reload-pjax-container' => 'p-jax-report-dashboard-view'
                ]) ?>
            <?= Html::a('<i class="fas fa-trash-alt text-danger font-18"></i>', "javascript:void(0)",
                [
                    'title' => Yii::t('biDashboard', 'Delete Box'),
                    'aria-label' => Yii::t('yii', 'Delete Box'),
                    'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                    'data-pjax' => '0',
                    'data-url' => Url::to(['/bidashboard/report-box/delete', 'id' => $box->id]),
                    'class' => "p-jax-btn d-flex",
                    'data-title' => Yii::t('biDashboard', 'Delete Box'),
                    'data-toggle' => 'tooltip',
                ]) ?>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="bg-white mb-0 table table-hover table-striped table-bordered">
            <thead class="text-white bg-inverse">
            <tr>
                <th class="text-center font-bold"><?= Yii::t('biDashboard', 'widgets') ?></th>
                <?php
                for ($i = 1; $i <= $box->rangeDateCount; $i++) {
                    if ($box->range_type == ReportBox::RANGE_TYPE_DAILY){
                        echo '<th scope="col" class="text-center font-bold">'. $i . '</th>';
                    }
                    elseif($box->range_type == ReportBox::RANGE_TYPE_MONTHLY) {
                        echo '<th scope="col" class="text-center">' . $pdate->jdate_words(['mm' => $i], ' ') . '</th>';
                    }
                } ?>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($box->boxWidgets)): ?>
                <?php foreach($box->boxWidgets as $table):?>
                    <tr>
                        <td class="text-center align-middle"><?= $table->title ?? $table->widget->title ?> | <span class="font-12 text-muted"><?= $table->description ?></span></td>
                        <?php for ($i = 1; $i <= $table->rangeDateCount; $i++) {
                            if ($box->range_type == ReportBox::RANGE_TYPE_DAILY){
                                if (!empty($table->results['combine'])){
                                    if (array_key_exists($i , $table->results['combine']) == 1){
                                        echo '<td scope="col" class="text-center align-middle">';
                                        echo ReportBoxWidgets::getFormattedValue($table->widget_field_format, $table->results['combine'][$i]);
                                        echo "<a title='کپی' class='far fa-copy font-14 text-secondary p-1' onclick='copyToClipboard(\"{$table->results['combine'][$i]}\")' href='javascript:void(0)' data-pjax='0'></a>";
                                        if ($table->results['percentageOfChange'][$i-1] != 0){
                                            echo '<br>' . '%' . abs($table->results['percentageOfChange'][$i-1]);
                                            echo '<i class="p-1 mt-2 fa ' . ($table->results['percentageOfChange'][$i-1] < 0 ? 'fas fa-arrow-alt-circle-down text-danger' : 'fas fa-arrow-alt-circle-up text-success') . '"></i>';
                                        }
                                        echo '</td>';
                                    }
                                    else
                                        echo '<td scope="col" class="text-center align-middle">'. '-' . '</td>';
                                }
                            }
                            elseif($box->range_type == ReportBox::RANGE_TYPE_MONTHLY) {
                                if (!empty($table->results['combine'])){
                                    if (array_key_exists($pdate->jdate_words(['mm' => $i], ' ') , $table->results['combine']) == 1){
                                        echo '<td scope="col" class="text-center align-middle">';
                                        echo ReportBoxWidgets::getFormattedValue($table->widget_field_format, $table->results['combine'][$pdate->jdate_words(['mm' => $i], ' ')]);
                                        echo "<a title='کپی' class='far fa-copy font-14 text-secondary p-1' onclick='copyToClipboard(\"{$table->results['combine'][$pdate->jdate_words(['mm' => $i], ' ')]}\")' href='javascript:void(0)' data-pjax='0'></a>";
                                        if ($table->results['percentageOfChange'][$i-1] != 0){
                                            echo '<br>' . '%' . abs($table->results['percentageOfChange'][$i-1]);
                                            echo '<i class="p-1 mt-2 fa ' . ($table->results['percentageOfChange'][$i-1] < 0 ? 'fas fa-arrow-alt-circle-down text-danger' : 'fas fa-arrow-alt-circle-up text-success') . '"></i>';
                                        }
                                        echo '</td>';
                                    }
                                    else
                                        echo '<td scope="col" class="text-center align-middle">'. '-' . '</td>';
                                }
                            }
                        } ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center min-h-28 w-100">
                    <span class="text-muted">این باکس خالی است!</span>
                </div>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex align-items-center justify-content-between px-3">
        <span class="text-muted font-12 mr-3"><?= $box->description ?? '(توضیحات باکس)' ?></span>
        <div class="d-flex">
            <div class="d-flex align-items-center mr-2">
                <?= Html::a('<i class="fas fa-arrow-up font-light"></i>', 'javascript:void(0)',
                    [
                        'title' => Yii::t('biDashboard', 'Moving'),
                        'aria-label' => Yii::t('yii', 'Moving'),
                        'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                        'data-pjax' => '0',
                        'data-url' => Url::to(['/bidashboard/report-box/dec-order', 'id' => $box->id]),
                        'class' => "p-jax-btn text-secondary mr-2",
                        'data-title' => Yii::t('biDashboard', 'Moving'),
                        'data-toggle' => 'tooltip',
                    ]); ?>
                <?= Html::a('<i class="fas fa-arrow-down font-light"></i>', 'javascript:void(0)',
                    [
                        'title' => Yii::t('biDashboard', 'Moving'),
                        'aria-label' => Yii::t('yii', 'Moving'),
                        'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                        'data-pjax' => '0',
                        'data-url' => Url::to(['/bidashboard/report-box/inc-order', 'id' => $box->id]),
                        'class' => "p-jax-btn text-secondary",
                        'data-title' => Yii::t('biDashboard', 'Moving'),
                        'data-toggle' => 'tooltip',
                    ]); ?>
            </div>
            <?= Html::a(Yii::t('biDashboard', 'Add and Edit Widgets'), "javascript:void(0)",
                [
                    'data-pjax' => '0',
                    'class' => "btn btn-info btn-sm rounded-md font-12 ml-2",
                    'data-size' => 'modal-xl',
                    'data-title' => Yii::t('biDashboard', 'Add and Edit Widgets'),
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-pjax-bi',
                    'data-url' => Url::to(['report-box-widget/update', 'boxId' => $box->id]),
                    'data-handle-form-submit' => 1,
                    'data-reload-pjax-container' => 'p-jax-report-dashboard-view'
                ]) ?>
        </div>
    </div>
</div>

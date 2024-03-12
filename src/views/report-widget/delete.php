<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\ReportBoxWidgets;
use sadi01\bidashboard\models\ReportDashboard;

/** @var View $this */
/** @var ReportWidget $model */
/** @var ReportPage $pages */
/** @var ReportDashboard $dashboards */

?>
<div class="d-flex justify-content-center flex-column align-items-center">
    <i class="fal fa-exclamation-circle text-danger fa-10x"></i>
    <h1 class="font-normal h4 mt-3"><?= Yii::t('biDashboard', 'Do you want to remove the widget?') ?></h1>
    <div class="d-flex justify-content-end">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'enableClientValidation' => true]); ?>
        <?= $form->field($model, 'description')->hiddenInput(['value' => $model->id])->label(false) ?>
        <div class="d-flex mt-3">
            <?= Html::submitButton(Yii::t('biDashboard', 'Yes'), ['class' => 'btn btn-primary btn-lg rounded-md mr-2 px-4']) ?>
            <button type="button" class="btn btn-danger btn-lg rounded-md ml-2 px-4" data-dismiss="modal" aria-label="ٰclose"><?= Yii::t('biDashboard', 'No') ?></button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php if (!empty($pages) || !empty($dashboards)): ?>
    <div class="card border rounded-md mt-4 mb-0">
    <div class="card-header d-flex align-items-center justify-content-center px-3">
        <span class="alert alert-danger mb-0 px-2 py-1 rounded-md"><?= Yii::t('biDashboard', 'This widget is used in the following pages and dashboards') ?></span>
    </div>
    <div class="card-body row min-h-60 py-3">

        <?php if (!empty($dashboards)): ?>
            <!--Dashboard Table-->
            <table class="bg-white mb-0 table table-hover table-striped table-bordered">
                <thead class="text-white bg-secondary">
                <tr>
                    <th scope="col" class="text-center font-normal"><?= Yii::t('biDashboard', 'Row') ?></th>
                    <th scope="col" class="text-center font-normal"><?= Yii::t('biDashboard', 'Dashboard ID') ?></th>
                    <th scope="col" class="text-center font-normal"><?= Yii::t('biDashboard', 'Dashboard Name') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dashboards as $index => $dashboard): ?>
                    <tr>
                        <td scope="col" class="text-center align-middle"><?= ++$index ?></td>
                        <td scope="col" class="text-center align-middle"><?= $dashboard->id ?></td>
                        <td scope="col" class="text-center align-middle"><?= $dashboard->title ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (!empty($pages)): ?>
            <!-- Pges Table -->
            <table class="bg-white mb-0 table table-hover mt-3 table-striped table-bordered">
                <thead class="text-white bg-secondary">
                <tr>
                    <th scope="col" class="text-center font-normal"><?= Yii::t('biDashboard', 'Row') ?></th>
                    <th class="text-center font-normal"><?= Yii::t('biDashboard', 'Page ID') ?></th>
                    <th scope="col" class="text-center font-normal"><?= Yii::t('biDashboard', 'Page Name') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($pages as $index => $page): ?>
                    <tr>
                        <td scope="col" class="text-center align-middle"><?= ++$index ?></td>
                        <td scope="col" class="text-center align-middle"><?= $page->id ?></td>
                        <td scope="col" class="text-center align-middle"><?= $page->title ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</div>
<?php endif; ?>
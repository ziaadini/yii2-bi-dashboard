<?php

namespace sadi01\bidashboard\models;

use Yii;

/**
 * This is the model class for table "report_widget_result".
 *
 * @property int $id
 * @property string|null $add_on
 * @property int $widget_id
 * @property int $start_range
 * @property int $end_range
 * @property string|null $run_controller
 * @property string|null $run_action
 * @property int $status
 * @property int $updated_at
 * @property int $created_at
 * @property int $deleted_at
 * @property int $update_by
 * @property int $created_by
 *
 * @property ReportWidget $widget
 */
class ReportWidgetResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_widget_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['add_on'], 'safe'],
            [['widget_id', 'start_range', 'end_range', 'updated_at', 'created_at', 'update_by', 'created_by'], 'required'],
            [['widget_id', 'start_range', 'end_range', 'status', 'updated_at', 'created_at', 'deleted_at', 'update_by', 'created_by'], 'integer'],
            [['run_controller'], 'string', 'max' => 256],
            [['run_action'], 'string', 'max' => 128],
            [['widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportWidget::class, 'targetAttribute' => ['widget_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'add_on' => Yii::t('biDashboard', 'Add On'),
            'widget_id' => Yii::t('biDashboard', 'Widget ID'),
            'start_range' => Yii::t('biDashboard', 'Start Range'),
            'end_range' => Yii::t('biDashboard', 'End Range'),
            'run_controller' => Yii::t('biDashboard', 'Run Controller'),
            'run_action' => Yii::t('biDashboard', 'Run Action'),
            'status' => Yii::t('biDashboard', 'Status'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'update_by' => Yii::t('biDashboard', 'Update By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
        ];
    }

    /**
     * Gets query for [[Widget]].
     *
     * @return \yii\db\ActiveQuery|ReportWidgetQuery
     */
    public function getWidget()
    {
        return $this->hasOne(ReportWidget::class, ['id' => 'widget_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReportWidgetResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ReportWidgetResultQuery(get_called_class());
        $query->notDeleted();
        return $query;
    }
}

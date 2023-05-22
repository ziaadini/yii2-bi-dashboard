<?php

namespace sadi01\bidashboard\models;

use Yii;

/**
 * This is the model class for table "report_model_class".
 *
 * @property int $id
 * @property string $title
 * @property string $search_model_class
 * @property string|null $search_model_method
 * @property string|null $search_model_run_result_view
 * @property int $status
 * @property int $deleted_at
 * @property int $updated_at
 * @property int $created_at
 * @property int $updated_by
 * @property int $created_by
 */
class ReportModelClass extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_model_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'search_model_class'], 'required'],
            [['status', 'deleted_at', 'updated_at', 'created_at', 'updated_by', 'created_by'], 'integer'],
            [['title', 'search_model_class', 'search_model_method', 'search_model_run_result_view'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'title' => Yii::t('biDashboard', 'Title'),
            'search_model_class' => Yii::t('biDashboard', 'Search Model Class'),
            'search_model_method' => Yii::t('biDashboard', 'Search Model Method'),
            'search_model_run_result_view' => Yii::t('biDashboard', 'Search Model Run Result View'),
            'status' => Yii::t('biDashboard', 'Status'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \sadi01\bidashboard\models\query\ReportModelClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \sadi01\bidashboard\models\query\ReportModelClassQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        $nowDate = new \DateTime('UTC');
        if ($this->isNewRecord){
            $this->created_by = Yii::$app->user->id;
            $this->created_at = $nowDate->getTimestamp();
        }
        $this->updated_at = $nowDate->getTimestamp();
        $this->updated_by = Yii::$app->user->id;

        return parent::beforeSave($insert);
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted')
            ],
        ];

        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
}

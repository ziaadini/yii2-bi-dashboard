<?php

namespace sadi01\bidashboard\models;

use sadi01\bidashboard\traits\AjaxValidationTrait;
use sadi01\bidashboard\traits\CoreTrait;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use sadi01\bidashboard\models\ReportPage;

/**
 * This is the model class for table "sharing_page".
 *
 * @property int $id
 * @property int $slave_id
 * @property int $page_id
 * @property string $access_key
 * @property int|null $expire_time
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property ReportPage $page
 * @mixin SoftDeleteBehavior
 * @mixin BlameableBehavior
 * @mixin TimestampBehavior
 *
 *
 */
class SharingPage extends \yii\db\ActiveRecord
{
    use AjaxValidationTrait;
    use CoreTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

    public static function getDb()
    {
        return Yii::$app->biDB;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%report_sharing_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            [['page_id', 'expire_time', 'slave_id'], 'required'],
            [['page_id', 'expire_time', 'slave_id'], 'integer'],
            [['access_key'], 'string', 'max' => 64],
            [['access_key'], 'unique'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportPage::class, 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->access_key = Yii::$app->security->generateRandomString();
        }
        $this->expire_time = $this->jalaliToTimestamp($this->expire_time, "Y/m/d H:i:s");
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'page_id' => Yii::t('biDashboard', 'Page ID'),
            'access_key' => Yii::t('biDashboard', 'Access Key'),
            'expire_time' => Yii::t('biDashboard', 'Expire Time'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery|ReportPageQuery
     */
    public function getPage()
    {
        return $this->hasOne(ReportPage::class, ['id' => 'page_id']);
    }

    public function expire()
    {
        $this->expire_time = time();
        $this->save(false);
    }

    public function isExpire(): bool
    {
        return ($this->expire_time > time());
    }

    public function canDelete()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     * @return SharingPageQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new SharingPageQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public static function itemAlias($type, $code = NULL)
    {
        $data = [];
        if ($type == 'List') {
            $data = ReportPage::find()->select(['id', 'title'])->asArray()->all();
        }
        $_items = [
            'Status' => [
                self::STATUS_DELETED => Yii::t('biDashboard', 'DELETED'),
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'ACTIVE'),
            ],
            'StatusClass' => [
                self::STATUS_DELETED => 'danger',
                self::STATUS_ACTIVE => 'success',
            ],
            'StatusColor' => [
                self::STATUS_DELETED => '#ff5050',
                self::STATUS_ACTIVE => '#04AA6D',
            ],
            'List' => $data];
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'deleted_at' => time(),
                    'status' => self::STATUS_DELETED
                ],
                'restoreAttributeValues' => [
                    'deleted_at' => 0,
                    'status' => self::STATUS_ACTIVE
                ],
                'replaceRegularDelete' => false,
                'invokeDeleteEvents' => false
            ],
        ];
    }
}
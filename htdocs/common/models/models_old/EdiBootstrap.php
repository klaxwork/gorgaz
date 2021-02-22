<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArEdiBootstrap;

/**
 * This is the model class for table "edi_bootstrap".
 *
 * @property int $id
 * @property int $edi_use_factory_ref
 * @property string $application_id
 * @property string $application_key
 * @property string $application_version
 * @property string $application_title
 * @property string $domain
 * @property string $data
 * @property string $dt_last_update
 * @property string $dt_expire_period
 * @property bool $is_default
 *
 * @property AppBranches[] $appBranches
 * @property AppEmployees[] $appEmployees
 * @property AppGallery[] $appGalleries
 * @property AppPartners[] $appPartners
 * @property AppProducts[] $appProducts
 * @property AppQuests[] $appQuests
 * @property AppWebhooks[] $appWebhooks
 * @property CmsMediaStorage[] $cmsMediaStorages
 * @property EbsTemplates[] $ebsTemplates
 * @property EcmOrderProducts[] $ecmOrderProducts
 * @property EdiUseFactory $ediUseFactoryRef
 */
class EdiBootstrap extends RArEdiBootstrap
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edi_bootstrap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edi_use_factory_ref', 'application_id', 'application_key', 'application_version', 'domain'], 'required'],
            [['edi_use_factory_ref'], 'default', 'value' => null],
            [['edi_use_factory_ref'], 'integer'],
            [['data', 'dt_expire_period'], 'string'],
            [['dt_last_update'], 'safe'],
            [['is_default'], 'boolean'],
            [['application_id'], 'string', 'max' => 50],
            [['application_key'], 'string', 'max' => 10],
            [['application_version'], 'string', 'max' => 32],
            [['application_title', 'domain'], 'string', 'max' => 255],
            [['edi_use_factory_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiUseFactory::className(), 'targetAttribute' => ['edi_use_factory_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edi_use_factory_ref' => 'Edi Use Factory Ref',
            'application_id' => 'Application ID',
            'application_key' => 'Application Key',
            'application_version' => 'Application Version',
            'application_title' => 'Application Title',
            'domain' => 'Domain',
            'data' => 'Data',
            'dt_last_update' => 'Dt Last Update',
            'dt_expire_period' => 'Dt Expire Period',
            'is_default' => 'Is Default',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppBranches()
    {
        return $this->hasMany(AppBranches::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppEmployees()
    {
        return $this->hasMany(AppEmployees::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppGalleries()
    {
        return $this->hasMany(AppGallery::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppPartners()
    {
        return $this->hasMany(AppPartners::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProducts()
    {
        return $this->hasMany(AppProducts::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuests()
    {
        return $this->hasMany(AppQuests::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppWebhooks()
    {
        return $this->hasMany(AppWebhooks::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaStorages()
    {
        return $this->hasMany(CmsMediaStorage::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEbsTemplates()
    {
        return $this->hasMany(EbsTemplates::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmOrderProducts()
    {
        return $this->hasMany(EcmOrderProducts::className(), ['edi_bootstrap_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdiUseFactoryRef()
    {
        return $this->hasOne(EdiUseFactory::className(), ['id' => 'edi_use_factory_ref'])->alias('factory');
    }

    public static function getDefaultBootstrap()
    {
        return self::find()->where(['is_default' => true])->one();
    }

    public static function getCurrentBootstrap()
    {
        if (!isset(Yii::$app->fw->work->id)) {
            return false;
        }
        $oBootstrap = EdiBootstrap::model()->with()->findByAttributes(array('edi_use_factory_ref' => Yii::app()->fw->work->id));
        if (empty($oBootstrap)) {
            return false;
        }
        return $oBootstrap->id;
    }

    public static function getBootstrap($id = false)
    {
        if ($id) {
            $oBootstrap = EdiBootstrap::model()->findByPk($id);
        } else {
            if (!isset(Yii::app()->fw->work->id)) {
                return false;
            }
            $oBootstrap = EdiBootstrap::model()->with()->findByAttributes(array('edi_use_factory_ref' => Yii::app()->fw->work->id));
        }
        if (empty($oBootstrap)) {
            return false;
        }
        return $oBootstrap;
    }

    public static function getByKey($dev_key = 'qw:mirror')
    {
        $oBootstrap = EdiBootstrap::getDefaultBootstrap();
        if (empty($oBootstrap)) {
            return false;
        }
        return $oBootstrap;
    }

}

<?php

namespace common\components;

use \yii;
//use yii\base\Model;
use common\models\models\SysVars;

class Vars //extends yii\base\Model
{
    public $vars = [];

    //разрешено
    /*/
    public $rules = array(
        'apps.*' => array(
            'groups' => array('SYSTEM'),
            'users' => array('admin'),
        ),
        '*' => array(
            'groups' => array('SYSTEM'),
            'users' => array('admin'),
        ),
    );
    //*/

    public function __construct()
    {
        //M::printr('init');
    }

    public function getVars()
    {
        $oVars = SysVars::find()->all();
        $vars = [];
        foreach ($oVars as $oVar) {
            $vars[$oVar->variable] = $oVar->value;
        }
        M::printr($vars, '$vars');
    }

    public static function getVar($var_name = 'LastHyntUpdate')
    {
        $oVar = SysVars::find()->where(['variable' => $var_name])->one();
        return $oVar->value;
    }

    public function setVar($variable = 'LastHyntUpdate')
    {

        //$LastHyntUpdate->value = ;
    }


}



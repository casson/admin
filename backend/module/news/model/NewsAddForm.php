<?php

namespace app\module\news\model;

use Yii;
use yii\base\Model;

class NewsAddForm extends Model
{
    public $title;
    public $content;
    public $type;
    
    public function attributeLabels()
    {
        return array(
            'title'=>Yii::t('global', 'title'),
            'type' =>Yii::t('global', 'typeid'),
            'content'=>Yii::t('global', 'content')
        );
    }
    
    public function getNewsType()
    {   
        $newsTypes = Yii::$app->params['news']['type'];
        $newsTypes[0] = '请选择资讯类型';
        array_multisort($newsTypes,SORT_DESC,SORT_NUMERIC);
        return $newsTypes;
    }
    
}
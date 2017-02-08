<?php

namespace app\module\news\model;

use Yii;
use yii\base\Model;
use app\module\news\model\News;

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
    
    public function addNews()
    {
        $model = new News();
        $model->title = $this->title;
        $model->content = $this->content;
        $model->type = $this->type;
        $model->sendtime = time();
        $model->admin = Yii::$app->session['admin_real_name'];
        $model->admin_id = Yii::$app->session['admin_id'];
        return $model->save();
    }
    
}
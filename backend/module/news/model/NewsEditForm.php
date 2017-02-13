<?php

namespace app\module\news\model;

use Yii;
use yii\base\Model;
use app\module\news\model\News;

class NewsEditForm extends Model
{
    public $title;
    public $content;
    public $type;
    
    /**
     * attributes error rules 
     *
     */
    public function rules()
    {
        return [
            ['title','required'],
            ['content','required'],
            ['type', 'in', 'range' => [1, 2]]
        ];
    }
    
    /**
     * view attributes error
     *
     */
    public function error($attr)
    {
        if($error = $this->getErrors($attr))
        {
            return '&nbsp;<font color="red">'.$error[0].'</div>';
        }        
    }
    
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
        $newsTypes['0'] = '请选择资讯类型';
        array_multisort($newsTypes,SORT_DESC,SORT_NUMERIC);
        return $newsTypes;
    }
    
    public function editNews($id)
    {
        $model = News::findOne($id);
        $model->title = $this->title;
        $model->content = $this->content;
        $model->type = $this->type;
        return $model->save();
    }
    
}
<?php

namespace app\module\news\controllers;

use Yii;
use app\widgets\ActiveForm;
use app\component\EController;
use app\component\ActionMenuHelper;
use app\module\news\model\News;
use app\module\news\model\NewsAddForm;
use app\module\news\model\NewsEditForm;

class NewsController extends EController
{
    
    //过滤器
	public function filters()
	{
		return array(
			array(
				'application.filters.BackEndAuthRequestFilter',
			)
		);
	}
    
    
    /**
     * 列表展示
     *
     */
    public function actionList()
    {
        $this->layout   = 'main';
		$this->son_menu = 0; //取列表操作时，取resource 中menu 为0的记录
		$act_list=ActionMenuHelper::getHiddenMenu();
		$model = new News();
		return $this->render('list',array(
			'dataProvider'=>$model->search(),
			'act_list'=>$act_list)
		); 
    }
    
    /**
     * 添加资讯
     *
     */
    public function actionAdd()
    {
        $this->layout = 'main';
        $this->son_menu = 1 ;
        $model = new NewsAddForm();
        if(Yii::$app->request->post('ajax') && Yii::$app->request->post('ajax') =='ajax_form')
        {
            echo ActiveForm::validate($model);
			Yii::$app->end();
        }
        if(Yii::$app->request->post('NewsAddForm'))
        {	
			$model->setAttributes(Yii::$app->request->post('NewsAddForm'), false);
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate())
            {	
				if($model->addNews())
                {
					return $this->showMessage(Yii::t('info','operation success'),'list');
				} else {
					return $this->showMessage(Yii::t('info','operation failed'),'list');
				}				
			}
		}
		return $this->render('add',array('model'=>$model));
    }
    
    
    /**
     * 修改资讯
     *
     */
    public function actionEdit()
    {
        $this->layout = 'main';
        $this->son_menu = 1 ;
        $model = new NewsEditForm();
        $news  = News::findOne(Yii::$app->request->get('id'));
        $model->setAttributes($news->getAttributes(), false);
        
        if(Yii::$app->request->post('ajax') && Yii::$app->request->post('ajax') =='ajax_form')
        {
            echo ActiveForm::validate($model);
			Yii::$app->end();
        }
        
        if(Yii::$app->request->post('NewsEditForm'))
        {	
			$model->setAttributes(Yii::$app->request->post('NewsEditForm'), false);
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate())
            {	
				if($model->editNews(Yii::$app->request->get('id')))
                {
					return $this->showMessage(Yii::t('info','operation success'),'list');
				} else {
					return $this->showMessage(Yii::t('info','operation failed'),'list');
				}				
			}
		}
		return $this->render('edit',array('model'=>$model));
    }
    
    
    
    /**
     * 删除资讯
     *
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if(News::findOne($id)->delete())
        {
            return $this->showMessage(Yii::t('info','operation success'),'list');
        } else {
            return $this->showMessage(Yii::t('info','operation failed'),'list');
        }   
    }
}
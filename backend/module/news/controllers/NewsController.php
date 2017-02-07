<?php

namespace app\module\news\controllers;

use app\component\EController;
use app\component\ActionMenuHelper;
use app\module\news\model\News;

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
    
    
}
<?php

namespace app\component;

use yii;
use yii\web\Controller;
use yii\widgets\ListView;
use app\component\CHttpRequest;

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class EController extends Controller
{	
	public $son_menu = 1;		//列表页最顶上菜单根据此参数读取
	public $dataProvider;		//列表数据源
	public $act_list;			//单条记录拥有的操作
	public $list_table_start;	//列表表头
	public $list_table_end;		//列表末尾
	public $bt_act_str;			//根据底部操作生成的HTML
	public $bt_act_list;		//底部操作
	public $sortableAttributes;	//排序字段
	 /* SEO Vars */
    public $pageTitle = 'Default Title Tag Here | YourWebsiteName';
	public $pageKeywords='';
    public $pageDesc = '';
    public $pageRobotsIndex = true;
	//初始化
	public function init()
	{
        $this->_loginCheck();
        
        //Yii::app()->session['search_form_show']=0;
		//后台界面语言设置
        
		$cookie = Yii::$app->request->getCookies();
		if(empty($cookie['admin_lang']->value))
		{
			$cookies = Yii::$app->response->cookies;
			$cookie_admin_lang = new \yii\web\Cookie(['name'=>'admin_lang','value'=>Yii::$app->language]);
			$cookies->add($cookie_admin_lang);
		
		}
		else
		{
			 Yii::$app->language=$cookie['admin_lang']->value;
		}
	}

	// Displays SEO-related Variables
	public function display_seo()
	{
		// STANDARD TAGS
		// -------------------------
		// Title/Desc
		echo '<meta name="description" content="'.CHtml::encode($this->pageDesc).'">'.PHP_EOL;
		echo '<meta name="keywords" content="'.CHtml::encode($this->pageKeywords).'">'.PHP_EOL;
		
		// Option for NoIndex
		if ( $this->pageRobotsIndex == false ) {
			echo '<meta name="robots" content="noindex">'.PHP_EOL;
		}
		
	
	}
	
	//后台列表显示
	public function showList($view_file='_view')
	{
		//列表
		return ListView::widget(array(
		
				'dataProvider'=>$this->dataProvider,
				'itemView'=>$view_file,
                'viewParams'=>array('act_list'=>$this->act_list),
                'layout'=>'<div class="sorter"></div>'.$this->list_table_start.'{items}'.$this->list_table_end.$this->bt_act_str.'<div class="page">{pager}<p>{summary}</p></div>',
				
				/**
                //'itemView'=>array('act_list'=>$this->act_list),
				//'ajaxUpdate'=>false,//设置列表页是否ajax刷新
				'layout'=>'<div class="sorter">{sorter}</div>'.$this->list_table_start.'{items}'.$this->list_table_end.$this->bt_act_str.'<div class="page">{pager}<p>{summary}</p></div>',
				'summaryCssClass'=>'summary_container',//定义summary的div容器的class
			
				'summaryText'=>''.Yii::t('pager','total').'{count}'.Yii::t('pager','records').'，'.Yii::t('pager','current').'{page}/{pages}'.Yii::t('pager','page').'',
			
				'sortableAttributes'=>$this->sortableAttributes,//定义可排序的属性
			
				'sorterCssClass'=>'sorter_container',//定义sorter的div容器的class
			
				'sorterHeader'=>Yii::t('pager','sort'),//定义的文字显示在sorter可排序属性的前面
			
				'sorterFooter'=>'',//定义的文字显示在sorter可排序属性的后面
			
				'pagerCssClass'=>'pager_container',//定义pager的div容器的class
				
				'pager'=>array(
					 
					'class'=>'CLinkPager',//定义要调用的分页器类，默认是CLinkPager，需要完全自定义，还可以重写一个
					'cssFile'=>false,//定义分页器的要调用的css文件，false为不调用，不调用则需要亲自己css文件里写这些样式
					'header'=>'',//定义的文字将显示在pager的最前面
					'footer'=>'',//定义的文字将显示在pager的最后面
					'firstPageLabel'=>Yii::t('pager','first_page'),//定义首页按钮的显示文字
					'lastPageLabel'=>Yii::t('pager','last_page'),//定义末页按钮的显示文字
					'nextPageLabel'=>Yii::t('pager','next_page'),//定义下一页按钮的显示文字
					'prevPageLabel'=>Yii::t('pager','prev_page'),//定义上一页按钮的显示文字
					'firstPageCssClass'=>'pg_index',
					'internalPageCssClass'=>'',
					'selectedPageCssClass'=>'pg_selected',
					'nextPageCssClass'=>'pg_next',
					'previousPageCssClass'=>'pg_last',
					'maxButtonCount'=>7, //最大按钮数		   
				)
                **/
		));
	
	}
	
	//添加图片
	public function processFileList($owner_id,$owner_type,$dir_arg='',$file_list_name='pic_list',$name_list_name='filename_list')
	{
		if($dir_arg=='')$dir_arg = array($owner_id);
		$pic_list = $_POST[$file_list_name];
		$filename_list = $_POST[$name_list_name];
		$file_checked = $_POST['file_checked'];
		$file_order = $_POST['file_order'];
		
		$this->widget('ext.attachmentwidget',array('dir_arg'=>$dir_arg,'owner_id'=>$owner_id,'owner_type'=>$owner_type,'file_list'=>$pic_list,'filename_list'=>$filename_list,'file_checked'=>$file_checked,'file_order'=>$file_order));
	
	}
	
	//读取图片
	public function getFileList($owner_id,$owner_type)
	{
		$file_list = $this->widget('ext.attachmentwidget',array('owner_id'=>$owner_id,'owner_type'=>$owner_type,'read'=>1))->file_list;
		return $file_list;
	}
	
	//初始化上传组件
	public function initUploadPlug($array)
	{
		$this->widget('ext.uploadwidget',$array);
	}
	
	
	public function showMessage($message,$url='',$patten='//system/info',$arguments=array(),$title='提示信息',$target='self',$time=3000){		
		if($url==''){
			$url = $_SERVER['HTTP_REFERER'];
		}
		if($title==''){
			$title = Yii::t('info','alert info');
		}
		return $this->renderPartial($patten, array('message'=>$message,'url'=>$url,'title'=>$title,'time'=>$time,'target'=>$target));
		exit;
		
	}
    
    //判断管理员是否登录
    private function _loginCheck()
    { 
        if($this->id=='default' && $this->module->id=='admin')
        {
            return ;
        }
        if(!isset(Yii::$app->session['admin_id'])||empty(Yii::$app->session['admin_id'])||!isset(Yii::$app->session['role_id'])||empty(Yii::$app->session['role_id']))
        {
            if(Yii::$app->session['admin_name']!='')
            {
                Yii::$app->session->clear(); 
                Yii::$app->session->destroy(); 
            }
            echo $this->showMessage("请重新登陆！", Yii::$app->request->baseUrl.'/admin/default/login');
            exit; 
        }
    }
    
    
}
<?php

namespace app\module\admin\controllers;

use yii;
use app\component\EController;
use app\module\admin\model\LoginForm;
use app\model\Resource;
use app\model\RoleResource;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends EController
{
    //后台管理首页
    public function actionIndex()
    {
        $this->_loginCheck();   
        return $this->renderPartial('index',array('top_menus'=>$this->getTopMenus()));    
    }

    //登录
    public function actionLogin()
    {   
        Yii::$app->session['wrong_time']=0;//密码错误次数
        $model = new LoginForm ;   
        if(isset($_POST['LoginForm'])){
            $model->setAttributes(Yii::$app->request->post('LoginForm')); 
            if(!$model->validate()){
                return $this->showMessage($model->getFirstError());
            }else{
                if(!$model->login()){
                    return $this->showMessage($model->getFirstError('login_error'));
                }
            }
            return $this->showMessage("登陆成功！",'index');
        }
        return $this->renderPartial('login',array('model'=>$model));
    }
    
    //退出
    public function actionLogout()
    {
        Yii::$app->session->removeAll(); 
        Yii::$app->session->destroy(); 
        return $this->showMessage(Yii::t('admin','logout success'),'login');
    }
    
    //获取当前角色的一级菜单
    public function getTopMenus()
    {   
        $this->_loginCheck();
        if($_SESSION['role_id']==1){
            $top_menus=Resource::findAll(array('parent_id'=>0,'disabled'=>0,'menu'=>1));
            //$top_menus->orderBy('list_order', 'ASC'); 
        }else{
            $role_resource = RoleResource::find()->with(array('resource'=>function($query){
                $query->andWhere(array('parent_id'=>'0', 'disabled'=>0, 'menu'=>1));
            }))->where(array('role_id'=>Yii::$app->session['role_id']))->all();
            foreach($role_resource as $value)
            {
                foreach($value->resource as $kk)
                {
                    $top_menus[] = $kk;
                }
            }
        }
        return $top_menus;
    }


    //显示左侧菜单
    public function actionLeftmenu()
    {
        $this->_loginCheck();
        $parent_id = intval($_GET['parent_id']);
        //$resource_info = Resource::model()->findByPk($parent_id);
        $resource_info = Resource::model()->findOne($parent_id);
        $current_pos = Yii::t('resource',$resource_info['name'])."&nbsp;>&nbsp;";//点击导航时获得的当前位置信息
        //获取二级菜单
                
        if(Yii::$app->session['role_id']==1){
            $resource_list=Resource::findAll(array('parent_id'=>$parent_id,'disabled'=>0,'menu'=>1)); // ,'order'=>'list_order ASC,parent_id ASC'));    
            foreach($resource_list as $o)
            {
                $class="left_title_up";
                $cs = "";
                if($parent_id==436){
                    $class="left_title";
                    $cs = "display:none";
                }
                echo "<div class='".$class."' onclick='switch_show(\"menu_".$o->resource_id."\",\"ul_".$o->resource_id."\")' id='menu_".$o->resource_id."'>".Yii::t('resource',$o->name)."</div>";
                
                $sub_resource_list=Resource::findAll(array('parent_id'=>$o->resource_id,'disabled'=>0,'menu'=>1)); //,'order'=>'list_order ASC'));
                if(count($sub_resource_list)>0)
                {
                    echo "<ul id='ul_".$o->resource_id."' style=\"".$cs."\" class='side'>";
                    foreach($sub_resource_list as $o_1)
                    {       
                        $url =$o_1->module.'/'.$o_1->controller.'/'.$o_1->action;
            
                        if($o_1->data!='')
                        {
                            $evalphp = $o_1->resource->data;
                            if(@eval("$evalphp;")==false)
                            {
                                $url .= "/".str_replace("=","/",$evalphp);
                            } else {
                                $evalresult = @eval("$evalphp;");
                                $url .= "/".str_replace("=","/",$evalresult);
                            }
                        }
                        $url = Yii::$app->urlManager->createAbsoluteUrl($url);     
                        $temp_current_pos = $current_pos.Yii::t('resource',$o->name)."&nbsp;>&nbsp;";//点击左侧菜单时生成当前位置信息
                        $temp_current_pos = $temp_current_pos.Yii::t('resource',$o_1->name)."&nbsp;>&nbsp;";//更新当前位置信息
            
                        echo "<li><a target='main' href='$url' onclick=\"$('#crumbs').html('".$temp_current_pos."');$.get('/admin/backend/web/ajax/searchform', {search_form_show:0});\">".Yii::t('resource',$o_1->name)."</a></li>";
                        unset($temp_current_pos);
                    }
                    echo "</ul>";
                }               
            }       
        }else{
            
            $resource_role = RoleResource::find()
                            ->with(array('resource'=>function($query) use ($parent_id){
                                $query->andWhere(array('parent_id'=>$parent_id, 'disabled'=>0, 'menu'=>1));
                                $query->orderBy('list_order ASC, parent_id ASC');
                            }))->where(array('role_id'=>Yii::$app->session['role_id']))
                            ->all();
            $resource_list = [];                
            foreach($resource_role as $kk=>$value)
            {
                foreach($value->resource as $vv)
                {
                    $resource_list[] = $vv;
                }
            }
            foreach($resource_list as $o)
            {
                $class="left_title_up";
                $cs = "";
                if($parent_id==436){
                    $class="left_title";
                    $cs = "display:none";
                }
                echo "<div class='".$class."' onclick='switch_show(\"menu_".$o->resource_id."\",\"ul_".$o->resource_id."\")' id='menu_".$o->resource_id."'>".Yii::t('resource',$o->name)."</div>";
                $sub_resource_role  = RoleResource::find()
                                    ->with(array('resource'=>function($query) use($o){
                                        $query->orderBy('list_order ASC'); 
                                        $query->andWhere(array('parent_id'=>$o->resource_id, 'disabled'=>0, 'menu'=>1));
                                    }))->where(array('role_id'=>Yii::$app->session['role_id']))
                                    ->all();
                $sub_resource_list = [];
                foreach($sub_resource_role as $role)
                {
                    foreach($role->resource as $vv){
                        $sub_resource_list[] = $vv;
                    }
                }    
                if(count($sub_resource_list)>0)
                {
                    echo "<ul id='ul_".$o->resource_id."' style=\"".$cs."\" class='side'>";
                    foreach($sub_resource_list as $o_1)
                    {       
                        $url =$o_1->module.'/'.$o_1->controller.'/'.$o_1->action;
                        if($o_1->data!='')
                        {
                            $evalphp = $o_1->data;
                            if(@eval("$evalphp;")==false)
                            {
                                $url .= "/".str_replace("=","/",$evalphp);
                            }else{
                                $evalresult = @eval("$evalphp;");
                                $url .= "/".str_replace("=","/",$evalresult);
                            }
                        }
                        $url = Yii::$app->urlManager->createAbsoluteUrl($url);                 
                        $temp_current_pos = $current_pos.Yii::t('resource',$o->name)."&nbsp;>&nbsp;";//点击左侧菜单时生成当前位置信息
                        $temp_current_pos = $temp_current_pos.Yii::t('resource',$o_1->name)."&nbsp;>&nbsp;";//更新当前位置信息
                        echo "<li><a target='main' href='$url' onclick=\"$('#crumbs').html('".$temp_current_pos."');$.get('/admin/backend/web/ajax/searchform', {search_form_show:0});\">".Yii::t('resource',$o_1->name)."</a></li>";
                        unset($temp_current_pos);
                    }
                    echo "</ul>";
                }                 
            }
        }
        echo "<script type='text/javascript'>";
        echo "$('#crumbs').html('".$current_pos."');";
        echo "</script>";
    }
    
    //锁屏功能
    public function actionLockScreen()
    {
        Yii::$app->session['admin_id'] = '';
        Yii::$app->session['role_id']  = '';
    }
    
    //解除屏幕锁定
    public function actionUnlockScreen()
    {
        if(Yii::$app->session['wrong_time']>=9)//密码最多重试9次
        {
            echo 3;
            exit;
        }
        $password = $_GET['lock_password'];
        
        $admin = Admin::model()->find('user_name=:user_name',array(':user_name'=>Yii::$app->session['admin_name']));
        if(password($password,$admin->encrypt)!=$admin->user_pwd)
        {
            Yii::$app->session['wrong_time'] = Yii::$app->session['wrong_time']+1;
            if(Yii::$app->session['wrong_time']>=9)//密码最多重试9次
            {
                echo 3;
                exit;
            }
            echo '2|'.(9-Yii::$app->session['wrong_time']);
            exit;
        }
        else
        {
            Yii::$app->session['wrong_time']=0;
            Yii::$app->session['admin_id']=$admin->admin_id;
            Yii::$app->session['role_id']=$admin->role_id;
            echo 1;
            exit;
        }
    }
    
    //判断管理员是否登录
    private function _loginCheck()
    {
        if(!isset(Yii::$app->session['admin_id'])||empty(Yii::$app->session['admin_id'])||!isset(Yii::$app->session['role_id'])||empty(Yii::$app->session['role_id']))
        {
            if(Yii::$app->session['admin_name']!=''){
                Yii::$app->session->clear(); 
                Yii::$app->session->destroy(); 
            }
            return $this->showMessage("请重新登陆！",'login');
            //return $this->showMessage("请重新登陆！",'login','',array(),'','top');
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {

        if($error=Yii::$app->errorHandler->error)
        {
            if(Yii::$app->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->renderPartial('//system/error', $error);
        }
    }


}

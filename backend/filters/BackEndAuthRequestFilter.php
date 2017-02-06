<?php
//后台过滤器
class BackEndAuthRequestFilter extends CFilter
{		
    //请求之前
    protected function preFilter($filterChain)
    {
        
        //未登录
        if(!isset(Yii::app()->session['admin_id'])||empty(Yii::app()->session['admin_id'])||!isset(Yii::app()->session['role_id'])||empty(Yii::app()->session['role_id']))
        {
            Yii::app()->controller->showMessage(Yii::t('info','please login management panel'),'admin/default/login',$arguments=array(),$title='',$target='top');
            exit;
        } else {
            if(Yii::app()->session['role_id']==1){
                return true;
            }else{
                $controller = Yii::app()->controller->id;
                $action = Yii::app()->controller->getAction()->getId();
                $module = Yii::app()->controller->getModule()->getId();
                $resource = Resource::model()->find('module=:module and controller=:controller and action=:action and disabled=0',array(':module'=>$module,':controller'=>$controller,':action'=>$action));
                
                if(count($resource)==0)
                {
                     throw new CHttpException('601',Yii::t('info','Invalid request. Please do not repeat this request again.'));
                } else {
                    $resource_id = $resource->resource_id;
                    $role_resource = RoleResource::model()->find('role_id=:role_id and resource_id=:resource_id',array(':role_id'=>Yii::app()->session['role_id'],':resource_id'=>$resource_id));
                    
                    if(count($role_resource)==0)
                    {
                        throw new CHttpException('602',Yii::t('info','Unauthorized request.'));
                    } else {
                        return true;
                    }
                }
                
            }
        }	
    }
    
    // 动作执行之后应用的逻辑		
    protected function postFilter($filterChain)
    {
        
    }
}
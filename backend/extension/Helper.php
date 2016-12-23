<?php

namespace app\extension;

class Helper
{
    
    //操作名切换
    static function open_switch($open)
    {
        if($open==1)
        {
            return Yii::t('resource','set_close');
        }
        else
        {
            return Yii::t('resource','set_open');
        }	
    }
    
    //操作名切换
    static function hot_switch($hot)
    {
        if($hot==1)
        {
            return Yii::t('resource','unset_hot');
        }
        else
        {
            return Yii::t('resource','set_hot');
        }	
    }
    
    static function not_forbid_fields($field)
    {
        $forbid_fields = Yii::$app->params['fields']['forbid_fields'];
        if(!in_array($field,$forbid_fields))
        {
            return true;
        }
        else
        {
            return false;
        }	
        
    }
    
    static function not_forbid_delete($field)
    {
        $forbid_delete = Yii::$app->params['fields']['forbid_delete'];
        if(!in_array($field,$forbid_delete))
        {
            return true;
        }
        else
        {
            return false;
        }	
        
    }

        
    //判断是否为超级管理员
    static function not_super_admin($id)
    {
        
        if($id!=1)
        {
            return true;
        }
        else
        {
            return false;
        }	
        
    }
    //判断是否为超级管理员
    static function has_sub($parent_id)
    {
        $link_list = Linkmenu::model()->findAll('key_id=:key_id or parent_id=:parent_id',array(':key_id'=>$parent_id,':parent_id'=>$parent_id));
        
        if(!empty($link_list))//有子级
        {
            return true;
        }
        else
        {
            return false;
        }	
        
    }
    
    
    
}
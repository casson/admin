<?php 
	
	//公共配置文件附加处理函数；

	class CCom{
	
		public function articletype(){
			
			$arrx = Yii::app()->params['shouyounewstype'];
			
			foreach($arrx as $key =>$value){
				$arrv[$value[1]] = $value[0];
			}
			return $arrv ;
			
		}
		
		public function jctype($typeid=0){
			$arrx = Yii::app()->params['shouyoujctype'];
			foreach($arrx as $key =>$value){
				$arrm[$value[1][0]] = $value[0];
			}
			if(!$typeid){
				return $arrm ;
			}else{
				$typeid = (int) $typeid ;
				//$arrm = array_flip($arrm);
				return $arrm[$typeid];
			} 
		}
		
	
		
	
	
	
	
	
	
	}
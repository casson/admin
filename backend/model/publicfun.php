<?php 
	/**
	**用以封装公用函数；
	**create by : zhouzhe 20150810 
	**@func catchimg 图片本地化；
	**/

	class publicfun{
	
		function catchimg($str){
			
			if(!$str) return $str ;
			preg_match_all('/<img[\s\S]*src=\"([^\"]*)\"[^>]*>/U',$str,$matches);
			
			//file_put_contents('test.php',var_export($matches,true));
			
			if(!$matches[1]) return $str ;
			
			foreach($matches[1] as $key=>$value){
				if(strchr($value,'http://')){
					if(strchr($value,'http://www.game333.net')){
						$img = str_replace('http://www.game333.net','http://img.game333.net',$matches[0][$key]);
						$str = str_replace($matches[0][$key],$img,$str);
					}
				}else{
					$img = str_replace($value,'http://img.game333.net'.$value,$matches[0][$key]);
					$str = str_replace($matches[0][$key],$img,$str);
				}
			}
			return $str ;
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}
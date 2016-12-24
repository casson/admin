<?php
	
	class GatherController extends Controller
	{
		
		public $local='uploads/gather/contents/';
		
		public function actioncatchimg(){
			$str = $_GET['str'] ;
			$imgid = $_GET['imgid'] ? (int)$_GET['imgid'] : 1 ;
			$waterimgarr = array('1'=>'public/images/thumb/waterimg.png','2'=>'public/images/thumb/ylyimg.png');
			if(!$str){
				$data['status'] = '400' ;
			}else{
				preg_match_all('/<img.*src=[\"\']([\S]+)[\"\'][^>]+>/U',$str,$matches);
				if(!$matches){
					$data['status'] = '300' ;
				}else{
					$date = date('Ymd');
					$local = $this->local . substr($date,0,4).'/'.substr($date,4,2).'/'.substr($date,6,2).'/';
					if(!file_exists($local)) mkdir($local,0777,true);
					$img = array();
					$list = array();
					foreach($matches[1] as $key => $value ){
						$name = md5($value);
						$res = false;
						$file = $local.substr($name,-15,12).'.jpg';
						$list[$value] = '/admin/'.$file ;
						$res = copy($value,$file);
						$locale = $file ;
						$file = '<li><img src="/admin/'.$file.'" /></li>';
						if($res){
							waterimg::imageWaterMark($locale,9,$waterimgarr[$imgid]);
							array_push($img,$file);
						}
					}
					$data['list'] = $list ;
					$data['img'] = $img ;
					$data['status'] = '200' ;
				}
			}
			$data = json_encode($data);
			echo $data ;
		}
		
		public function actionfindimg(){
			$date = $_GET['date'] ? (int)$_GET['date'] : 1 ;
			$time = date('Ymd',(time()-($date-1)*3600*24)) ;
			$path = 'uploads/gather/contents/'.substr($time,0,4).'/'.substr($time,4,2).'/'.substr($time,6,2)."/*.jpg";
			$arrx['path'] = glob($path) ;
			if($arrx['path']){
				$arrx['time'] = $time ;
				$arrx['date'] = $date ;
				$arrx['status'] = '200';	
			}else{
				$arrx['status'] = '300';
			}
			$json = json_encode($arrx);
			echo $json ;
		}

	
	}
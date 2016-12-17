<?php
	
	/**
	**@param $ftp :$ftp对象；
	**@param $arrx : 替换模板数据的数组；
	**@param $tpl : 模板地址；
	**@param $local : 生成的本地文件的地址；
	**@param $remote : 同步到服务器上的远程地址：
	**/
	
	class synchtml
	{
		private $ftp ;
		private $ftpimg ;
		
		public function __construct($arrx=NULL){
			$this->newftp($arrx);
		}
		
		private function newftp($array=NULL){
			if($array){
				$arrx = $array ;
			}else{
				$arrx = Yii::app()->params['ylyftpx'];
			}
			if($arrx['official']){
				$ftp[] = new ftp($arrx['official'][0],$arrx['official'][1],$arrx['official'][2],$arrx['official'][3]);
			}
			if($arrx['backup']){
				$ftp[] = new ftp($arrx['backup'][0],$arrx['backup'][1],$arrx['backup'][2],$arrx['backup'][3]);
			}
			if(!$this->ftp) exit('没有脸上文件服务器，请检测$arrx参数');
			$this->ftp = $ftp;	
		}
		
		private function replaceTpl($arrx,$tpl,$local)
		{
			if(!$arrx){
				$newFile = $tpl ;
				file_put_contents($local,$newFile);
				return ;
			}
			$tpl = file_get_contents($tpl);
			preg_match_all("/\{(\w+)\}/iU",$tpl,$matcheArr);
			foreach ($matcheArr[1] as $value)
			{
				$matcheArr[2][] = $arrx[$value];
			}
			$newFile=str_replace($matcheArr[0],$matcheArr[2],$tpl);
			file_put_contents($local,$newFile);
		}
		
		private function checkdir($local)
		{
			$dir = dirname($local);
			if(!file_exists($dir))
			{
				mkdir($dir,0777,true);
			}
		}
		
		public function upload($arrx,$tpl,$local,$remote)
		{			
			$this->checkdir($local);
			$this->replaceTpl($arrx,$tpl,$local);
			foreach($this->ftp as $ftpobj){
				$ftpobj->up_file($local,$remote);
				$ftpobj->close();
			}
			unlink($local);
		}
		
	}
	
?>
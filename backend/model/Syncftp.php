<?php
class Syncftp
{
	private $localFile;
	private $templateFile;
	private $syncFilePath; 
	private $dataArray;
	private $ftpArray;
	private $isDeleteLocalFile;
	
	public function __construct($localFile,$templateFile,$dataArray,$ftpArray=NULL,$isDeleteLocalFile=false)
	{
		$this->localFile = $localFile;
		$this->templateFile = file_get_contents($templateFile);
		$this->dataArray = $dataArray;
		$this->ftpArray = $ftpArray;
		$this->isDeleteLocalFile = $isDeleteLocalFile;
		$this->upFile();
	}
	private function upFile()
	{
		$foldArr= explode("/",$this->localFile);
		$newFoldArr=array_slice($foldArr,1,count($foldArr)-2);	
		$this->syncFilePath=implode("/",array_slice($foldArr,2));
		$fold = '..';
		foreach ($newFoldArr as $value)
		{
			$fold .= '/'.$value;
			if (!file_exists($fold)) mkdir($fold);
		}
		$this->replaceTpl();
	}
	private function replaceTpl()
	{
		preg_match_all("/\{(\w+)\}/iU",$this->templateFile,$matcheArr);
		foreach ($matcheArr[1] as $value)
		{
			$matcheArr[2][] = $this->dataArray[$value];
		}
		$newFile=str_replace($matcheArr[0],$matcheArr[2],$this->templateFile);
		file_put_contents($this->localFile,$newFile);
		
	}
	
	public function upload()
	{
	    if ($this->ftpArray){
		   $this->exeFtp("upload");
		   if ($this->isDeleteLocalFile) @unlink($this->localFile);
		}
	}
	
	public function delete()
	{  
		if ($this->ftpArray){
		    $this->exeFtp("del");
		}
	}
	
	private function exeFtp($type){
		$ftpArr=new ftp($this->ftpArray['host'],$this->ftpArray['port'],$this->ftpArray['usr'],$this->ftpArray['pwd']);
		if($this->ftpArray['backup']){
			$ftpArrx =new ftp($this->ftpArray['backup']['host'],$this->ftpArray['backup']['port'],$this->ftpArray['backup']['usr'],$this->ftpArray['backup']['pwd']);
		    if($type=="del"){
				$ftpArr -> del_file($this->syncFilePath);
				$ftpArrx ->del_file($this->syncFilePath);
				$ftpArr -> close();
				$ftpArrx -> close();
			}else{
				$ftpArr -> up_file($this->localFile,$this->syncFilePath);
				$ftpArrx -> up_file($this->localFile,$this->syncFilePath);
			    $ftpArr -> close();
			    $ftpArrx -> close();
			}
		}else{
		    $type=="del" ? $ftpArr -> del_file($this->syncFilePath) : $ftpArr -> up_file($this->localFile,$this->syncFilePath);
		    $ftpArr -> close();
	    }
	}
	
	
	//做双同步用；
	/**
	private function exeFtp($type){
		$ftpArr=new ftp($this->ftpArray['host'],$this->ftpArray['port'],$this->ftpArray['usr'],$this->ftpArray['pwd']);

		$type=="del" ? $ftpArr -> del_file($this->syncFilePath) : $ftpArr -> up_file($this->localFile,$this->syncFilePath);
		$ftpArr -> close();
	   
	}
	**/
}
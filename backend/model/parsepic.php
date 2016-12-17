<?php
class parsepic{

	private $content;
	private $type;

    public function __construct($content,$type){

            $this->content=$content;
            $this->type=$type;

    }
    public static function model($content,$type){
            $model=new parsepic($content,$type);
            return $model->parsecon();
    }
	private function parsecon(){
		$narr=array();
		$content=$this->content;
	    if(strlen($content)>0){
		     preg_match_all('/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/',$content,$matches);
			 if(count($matches)>0){
			   foreach($matches[1] as $key => $value){
			       if(strchr($value,"/admin/")){
						$dirarr=explode("/",$value);
						$pdir=substr($value,7);
						$newarr=array_slice($dirarr,5);
						$newstr="uploads/".$this->type."/img/".join("/",$newarr);
						//waterimg::imageWaterMark($newstr,9,"data/shouyou/waterimg.png");
						$ftpobj=new ftp(Yii::app()->params['ylyftp']['host'],Yii::app()->params['ylyftp']['port'],Yii::app()->params['ylyftp']['usr'],Yii::app()->params['ylyftp']['pwd']);
		                $ftpobj->up_file($pdir,$newstr);
						$narr[$key]='<a href="http://www.game333.net/'.$newstr.'" target="_blank"><img src="http://www.game333.net/'.$newstr.'" style="max-width:580px"/></a>';
				   }else{
				        $narr[$key]='<img src="'.$value.'" />';
				   }
			   }
			   $content=str_replace($matches[0],$narr,$content);
			   
			 }
			 
		}
		return $content;
	}
}
?>
<?php
 
class mobile_comment extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function relations(){
		return array(
			 	//'author'=> array(self::BELONGS_TO, 'mh_author', 'authorid'), //可以不保持一致
		);
	}
	
	/* reset db */
	public function getDbConnection()
	{ 
	  self::$db=Yii::app()->db6;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
    public function tableName()
	{
		return '{{comment}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'title' => Yii::t('shouyou','title'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('content,title', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		//$time=strtotime(date("Y-m-d",time()));
		$criteria=new CDbCriteria; 
	 	$criteria->compare('title',$this->title,true);  
		$criteria->compare('content',$this->content,true);  
	 	//if($start!="" && $end!="") $criteria->addCondition("time>='".$start."' and time<='".$end."'");
	 	//else if($start!="" && $end=="") $criteria->addCondition("time>='".$start."'");
	 	//else if($start=="" && $end!="") $criteria->addCondition("time<='".$end."'");
 		$criteria->order='addtime desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function getch($chid){
		$str = '' ;
		if($chid==1){
			$str = '手游资讯';
		}else if( $chid ==2){
			$str = '手游攻略';
		}else if( $chid ==3){
			$str = '手游评测';
		}else if( $chid ==4){
			$str = '单机下载';
		}else if( $chid == 5){
			$str = '单机攻略';
		}else if( $chid ==6){
			$str = '单机资讯';
		}else if($chid ==7){
			$str = '单机补丁';
		}else if($chid ==8){
			$str = '单机图库';
		}else{
			$str = '未知频道';
		}
		return $str ;
	}
	
	public function getur($id,$chid){
		$str = '' ;
		if($chid==1){
			$str ='<a href="http://m.game333.net/m/'.$id.'" target="_blank" >http://m.game333.net/m/'.$id.'</a>';
		}else if( $chid ==2){
			$str = '<a href="http://m.game333.net/g/'.$id.'"  target="_blank" >http://m.game333.net/g/'.$id.'</a>';
		}else if( $chid ==3){
			$str = '<a href="http://m.game333.net/p/'.$id.'"  target="_blank" >http://m.game333.net/p/'.$id.'</a>';
		}else if( $chid ==4){
			$str = '<a href="http://m.game333.net/d/'.$id.'" target="_blank" >http://m.game333.net/d/'.$id.'</a>';
		}else if( $chid == 5){
			$str = '<a href="http://m.game333.net/gl/'.$id.'" target="_blank" >http://m.game333.net/gl/'.$id.'</a>';
		}else if( $chid ==6){
			$str = '<a href="http://m.game333.net/c/'.$id.'" target="_blank" >http://m.game333.net/c/'.$id.'</a>';
		}else if($chid ==7){
			$str = '<a href="http://m.game333.net/patch/'.$id.'" target="_blank" >http://m.game333.net/patch/'.$id.'</a>';
		}else if($chid ==8){
			$str = '<a href="http://m.game333.net/pic/'.$id.'" target="_blank" >http://m.game333.net/pic/'.$id.'</a>';
		}else{
			$str = '未知';
		}
		return $str ;		
	}
	
	
}
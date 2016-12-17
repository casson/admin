<?php
 
class mobile_zttj extends logCAr
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
		return '{{zttj}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'typeid' => Yii::t('shouyou','typeid'), 
			'title' => Yii::t('shouyou','title'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('typeid,title', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}
	static public function getTypeOptions(){
	    $array=array("1"=>"攻略推荐","2"=>"横版推荐","3"=>"资讯推荐","4"=>"视频推荐","5"=>"截图推荐","6"=>"火爆礼包","7"=>"幻灯片","8"=>"专题推荐");
		return $array;
	}
	static public function gettypename($typeid){
		    $array=array("1"=>"攻略推荐","2"=>"横版推荐","3"=>"资讯推荐","4"=>"视频推荐","5"=>"截图推荐","6"=>"火爆礼包","7"=>"幻灯片","8"=>"专题推荐");
			return $array[$typeid];
	}
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('title',$this->title,true,"or");  
	 	$criteria->compare('typeid',$this->typeid);  
 		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}	
	
}
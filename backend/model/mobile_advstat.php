<?php
 
class mobile_advstat extends logCAr
{
	public $rid;
	public $lid;
	public $aid;
	
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
		return '{{adstat_intime}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'rid' => Yii::t('shouyou','rid'),  
			'lid' => Yii::t('shouyou','lid'),  
			'aid' => Yii::t('shouyou','aid'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  //array('rid,lid,aid', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('comkey',$this->comkey);  
 		$criteria->order='addtime desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
<?php
 
class mobiletg_version extends CActiveRecord
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
	  self::$db=Yii::app()->db9;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
    public function tableName()
	{
		return '{{version}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'version' => Yii::t('shouyou','version'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('version', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('version',$this->version,true,'or');  
 		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	static public function cacheVersion()
	{
		$version = self::model()->findAllBySql('select id,version from version');
		foreach ($version as $value) $cache[$value->id] = $value->version;
		file_put_contents("public/js/shouyou/version", json_encode($cache));
	}
}
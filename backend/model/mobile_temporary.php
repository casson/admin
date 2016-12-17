<?php
 
class mobile_temporary extends logCAr
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
		return '{{temporary}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array();
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array();
	}
	
	public function primaryKey()
	{
		return 'file';
	}	
	
	
	static public function clearExpire()
	{
		$temporary = self::model()->findAllBySql('select file from temporary where addtime < '.(time()-86400));
		foreach ($temporary as $value)
		{
			$delete = self::model()->deleteByPk($value['file']);
			@unlink($value['file']);
		}
	}
}
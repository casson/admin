<?php
 
class mobile_company extends CActiveRecord
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
		return '{{company}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'title' => Yii::t('shouyou','title'),  
			'url' => Yii::t('shouyou','url'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('title,url', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('title',$this->title,true,"or");  
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	} 
	
	static public function getcid($str)
	{
		if ($str == '互联网') return 0;
		$getcid = self::model()->findBySql('select id from company where title=\''.$str.'\'');
		if ($getcid)
		{
			return $getcid->id;
		}
		else 
		{
			$insertcid = new mobile_company();
			$insertcid->title = $str;
			if ($insertcid->save())
			{
				self::cachecompany();
				return $insertcid->id;
			}
			else 
			{
				return null;
			}
		}
	}
	
	static public function checkcompany($id)
	{
		$company = self::model()->findByPk($id);
		return $company;
	}
	
	static public function cachecompany()
	{
		$connection=Yii::app()->db6;
		$command=$connection->createCommand('select id,title from company');
		$company = $command->queryAll();
		foreach ($company as $value) $cache[$value["id"]] = $value["title"];
		file_put_contents('data/shouyou/company', json_encode($cache));
	}
}
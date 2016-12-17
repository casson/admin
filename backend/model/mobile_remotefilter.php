<?php
 
class mobile_remotefilter extends logCAr
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
		return '{{remotefilter}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'typeid' => Yii::t('shouyou','typeid'),  
			'keyword' => Yii::t('shouyou','keyword'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('typeid,keyword', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('keyword',$this->keyword,true,"or");
		$criteria->compare('typeid',$this->typeid);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	static public function cachefilter()
	{
		$filter = self::model()->findAllBySql('select length(keyword) as l,keyword,typeid from remotefilter order by l desc');
		foreach ($filter as $value)
		{
			if ($value->typeid == 1)
			{
				$arrtxt[] = $value->keyword;
			}else {
				$arrimg[] = $value->keyword;
			}
		}
		file_put_contents('data/shouyou/txtfilter', serialize($arrtxt));
		file_put_contents('data/shouyou/imgfilter', serialize($arrimg));
	}
}
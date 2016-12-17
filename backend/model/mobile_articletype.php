<?php
 
class mobile_articletype extends logCAr
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
		return '{{article_type}}';
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
			  array('title', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('title',$this->title,true);  
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	} 
	
	static public function cachearticle()
	{
		$article = self::model()->findAll();
		foreach ($article as $value){
			$cache[$value->id] = array(
					'title' => $value->title,
					'relative' => $value->relative,
			);
			$cache22[$value->id] = $value->title;
		}
		file_put_contents('public/js/shouyou/articletypedata.js', json_encode($cache));
		file_put_contents('data/shouyou/articletypeform.js', json_encode($cache22));
	}
}
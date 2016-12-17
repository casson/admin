
<?php
 
class Menu extends CActiveRecord
{

	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/* reset db */
	public function getDbConnection()
	{ 
	  self::$db=Yii::app()->db;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
	
	
	
    public function tableName()
	{
		return '{{resource}}';
	}
	
	/* reles */
	public function rules()
	{
		return array(
				array('name,module,parent_id', 'safe', 'on'=>'search'),
		);
	}
	/* replace  */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('attr','name'),
			'parent_id' => Yii::t('attr','parent_id'),
			'module' => Yii::t('attr','module'),
			'controller' => Yii::t('attr','controller'),
			'action' => Yii::t('attr','action'), 
			'at_bottom' => Yii::t('attr','at_bottom'), 
			'menu' => Yii::t('attr','menu'), 
			'disabled' => Yii::t('attr','disabled'), 
			'btn_class' => Yii::t('attr','btn_class'), 
			'title_field' => Yii::t('attr','title_field'), 
			'list_order' => Yii::t('attr','list_order'), 
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		 
		 $criteria=new CDbCriteria; 
		 
		 if($_GET['parent_id']){
		 	$criteria->compare('parent_id',$_GET['parent_id'],false);
 		 }else{
 		 	$criteria->compare('name',$this->name,true,"or"); 
 		 	$criteria->compare('module',$this->module,true,"or"); 
 		 }
 		 
		 $criteria->order='resource_id desc';

 		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	
	public function getTypeOptions()
	{
		
		$menuinfo=Menu::model()->findAll(array("condition"=>"parent_id=0","order"=>"resource_id desc"));
		
		foreach($menuinfo as $_v){
			
    	$list[$_v->module]=Yii::t('resource',$_v->name);
    
    }

		return $list;
		 
	}
 
 
	

}







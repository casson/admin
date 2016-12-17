<?php 

   class Writer extends logCAr{
	   
		public static function model($className=__CLASS__)
		{
			return parent::model($className);
		}
	   
	    public function getDbConnection()
		{ 
			self::$db=Yii::app()->tongji;
			if(self::$db instanceof CDbConnection) return self::$db;
		}
		
		public function tableName()
		{
			return '{{writer}}';
		}

		public function rules() //返回属性的验证规则
		{
			return array(
				array('wtid, wtname', 'required'),
				array('wtid', 'numerical', 'integerOnly'=>true),
				array('wtname', 'length', 'max'=>20),
				array('wtid,wtname', 'safe', 'on'=>'search'),
			);
		}
	
		public function primaryKey()
		{
			return 'wtid';
		}	
	
	
		public function search(){
			$sql ='select * from {{writer}} ' ; 
			$arrwriter = Yii::app()->tongji->createCommand($sql)->queryAll() ;
			
			$dataProvider=new CArrayDataProvider($arrwriter, array(
													'sort'=>array(  
														'attributes'=>array(  
															'wtid',  
														),  
													),  
													'pagination'=>array(  
														'pageSize'=>10,  
													),  
											    ));
			return $dataProvider ;								
			
		}
	    
		public function queryAll(){
			$sql ='select * from {{writer}} ' ; 
			$arrwriter = Yii::app()->tongji->createCommand($sql)->queryAll() ;
			return $arrwriter;
		}
   }
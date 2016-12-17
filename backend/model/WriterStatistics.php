<?php 

   class WriterStatistics extends logCAr{
	   
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
			return '{{writerstatistics}}';
		}

		public function rules() //返回属性的验证规则
		{
			return array(
				array('date,wtid', 'safe', 'on'=>'search'),
			);
		}
	
		public function primaryKey()
		{
			return 'id';
		}	
	
	
		public function search($up,$end){
			$sql ='select sum(ip) as ip ,wtname,sum(pv) as pv from {{writerstatistics}} where date>'.$up.' and date<='.$end.' group by wtid order by ip desc '; 
			$arrd = Yii::app()->tongji->createCommand($sql)->queryAll() ;
			$date=$up.'~'.$end;
			array_walk($arrd,function(&$v,$k,$date){$v['date']=$date;},$date);
			$dataProvider=new CArrayDataProvider($arrd, array(
													'sort'=>array(  
														'attributes'=>array(  
															'ip',  
														),  
													),
													'pagination'=>array(  
														'pageSize'=>10,  
													),  
											    ));
			return $dataProvider ;								
			
		}
   }
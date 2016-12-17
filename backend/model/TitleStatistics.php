<?php 

   class TitleStatistics extends logCAr{
	   
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
			return '{{titlestatistics}}';
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
	
	
		public function search($up,$end,$wtid){
			$sql ='select sum( count ) as count, wtname, title, chid, aid from {{titlestatistics}} where '.($wtid?(' wtid='.$wtid.' and'):'').' date>'.$up.' and date<='.$end.' group by wtid, chid, aid order by count desc '; 
			$arrd = Yii::app()->tongji->createCommand($sql)->queryAll();
			$date=$up.'~'.$end;
			array_walk($arrd,function(&$v,$k,$date){$v['date']=$date;},$date);
			$dataProvider=new CArrayDataProvider($arrd, array(
													'sort'=>array(  
														'attributes'=>array(  
															'count',  
														),  
													),  
													'pagination'=>array(  
														'pageSize'=>10,  
													),  
											    ));
			return $dataProvider ;								
			
		}
	     
   }
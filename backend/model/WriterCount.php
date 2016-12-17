<?php 

   class WriterCount extends logCAr{
	   
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
			return '{{writercount}}';
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
						
			$sql ='select * from {{writercount}} where date>'.$up.' and date<='.$end ; 
			$arrx = Yii::app()->tongji->createCommand($sql)->queryAll() ;
			$arrv = array(); 
			$arrd = array();
			
			foreach($arrx as $key =>$value){
			    if(!in_array($value['wtid'],$arrv)){
					$arrd[$value['id']]['id'] = $value['id'] ;
					$arrd[$value['id']]['ip'] = $value['ip'] ;
					$arrd[$value['id']]['pv'] = $value['pv'] ;
					$arrd[$value['id']]['wtid'] = $value['wtid'] ;
					$arrd[$value['id']]['wtname'] = $value['wtname'] ;
					$arrd[$value['id']]['date'] = $up.'~'.$end ;
					$arrv[$value['id']] = $value['wtid'] ;
				}else{
					$kes = array_keys($arrv,$value['wtid']);
					$arrd[$kes[0]]['ip'] = $arrd[$kes[0]]['ip'] + $value['ip'];
                    $arrd[$kes[0]]['pv'] = $arrd[$kes[0]]['pv'] + $value['pv'];					
				}	
			}
			
			$dataProvider=new CArrayDataProvider($arrd, array(
													'sort'=>array(  
														'attributes'=>array(  
															'num',  
														),  
													),  
													'pagination'=>array(  
														'pageSize'=>20,  
													),  
											    ));
			return $dataProvider ;								
			
		}
	     
   }
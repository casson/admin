<?php

class autoWidget extends CWidget
{
   public $type=0;
   public $class="autokey";
   public $gid ;
	
    public function init()
	{

		$this->registerClientScript();
	 
	}
	
	public function run()
	{
		 
?>
 
<script>
	$(function() {
		$( ".<?php echo $this->class;?>" ).autocomplete({
			source: "/admin/api/ajaxKeyword?type=<?php echo $this->type;?>",
			minLength: 1,
			select: function( event, ui ){ 				 
				 $(".<?php echo $this->class;?>").val(ui.item.label);			
			}
		});
	});
</script>
 
 
<?php 
		
	
	}
	
	protected function registerClientScript()
	{

		
		$cs=Yii::app()->clientScript;
	    $cs->registercssFile(Yii::app()->request->baseUrl."/public/css/jquery-ui.css");
	    $cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/jquery-ui.js");
	    $cs->registercssFile(Yii::app()->request->baseUrl."/public/css/style.css");
		
		
		
	}
	
}
?>
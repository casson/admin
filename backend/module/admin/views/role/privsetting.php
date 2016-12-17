<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.treeTable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.treetable.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#dnd-example").treeTable({
    	indent: 20
    	});
  });
  function checknode(obj)
  {
      var chk = $("input[type='checkbox']");
      var count = chk.length;
      var num = chk.index(obj);
      var level_top = level_bottom =  chk.eq(num).attr('level')
      for (var i=num; i>=0; i--)
      {
              var le = chk.eq(i).attr('level');
              if(eval(le) < eval(level_top)) 
              {
                  chk.eq(i).attr("checked",'checked');
                  var level_top = level_top-1;
              }
      }
      for (var j=num+1; j<count; j++)
      {
              var le = chk.eq(j).attr('level');
              if(chk.eq(num).attr("checked")=='checked') {
                  if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",'checked');
                  else if(eval(le) == eval(level_bottom)) break;
              }
              else {
                  if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",false);
                  else if(eval(le) == eval(level_bottom)) break;
              }
      }
  }
</script>
<style type="text/css">
.priv_form{float:left;width:600px;height:400px;margin-bottom:10px}
.priv_form_right{float:left;width:600px;height:400px;border:1px solid #d6d6d6;background:#fff;overflow:auto;}
.priv_form_right_top{padding-left:30px;height:25px;line-height:25px;text-align:left;cursor:pointer; background:#EEF3F7}
</style>
<div class="common_form" >
	<div class="priv_form" >
		<div class="priv_form_right">
			<?php if($role_id){?>
			<div class="priv_form_right_top" >
				<span onClick="javascript:$('input[name=\'menuid[]\']').attr('checked', true)"><?php echo Yii::t('admin','select all');?></span>/<span onClick="javascript:$('input[name=\'menuid[]\']').attr('checked', false)"><?php echo Yii::t('admin','cancel');?></span>
			</div>
			<table width="100%" cellspacing="0" id="dnd-example"  style="border-right:none;border-left:none;">
			<?php $form=$this->beginWidget('CActiveForm', array('id'=>'ajax_form','enableAjaxValidation'=>false,'clientOptions'=>array('validateOnSubmit'=>true, 'validateOnChange'=>false))); ?>
			<input type="hidden" name="role_id" value="<?php echo $role_id;?>" />
			<tbody>
			<?php echo $categorys;?>
			</tbody>
			</table>
			<div  style="margin:5px;"><input type="submit"  class="default_btn" name="dosubmit" id="dosubmit" value="<?php echo Yii::t('admin','submit');?>" /></div>
			<?php $this->endWidget(); ?>
			<?php }else{?>
			<p  class="please_select_site"><?php echo Yii::t('admin','please select role');?></p>
			<?php }?>
		</div>
	</div>
	
</div>
		
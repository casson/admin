<?php 
use yii\widgets\ActiveForm;
?>
<link href="<?php echo Yii::$app->request->baseUrl; ?>/public/css/jquery.treeTable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/public/js/jquery.treetable.js"></script>
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
	.priv_form{width:100%;height:650px;margin-bottom:10px}
	.priv_form_right{width:98%;height:650px;border:1px solid #d6d6d6;background:#fff;overflow:auto;margin:0 auto;}
</style>


<div class="common_form" >
	<div class="priv_form" >
		<div class="priv_form_right">
			<?php if($role_id){?>
			<table width="100%" cellspacing="0" id="dnd-example"  style="border:0px;">
			<?php $form=ActiveForm::begin(array('id'=>'ajax_form','enableAjaxValidation'=>false,'validateOnSubmit'=>true, 'validateOnChange'=>false)); ?>
			<input type="hidden" name="role_id" value="<?php echo $role_id;?>" />
			<tbody>
			<tr>
			<td style="padding-left:30px;"><a href="javascript:void(0);" onclick="javascript:edit(&quot;/admin/admin/menu/addmodule/parent_id/0 &quot;,&quot;pop_original&quot;,&quot;添加菜单&quot;)" title="添加"><b>添加菜单</b></a></td>
			</tr>
			<?php echo $categorys;?>
			</tbody>
			</table>
			
			<?php ActiveForm::end(); ?>
			<?php }else{?>
			<p  class="please_select_site"><?php echo Yii::t('admin','please select role');?></p>
			<?php }?>
		</div>
	</div>
</div>
		
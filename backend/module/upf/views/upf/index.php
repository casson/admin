<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>UploadiFive Test</title>       
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->controller->assetsUrl; ?>/js/uploadify/uploadify.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->controller->assetsUrl; ?>/js/uploadify/custom.css"/>
    <script type="text/javascript" src="<?php echo Yii::$app->controller->assetsUrl; ?>/js/uploadify/jquery.uploadify.min.js?r=<?php echo rand(0,9999)?>"></script>
    <script type="text/javascript" src="<?php echo Yii::$app->controller->assetsUrl; ?>/js/uploadify/<?php echo Yii::$app->language; ?>.js?r=<?php echo rand(0,9999)?>"></script>
    <style type="text/css">
        body { font: 13px Arial, Helvetica, Sans-serif;}
    </style>
</head>

<body style="width:750px;height:350px;">
    <ul class="tab_header" id='tab_header'>
        <li class="tab_on" >上传文件</div>
        <li class="tab_off">网络文件</div>
    </ul>
    <!--本地文件上传-->
    <div class="tab_content" id='tab_content_0'  >
        <script type="text/javascript">
            <?php $timestamp = time();?>
            $(function() {
                $('#file_upload').uploadify({
                    'overrideEvents' : ['onDialogClose','onUploadError','onSelectError'],
                    'auto'     : <?php echo $auto ;?>,
                    'fileTypeExts' : '<?php echo $ext ;?>', 
                    'fileSizeLimit' : '<?php echo $max_size ;?>',
                    'uploadLimit' : <?php echo $max_num ;?>,
                    'queueSizeLimit' : <?php echo $max_num ;?>,
                    'multi'    : <?php echo $multi ;?>,
                    //传递参数
                    'formData'     : {
                        'timestamp' : '<?php echo $timestamp;?>',
                        'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
                        'model' :'<?php echo $model;?>',
                        'thumb' :'<?php echo $thumb1;?>' ,
                        'thumbImg' :'<?php echo $thumbImg1;?>' ,
                        'ext' :'<?php echo $ext;?>' ,
                        'style' :'<?php echo $style;?>' ,
                        'rename':'',
                        'shui':'',
                        'st':''
                        
                    },
                    'buttonImage' : '<?php echo Yii::$app->controller->assetsUrl; ?>/images/swfBnt.png',
                    'swf'      : '<?php echo Yii::$app->controller->assetsUrl; ?>/js/uploadify/uploadify.swf',
                     'onSelect' : function(file) {  
                            this.addPostParam("file_name",encodeURI(file.name));//改变文件名的编码
                       },
                    'width':75,
                    'height':28,
                    'queueID'  : 'file_queue',
                    'uploader' : '<?php echo Yii::$app->request->baseUrl; ?>/upf/upf/upload',
                 
                    'onUploadStart':function(){
                         $("#file_upload").uploadify('settings','formData' ,{'rename': $("#rename").val(),'shui': $("#shui").val(),'st': $("#st").val()});
                        },
                 
                    
                    //单个文件上传成功响应
                    'onUploadSuccess' : function(file, data, response) {
                         //alert(data);
                        $('.uploadify-queue-item').fadeOut(2000);
                        var data = data.split("|");
                        //alert(data[0]);
                        var img='<img src="'+data[1]+'" alt='+data[1]+' <?php echo $allselect==1?"  class=\'selected_img\'":""; ?>>';
                        var delete_btn = "<div class='select_btn <?php echo $allselect==1?"select_btn_on":"select_btn_off"; ?>'></div>";
                        var div = "<div class='unit' id='unit' >"+img+delete_btn+"</div>";
                        $('#file_queue').append(div);
                        <?php 
                               if($allselect==1){	
                         ?>
                        $(".unit").toggle(
                          function () {
                            $(this).find('img').removeClass('selected_img');
                            $(this).find('.select_btn').removeClass("select_btn_on");
                            $(this).find('.select_btn').addClass("select_btn_off");
                          },
                         function () {
                            $(this).find('img').addClass('selected_img');
                            $(this).find('.select_btn').addClass("select_btn_on");
                            $(this).find('.select_btn').removeClass("select_btn_off");
                          }
                          
                        );
                        <?php }else{?>

                        $(".unit").toggle(
                                  function () {

                                    $(".unit").find('img').removeClass('selected_img');
                                    $(".unit").find('.select_btn').addClass("select_btn_off");
                                    $(this).find('img').removeClass('selected_img');
                                    $(this).find('.select_btn').removeClass("select_btn_on");
                                    $(this).find('.select_btn').addClass("select_btn_off");
                                  },
                                 function () {
                                    $(this).find('img').addClass('selected_img');
                                    $(this).find('.select_btn').addClass("select_btn_on");
                                    $(this).find('.select_btn').removeClass("select_btn_off");
                                  }
                                  
                                );
                        <?php }?> 
                         
                        if(this.settings.uploadLimit>1)
                        {
                            $('#file_upload').uploadify('upload');
                        }
                        
                                    
                    },
                    //上传异常处理 
                    'onUploadError' : function(file, errorCode, errorMsg, errorString) {

                        if(errorCode==-280||errorCode==-290)    //使用者自己取消的動作不再跳訊息視窗
                        {
                             return ;   
                        }
                        var msgText = "";
                        switch(errorCode)
                        {
                            case -200:
                                msgText += uploadifyLang['errorMsg200']+errorMsg;
                            break;
                            case -210:
                                msgText += uploadifyLang['errorMsg210'];
                                break;
                            case -230:
                                msgText += uploadifyLang['errorMsg230']+errorMsg;
                                break;
                            case -240:
                                msgText += uploadifyLang['errorMsg100']+this.settings.uploadLimit+uploadifyLang['unit'];
                                break;
                            case -250:
                                msgText += uploadifyLang['failed']+errorMsg;
                                break;
                            case -260:
                                msgText += uploadifyLang['errorMsg260'];
                                break;
                            case -270:
                                msgText += uploadifyLang['error_arg'];
                                break;
                            case -280:
                                msgText += file.name+uploadifyLang['errorMsg280'];
                                break;
                            case -290:
                                msgText += file.name+uploadifyLang['errorMsg290'];
                                break;
                            default:   
                                msgText += uploadifyLang['file']+file.name+uploadifyLang['errorMsg888']+errorCode+"\n"+errorMsg+"\n"+errorString;
                        }
                        
                        $('.error').html(msgText);
                        $('.error').show();
                        $('.error').fadeOut(5000);
                    },
                    'onSelectError' : function(file, errorCode, errorMsg) {
                        var msgText = "";
                        switch(errorCode)
                        {
                            case -100:
                                msgText += uploadifyLang['errorMsg100']+this.settings.queueSizeLimit+uploadifyLang['unit'];
                                break;
                            case -110:
                                msgText += uploadifyLang['errorMsg110']+"( "+this.settings.fileSizeLimit+" )";
                                break;
                            case -120:
                                msgText += uploadifyLang['errorMsg120'];
                                break;
                            case -130:
                                msgText += uploadifyLang['errorMsg130']+this.settings.fileTypeExts;
                                break;
                            default:   
                                msgText += uploadifyLang['errorMsg888']+errorCode+"\n"+errorMsg;
                        }
                        
                        $('.error').html(msgText);
                        $('.error').show();
                        $('.error').fadeOut(5000);
                    }                       
                });
            });
        </script> 
        <div>
            <div class="addnew" id="addnew"><input type="file" name="file_upload" id="file_upload" style="display:none" /></div>		
            <input id="btupload" value="开始上传"  type="button" onclick="javascript:$('#file_upload').uploadify('upload')">      
        </div>
        <div class="init_info" >最多上传 <font color="#FF0000"><?php echo $max_num ;?></font> 个附件,单文件最大 <font color="#FF0000"><?php echo $max_size ;?></font> 支持<font color="#FF0000"><?php echo $ext ;?></font>格式。</div>
     
        <p style="height:30px; line-height:30px; vertical-align:middle;">
        <?php 


         if($thumb){
        ?>
        <select name="chkPicEdit" id="st"  style="display:none;" >
            <option value="0">不做缩图</option>
            <?php 
              foreach ($thumb as $r){
            //   $tb=  isset($_COOKIE["tb"])?$_COOKIE["tb"]:"0";
               
            ?>
            <option value="<?php echo $r;?>"   ><?php echo $r;?></option>
            <?php }?>
            </select>　　
         <?php }?>   
         
        <?php 
            if($thumbImg){
        ?>
            水印：<select name="chkAddWaterMark" id="shui"  >
            <?php 
               foreach ($thumbImg as $r){
              // $tb=  isset($_COOKIE["tb1"])?$_COOKIE["tb1"]:"0";
               $r = explode("|", $r);
            ?>
            <option value="<?php echo $r[1];?>"   ><?php echo $r[0];?></option>
            <?php }?>
          </select>　　
           <?php }?> 
          重命名：<select name="chkFileName" id="rename">
              <option value="0"  >否</option>
              <option value="1" selected  >是</option>
          </select>  
       </p>
     
     
        <fieldset id="file_queue" class="file_queue">
            <legend>列表</legend>
            <div  class="error"></div>
        </fieldset>
    </div>
    <!--网络文件上传-->
    <div class="tab_content" id='tab_content_1'  style="display:none">      
        <table width="98%" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
            <tbody>
                <tr>
                    <td width="37%" align="left" valign="middle" class="xingmu" title="点击以文件名排序"><span value="0" id="Order_0" style="cursor:pointer;" onclick="Javascript:Order_AllFiles(this);">文 件 名</span></td>
                    <td width="10%" align="left" valign="middle" class="xingmu" title="点击以文件类型排序"><span value="0" id="Order_1" style="cursor:pointer;" onclick="Javascript:Order_AllFiles(this);">文件类型</span></td>
                    <td width="10%" align="left" valign="middle" class="xingmu" title="点击以文件大小排序"><span value="0" id="Order_2" style="cursor:pointer;" onclick="Javascript:Order_AllFiles(this);">文件大小</span></td>
                    <td width="13%" align="left" valign="middle" class="xingmu" title="点击以上传日期排序"><span value="0" id="Order_3" style="cursor:pointer;" onclick="Javascript:Order_AllFiles(this);">上传日期</span></td>
                </tr> 
              
            <?php 
                         foreach($dirlist as $key=>$r)
                         {
                         
                            $picname = str_replace($dirs, "", iconv("gb2312","UTF-8", $r["dir"]));
             
                            
                            // $myfile = Yii::$app->file->set($r, true);
                  
            ?>
                <tr id="<?php echo $key;?>"> 
                    <td width="37%" class="hback" >
                        <input type="checkbox"   id="cbk<?php echo $key;?>"  alt="<?php echo Yii::$app->request->baseUrl."/".$dirs.$picname;?>">
                        <span> <?php echo $picname;?></span> 
                        <div id="piao" class="chakan0" style="display:none;"></div>
                    </td>
                    <td width="10%" class="hback">
                        <div align="left"> 图像 </div>
                    </td>
                    <td width="10%" class="hback">
                        <div align="left"> <?php echo $r["size"];?></div>
                    </td>
                    <td width="13%" class="hback"><?php echo $r["date"];?></td>
                </tr>
            <?php   }?> 
            </tbody>  
        </table>
    </div>
    <style>
    #piao img{width:expression(this.width > 300  ? 300 : true); max-width:300px;}
           #piao { position:absolute; margin-left:160px;}

    </style>
    <script>
    $(document).ready(function(){
        $('ul.tab_header li').each(function(i)
        {
            
            $(this).bind('click',function(){
                 changeShowMode(i);
                
            });
            
        })
    })
    //切换样式及显示模式
    function changeShowMode(click_num)
    {
        $('#mode').val(click_num);
        var content_id;
        $('ul.tab_header li').each(function(i)
        {
            content_id = 'tab_content_'+i;
            if(click_num==i)
            {
                $(this).addClass('tab_on');
                $(this).removeClass('tab_off');
                $('#'+content_id).show();
            
            }
            else
            {
                $(this).addClass('tab_off');
                $(this).removeClass('tab_on');
                $('#'+content_id).hide();
            }		
        })
    }
     
    <?php 
    if($multi==1){
    ?>
    $("#tab_content_1 tr").toggle(
            function (){
              $id =$(this).attr("id");
              $(this).addClass("sel");
              $("#cbk"+$id).addClass("selected");     
              $("#cbk"+$id).prop("checked",true);     
            },
            function (){
           
                $id =$(this).attr("id"); 
                $(this).removeClass("sel");
                $("#cbk"+$id).removeClass("selected");     
                
                $("#cbk"+$id).prop("checked",false);   
            }

    )
    <?php }else{?>
    $("#tab_content_1 tr").toggle(
            function (){
                 $("#tab_content_1 tr input").attr("checked",false);	
                 $("#tab_content_1 tr").removeClass("sel");			 
              $id =$(this).attr("id");

              $("#cbk"+$id).addClass("selected");  
              $(this).addClass("sel");
              $("#cbk"+$id).prop("checked",true);     
            },
            function (){
                 $id =$(this).attr("id"); 
                 $(this).removeClass("sel");
                 $("#cbk"+$id).removeClass("selected");    
                $("#cbk"+$id).prop("checked",false);   
            }

    )
    <?php }?>
     
     
     

    $("#tab_content_1 tr").mousemove(function (){
     $img = $(this).find("input").attr("alt");
     $(this).find("#piao").html("<img src=\""+$img+"\">");
        $(this).find("#piao").show();
        
    })
    $("#tab_content_1 tr").mouseout(function (){
         $(this).find("#piao").html("");
        $(this).find("#piao").hide();
    })
    </script>	
	
    <style> 
    #tab_content_1 tr{cursor:pointer;} 
     /* 定义表CSS */
    .table{
        border: 0px solid #939393;
        margin-top: 5px;
        margin-bottom: 5px;
        background:#C8C8C8; font-size:12px;
    }
      
     /* 定义大字体标题CSS  */
    .xingmu {
        line-height: 20px;
        font-family: "Verdana, 新宋体";
        color:#333333;
        font-size:12px;
        font-weight:bolder;
        background:#DBDAD9;
        /*background-image : url("images/skin/title_bg.gif");*/
    }
    .titledaohang {
        FONT-SIZE: 12px; 
        FILTER: Glow(Color=#CACACA, Strength=1) dropshadow(Color=#A2A2A2, OffX=1, OffY=1,); 
        COLOR: #2F2F2F; 
        font-weight:bolder;
        FONT-FAMILY: '宋体'
    }
    A.admintx:link {
        FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #3D3D3D; TEXT-DECORATION: none;font-weight:bolder;
    }
    A.admintx:visited {
        FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #3D3D3D; TEXT-DECORATION: none;font-weight:bolder;
    }
    A.admintx:hover {
        FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #FF0000; TEXT-DECORATION: none;font-weight:bolder;
    }
    A.admintx:active {
        FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #FF0000; TEXT-DECORATION: none;font-weight:bolder;
    }
    .back {
        background:#F2F2F2;
    }
    .Leftback {
        background:#DBDBDB;
    }
    .hback {
        background:#EAEAEA;
    }
    .hback_1 {
        background:#D9D9D9;
    }
    .sel .hback{background:#fff;}
             
    </style>	 
</body>
</html>
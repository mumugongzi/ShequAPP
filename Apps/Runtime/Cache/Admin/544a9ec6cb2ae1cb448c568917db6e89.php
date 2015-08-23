<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['shopTitle']['fieldValue']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <script>
      $(function(){
    	  $('#myTab a').click(function (e) {
    		  e.preventDefault();
    		  $(this).tab('show');
    	  })
      })
      function save(){
    		var params = {};
    		<?php foreach($configs as $key =>$cf){ foreach($cf as $key =>$vo){ if($vo['fieldType']=='radio'){ ?>
    			params.<?php echo ($vo['fieldCode']); ?> = $("input:radio[name='<?php echo ($vo['fieldCode']); ?>']:checked").val();
    		<?php }else{ ?>
    			params.<?php echo ($vo['fieldCode']); ?> = $('#<?php echo ($vo['fieldCode']); ?>').val();
    		<?php }}} ?>
    		Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
    		$.post("/index.php/Admin/index/saveMallConfig",params,function(data,textStatus){
    			var json = WST.toJson(data);
    			if(json.status=='1'){
    				Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){}});
    			}else{
    				Plugins.closeWindow();
    				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
    			}
    		});
    	}
      </script>
   </head>
   <body>
      <ul id="myTab" class="nav nav-tabs wst-tab" role="tablist">
	      <li class="active"><a href="#tabc0" role="tab" data-toggle="tab">商城设置</a></li>
	      <li><a href="#tabc1" role="tab" data-toggle="tab">邮件设置</a></li>
	      <li><a href="#tabc2" role="tab" data-toggle="tab">短信设置</a></li>
	  </ul>
      <div class='tab-content wst-tab-content'>
          <?php if(is_array($configs)): foreach($configs as $k=>$vo): ?><div class='tab-pane <?php if($k == 0): ?>active in<?php endif; ?> fade wst-tab-pane' id='tabc<?php echo ($k); ?>'>
            <form class="form-horizontal" role="form">
               <table class='table table-hover table-striped table-bordered wst-form'>
               <?php if(is_array($vo)): foreach($vo as $key=>$v): ?><tr>
                  <th width='150'><?php echo ($v['fieldName']); ?>：</th>
                  <td>
                     <?php if($v['fieldType']=='text'){ ?>
                     <input type='text' class="form-control wst-ipt" id='<?php echo ($v["fieldCode"]); ?>' name='<?php echo ($v["code"]); ?>' value="<?php echo ($v['fieldValue']); ?>"/>
                     <?php }else if($v['fieldType']=='radio'){ foreach($v['txt'] as $kt => $vt){ ?>
                       <label>
			           <input type='radio' id='<?php echo ($v["val"][$kt]); ?>_<?php echo ($kt); ?>' name='<?php echo ($v["fieldCode"]); ?>' value='<?php echo ($v["val"][$kt]); ?>' size='30' <?php if($v["fieldValue"]==$v["val"][$kt]){ echo "checked";} ?> /><?php echo ($vt); ?>&nbsp;&nbsp;
			           </label>
			         <?php } ?>
                     <?php }else if($v['fieldType']=='textarea'){ ?>
                     <textarea id='<?php echo ($v["fieldCode"]); ?>' name='<?php echo ($vo["fieldCode"]); ?>' style='width:400px;height:100px;'><?php echo ($v['fieldValue']); ?></textarea><?php echo ($vo['txtTips']); ?>
                     <?php } ?>
                  </td>
               </tr><?php endforeach; endif; ?>
               <tr>
                 <td style='padding-left:250px;' colspan='2'>
                    <button type="button" class="btn btn-primary" onclick='javascript:save()'>保&nbsp;存</button>
                    <button type="reset" class="btn btn-primary">重&nbsp;置</button>
                 </td>
               </tr>
               </table>
             </form>  
          </div><?php endforeach; endif; ?>
      </div>
   </body>
</html>
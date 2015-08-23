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
   </head>
   <script>
   function edit(id){
       location.href='/index.php/Admin/Ads/toEdit/?id='+id;     
   }
   function del(id){
	   Plugins.confirm({title:'信息提示',content:'您确定要删除该广告吗?',okText:'确定',cancelText:'取消',okFun:function(){
		   Plugins.closeWindow();
		   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
		   $.post("/index.php/Admin/Ads/del",{id:id},function(data,textStatus){
					var json = WST.toJson(data);
					if(json.status=='1'){
						Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
						   location.reload();
						}});
					}else{
						Plugins.closeWindow();
						Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
					}
				});
	   }});
   }
   </script>
   <body class='wst-page'>
       <div class='wst-tbar' style='text-align:right;height:25px;'>
       <button type="button" class="btn btn-success glyphicon glyphicon-plus" onclick='javascript:edit(0)' style='float:right'>新增</button>
       </div>
       <div class="wst-body"> 
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='40'>&nbsp;</th>
               <th width='120'>广告标题</th>
               <th>广告位置</th>
               <th>广告网址</th>
               <th>广告日期</th>
               <th>所属地区</th>
               <th width='80'>图标</th>
               <th width='80'>点击数</th>
               <th width='150'>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['root'])): $i = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
               <td><?php echo ($i); ?></td>
               <td><?php echo ($vo['adName']); ?></td>
               <td>
               <?php if($vo['adPositionId'] == -1 ): ?>首页主广告
               <?php elseif($vo['adPositionId'] == -2 ): ?>品牌汇广告
               <?php elseif($vo['adPositionId'] == -3 ): ?>店铺街广告
               <?php else: ?>首页分层广告<?php endif; ?>
               </td>
               <td><?php echo ($vo['adURL']); ?></td>
               <td><?php echo ($vo['adStartDate']); ?>至<?php echo ($vo['adEndDate']); ?></td>
               <td><?php echo ($vo['areaName1']); echo ($vo['areaName2']); ?></td>
               <td><img src='/<?php echo ($vo['adFile']); ?>' width='60' height='30'></td>
               <td><?php echo ($vo['adClickNum']); ?></td>
               <td>
               <button type="button" class="btn btn-default glyphicon glyphicon-pencil" onclick="javascript:edit(<?php echo ($vo['adId']); ?>)"">修改</button>&nbsp;
               <button type="button" class="btn btn-default glyphicon glyphicon-trash" onclick="javascript:del(<?php echo ($vo['adId']); ?>)"">刪除</button>
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='9' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
</html>
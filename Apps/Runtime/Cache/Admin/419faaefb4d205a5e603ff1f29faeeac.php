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
       location.href='/index.php/Admin/Shops/toEdit/?id='+id;     
   }
   function del(id){
	   Plugins.confirm({title:'信息提示',content:'您确定要删除该商家吗?',okText:'确定',cancelText:'取消',okFun:function(){
		   Plugins.closeWindow();
		   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
		   $.post("/index.php/Admin/Shops/del",{id:id},function(data,textStatus){
					var json = WST.toJson(data);
					if(json.status=='1'){
						Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
							location.reload();
						}});
					}else{
						Plugins.closeWindow();
						parent.showMsg({msg:'操作失败!',status:'danger'});
					}
				});
	      }});
   }
   function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post("/index.php/Admin/Areas/queryByList",params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.areaId+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
	   });
   }
   
   function batchBest(v){
	   var ids = [];
	   $('.chk').each(function(){
		   if($(this).prop('checked'))ids.push($(this).val());
	   })
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("/index.php/Admin/Shops/changeBestStatus",{id:ids.join(','),status:v},function(data,textStatus){
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
   }
   function batchRecom(v){
	   var ids = [];
	   $('.chk').each(function(){
		   if($(this).prop('checked'))ids.push($(this).val());
	   })
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("/index.php/Admin/Shops/changeRecomStatus",{id:ids.join(','),status:v},function(data,textStatus){
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
   }
   function checkAll(v){
	   $('.chk').each(function(){
		   $(this).prop('checked',v);
	   })
   }
   
   function query(){
	   var q = [];
	   q.push('shopName='+$('#shopName').val());
	   q.push('shopSn='+$('#shopSn').val());
	   q.push('areaId1='+$('#areaId1').val());
	   q.push('areaId2='+$('#areaId2').val());
	   location.href="/index.php/Admin/Shops/index/?"+q.join('&');
   }
   $(document).ready(function(){
	    <?php if(!empty($areaId1)): ?>getAreaList("areaId2",'<?php echo ($areaId1); ?>',0,'<?php echo ($areaId2); ?>');<?php endif; ?>
   });
   
   </script>
   <body class='wst-page'>
       <div class='wst-tbar'> 
    地区：<select id='areaId1' onchange='javascript:getAreaList("areaId2",this.value,0)'>
               <option value=''>请选择</option>
               <?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($areaId1 == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
             </select>
             <select id='areaId2'>
               <option value=''>请选择</option>
             </select>    
       店铺名称：<input type='text' id='shopName' name='shopName' class='form-control wst-ipt-10' value='<?php echo ($shopName); ?>'/> 
       店铺编号：<input type='text' id='shopSn' name='shopSn' class='form-control wst-ipt-10' value='<?php echo ($shopSn); ?>'/> 
  <button type="button" class="btn btn-primary glyphicon glyphicon-search" onclick='javascript:query()'>查询</button> 
  <?php if(in_array('dplb_01',$WST_STAFF['grant'])){ ?>
  <button type="button" class="btn btn-success glyphicon glyphicon-plus" onclick='javascript:edit(0)' style='float:right'>新增</button>
  <?php } ?>     
       </div>
       <div class='wst-body'>
	   
        <div class='wst-tbar'> 
        <button type="button" class="btn btn-primary glyphicon" onclick='javascript:batchBest(1)'>设置精品</button>
        <button type="button" class="btn btn-primary glyphicon" onclick='javascript:batchBest(0)'>取消精品</button>
        <button type="button" class="btn btn-primary glyphicon" onclick='javascript:batchRecom(1)'>设置推荐</button>
        <button type="button" class="btn btn-primary glyphicon" onclick='javascript:batchRecom(0)'>取消推荐</button>  
        </div>
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
             <th width='5'><input type='checkbox' name='chk' onclick='javascript:checkAll(this.checked)'/></th>
               <th width='30'>序号</th>
               <th width='50'>店铺名称</th>
               <th width='50'>店铺编号</th>
               <th width='50'>店主</th>
               <th width='50'>分类</th>
               <th width='30'>推荐</th>
               <th width='30'>精品</th>
               <th width='60'>营业状态</th>
               <th width='120'>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['root'])): $i = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
             <td><input type='checkbox' class='chk' name='chk_<?php echo ($vo['shopId']); ?>' value='<?php echo ($vo['shopId']); ?>'/></td>
             
               <td><?php echo ($i); ?></td>
               <td><?php echo ($vo['shopName']); ?></td>
               <td><?php echo ($vo['shopSn']); ?>&nbsp;</td>
               <td><?php echo ($vo['userName']); ?>&nbsp;</td>
               <td><?php echo ($vo['catName']); ?>&nbsp;</td>
               <td>
               <?php if($vo['isAdminRecom']==1 ): ?>推荐<?php endif; ?>
               </td>
               <td>
               <?php if($vo['isAdminBest']==1 ): ?>精品<?php endif; ?>
               </td>
               
               <td>
               <?php if($vo['shopAtive'] == 1 ): ?><span class='label label-success'>营业中</span><?php endif; ?>
               <?php if($vo['shopAtive'] == 0 ): ?><span class='label label-warning'>休息中</span><?php endif; ?>&nbsp;
               </td>
               <td>
               <?php if(in_array('dplb_02',$WST_STAFF['grant'])){ ?>
               <button type="button" class="btn btn-default glyphicon glyphicon-pencil" onclick="javascript:edit(<?php echo ($vo['shopId']); ?>)">修改</button>&nbsp;
               <?php } ?>
               <?php if(in_array('dplb_03',$WST_STAFF['grant'])){ ?>
               <button type="button" class="btn btn-default glyphicon glyphicon-trash" onclick="javascript:del(<?php echo ($vo['shopId']); ?>)">刪除</buttona>
               <?php } ?>
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='11' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
</html>
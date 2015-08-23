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
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
   </head>
   <script>
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
   $(function(){
	   getAreaList("areaId2",'<?php echo ($areaId1); ?>',0,'<?php echo ($areaId2); ?>');
	   getAreaList("areaId3",'<?php echo ($areaId2); ?>',1,'<?php echo ($areaId3); ?>');
   });
   function query(){
	   var q = [];
	   q.push('shopName='+$('#shopName').val());
	   q.push('orderNo='+$('#orderNo').val());
	   q.push('isRefund='+$('#isRefund').val());
	   q.push('areaId1='+$('#areaId1').val());
	   q.push('areaId2='+$('#areaId2').val());
	   q.push('areaId3='+$('#areaId3').val());
	   location.href="/index.php/Admin/Orders/queryRefundByPage/?"+q.join('&');
   }
   function refund(id){
	   Plugins.Modal({url:'/index.php/Admin/Orders/toRefund/?id='+id,title:'订单退款',width:600});
   }
   </script>
   <body class='wst-page'>
       <div class='wst-tbar'>
          所属区域：
          <select id='areaId1' onchange='javascript:getAreaList("areaId2",this.value,0)'>
             <option value=''>请选择</option>
             <?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($areaId1 == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
          <select id='areaId2' onchange='javascript:getAreaList("areaId3",this.value,1);getCommunitys()'>
             <option value=''>请选择</option>
          </select>
          <select id='areaId3'>
             <option value=''>请选择</option>
          </select>
       店铺：<input type='text' id='shopName' value='<?php echo ($shopName); ?>'/>  
       订单：<input type='text' id='orderNo' value='<?php echo ($orderNo); ?>'/>
       退款状态 ：<select id='isRefund'>
             <option value='-1'>全部</option>
             <option value='0' <?php if($isRefund ==0 ): ?>selected<?php endif; ?>>未退</option>
             <option value='1' <?php if($isRefund ==1 ): ?>selected<?php endif; ?>>已退</option>
         </select>
       <button type="button" class="btn btn-primary glyphicon glyphicon-search" onclick='javascript:query()'>查询</button> 
       </div>
       <div class="wst-body"> 
        <table class="table table-hover table-striped table-bordered wst-list">
           <?php if(is_array($Page['root'])): $key = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><thead>
             <tr>
               <th colspan='6'><?php echo ($key); ?>.订单：<?php echo ($vo['orderNo']); ?><span style='margin-left:100px;'><?php echo ($vo['shopName']); ?></span></th>
             </tr>
           </thead>
           <tbody>
             <tr>
               <td>
               <div style='width:150px;'>
               <?php if(is_array($vo['goodslist'])): $i = 0; $__LIST__ = $vo['goodslist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><img style='margin:2px;' src="/<?php echo ($goods['goodsThums']); ?>" height="50" width="50" title='<?php echo ($goods['goodsName']); ?>'/><?php endforeach; endif; else: echo "" ;endif; ?>
			   </div>
               </td>
               <td><?php echo ($vo['userName']); ?></td>
               <td>
                                             ￥<?php echo ($vo['totalMoney']+$vo['deliverMoney']); ?><br/>
               <?php if($vo['payType'] ==1 ): ?>在线支付<?php else: ?>货到付款<?php endif; ?>
               </td>
               <td ><?php echo ($vo['createTime']); ?></td>
               <td><?php if($vo['isRefund'] ==1 ): ?>已退款<?php else: ?>未退款<?php endif; ?></td>
               <td width='150'>
               <a class="btn btn-primary glyphicon" href="/index.php/Admin/Orders/toRefundView/?id=<?php echo ($vo['orderId']); ?>">查看</a>&nbsp;
               <?php if($vo['isRefund'] ==0 ): if(in_array('tk_04',$WST_STAFF['grant'])){ ?>
               <a class="btn btn-primary glyphicon" href="javascript:refund(<?php echo ($vo['orderId']); ?>)">退款</a>&nbsp;
               <?php } endif; ?>
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='6' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
</html>
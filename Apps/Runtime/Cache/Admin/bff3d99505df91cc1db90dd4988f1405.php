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
     <?php if ($areaId1!=0): ?>
	   getAreaList("areaId2",'<?php echo ($areaId1); ?>',0,'<?php echo ($areaId2); ?>');
     <?php elseif ($areaId2 != 0) : ?>
	   getAreaList("areaId3",'<?php echo ($areaId2); ?>',1,'<?php echo ($areaId3); ?>');
     <?php endif ?>
	   $('#orderStatus').val(<?php echo ($orderStatus); ?>);
   });
   function query(){
	   var q = [];
	   q.push('shopName='+$('#shopName').val());
	   q.push('orderNo='+$('#orderNo').val());
	   q.push('orderStatus='+$('#orderStatus').val());
	   q.push('areaId1='+$('#areaId1').val());
	   q.push('areaId2='+$('#areaId2').val());
	   q.push('areaId3='+$('#areaId3').val());
	   location.href="/index.php/Admin/Orders/index/?"+q.join('&');
   }
   </script>
   <body class='wst-page'>
       <div class='wst-tbar' style='height:25px;'>
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
  订单状态：  <select id='orderStatus'>
             <option value='-9999'>请选择</option>
             <option value='-2'>未支付</option>
             <option value='0'>未受理</option>
             <option value='1'>已受理</option>
             <option value='2'>打包中</option>
             <option value='3'>配送中</option>
             <option value='4'>已到货</option>
             <option value='5'>店铺确认到货</option>
             <option value='-1'>已取消</option>
             <option value='-3'>会员拒收</option>
             <option value='-4'>店铺确认拒收</option>
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
               <td><?php echo ($vo['createTime']); ?></td>
               <td>
               <?php if($vo["orderStatus"] == -3): ?>会员拒收
               <?php elseif($vo["orderStatus"] == -4): ?>店铺确认拒收
			   <?php elseif($vo["orderStatus"] == -2): ?>未付款
			   <?php elseif($vo["orderStatus"] == -1): ?>已取消
			   <?php elseif($vo["orderStatus"] == 0): ?>未受理
			   <?php elseif($vo["orderStatus"] == 1): ?>已受理
			   <?php elseif($vo["orderStatus"] == 2): ?>打包中
			   <?php elseif($vo["orderStatus"] == 3): ?>配送中
			   <?php elseif($vo["orderStatus"] == 4): ?>已到货
			   <?php elseif($vo["orderStatus"] == 5): ?>店铺确认到货<?php endif; ?>
               </td>
               <td>
               <a class="btn btn-primary glyphicon" href="/index.php/Admin/Orders/toView/?id=<?php echo ($vo['orderId']); ?>"">查看</a>&nbsp;
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
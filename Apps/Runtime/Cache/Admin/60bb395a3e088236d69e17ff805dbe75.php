<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['shopTitle']['fieldValue']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/Apps/Admin/View/css/AdminLTE.css">
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script>
      $(function () {
	      WST.getWSTMAllVersion("<?php echo U('Admin/Index/getWSTMallVersion');?>");
      });
      </script>
   </head>
   <body>
      <div class='panel wst-panel-full'>
         <!-- <div class='wstmall-version-tips'>您有新的版本(<span id='wstmall_version'>0.0.0</span>)可以下载啦~，<a id='wstmall_down' href='' target='_blank'>点击</a>下载</div>   -->   
         <div class="box box-info col-xs-12">
             <p style='font-size:18px;'>您好，<?php echo session('WST_STAFF.staffName');?>，欢迎使用<?php echo ($CONF['shopTitle']['fieldValue']); ?>。 您上次登录的时间是 <?php echo session('WST_STAFF.lastTime');?> ，IP 是 <?php echo session('WST_STAFF.lastIP');?></p>
         </div>
         <div class="box box-info col-xs-12">
           <div class="box-header">
             <h3 class="text-blue">一周动态</h3>
             <table class="table table-hover table-striped table-bordered wst-form">
                <tr>
                   <td width="200">新增会员数：</td>
                   <td width="300"><?php echo ($weekInfo["userNew"]); ?></td>
                   <td width="200">新增店铺数/申请数：</td>
                   <td width="300"><?php echo ($weekInfo["shopNew"]); ?>/<?php echo ($weekInfo["shopApply"]); ?></td>
                </tr>
                <tr>
                   <td width="200">新增商品数：</td>
                   <td width="300"><?php echo ($weekInfo["goodsNew"]); ?></td>
                   <td width="200">新增订单数：</td>
                   <td width="300"><?php echo ($weekInfo["ordersNew"]); ?></td>
                </tr>
             </table>
           </div><!-- /.box-header -->
        </div><!-- /.box-body -->   
        <div class="box box-info col-xs-12">
           <div class="box-header">
             <h3 class="text-blue">统计信息</h3>
             <table class="table table-hover table-striped table-bordered wst-form">
                <tr>
                   <td width="200">会员总数：</td>
                   <td width="300"><?php echo ($sumInfo["userSum"]); ?></td>
                   <td width="200">店铺总数/申请总数：</td>
                   <td width="300"><?php echo ($sumInfo["shopSum"]); ?>/<?php echo ($sumInfo["shopApplySum"]); ?></td>
                </tr>
                <tr>
                   <td width="200">商品总数：</td>
                   <td width="300"><?php echo ($sumInfo["goodsSum"]); ?></td>
                   <td width="200">订单总数：</td>
                   <td width="300"><?php echo ($sumInfo["ordersSum"]); ?></td>
                </tr>
                <tr>
                   <td width="200">订单总金额</td>
                   <td width="300" colspan='3'><?php echo ($sumInfo["moneySum"]); ?></td>
                </tr>
             </table>
           </div><!-- /.box-header -->
        </div><!-- /.box-body -->   
        <div class="box box-info col-xs-12">
           <div class="box-header">
             <h3 class="text-blue">系统信息</h3>
             <table class="table table-hover table-striped table-bordered wst-form">
                <tr>
                   <td width="200">服务器操作系统：</td>
                   <td width="300"><?php echo (PHP_OS); ?></td>
                   <td width="200">WEB服务器：</td>
                   <td width="300"><?php echo ($_SERVER['SERVER_SOFTWARE']); ?></td>
                </tr>
                <tr>
                   <td width="200">PHP版本：</td>
                   <td width="300"><?php echo (PHP_VERSION); ?></td>
                   <td width="200">MYSQL版本：</td>
                   <td width="300"><?php echo mysql_get_server_info();?></td>
                </tr>
             </table>
           </div><!-- /.box-header -->
        </div><!-- /.box-body -->   
      </div>
   </body>
</html>
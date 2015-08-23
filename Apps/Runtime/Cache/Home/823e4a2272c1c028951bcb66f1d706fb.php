<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  		<title>我的商铺 - <?php echo ($CONF['shopTitle']['fieldValue']); ?></title>
  		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="Cache" content="no-cache">
  		<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css" />
    	<link rel="stylesheet" href="/Apps/Home/View/default/css/shop.css">
      	
      	<script>
		var publicurl = '/Public/';
		var shopId = '<?php echo ($orderInfo["order"]["shopId"]); ?>';
		var pageCount='<?php echo ($receiveOrders["totalPage"]); ?>';
		var current='<?php echo ($receiveOrders["currPage"]); ?>';
		</script>
		<?php echo WSTLoginTarget(1);?>
    </head>
    <body>
        <div class="wst-wrap">
          <div class='wst-header'>
			<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/plugins/lazyload/jquery.lazyload.min.js?v=1.9.1"></script>
<script type="text/javascript">
     var domainURL = "<?php echo WSTDomain();?>";
     var publicurl = "/Public";
     var currCityId = "<?php echo ($currArea['areaId']); ?>";
     var currCityName = "<?php echo ($currArea['areaName']); ?>";
     $(function() {
     	   $("img").lazyload({effect: "fadeIn",failurelimit : 10,threshold: 200,placeholder:'/Apps/Home/View/default/images/store_default_signlist.png'});
     });
</script>
<div id="wst-shortcut">
	<div class="w">
		<ul class="fl lh">
			<li class="fore1 ld"><b></b><a href="javascript:addToFavorite()"
				rel="nofollow">收藏<?php echo ($CONF['shopTitle']['fieldValue']); ?></a></li><s></s>
			<li class="fore3 ld menu" id="app-jd" data-widget="dropdown">
				<span class="outline"></span> <span class="blank"></span> 
				<a href="#" target="_blank"><img src="/Apps/Home/View/default/images/icon_top_02.png"/>&nbsp;<?php echo ($CONF['shopTitle']['fieldValue']); ?> 手机版</a>
			</li>
			<!-- <li class="fore4" id="biz-service" data-widget="dropdown" style='padding:0;'>&nbsp;<s></s>&nbsp;&nbsp;&nbsp;
				所在城市
				【<span class='wst-city'>&nbsp;<?php echo ($currArea["areaName"]); ?>&nbsp;</span>】
				<img src="/Apps/Home/View/default/images/icon_top_03.png"/>	
				&nbsp;&nbsp;<a href="javascript:;" onclick="changeCity();">切换城市</a><i class="triangle"></i>
			</li> -->
		</ul>
	
		<ul class="fr lh" style='float:right;'>
			<li class="fore1" id="loginbar"><a href="<?php echo U('Home/Orders/queryByPage');?>"><span style='color:blue'><?php echo ($WST_USER['loginName']); ?></span></a> 欢迎您来到 <a href='<?php echo WSTDomain();?>/index.php'><?php echo ($CONF['shopTitle']['fieldValue']); ?></a>！<s></s>&nbsp;
			<span>
				<?php if(!$WST_USER['userId']): ?><!-- <a href="<?php echo U('Home/Shops/login');?>">[登录]</a> -->
				<a href="<?php echo U('Home/Shops/toOpenShop');?>"	rel="nofollow">开店申请</a><?php endif; ?>
				<?php if($WST_USER['userId'] > 0): ?><a href="javascript:logout();">[退出]</a><?php endif; ?>
			</span>
			</li>
			<!-- <li class="fore2 ld"><s></s>
			<?php if(session('WST_USER.userId')>0){ ?>
				<?php if(session('WST_USER.userType')==0){ ?>
				    <a href="<?php echo U('Home/Shops/toOpenShopByUser');?>" rel="nofollow">我要开店</a>
				<?php }else{ ?>
				    <?php if(session('WST_USER.loginTarget')==0){ ?>
				        <a href="<?php echo U('Home/Shops/index');?>" rel="nofollow">卖家中心</a>
				    <?php }else{ ?>
				        <a href="<?php echo U('Home/Users/index');?>" rel="nofollow">买家中心</a>
				    <?php } ?>
				<?php } ?>
			<?php }else{ ?>
			    <a href="<?php echo U('Home/Shops/toOpenShop');?>" rel="nofollow">我要开店</a>
			<?php } ?>
			</li> -->
		</ul>
		<span class="clr"></span>
	</div>
</div>


			<!-- <div class='wst-user-top'>
			<div class="wst-user-top-main">
					<div class='wst-user-top-logo'>
						<a href="<?php echo WSTDomain();?>/index.php"  title='商城首页'>
						<img src="/Apps/Home/View/default/images/logo.png" height="132" width='240'/>	
						</a>
					</div>
					<div class='wst-user-top-search'>
						<div class="search-box">
							<input id="wst-search-type" type="hidden" value="1"/>
							<input id="keyword" class="wst-search-ipt" me="q" tabindex="9" placeholder="搜索 商品" autocomplete="off" >
							<div id="btnsch" class="wst-search-btn">搜&nbsp;索</div>
						</div>
					</div>
					
				</div>
			</div> -->
			<div class="wst-shop-nav">
				<div class="wst-nav-box">
					<li class="liselect"><a href="<?php echo U('Home/Shops/index');?>" style='color:#FFFFFF;'>我的商铺</a></li>
					<div class="wst-clear"></div>
				</div>
			</div>
			<div class="wst-clear;"></div>
		</div>
          <div class='wst-nav'></div>
          <div class='wst-main'>
            <div class='wst-menu'>
            <span class='wst-menu-title' style='border-top:0px;'><span></span>商品管理</span>
            
               <a href='/index.php/Home/ShopsCats/index'><li <?php if($umark == "index"): ?>class='liselect'<?php endif; ?>>商品分类</li></a>
               <a href='/index.php/Home/Goods/queryOnSaleByPage'><li <?php if($umark == "queryOnSaleByPage"): ?>class='liselect'<?php endif; ?>>出售中的商品</li></a>
               <a href='/index.php/Home/Goods/queryPenddingByPage'><li <?php if($umark == "queryPenddingByPage"): ?>class='liselect'<?php endif; ?>>待审核商品</li></a>
               <a href='/index.php/Home/Goods/queryUnSaleByPage'><li <?php if($umark == "queryUnSaleByPage"): ?>class='liselect'<?php endif; ?>>仓库中的商品</li></a>
               <a href='/index.php/Home/Goods/toEdit/?umark=toEditGoods'><li <?php if($umark == "toEditGoods"): ?>class='liselect'<?php endif; ?>>新增商品</li></a>
               <a href='/index.php/Home/GoodsAppraises/index'><li <?php if($umark == "GoodsAppraises"): ?>class='liselect'<?php endif; ?>>评价管理</li></a>
            
            <span class='wst-menu-title'><span></span>交易管理</span>
            
              <a href='/index.php/Home/Orders/toShopOrdersList'><li <?php if($umark == "toShopOrdersList"): ?>class='liselect'<?php endif; ?>>订单管理</li></a>
              <span class='wst-menu-title'><span></span>网店设置</span>
            	<a href='/index.php/Home/Shops/toEdit'><li <?php if($umark == "toEdit"): ?>class='liselect'<?php endif; ?>>店铺资料</li></a>
              	<a href='/index.php/Home/Shops/toShopCfg'><li <?php if($umark == "setShop"): ?>class='liselect'<?php endif; ?>>店铺设置</li></a>
              	<a href='/index.php/Home/Messages/queryByPage'><li <?php if($umark == "queryMessageByPage"): ?>class='liselect'<?php endif; ?>>商城消息</li></a>
              	<a href='/index.php/Home/Shops/toEditPass'><li <?php if($umark == "toEditPass"): ?>class='liselect'<?php endif; ?>>修改密码</li></a>
            </div>
            <div class='wst-content'>
            
	<script>
	var statusMark = 0;
	$(function () {
		$('#tab').TabPanel({tab:statusMark,callback:function(tab){
			statusMark = tab;
			queryOrderPager(statusMark,0);
		}});
	});
	</script>
	<div class="wst-body"> 
		<div class='wst-page-header'>卖家中心 > 订单管理</div>
		<div class='wst-page-content' style="padding-top:10px;">
		   <div id='tab' class="wst-tab-box">
			<ul class="wst-tab-nav">
				<li>待受理订单</li>
				<li>已受理订单</li>
				<li>打包中订单</li>
				<li>配送中订单</li>
				<li>已到货订单</li>
				<li>确认已收货订单</li>
				<li>拒收订单</li>
			</ul>
			<div class="wst-tab-content" style='width:98%;'>
				<div class='wst-tab-item'>
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="6" class="wst-form">
									订单号：<input type="text" id="orderNo_0" style='width:120px;'/>
									收货人：<input type="text" id="userName_0" style='width:120px;'/>
									收货地址：<input type="text" id="userAddress_0" style='width:120px;'/>
									<button class='wst-btn-query' onclick="queryOrderPager(0,0)">查询</button>
									</th>
								</tr>
								<tr>
									<th width='100'>订单信息</th>
									<th width='100'>收货人</th>
									<th width='*'>收货地址</th>
									<th width='70'>订单金额</th>
									<th width='130'>下单时间</th>
									<th width='100'>操作</th>
								</tr>
							</thead>
							<tbody id="otbody0">
							</tbody>
							<tfoot>
								<tr>
									<td colspan='8' align='center' id="opage_0">
										<div class="wst-page" style="float:right;padding-bottom:10px;">
											<div class="wst-page-items pager_0">
												
											</div>
										</div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
				
				<div class='wst-tab-item'>
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="6" class="wst-form">
									订单号：<input type="text" id="orderNo_1" style='width:120px;'/>
									收货人：<input type="text" id="userName_1" style='width:120px;'/>
									收货地址：<input type="text" id="userAddress_1" style='width:120px;'/>
									<button class='wst-btn-query' onclick="queryOrderPager(1,0)">查询</button>
									</th>
								</tr>
								<tr>
									<th width='100'>订单信息</th>
									<th width='100'>收货人</th>
									<th width='*'>收货地址</th>
									<th width='70'>订单金额</th>
									<th width='130'>下单时间</th>
									<th width='100'>操作</th>
								</tr>
							</thead>
							<tbody id="otbody1">
							</tbody>
							<tfoot>
								<tr>
									<td colspan='8' align='center' id="opage_1">
										<div class="wst-page" style="float:right;padding-bottom:10px;">
											<div class="wst-page-items pager_1">
												
											</div>
										</div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
				
				<div class='wst-tab-item'>
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="6" class="wst-form">
									订单号：<input type="text" id="orderNo_2" style='width:120px;'/>
									收货人：<input type="text" id="userName_2" style='width:120px;'/>
									收货地址：<input type="text" id="userAddress_2" style='width:120px;'/>
									<button class='wst-btn-query' onclick="queryOrderPager(2,0)">查询</button>
									</th>
								</tr>
								<tr>
									<th width='100'>订单信息</th>
									<th width='100'>收货人</th>
									<th width='*'>收货地址</th>
									<th width='70'>订单金额</th>
									<th width='130'>下单时间</th>
									<th width='100'>操作</th>
								</tr>
							</thead>
							<tbody id="otbody2">
							</tbody>
							<tfoot>
								<tr>
									<td colspan='8' align='center' id="opage_2">
										<div class="wst-page" style="float:right;padding-bottom:10px;">
											<div class="wst-page-items pager_2">
												
											</div>
										</div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
				
				<div class='wst-tab-item'>
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="6" class="wst-form">
									订单号：<input type="text" id="orderNo_3" style='width:120px;'/>
									收货人：<input type="text" id="userName_3" style='width:120px;'/>
									收货地址：<input type="text" id="userAddress_3" style='width:120px;'/>
									<button class='wst-btn-query' onclick="queryOrderPager(3,0)">查询</button>
									</th>
								</tr>
								<tr>
									<th width='100'>订单信息</th>
									<th width='100'>收货人</th>
									<th width='*'>收货地址</th>
									<th width='70'>订单金额</th>
									<th width='130'>下单时间</th>
									<th width='100'>操作</th>
								</tr>
							</thead>
							<tbody id="otbody3">
							</tbody>
							<tfoot>
								<tr>
									<td colspan='8' align='center' id="opage_3">
										<div class="wst-page" style="float:right;padding-bottom:10px;">
											<div class="wst-page-items pager_3">
												
											</div>
										</div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
				
				<div class='wst-tab-item'>
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="6" class="wst-form">
									订单号：<input type="text" id="orderNo_4" style='width:120px;'/>
									收货人：<input type="text" id="userName_4" style='width:120px;'/>
									收货地址：<input type="text" id="userAddress_4" style='width:120px;'/>
									<button class='wst-btn-query' onclick="queryOrderPager(4,0)">查询</button>
									</th>
								</tr>
								<tr>
									<th width='100'>订单信息</th>
									<th width='100'>收货人</th>
									<th width='*'>收货地址</th>
									<th width='70'>订单金额</th>
									<th width='130'>下单时间</th>
									<th width='100'>操作</th>
								</tr>
							</thead>
							<tbody id="otbody4">
							<tr><td>aaaaa</td></tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan='8' align='center' id="opage_4">
										<div class="wst-page" style="float:right;padding-bottom:10px;">
											<div class="wst-page-items pager_4">
												
											</div>
										</div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
				
				<div class='wst-tab-item'>
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="6" class="wst-form">
									订单号：<input type="text" id="orderNo_5" style='width:120px;'/>
									收货人：<input type="text" id="userName_5" style='width:120px;'/>
									收货地址：<input type="text" id="userAddress_5" style='width:120px;'/>
									<button class='wst-btn-query' onclick="orderPager(5,0)">查询</button>
									</th>
								</tr>
								<tr>
									<th width='100'>订单信息</th>
									<th width='100'>收货人</th>
									<th width='*'>收货地址</th>
									<th width='70'>订单金额</th>
									<th width='130'>下单时间</th>
									<th width='100'>操作</th>
								</tr>
							</thead>
							<tbody id="otbody5">
							</tbody>
							<tfoot>
								<tr>
									<td colspan='8' align='center' id="opage_5">
										<div class="wst-page" style="float:right;padding-bottom:10px;">
											<div class="wst-page-items pager_5">
												
											</div>
										</div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
				
				<div class='wst-tab-item'>
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="6" class="wst-form">
									订单号：<input type="text" id="orderNo_4" style='width:120px;'/>
									收货人：<input type="text" id="userName_4" style='width:120px;'/>
									收货地址：<input type="text" id="userAddress_4" style='width:120px;'/>
									<button class='wst-btn-query' onclick="queryOrderPager(6,0)">查询</button>
									</th>
								</tr>
								<tr>
									<th width='100'>订单信息</th>
									<th width='100'>收货人</th>
									<th width='*'>收货地址</th>
									<th width='70'>订单金额</th>
									<th width='130'>下单时间</th>
									<th width='100'>操作</th>
								</tr>
							</thead>
							<tbody id="otbody6">
							<tr><td></td></tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan='8' align='center' id="opage_6">
										<div class="wst-page" style="float:right;padding-bottom:10px;">
											<div class="wst-page-items pager_6">
												
											</div>
										</div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
			</div>
			</div>
		</div>
		<div style='clear:both;'></div>
	</div>

            </div>
          </div>
          <div style='clear:both;'></div>
          <br/>
          <!-- <div class='wst-footer'>
          	<div class="wst-footer-fl-box">
	<div class="wst-footer" >
		<div class="wst-footer-cld-box">
			<div class="wst-footer-fl">友情链接：</div>
			<div style="padding-left:30px;">
				<?php if(is_array($friendLikds)): $k = 0; $__LIST__ = $friendLikds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div style="float:left;"><a href="<?php echo ($vo["friendlinkUrl"]); ?>" target="_blank"><?php echo ($vo["friendlinkName"]); ?></a>&nbsp;&nbsp;</div><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="wst-clear"></div>
			</div>
		</div>
	</div>
</div>

<div class="wst-footer-hp-box">
	<div class="wst-footer">
		<div class="wst-footer-hp-ck1">
			<?php if(is_array($helps)): $k1 = 0; $__LIST__ = $helps;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><div class="wst-footer-wz-ca">
				<div class="wst-footer-wz-pt">
				    <img src="/Apps/Home/View/default/images/a<?php echo ($k1); ?>.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-pn"><?php echo ($vo1["catName"]); ?></span>
					<div style='margin-left:30px;'>
						<?php if(is_array($vo1['articlecats'])): $k2 = 0; $__LIST__ = $vo1['articlecats'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><a href="/index.php/Home/Articles/index/?articleId=<?php echo ($vo2['articleId']); ?>"><?php echo ($vo2['articleTitle']); ?></a><br/><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
			
			<div class="wst-footer-wz-clt">
				<div style="padding-top:5px;line-height:25px;">
				    <img src="/Apps/Home/View/default/images/a6.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-kf">联系客服</span>
					<div style='margin-left:30px;'>
						<a href="#">订购热线</a><br/>
						<span class="wst-footer-pno">社区电话!</span><br/>
						<a href="#">在线客服</a><br/>
						<a href="#" class="wst-footer-wz-ent">点击这里进入</a><br/>
					</div>
				</div>
			</div>
			<div class="wst-clear"></div>
		</div>
	    
		
	    
	</div>
</div>

          </div> -->
        </div>
    </body>
      	<script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
     	<script src="/Public/js/common.js"></script>
      	<script src="/Apps/Home/View/default/js/shopcom.js"></script>
      	<script src="/Apps/Home/View/default/js/head.js"></script>
      	<script src="/Apps/Home/View/default/js/common.js"></script>
      	<script src="/Public/plugins/layer/layer.min.js"></script>
      	<script src="/Apps/Home/View/default/js/jquery.page.js" type="text/javascript"></script>
</html>
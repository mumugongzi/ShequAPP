
$(function() {
	$(".wst-shop-address").click(function(){
		getShopByCommunitys(this);
	});
	$(".wst-shop-address").eq(0).click();
});

function getShopByCommunitys(obj){
	$(".wst-shop-address").removeClass("liselected");
	$(obj).addClass("liselected");
	var communityId = $(obj).attr("data");
	var shopName = $.trim($("#shopName").val());
	var deliveryStartMoney = $("#deliveryStartMoney").val();
	var deliveryMoney = $("#deliveryMoney").val();
	var shopAtive = $("#shopAtive").val();
	var searchType = $("#wst-search-type").val();
	var keyWords = "";
	if(searchType==2){
		keyWords = $.trim($("#keyword").val());
	}
	$.post(domainURL +"/index.php/Home/Shops/getShopByCommunitys/" ,{"communityId":communityId,"shopName":shopName,"deliveryStartMoney":deliveryStartMoney,"deliveryMoney":deliveryMoney,"shopAtive":shopAtive,"keyWords":keyWords},function(data) {		
		var json = WST.toJson(data);
		$(".wst-shop-list").empty();
		var html = new Array();
		for(var i=0;i<json.length;i++){
			var shop = json[i];
			html.push('<div class="wst-shop-box">');
				html.push('<div style="width:80px;height:80px; float:left;"><a href="'+domainURL +'/index.php/Home/Shops/toShopHome/?shopId='+shop.shopId+'"><img data-original="'+domainURL +"/"+shop.shopImg+'" width="80" height="80" title="'+shop.shopName+'"/></a></div>');
				html.push('<div class="wst-shop-streets-items">');
				html.push('<div style="font-weight:bolder;"><a href="'+domainURL +'/index.php/Home/Shops/toShopHome/?shopId='+shop.shopId+'">'+shop.shopName+'</a></div>');
				html.push('<div style="">店铺地址：'+shop.shopAddress+'</div>');
				html.push('<div style="">'+shop.deliveryStartMoney+'元起送，配送费'+shop.deliveryMoney+'元，'+shop.deliveryFreeMoney+'元起免配送费</div>');
				html.push('<div class="wst-shop-streets-items-status"><img src="'+domainURL +'/Apps/Home/View/default/images/icon_menu_01.png" style="vertical-align:middle"/>&nbsp;&nbsp;'+(shop.shopAtive==1?"营业中":"休息中")+'</div>');
				html.push('</div>');
				html.push('<div class="wst-clear"></div>');
			html.push('</div>');
		}
		$(".wst-shop-list").html(html.join(""));
		$(".wst-shop-list img").lazyload({effect: "fadeIn",failurelimit : 1000,threshold: 200,placeholder:domainURL +'/Apps/Home/View/default/images/store_default_signlist.png'});
	});
}

function getDistrictsShops(){
	var areaId3 = $("#cityId").val();
	var shopName = $.trim($("#shopName").val());
	var deliveryStartMoney = $("#deliveryStartMoney").val();
	var deliveryMoney = $("#deliveryMoney").val();
	var shopAtive = $("#shopAtive").val();
	var searchType = $("#wst-search-type").val();
	var keyWords = "";
	if(searchType==2){
		keyWords = $.trim($("#keyword").val());
	}
	$.post(domainURL +"/index.php/Home/Shops/getDistrictsShops/" ,{"areaId3":areaId3,"shopName":shopName,"deliveryStartMoney":deliveryStartMoney,"deliveryMoney":deliveryMoney,"shopAtive":shopAtive,"keyWords":keyWords},function(data) {		
		var json = WST.toJson(data);
		$(".wst-shop-list").empty();
		var html = new Array();
		var cnt = 0;
		for(var i=0;i<json.length;i++){
			var districts = json[i];
			var ctlist = districts.ctlist;
			for(var k=0;k<ctlist.length;k++){
				var community = ctlist[k];
				html.push('<li class="wst-shop-address" data="'+community.communityId+'" onclick="getShopByCommunitys(this);">');
					html.push('<div style="padding:4px;">'+community.communityName+'</div>');
					html.push('<div style="padding:4px;">附近共有 <span style="font-weight:bold;color:red;">'+community.spcnt+'</span> 家店铺入驻并提供服务</div>');
				html.push('</li>');
				cnt++;
			}
		}
		if(json.length==0){
			html.push('<div style="font-size:15px;text-align:center;padding-top:80%;">没有相关店铺信息</div>');
		}
		$("#spcnt").html(cnt);
		$(".wst-shop-address-box").html(html.join(""));
		if(html.length>0){
			$(".wst-shop-address").eq(0).click();
		}
	});
	
}


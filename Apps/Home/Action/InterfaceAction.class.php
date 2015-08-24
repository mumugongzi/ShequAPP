<?php 
namespace Home\Action;
use Home\Action\BaseAction;
/**
  * ============================================================================
  * 接口控制器
 * ============================================================================
 */
class InterfaceAction extends BaseAction{



/*
*用户登陆验证
*/
	public function UserLongin(){

		$userAccount = I('userAccount');
		$loginName = $userAccount;
		$password = I('password');
		//dump($userAccount);
		//dump($password);
		//$m = M('users'); 
		
		if (empty($loginName)) {
			return '';
		} elseif (empty($password)) {
			return '';
		} else{
			
							
			$m = M('users');
			$rs = $m->where('loginName LIKE '.'"'.$loginName.'"')->find();
			//dump($rs['loginName']);
			//dump($rs['loginSecret']);
			//dump($rs['loginPwd']);
			//dump(md5($password.$rs['loginSecret']));
			
			$flag = 0;
			if ($rs['loginPwd']==md5($password.$rs['loginSecret'])) {
				$flag = 1;
			} else {
				//return '';
				}
			
		}
		
		if($flag == 1) {	
			$userInfo = array();		
			$userInfo['userId'] = $rs['userId'];
			$userInfo['userAccount'] = $rs['loginName'];
			
			return $this->json(100, '成功', $userInfo,"userInfo");
		}else{
			$user = 'loginName or loginPWD error';
			return $this->json(400, '失败');
		}

	}



/*
*用户注册接口
*/
	public function UserRegister(){

		$loginName = I('userAccount');
		$password = I('password');
		$verificationCode = I('verificationCode');
		$userPhone = session('findPass.userPhone');
		$vcode = session('findPass.phoneVerify');
		$sessions = session('findPass');
		file_put_contents("sessions.txt",$sessions);
		file_put_contents("sessionvcode.txt",json_encode($vcode) );
		file_put_contents("vcode.txt",json_encode($verificationCode) );
		//$userPhone = isset($_POST('userPhone'))?$_POST('userPhone'):session('findPass.userPhone');
		//$m = M('users'); 
		/* dump($loginName);
		dump($password);
		dump($verificationCode);
		dump(session('findPass.phoneVerify')); */
		
		$m = M('users');
    	$rd = array('status'=>-1);	
		if (session('findPass.phoneVerify') == $verificationCode ) {
			$rd['status'] = 0;
		}else{
			$rd['status'] = 2;	
		}
		
		//检测账号是否存在
		$md = D('Users');
        $crs = $md->checkLoginKey($loginName);
        if($crs['status']!=1){
	    	$rd['status'] = 3;   //账号名已存在
			//dump($crs['status']);
	    	
	    }else{
			$rd['status'] = 0;
			$data = array();
			$data['loginName'] = I('userAccount');
			$data['loginPwd'] = I("password");
			$loginName = $data['loginName'];
			$data["loginSecret"] = rand(1000,9999);
			
			$data['loginPwd'] = md5(I('password').$data['loginSecret']);
			
			$data['userType'] = 0;
			$data['userName'] = I('userName');
			$data['userQQ'] = I('userQQ');
			$data['userPhone'] = $userPhone;
			$data['userScore'] = I('userScore');
			$data['userEmail'] = I("userEmail");
			$data['createTime'] = date('Y-m-d H:i:s');
			$data['userFlag'] = 1;
		}
	    
		if($rd['status'] == 0){
			$rs = $m->add($data);
			if(false !== $rs){
			$rd['status'] = 1;
			$info['userId']= $rs;
			$info['userAccount'] = I('userAccount');
			$info['password'] = I("password");			
			} 
		}
	       
	    switch ($rd['status']) {
    		case 1:#注册成功
    			return $this->json(100, '注册成功',$info,"registerUserInfo");
    			break;
    		case 2:#验证码错误
    			return $this->json(200, '验证码错误');
    			break;
    		case 3:#用户已注册
    			return $this->json(401, '用户已注册');
    			break;
    		default:
    			return $this->json(400, '注册失败');
    			break;
    	}  	

	}

	/*
	*找回密码接口
	*/
	public function UserFindPasswd(){

		$loginName = I('userAccount');
		$password = I('password');
		$verificationCode = I('verificationCode');
		$userPhone = session('findPass.userPhone');
		$vcode = session('findPass.phoneVerify');
		$sessions = session('findPass');
			
		$m = M('users');
    	$rd = array('status'=>-1);	
		if (session('findPass.phoneVerify') == $verificationCode ) {
			$rd['status'] = 0;
		}else{
			$rd['status'] = 2;	
		}
		
		//检测账号是否存在
		$md = D('Users');
        $crs = $md->checkLoginKey($loginName);
        if($crs['status']==1){
	    	$rd['status'] = 3;   //账号名不存在
			//dump($crs['status']);
	    	
	    }else{
			$rd['status'] = 0;
			$data = array();
			//$data['loginName'] = I('userAccount');
			$data['loginPwd'] = I("password");
			$loginName = $data['loginName'];
			$data["loginSecret"] = rand(1000,9999);
			
			$data['loginPwd'] = md5(I('password').$data['loginSecret']);
			
		}
	    
		if($rd['status'] == 0){
			$rs = $m->where('loginName='.$loginName)->setField($data);
			if(false !== $rs){
			$rd['status'] = 1;
			$info['userId']= $rs;
			$info['userAccount'] = I('userAccount');
			$info['password'] = I("password");			
			} 
		}
	       
	    switch ($rd['status']) {
    		case 1:#密码重置成功
    			return $this->json(100, '注册成功',$info,"findpasswdUserInfo");
    			break;
    		case 2:#验证码错误
    			return $this->json(200, '验证码错误');
    			break;
    		case 3:#用户不存在
    			return $this->json(401, '用户不存在');
    			break;
    		default:
    			return $this->json(400, '注册失败');
    			break;
    	}  	

	}

/*
*获取订单列表
*/
	public function getOrdersList(){

		$page = I('pageNo');			
		$userId = I('userId');
		//echo '1';
		if(empty($page)){
			return "";
		}elseif (empty($userId)) {
			return "";
		}
		
		$pageSize = isset($_POST['pageSize']) ? $_POST['pageSize'] : 10;	
		
		$m = M('orders');						
		$orders = array();
		/*$morder = D('Orders');
		$orde=$morder->getOrdersList($userId);
		dump($orde);*/
		$orders=$m->where('userId='.$userId)->order('createTime desc')->Page($page,$pageSize)->select();
		//echo 'orders';
		//dump($orders);									
		$ordersList = array();
		
		if($orders){
			for($i=0;$i<count($orders);$i++){
				if($orders[$i]){

					$ordersList[$i]['order_id']=$orders[$i]['orderId'];
					$ordersList[$i]['order_No']=$orders[$i]['orderNo'];
					$ordersList[$i]['order_state']=$orders[$i]['orderStatus'];
					$ordersList[$i]['order_time_start']=$orders[$i]['createTime'];
					$ordersList[$i]['order_time_end']=($orders[$i]['orderStatus']==5)?$orders[$i]['requireTime']:'未结束';
					$ordersList[$i]['order_total_price']=$orders[$i]['totalMoney'];//未包括配送费
					$shopId=$orders[$i]['shopId'];
					
					$mshops = M('shops');
					$shops = $mshops->where('shopId='.$shopId)->select();					
					//dump($shops[0]['shopName']);
					//$ordersList[$i]['shop_id']=$orders[$i]['shopId'];	
					$ordersList[$i]['shop_imgLink']='http://101.200.190.57/'.$shops[0]['shopImg'];
					$ordersList[$i]['shop_name']=$shops[0]['shopName'];
					//$ordersList[$i]['shop_coupon_cost']=isset($shops[0]['shopCoupon'])?$shops[0]['shopCoupon']:0.00;
					//$ordersList[$i]['shop_lunchbox_cost']=$shops[0]['lunchboxCharge'];
					//$ordersList[$i]['shop_delivery_cost']=$orders[$i]['deliverMoney'];

					
					/*$mgoods = D('Functions');
					$ordergoods = $mgoods->getOrdersGoods($orders[$i]['orderId']);
					
					
					for($j=0;$j<count($ordergoods);$j++){
						if($ordergoods[$j]){
							//echo 'ordergoods[j]';
							//dump($ordergoods[$j]);
							//$orders = array();
							$ordersList[$i]['shop_order_goodsList'][$j]['goods_id']=$ordergoods[$j]['goodsId'];
							$ordersList[$i]['shop_order_goodsList'][$j]['goods_month_sales']=isset($shops[0]['goodssales'])?$shops[0]['goodssales']:10;
							$ordersList[$i]['shop_order_goodsList'][$j]['goods_imgLink']=$ordergoods[$j]['goodsImg'];
							$ordersList[$i]['shop_order_goodsList'][$j]['goods_name']=$ordergoods[$j]['goodsName'];
							$ordersList[$i]['shop_order_goodsList'][$j]['goods_price']=$ordergoods[$j]['goodsPrice'];
							$ordersList[$i]['shop_order_goodsList'][$j]['goods_quantity']=$ordergoods[$j]['goodsNums'];
							
							}
					}*/
				}
			}
			file_put_contents("ordersList.txt",json_encode($ordersList) );
			return $this->json(100, '成功',$ordersList,"ordersList");
		}else{
			
			file_put_contents("ordersList.txt",json_encode($ordersList) );
			return $this->json(100, '成功,无数据',$ordersList,"ordersList");
		}	
	}

/*
*获取订单详情
*/
	public function getOrdersDetail(){

					
		$orderId = I('order_id');
		//echo '1';
		if(empty($orderId)){
			return "";
		}
		
		
		
		$m = M('orders');						
		$orders = array();
		/*$morder = D('Orders');
		$orde=$morder->getOrdersList($userId);
		dump($orde);*/
		$orders=$m->where('orderId='.$orderId)->select();
		//echo 'orders';
		//dump($orders);									
		
		
		if($orders[0]){
			

					$ordersDetail['order_id']=$orders[0]['orderId'];
					$ordersDetail['order_No']=$orders[0]['orderNo'];
					$ordersDetail['order_state']=$orders[0]['orderStatus'];
					$ordersDetail['order_time_start']=$orders[0]['createTime'];
					$ordersDetail['order_time_end']=($orders[0]['orderStatus']==5)?$orders[0]['requireTime']:'未结束';
					$ordersDetail['order_total_price']=$orders[0]['totalMoney'];//未包括配送费
					$shopId=$orders[0]['shopId'];
					
					$mshops = M('shops');
					$shops = $mshops->where('shopId='.$shopId)->select();					
					//dump($shops[0]['shopName']);
					$ordersDetail['shop_id']=$orders[0]['shopId'];	
					$ordersDetail['shop_imgLink']='http://101.200.190.57/'.$shops[0]['shopImg'];
					$ordersDetail['shop_name']=$shops[0]['shopName'];
					$ordersDetail['shop_coupon_cost']=isset($shops[0]['shopCoupon'])?$shops[0]['shopCoupon']:0.00;
					$ordersDetail['shop_lunchbox_cost']=$shops[0]['lunchboxCharge'];
					$ordersDetail['shop_delivery_cost']=$orders[0]['deliverMoney'];

					
					$mgoods = D('Functions');
					
					$ordergoods = $mgoods->getOrdersGoods($orders[0]['orderId']);
					//dump($ordergoods);
					
					for($j=0;$j<count($ordergoods);$j++){
						if($ordergoods[$j]){
							//echo 'ordergoods[j]';
							//dump($ordergoods[$j]);
							//$orders = array();
							$ordersDetail['shop_order_goodsList'][$j]['goods_id']=$ordergoods[$j]['goodsId'];
							$ordersDetail['shop_order_goodsList'][$j]['goods_month_sales']=isset($shops[0]['goodssales'])?$shops[0]['goodssales']:10;
							$ordersDetail['shop_order_goodsList'][$j]['goods_imgLink']=$ordergoods[$j]['goodsImg'];
							$ordersDetail['shop_order_goodsList'][$j]['goods_name']=$ordergoods[$j]['goodsName'];
							$ordersDetail['shop_order_goodsList'][$j]['goods_price']=$ordergoods[$j]['goodsPrice'];
							$ordersDetail['shop_order_goodsList'][$j]['goods_quantity']=$ordergoods[$j]['goodsNums'];
							
							}
					}
				
			
			
			return $this->json(100, '成功',$ordersDetail,"ordersDetail");
		}else{
			return $this->json(400, '服务器异常', $ordersDetail,"ordersDetail");
		}	
	}

	/**
	* 统计店铺信息
	*/
	public function getShopDetails($shopId){
		
		$data['shop']['shopId'] = $shopId;
		$spm = D('Home/Shops');
		$obj["shopId"] = $shopId;
		//$obj["shopId"] = I('shopId');
		//dump($obj["shopId"]);
		$details = $spm->getShopDetails($obj);
		$data['details'] = $details;
		//dump($data);
		return $data;
	}	
	
	

/**
 * 获取商铺列表
 */	
	public function getShopList(){
		
		//dump($_POST);
		$page = I('pageNo');		
		$type = I('type');  //  type = 1 今日推荐
							//  type = 2 大家在吃
							//  type = 3 经常吃的
		$category = I('category');


		$lng = I('address_longitude');
		$lat = I('address_latitude');
		//echo "lng=".$lng;
		//echo ""
		$map=array();	//数据库查询条件
		if((!empty($lng))&&(!empty($lat))){
			$lbs = D('Location');
			$shopsId=$lbs->getNearbyShop($lng,$lat,4);
			//dump($shopsId);
			$map['shopId']=array('in',$shopsId);
		}
		
		
		if(empty($page)){
			return "";
		}
		//$page = isset($_POST['pageNo']) ? $_POST['pageNo'] : 1;
		$pageSize = isset($_POST['pageSize']) ? $_POST['pageSize'] : 10;	
		
		$m = M('shops');						
		$shops = array();
		
		if($type){
			if($type == 'today_recommended'){
				$typestr = 'isAdminRecom';
			}elseif($type == 'everyone_eating'){
				$typestr = 'isAdminBest';
			}elseif ($type == 'recently_eaten') {
				$typestr = 'shopStatus';
			}else{
				return '';
				//$typestr = 'shopStatus';
			}
			
			$map[$typestr]=array('eq',1);
			//dump($map);
			$shops=$m->where($map)->Page($page,$pageSize)->select();
			
		}elseif($category){	
			//$category = isset($_POST['category']) ? $_POST['category'] : 1;
							//  category = 0 品牌店铺
							//  category = 1 中式正餐
							//  category = 2 地方美食
							//  category = 3 中式快餐
							//  category = 4 西式快餐
			
			switch ($category)
				{
				case 'chinese_dinner':
				  $str = "goodsCatId1=100";
				  break;
				case 'local_delicacies':
				  $str = "goodsCatId1=200";
				  break;
				case 'chinese_fast_food':
				  $str = "goodsCatId1=300";
				  break;
				case 'western_fast_food':
				  $str = "goodsCatId1=400";
				  break;
				default:
				  $str = "";
					//return '';
				}	
			if(!empty($str))			
				$map['goodsCatId1']=array('eq',$str);			
			$shops=$m->where($map)->Page($page,$pageSize)->select();				
			
		}elseif($category == 'brand_shop'){
			//$str = "2";	
			//echo "haha";
			if(empty($map)){
				return "没有提供经纬度";
			}
			$shops=$m->where($map)->Page($page,$pageSize)->select();	
		}else{
			return "缺少参数";
		}			
		
				//  $shop_name;  	//店铺名称
				//  $shop_id; 		//店铺Id
				//  $shop_address;   //店铺地址
				//  $shop_imgLink;	//店铺图标地址
				//  $shop_state;  	//店铺营业状态       如：休息不接受预定   休息接受预定 营业中
				//  $shop_start_time;	//店铺营业开始时间
				//  $shop_end_time;		//店铺营业结束时间
				//  $shop_month_sales;  //店铺月销售总数量  为每个产品月销量的总和
				//  $shop_star_level;	//店铺图标星级
				//  $shop_delivery_cast;	//店铺配送费用
				//  $shop_delivery_time;	//店铺配送开始时间
				//  $shop_delivery_cost_time;	//店铺配送花费时间
				//  $shop_coupon;		//店铺的优惠劵
				//  $shop_promotions; 	//店铺促销活动		
		
		
		if($shops){
			for($i=0;$i<count($shops);$i++){
				if($shops[$i]){
					
					$shopsList[$i]['shop_name']=$shops[$i]['shopName'];
					$shopsList[$i]['shop_id']=$shops[$i]['shopId'];
					$shopsList[$i]['shop_address']=$shops[$i]['shopAddress'];
					$shopsList[$i]['shop_imgLink']='http://101.200.190.57/'.$shops[$i]['shopImg'];
					$shopsList[$i]['shop_state']=$shops[$i]['shopStatus'];
					$shopsList[$i]['shop_delivery_self']=$shops[$i]['isSelf'];
					$shopsList[$i]['shop_start_time']=$shops[$i]['serviceStartTime'];
					$shopsList[$i]['shop_end_time']=$shops[$i]['serviceEndTime'];
					$shopId = $shops[$i]['shopId'];
					$shopStatistics = $this->getShopDetails($shopId);
					
					//file_put_contents("shopid.txt",json_encode($shops[$i]['shopId']) );
					file_put_contents("shopStatistics.txt",$ordersList );
					$shopsList[$i]['shop_month_sales']=$shopStatistics['details']['monthOrderCnt'];
					$shopsList[$i]['shop_star_level']=$shops[$i]['shopScore'];
					$shopsList[$i]['shop_delivery_cost_start']=$shops[$i]['deliveryStartMoney'];
					$shopsList[$i]['shop_delivery_time']=$shops[$i]['deliveryCostTime'];
					$shopsList[$i]['shop_delivery_start_time']=$shops[$i]['deliveryStartTime'];
					$shopsList[$i]['shop_delivery_end_time']=$shops[$i]['deliveryEndTime'];
					$shopsList[$i]['shop_coupon']=isset($shops[$i]['shopCoupon'])?$shops[$i]['shopCoupon']:"满20减8";
					$shopsList[$i]['shop_promotions']=isset($shops[$i]['shopPromotions'])?$shops[$i]['shopPromotions']:"满10减3";
					$shopsList[$i]['shop_lunchbox_cost']=$shops[$i]['lunchboxCharge'];
					$shopsList[$i]['shop_invoice']=$shops[$i]['isInvoice'];
					$shopsList[$i]['shop_delivery_cost']=$shops[$i]['deliveryMoney'];
					$shopsList[$i]['shop_delivery_freecost']=$shops[$i]['deliveryFreeMoney'];
					
				}else{
					//return '';
				}
				
			}
			
			return $this->json(100, '成功',$shopsList,"shopList");
		}else{
			$shopsList = array();
			return $this->json(100, '没有数据', $shopsList,"shopList");
		}						
	}
	
	
/**
 * 获取用户信息
 */		
	public function getUserInfo(){
		
		//$userId = isset($_POST['userId'])?$_POST['userId']:0;
		//$sessionId = isset($_POST['sessionId'])?$_POST['sessionId']:0;
		$userId = I('userId',2);
		//$sessionId = I('post.sessionId');
		
		$m = M('users');
		$user = $m->where("userId=".$userId)->find();
		//dump($user);
		if($user) {
			
			$userInfo = array();
			//$userInfo['sessionId']=$sessionId;
			$userInfo['userId']=$userId;
			//$userInfo['nickName']=isset($user['userName'])?$user['userName']:"萌萌";
			//$userInfo['isNick ']=isset($user['userName '])? "0":"1";
			//$userInfo['userAvatarUrl']="http://101.200.190.57/".$user['userPhoto'];
			$userInfo['userAccount']=$user['loginName'];
			//$userInfo['userSex']=$user['userSex'];
			$userInfo['userSorce']=$user["userScore"];
			
			return $this->json(100, '成功', $userInfo,"userInfo");
		}else{
			return $this->json(400, '服务器异常', $user,"userInfo");
		}
		
	}

/**
 * 获取首页广告
 */		
	public function homeAds(){
		$m = M('ads');
		//$adNum=5;
		$adSort=isset($_POST['adSort'])?$_POST['adSort']:5;
		//$ads=$m->where("adPositionId=-1")->limit($adSort)->select();
		$ads=$m->where('adPositionId=-1')->order('adSort asc')->select();
		$adsInfo=Array();
		if($ads){
			for($i=0;$i<$adSort;$i++){
				if($ads[$i]){
				$adsInfo[$i]['imgSrc']="http://101.200.190.57/".$ads[$i]['adFile'];
				$adsInfo[$i]['tagTxt']=$ads[$i]['adPositionId'];
				$adsInfo[$i]['title']=$ads[$i]['adName'];
				$adsInfo[$i]['imgLink']=$ads[$i]['adUrl'];
				}else{
					//return '';
				}
			}
			return $this->json(100, '成功',$adsInfo,"homeAdsList");
		}else{
			return $this->json(400, '服务器异常', $adsInfo,"homeAdsList");
		}
	}
	
/**
 * 获取分类列表
 */		
	public function getCategoryList(){
		$shopId=I('shop_id');
		
		$m=M("goods");
		$goods=$m->where("shopId=".$shopId)->select();
		$catList=array();
		if(!empty($goods)){
			//$typeId=0;
			foreach ($goods as $good){
				$m=M("goods_cats");
				$cats=$m->field("catName")->where("catId=".$good["goodsCatId3"])->select();
				if(!in_array($cats[0]['catName'],$catList)){
					$catList[]=$cats[0]['catName'];
					//$typeId++;
				}
				
			}
			//dump($goodsInfo);
			return $this->json(100, '成功',$catList,"categoryList");
		}
		else{

			return $this->json(100, '成功', $catList,"categoryList");
		}
	}


	
/**
 * 获取商品信息
 */		
	public function getGoodsInfo(){
		$shopId=I('shop_id');
		$goodsCat=I('category');
		$m=M("goods");
		$goods=$m->where("shopId=".$shopId)->select();
		
		$goodsInfo=array();
		if(!empty($goods)){
			foreach ($goods as $good){
				$m=M("goods_cats");
				$cats=$m->field("catName")->where("catId=".$good["goodsCatId3"])->select();
				//$good["catName"]=$cats["catName"];
				if(!$this->arrayKeyExist($cats[0]['catName'],$goodsInfo)){ 
					//dump($cats[0]);
					$tmp=array();
					$tmp["category_name"]=$cats[0]['catName'];
					
					$tmp1[]=array();
					$tmp1["goods_name"]=$good["goodsName"];
					$tmp1["goods_id"]=$good["goodsId"];
					$tmp1["goods_price"]=$good["shopPrice"];
					$tmp1["goods_imgLink"]="http://101.200.190.57/".$good["goodsImg"];
					
					$tmp1["goods_month_sales"]=$good["saleCount"];	
					/* if($goodsCat==$cats[0]["catName"]){
						$tmp=array();
						$tmp["goods_name"]=$good["goodsName"];
						$tmp["goods_id"]=$good["goodsId"];
						$tmp["goods_price"]=$good["shopPrice"];
						$tmp["goods_imgLink"]="http://101.200.190.57/".$good["goodsImg"];
						$tmp["goods_month_sales"]=$good["saleCount"];
						$goodsInfo[]=$tmp;
					} */
					
					$tmp['goodsList'][]=$tmp1;
					//dump($tmp);
					$goodsInfo[]=$tmp;
				}
				else{
					//dump($cats[0]);
					foreach ($goodsInfo as $key => $value){
						if($goodsInfo[$key]["category_name"]==$cats[0]['catName']){
							$tmp1[]=array();
							$tmp1["goods_name"]=$good["goodsName"];
							$tmp1["goods_id"]=$good["goodsId"];
							$tmp1["goods_price"]=$good["shopPrice"];
							$tmp1["goods_imgLink"]="http://101.200.190.57/".$good["goodsImg"];
							$tmp1["goods_month_sales"]=$good["saleCount"];
							
							$goodsInfo[$key]["goodsList"][]=$tmp1;
							break;
						}
					}
				}
				
			}
			//dump($goodsInfo);
			return $this->json(100, '成功',$goodsInfo,"goodsCategoryList");
		}
		else{
			return $this->json(100, '成功', $goodsInfo,"goodsCategoryList");
		}
	}

	
/**
 * 获取商品信息
 */		
	public function getGoodsInfos(){
		$shopId=I('shop_id');
		$goodsCat=I('category');
		
		$mgoods = D('Home/Goods');
		//查询商品详情		
		//$obj["goodsId"] = $goodsId;	
		$goods = $mgoods->getGoodDetails($shopId);
		//dump($goods);
		$goodsInfo=array();
		if(!empty($goods)){
			foreach ($goods as $good){
				$m=M("goods_cats");
				$cats=$m->field("catName")->where("catId=".$good["goodsCatId3"])->select();
				//$good["catName"]=$cats["catName"];
				if(!$this->arrayKeyExist($cats[0]['catName'],$goodsInfo)){ 
					//dump($cats[0]);
					$tmp=array();
					$tmp["category_name"]=$cats[0]['catName'];
					
					$tmp1[]=array();
					$tmp1["goods_name"]=$good["goodsName"];
					$tmp1["goods_id"]=$good["goodsId"];
					$tmp1["goods_price"]=$good["shopPrice"];
					$tmp1["goods_imgLink"]="http://101.200.190.57/".$good["goodsImg"];
					$tmp1["goods_month_sales"]=$good["totalnum"];						
					$tmp['goodsList'][]=$tmp1;
					//dump($tmp);
					$goodsInfo[]=$tmp;
				}
				else{
					//dump($cats[0]);
					foreach ($goodsInfo as $key => $value){
						if($goodsInfo[$key]["category_name"]==$cats[0]['catName']){
							$tmp1[]=array();
							$tmp1["goods_name"]=$good["goodsName"];
							$tmp1["goods_id"]=$good["goodsId"];
							$tmp1["goods_price"]=$good["shopPrice"];
							$tmp1["goods_imgLink"]="http://101.200.190.57/".$good["goodsImg"];
							$tmp1["goods_month_sales"]=$good["saleCount"];
							
							$goodsInfo[$key]["goodsList"][]=$tmp1;
							break;
						}
					}
				}
				
			}
			//dump($goodsInfo);
			return $this->json(100, '成功',$goodsInfo,"goodsCategoryList");
		}
		else{
			return $this->json(100, '成功', $goodsInfo,"goodsCategoryList");
		}
	}

		
	
	
	
	private function arrayKeyExist($var,$array){
		foreach ($array as $key => $value){
			if($array[$key]['category_name']===$var)
				return true;
		}
		return false;
	}


	public function test(){
		$handle=fopen("addr.txt", 'r');
		$lbs = D('Location');
		$m = M('addr_test');
		$success_num=0;
		$fail_num=0;
		if($handle){
			while(($addr=fgets($handle))!=false){
				$addr=trim($addr);
				$coordinate=array();
				$coordinate=$lbs->getCoordinate($addr);

				
				if(isset($coordinate["lng"])&&isset($coordinate["lat"])){
					$addr=html_entity_decode($addr);
					$data=array(
							'addr'	=>	$addr,
							'lng'	=>	$coordinate["lng"],
							'lat'	=>	$coordinate["lat"]
						);
					
					$m->add($data);
					$success_num++;
				}else{
					$fail_num++;
					file_put_contents(log, date("[Y-m-d H:i:s]",time()).":".$addr."获取经纬度失败！".PHP_EOL,FILE_APPEND);
					$a=json_encode($coordinate);
					file_put_contents(log, "message:".$a.PHP_EOL,FILE_APPEND);
				}
				//break;
			}
			echo "success_num=".$success_num."<br/>";
			echo "fail_num=".$fail_num."<br/>";
		}
	}

   public function updateShopLngLat(){
   		$d = D('Areas');
   		$lbs = D('Location');
   		$m = M('shops');
   		$addrInfos = $m->field('shopId,areaId1,areaId2,areaId3,shopAddress')->select();
   		dump($addrInfos);
   		foreach ($addrInfos as $key => $value) {
   			$area1=M('areas')->where("areaId=".$value['areaId1'])->select();
   			$area2=M('areas')->where("areaId=".$value['areaId2'])->select();
   			$area3=M('areas')->where("areaId=".$value['areaId3'])->select();
   			$addr=$area1[0]['areaName'].$area2[0]['areaName'].$area3[0]['areaName'].$value['shopAddress'];
   			echo "<br/>".$addr."<br/>";
   			$position=$lbs->getCoordinate($addr);
   			$m->where("shopId=".$value['shopId'])->save($position);

   		}
   }

   public function nearby(){
   		$addr=I('addr');
   		$lbs = D('Location');
   		echo $addr;
   		$coordinate=$lbs->getCoordinate($addr);
   		echo "lng=".$coordinate['lng']."<br/>";
   		echo "lat=".$coordinate['lat']."<br/>";
   		$addr=$lbs->getAddr($coordinate['lng'],$coordinate['lat']);
   		echo "原点：".$addr."<br/>";
   		$shops=$lbs->getNearbyShop($coordinate['lng'],$coordinate['lat'],2.5);
   		// foreach ($shops as $key => $value) {
   		// 	echo $value["shopSn"].":".$value["shopName"].":".$value["shopAddress"]."<br/>";
   		// }
   		dump($shops);
   		echo "<br/><br/><br/><br/>";
   		echo $lbs->getId($coordinate['lng'],$coordinate['lat'],"province");
   		echo $lbs->getId($coordinate['lng'],$coordinate['lat'],"city");
   		echo $lbs->getId($coordinate['lng'],$coordinate['lat'],"district");
   }

   public function upLoadAddressInfo(){
   		$d = D("UserAddress");
   		$result=$d->addAPP();
   		if($result['status']<0){
   			return $this->json(200,"保存收货地址失败");
   		}
   		return $this->getAddressInfoList();
   }

   public function getAddressInfoList(){
   		$d = D("UserAddress");
   		//$result=$d->addAPP();
		//$addrList = array();
		//dump($addrList);
   		$addrList = $d->getUserAddressApp();
		
   		if(isset($addrList)){
   			return $this->json(100,'成功',$addrList, "addressInfoList");
   		}
   		else{
   			return $this->json(200,"获取收货地址失败");
   		}
   }


   public function notification(){
		$a=I('a');
		//echo "HAAHH".$a;
		//die;
		$d = D('Notification');
		$d->sendAndroidUnicast('ticker','title','text');
	}


	public function sendVerificationCode(){
        
		$userPhoneNumber = I('userPhoneNumber');
		//dump($userPhoneNumber);
		$m = D('Functions');
		$arr=$m->send($userPhoneNumber);
		//dump($arr);
		if ($arr == 000000) {
            //如果成功就，这里只是测试样式，可根据自己的需求进行调节
            //echo "短信验证码已发送成功，请注意查收短信";
			//return $this->json(100,"短信验证码已发送成功",$obj["resp"]["templateSMS"]["smsId"],'smsId');
            return $this->json(100,"短信验证码已发送成功");
        }else{
            //如果不成功
            //echo "短信验证码发送失败，请联系客服";    
			return $this->json(400,"短信验证码发送失败");	
        }     
		      
    }



}
?>
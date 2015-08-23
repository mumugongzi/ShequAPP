<?php
namespace Home\Action;
use Home\Action\BaseAction;
class OrdersAppAction extends OrdersAction{
	/**
	 * 订单详情：
	 *		订单：
	 *		商家：shopId（上行）
	 * 		用户: userID (上行)
	 * 		地址: userAddress（上行）
	 * 		联系方式:userPhone（上行）
	 * 		总金额:totalMoney（上行）
	 * 		支付方式:payType（上行）
	 *		订单状态：orderStatus
	 *			1 下单，未接单
	 *			2 接单，未配送
	 *			3 配送，未收货
	 *			4 已收货
	 *      配送方式:deliverType（商家确认）
	 *      下单时间：createTime（后台生成）
	 *      送达时间：requireTime（商家确认）
	 *
	*/
	public function submitOrder(){
		// $data =array(
		// 		'shopId' => I('shopId'),
		// 		'userId' =>	I('userId'),
		// 		'orderStatus' => 1,
		// 		'userAddress' =>	I('userAddress'),
		// 		'userPhone'	=>	I('userPhone'),
		// 		'totalMoney' =>	I('totalMoney'),
		// 		'payType'	=>	I('payType'),
		// 		'createTime'	=>	date('Y-m-d H:i:s')
		// 		'consigneeId'	=>	1,
		// 		'isself'	=>	0,
		// 		'needreceipt'	=> 0,
		// 	);

		$shopId=I('shopId');
		$userId=I('userId');
		$userAddress=I('userAddress');


		$m=M('user_address');
		$userAddressInfo=$m->where("addressId=".$userAddress)->select();
		$userPhone=$userAddressInfo['userPhone'];
		$payway=I('payType');
		$isself=0;		//默认非自取
		$needreceipt=0; //默认不需要发票
		$consigneeId=$userAddress;
		$orderunique=time();
		$remark=I('orderOthers');
		session('WST_USER.userId',$userId);

		$userMenu=I('userMenu');
		//file_put_contents("post.txt", json_encode($_POST));
		// $encode = mb_detect_encoding($userMenu,array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
		// echo $encode;
		// $userMenu = str_replace("'", '"', $userMenu);
		// $userMenu = iconv($encode, 'utf8', $userMenu);
		//$userMenu='{"0":{"goodsId":"2","quantity":"2"}}';
		// $encode = mb_detect_encoding($userMenu,array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
		// echo $encode;
		$catInfo=$this->decodeUserMenu($userMenu);
		//file_put_contents("catInfo.txt", json_encode($catInfo));
		// echo I('userMenu')."HHHH"."<br/>";
		// echo json_last_error();
		//dump($catInfo);
		//将商品添加到购物车
		$cartM=D('Home/Cart');
		foreach ($catInfo as $key => $value) {
			$cartM->addCart($value['goodsId'],$value['quantity']);
		}

		$shopcat = session("WST_CART")?session("WST_CART"):array();	
		//file_put_contents("shopcat.txt", json_encode($shopcat));

		$goodsmodel = D('Home/Goods');
		$morders = D('Home/Orders');
		//dump($shopcat);
		$catgoods = array();	
		$order = array();
		if(empty($order)){
			if(empty($shopcat)){
				return $this->json(200,'您的购物车里暂时还没有商品！！');
			}else{
				//整理及核对购物车数据
				foreach($shopcat as $key=>$cgoods){
					$goods = $goodsmodel->getGoodsSimpInfo($key);
					//核对商品是否符合购买要求
					if($goods['goodsStock']<=0){
						//$this->assign("fail_msg",'对不起，商品'.$goods['goodsName'].'库存不足!');
						//$this->display('default/order_fail');
						//exit();
						return $this->json(300,'商品库存不足！！');
					}
					if($goods['isSale']!=1){
						//$this->assign("fail_msg",'对不起，商品库'.$goods['goodsName'].'已下架!');
						//$this->display('default/order_fail');
						//exit();
						return $this->json(400,'商品已下架');
					}
					$goods["cnt"] = $cgoods["cnt"];
					$totalCnt += $cgoods["cnt"];
					$totalMoney += $goods["cnt"]*$goods["shopPrice"];
					$catgoods[$goods["shopId"]]["shopgoods"][] = $goods;
					$catgoods[$goods["shopId"]]["deliveryFreeMoney"] = $goods["deliveryFreeMoney"];//门店免运费最低金额
					$catgoods[$goods["shopId"]]["deliveryMoney"] = $goods["deliveryMoney"];//门店免运费最低金额
					$catgoods[$goods["shopId"]]["totalCnt"] = $catgoods[$goods["shopId"]]["totalCnt"]+$cgoods["cnt"];
					$catgoods[$goods["shopId"]]["totalMoney"] = $catgoods[$goods["shopId"]]["totalMoney"]+($goods["cnt"]*$goods["shopPrice"]);
					
				}
				foreach($catgoods as $key=> $cshop){
					if($cshop["totalMoney"]<$cshop["deliveryFreeMoney"]){
						if($isself==0){
							/*
							 *这里客户预定的商品可能包含还几家店铺的商品，支付总价包括了每个商家的
							 *派送费
							*/
							$totalMoney = $totalMoney + $cshop["deliveryMoney"];
						}
					}
				}
				
				$ordersInfo = $morders->addOrders($userId,$consigneeId,$payway,$needreceipt,$catgoods,$orderunique,$isself);
				session("WST_CART",null);
				$orderNos = $ordersInfo["orderNos"];
				// $this->assign("torderIds",implode(",",$ordersInfo["orderIds"]));
				// $this->assign("orderInfos",$ordersInfo["orderInfos"]);
				// $this->assign("isMoreOrder",(count($ordersInfo["orderInfos"])>0)?1:0);
				// $this->assign("orderNos",implode(",",$orderNos));
				// $this->assign("totalMoney",$totalMoney);
				// //if($payway==0){
				// 	$this->display('default/order_success');	
				//}else{
					//$this->display('default/paystep1');	
				//}
				//$this->display();
				//file_put_contents("sql.txt", M()->getLastsql());
				$this->json(100,'下单成功');
			}
		}else{
			//$this->display('default/check_order');	
			return $this->json(500,'！！！！！！！！！！！');	
		}		
		
	}
	/*{
	 * ["goodsId":2,"quantity":1];
	 * ["goodsId":3,"quantity":10]
	 *}
	 *
	 *
	 *
	*/
	public function decodeUserMenu($userMenu){
		//$userMenu='[goodsId:2,quantity:1];[goodsId:3,quantity:10]';
		//$userMenu = iconv("ASCII", 'utf-8', $userMenu);
		$userMenu=html_entity_decode($userMenu);
		//$encode = mb_detect_encoding($userMenu,array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
		//echo $encode."<br/>";
		//echo $userMenu;
		$menus=explode(";",$userMenu);
		$menuArr=array();
		foreach ($menus as $key => $value) {
			$value=substr($value, 1,-1);
			$tmp=array();
			$k_v=explode(",", $value);
			//dump($k_v);
			$goodsId=explode(":", $k_v[0]);
			$quantity=explode(":", $k_v[1]);

			//$goodsId[0]=substr($goodsId[0], 1,-1);
			//$quantity[0]=substr($quantity[0], 1,-1);

			$tmp[$goodsId[0]]=$goodsId[1];
			$tmp[$quantity[0]]=$quantity[1];
			$menuArr[]=$tmp;
		}
		//dump($menuArr);
		return $menuArr;
	}
}
?>
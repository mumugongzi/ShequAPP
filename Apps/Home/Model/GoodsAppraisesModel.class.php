<?php
 namespace Home\Model;
/**
 * 商品评价服务类
 */
class GoodsAppraisesModel extends BaseModel {
	 /**
	  * 商品评价分页列表
	  */
     public function queryByPage($shopId){
        $m = M('goods_appraises');
        $shopCatId1 = I('shopCatId1',0);
		$shopCatId2 = I('shopCatId2',0);
		$goodsName = I('goodsName');
        $pcurr = I("pcurr",0);
		$pageSize = 20;
	 	$sql = "select gp.*,g.goodsName,g.goodsThums,u.loginName from 
	 	           __PREFIX__goods_appraises gp ,__PREFIX__goods g, __PREFIX__users u
	 	           where gp.userId=u.userId and gp.goodsId=g.goodsId and gp.shopId=".$shopId."";
		if($shopCatId1>0)$sql.=" and shopCatId1=".$shopCatId1;
		if($shopCatId2>0)$sql.=" and shopCatId2=".$shopCatId2;
		if($goodsName!='')$sql.=" and (goodsName like '%".$goodsName."%' or goodsSn like '%".$goodsName."%')";
		$sql.=" order by id desc";
	 	$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		
		return $pages;
	 }
	 
 	/**
	  * 获取指定商品评价
	  */
     public function getAppraise(){
	 	$m = M('goods_appraises');
	 	$id = I('id');
	 	$sql = "select gp.*,g.goodsName,g.goodsThums from __PREFIX__goods_appraises gp ,__PREFIX__goods g where gp.goodsId=g.goodsId and gp.id=".$id;
		return $this->queryRow($sql);
	 }
	
	  
	 /**
	  * 删除商品评价
	  */
	 public function delAppraise(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods_appraises');
		$rs = $m->delete(I('id'));
		if($rs){
		   $rd['status']= 1;
		}
		return $rd;
	 }
	 
	/**
	  * 修改商品评价
	  */
	 public function editAppraise(){
	 	$id = I('id');
	 	$m = M('goods_appraises');
	
		$data = array();
		
		$data["goodsScore"] = I("goodsScore");
		$data["serviceScore"] = I("serviceScore");
		$data["timeScore"] = I("timeScore");
		$data["content"] = I("content");
		
		$m->where(" id=".$id)->data($data)->save();
		$rd['status']=1;
		return $rd;
	 }
	 /**
	  * 增加商品评论
	  */
	public function addGoodsAppraises($obj){	
		$m = M('goods_appraises');
		$userId = $obj["userId"];
		$orderId = $obj["orderId"];
		//检查订单是否已评论
		$sql="select isAppraises,orderFlag,shopId from __PREFIX__orders where orderId=".$orderId." and userId=".$userId;
		$rs = $this->query($sql);
		if($rs[0]['isAppraises']==1 || $rs[0]['orderFlag']==-1){
			return -1;
		}
		$shopId = $rs[0]['shopId'];
		//新增评价记录
		$data = array();
		$goodsId = I("goodsId");
		$data["goodsId"] = $goodsId;
		$data["shopId"] = $shopId;
		$data["userId"] = $userId;
		$data["goodsScore"] = (int)I("goodsScore");
		$data["timeScore"] = (int)I("timeScore");
		$data["serviceScore"] =(int)I("serviceScore");
		$data["content"] = I("content");
		$data["isShow"] = 1;
		$data["createTime"] = date('Y-m-d H:i:s');
		$data["orderId"] = I("orderId");
		$rs = $m->add($data);
		
		$data["totalScore"] = $data["goodsScore"]+$data["timeScore"]+$data["serviceScore"];
		
		$sql ="SELECT * FROM __PREFIX__goods_scores WHERE goodsId=$goodsId";
		$goodsScores = $this->queryRow($sql);
		
		if($goodsScores["goodsId"]>0){
			$sql = "UPDATE __PREFIX__goods_scores set 
					totalUsers = totalUsers +1 , totalScore = totalScore +".$data["totalScore"]."
					,goodsUsers = goodsUsers +1 , goodsScore = goodsScore +".$data["goodsScore"]."
					,timeUsers = timeUsers +1 , timeScore = timeScore +".$data["timeScore"]."
					,serviceUsers = serviceUsers +1 , serviceScore = serviceScore +".$data["serviceScore"]."
					WHERE goodsId = ".$goodsId;		
			$this->query($sql);		
		}else{
			$data = array();
			$gm = M('goods_scores');

			$data["goodsId"] = I("goodsId");
			$data["shopId"] = I("shopId");
			
			$data["goodsScore"] =(int)I("goodsScore");
			$data["goodsUsers"] = 1;
			
			$data["timeScore"] =(int)I("timeScore");
			$data["timeUsers"] = 1;
			
			$data["serviceScore"] =(int)I("serviceScore");
			$data["serviceUsers"] = 1;
			
			$data["totalScore"] = (int)$data["goodsScore"]+$data["timeScore"]+$data["serviceScore"];
			$data["totalUsers"] = 1;
			
			$rs = $gm->add($data);
		}
		//检查下是不是订单的所有商品都评论完了
		$sql = "SELECT g.goodsId,og.goodsNums as ogoodsNums,og.goodsPrice as ogoodsPrice ,ga.id as gaId
				FROM __PREFIX__order_goods og, __PREFIX__goods g 
				LEFT JOIN __PREFIX__goods_appraises ga ON g.goodsId = ga.goodsId AND ga.orderId = $orderId
				WHERE og.orderId = $orderId AND og.goodsId = g.goodsId";
		$goodslist = $this->query($sql);
		$gmark = 1;
		for($i=0;$i<count($goodslist);$i++){
			$goods = $goodslist[$i];
			if(!$goods["gaId"]) $gmark =0;
		}
		if($gmark==1){
			$sql="update __PREFIX__orders set isAppraises=1 where orderId=".$orderId;
			$this->query($sql);
		}
		
		return 1;
	}
	/**
	 * 获取待评价订单
	 */
	public function getOrderAppraises($obj){
		$userId = $obj["userId"];
		$orderId = $obj["orderId"];
		$data = array();
		
		$sql = "SELECT o.*,sp.shopId,sp.shopName FROM __PREFIX__orders o,__PREFIX__shops sp WHERE o.shopId=sp.shopId AND o.orderId = $orderId ";		
		$order = $this->queryRow($sql);
		$data["order"] = $order;
		
		$sql = "SELECT g.*,og.goodsNums as ogoodsNums,og.goodsPrice as ogoodsPrice ,ga.id as gaId
				FROM __PREFIX__order_goods og, __PREFIX__goods g 
				LEFT JOIN __PREFIX__goods_appraises ga ON g.goodsId = ga.goodsId AND ga.orderId = $orderId
				WHERE og.orderId = $orderId AND og.goodsId = g.goodsId";
		$goods = $this->query($sql);
		$data["goodsList"] = $goods;
		
		$sql = "SELECT * FROM __PREFIX__shop_appraises WHERE orderId = $orderId ";	
		$appraises = $this->query($sql);
		$data["shopAppraises"] = $appraises;
		
		return $data;
	}
	/**
	 * 获取商品评价列表
	 */
	public function getAppraisesList($obj){
		$userId = $obj["userId"];
		$pcurr = I("pcurr",0);
		$pageSize = 20;
		$data = array();

		$sql = "SELECT ga.*,o.orderNo,g.goodsName,g.goodsThums
				FROM __PREFIX__goods_appraises ga, __PREFIX__goods g, __PREFIX__orders o 
				WHERE ga.userId=$userId AND ga.goodsId = g.goodsId AND ga.orderId = o.orderId
				ORDER BY ga.createTime DESC";
		$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		return $pages;
	}
};
?>
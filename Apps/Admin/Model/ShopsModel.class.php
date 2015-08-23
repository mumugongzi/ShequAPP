<?php
 namespace Admin\Model;
/**
  * ============================================================================
 * 店铺服务类
 * ============================================================================
 */
use Think\Model;
class ShopsModel extends BaseModel {
     /**
	  * 查询登录关键字
	  */
	 public function checkLoginKey($val,$id = 0){
	 	$sql = " (loginName ='%s' or userPhone ='%s' or userEmail='%s') ";
	 	$keyArr = array($val,$val,$val);
	 	if($id>0)$sql.=" and userId!=".$id;
	 	$m = M('users');
	 	$rs = $m->where($sql,$keyArr)->count();
	    if($rs==0)return 1;
	    return 0;
	 }
    /**
	  * 新增
	  */
	 public function add(){
	 	$rd = array('status'=>-1);
	 	//先建立账号
	 	$hasLoginName = self::checkLoginKey(I("loginName"));
	 	$hasUserPhone = self::checkLoginKey(I("userPhone"));
	 	if($hasLoginName==0 || $hasUserPhone==0){
	 		$rd = array('status'=>-2);
	 		return $rd;
	 	}
	 	$data = array();
	 	$data["loginName"] = I("loginName");
		$data["loginSecret"] = rand(1000,9999);
		$data["loginPwd"] = md5(I('loginPwd').$data['loginSecret']);
		$data["userName"] = I("userName");
		$data["userPhone"] = I("userPhone");
		if($this->checkEmpty($data,true)){ 
			$data["userStatus"] = I("userStatus",1);
			$data["userType"] = I("userType",1);
			$data["userEmail"] = I("userEmail");
			$data["userQQ"] = I("userQQ");
			$data["userScore"] = I("userScore",0);
		    $data["userTotalScore"] = I("userTotalScore",0);
		    $data["userFlag"] = 1;
		    $data["createTime"] = date('Y-m-d H:i:s');
			$m = M('users');
			$rs = $m->add($data);
			if(false !== $rs){
				$data = array();
				$data["shopSn"] = I("shopSn");
				$data["userId"] = $rs;
				$data["areaId1"] = I("areaId1");
				$data["areaId2"] = I("areaId2");
				$data["areaId3"] = I("areaId3");
				$data["goodsCatId1"] = I("goodsCatId1");
				$data["isSelf"] = I("isSelf",0);
				$data["shopName"] = I("shopName");
				$data["shopCompany"] = I("shopCompany");
				$data["shopImg"] = I("shopImg");
				$data["shopAddress"] = I("shopAddress");
				$data["deliveryStartMoney"] = I("deliveryStartMoney",0);
		        $data["deliveryCostTime"] = I("deliveryCostTime",0);
				$data["deliveryFreeMoney"] = I("deliveryFreeMoney",0);
		        $data["deliveryMoney"] = I("deliveryMoney",0);
				$data["avgeCostMoney"] = I("avgeCostMoney",0);
				$data["bankId"] = I("bankId");
				$data["bankNo"] = I("bankNo");
				$data["isInvoice"] = I("isInvoice",1);
				$data["serviceStartTime"] = I("serviceStartTime");
				$data["serviceEndTime"] = I("serviceEndTime");
				$data["shopStatus"] = I("shopStatus",1);
				$data["shopAtive"] = I("shopAtive",1);
				$data["shopFlag"] = 1;
				$data["createTime"] = date('Y-m-d H:i:s');
			    if($this->checkEmpty($data,true)){
			    	$data['statusRemarks'] = I('statusRemarks');
			    	$data["shopTel"] = I("shopTel");
			    	$data["invoiceRemarks"] = I("invoiceRemarks");
					$m = M('shops');
					$rs = $m->add($data);
				    if(false !== $rs){
						$rd['status']= 1;
						//建立门店和社区的关系
						$relateArea = I('relateAreaId');
						$relateCommunity = I('relateCommunityId');
						if($relateArea!=''){
							$m = M('shops_communitys');
							$relateAreas = explode(',',$relateArea);
							foreach ($relateAreas as $v){
								if($v=='' || $v=='0')continue;
								$tmp = array();
								$tmp['shopId'] = $rs;
								$tmp['areaId1'] = I("areaId1");
								$tmp['areaId2'] = I("areaId2");
								$tmp['areaId3'] = $v;
								$tmp['communityId'] = 0;
								$ra = $m->add($tmp);
							}
						}
				        if($relateCommunity!=''){
				        	$m = M('communitys');
				        	$lc = $m->where('communityFlag=1 and (communityId in(0,'.$relateCommunity.") or areaId3 in(0,".$relateArea."))")->select();
				        	if(count($lc)>0){
				        		$m = M('shops_communitys');
								foreach ($lc as $key => $v){
									$tmp = array();
									$tmp['shopId'] = $rs;
									$tmp['areaId1'] = $v['areaId1'];
									$tmp['areaId2'] = $v['areaId2'];
									$tmp['areaId3'] = $v['areaId3'];
									$tmp['communityId'] = $v['communityId'];
									$ra = $m->add($tmp);
								}
							}
						}
					}
				}
				
			}
			
		}
		
		return $rd;
	 } 
     /**
	  * 修改
	  */
	 public function edit(){
	 	$rd = array('status'=>-1);
	 	$shopId = I('id',0);
	 	if($shopId==0)return rd;
	 	$m = M('shops');
	 	//获取店铺资料
	 	$shops = $m->where("shopId=".$shopId)->find();
	    //检测手机号码是否存在
	 	if(I("userPhone")!=''){
	 		$hasUserPhone = self::checkLoginKey(I("userPhone"),$shops['userId']);
	 		if($hasUserPhone==0){
	 			$rd = array('status'=>-2);
	 		    return $rd;
	 		}
	 	}
	    $data = array();
		$data["shopSn"] = I("shopSn");
		$data["areaId1"] = I("areaId1");
		$data["areaId2"] = I("areaId2");
		$data["areaId3"] = I("areaId3");
		$data["goodsCatId1"] = I("goodsCatId1");
		$data["isSelf"] = I("isSelf",0);
		$data["shopName"] = I("shopName");
		$data["shopCompany"] = I("shopCompany");
		$data["shopImg"] = I("shopImg");
		$data["shopAddress"] = I("shopAddress");
		$data["deliveryStartMoney"] = I("deliveryStartMoney",0);
		$data["deliveryCostTime"] = I("deliveryCostTime",0);
		$data["deliveryFreeMoney"] = I("deliveryFreeMoney",0);
		$data["deliveryMoney"] = I("deliveryMoney",0);
		$data["avgeCostMoney"] = I("avgeCostMoney",0);
		$data["bankId"] = I("bankId");
		$data["bankNo"] = I("bankNo");
		$data["isInvoice"] = I("isInvoice",1);
		$data["serviceStartTime"] = I("serviceStartTime");
		$data["serviceEndTime"] = I("serviceEndTime");
		$data["shopStatus"] = I("shopStatus",0);
		$data["shopAtive"] = I("shopAtive",1);
		$data["shopFlag"] = 1;
		$data["createTime"] = date('Y-m-d H:i:s');
		if($this->checkEmpty($data,true)){
			$data["shopTel"] = I("shopTel");
			$data["invoiceRemarks"] = I("invoiceRemarks");
			$rs = $m->where("shopId=".$shopId)->save($data);
		    if(false !== $rs){
		    	//检查用户类型
		    	$m = M('users');
		    	$userType = $m->where('userId='.$shops['userId'])->getField('userType');
		    	
		    	//保存用户资料		    	
		    	$data = array();
		    	$data["userName"] = I("userName");
		        $data["userPhone"] = I("userPhone");
		        //如果是普通用户则提升为店铺会员
		        if($userType==0){
		        	$data["userType"] = 1;
		        }
		        $urs = $m->where("userId=".$shops['userId'])->save($data);
				$rd['status']= 1;
				
		        //建立门店和社区的关系
				$relateArea = I('relateAreaId');
				$relateCommunity = I('relateCommunityId');
				$m = M('shops_communitys');
				$m->where('shopId='.$shopId)->delete();
				if($relateArea!=''){
					$relateAreas = explode(',',$relateArea);
					foreach ($relateAreas as $v){
						if($v=='' || $v=='0')continue;
						    $tmp = array();
							$tmp['shopId'] = $shopId;
							$tmp['areaId1'] = I("areaId1");
							$tmp['areaId2'] = I("areaId2");
							$tmp['areaId3'] = $v;
							$tmp['communityId'] = 0;
							$ra = $m->add($tmp);
					}
				}
				if($relateCommunity!=''){
				    $m = M('communitys');
				    $lc = $m->where('communityFlag=1 and (communityId in(0,'.$relateCommunity.") or areaId3 in(0,".$relateArea."))")->select();
				    if(count($lc)>0){
				    	$m = M('shops_communitys');
						foreach ($lc as $key => $v){
							$tmp = array();
							$tmp['shopId'] = $shopId;
							$tmp['areaId1'] = $v['areaId1'];
							$tmp['areaId2'] = $v['areaId2'];
							$tmp['areaId3'] = $v['areaId3'];
							$tmp['communityId'] = $v['communityId'];
							$ra = $m->add($tmp);
						}
					}
				}
			}
		}
	
		return $rd;
	 } 
	 /**
	  * 获取指定对象
	  */
     public function get(){
	 	$m = M('shops');
		$rs = $m->where("shopId=".I('id'))->find();
		$m = M('users');
		$us = $m->where("userId=".$rs['userId'])->find();
		$rs['userName'] = $us['userName'];
		$rs['userPhone'] = $us['userPhone'];
		
		//获取门店社区关系
		$m = M('shops_communitys');
		$rc = $m->where('shopId='.I('id'))->select();
		$relateArea = array();
		$relateCommunity = array();
		if(count($rc)>0){
			foreach ($rc as $v){
				if($v['communityId']==0 && !in_array($v['areaId3'],$relateArea))$relateArea[] = $v['areaId3'];
				if(!in_array($v['communityId'],$relateCommunity))$relateCommunity[] = $v['communityId'];
			}
		}
		$rs['relateArea'] = implode(',',$relateArea);
		$rs['relateCommunity'] = implode(',',$relateCommunity);
		return $rs;
	 }
	 /**
	  * 停止或者拒绝店铺
	  */
	 public function reject(){
	 	$rd = array('status'=>-1);
	 	$shopId = I('id',0);
	 	if($shopId==0)return rd;
	 	$m = M('shops');
	 	//获取店铺资料
	 	$shops = $m->where("shopId=".$shopId)->find();
	 	$data = array();
	 	$data['shopStatus'] = I('shopStatus',-1);
	 	$data['statusRemarks'] = I('statusRemarks');
	 	if($this->checkEmpty($data,true)){
		 	$rs = $m->where("shopId=".$shopId)->save($data);
			if(false !== $rs){
				$yj_data = array(
					'msgType' => 0,
					'sendUserId' => session('WST_STAFF.staffId'),
					'receiveUserId' => $shops['userId'],
					'msgContent' => I('statusRemarks'),
					'createTime' => date('Y-m-d H:i:s'),
					'msgStatus' => 0,
					'msgFlag' => 1,
				);
				M('messages')->add($yj_data);
				$rd['status'] = 1;
			}
			
	 	}
		return $rd;
	 }
	 
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('shops');
        $areaId1 = I('areaId1',0);
     	$areaId2 = I('areaId2',0);
	 	$sql = "select shopId,shopSn,isAdminRecom,isAdminBest,shopName,u.userName,shopAtive,shopStatus,gc.catName from __PREFIX__shops s,__PREFIX__users u ,__PREFIX__goods_cats gc 
	 	     where gc.catId=s.goodsCatId1 and s.userId=u.userId and shopStatus=1 and shopFlag=1 ";
	 	if(I('shopName')!='')$sql.=" and shopName like '%".I('shopName')."%'";
	 	if(I('shopSn')!='')$sql.=" and shopSn like '%".I('shopSn')."%'";
	 	if($areaId1>0)$sql.=" and areaId1=".$areaId1;
	 	if($areaId2>0)$sql.=" and areaId2=".$areaId2;
	 	$sql.=" order by shopId desc";
		return $m->pageQuery($sql);
	 }
     /**
	  * 分页列表[待审核列表]
	  */
     public function queryPeddingByPage(){
        $m = M('shops');
        $areaId1 = I('areaId1',0);
     	$areaId2 = I('areaId2',0);
	 	$sql = "select shopId,shopSn,shopName,u.userName,shopAtive,shopStatus,gc.catName from __PREFIX__shops s,__PREFIX__users u ,__PREFIX__goods_cats gc 
	 	     where gc.catId=s.goodsCatId1 and s.userId=u.userId and shopStatus<=0 and shopFlag=1";
	 	if(I('shopName')!='')$sql.=" and shopName like '%".I('shopName')."%'";
	 	if(I('shopSn')!='')$sql.=" and shopSn like '%".I('shopSn')."%'";
	 	if(I('shopStatus',-999)!=-999)$sql.=" and shopStatus =".(int)I('shopStatus');
	 	if($areaId1>0)$sql.=" and areaId1=".$areaId1;
	 	if($areaId2>0)$sql.=" and areaId2=".$areaId2;
	 	$sql.=" order by shopId desc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('shops');
	     $sql = "select * from __PREFIX__shops order by shopId desc";
		 $rs = $m->find($sql);
	  }
	  
	 /**
	  * 删除
	  */
	 public function del(){
	    $rd = array('status'=>-1);
	 	$m = M('shops');
	    $data = array();
		$data["shopFlag"] = -1;
	 	$rs = $m->where("shopId=".I('id'))->save($data);
	    if(false !== $rs){
			$rd['status']= 1;
		}
		return $rd;
	 }
     /**
	  * 获取待审核的店铺数量
	  */
	 public function queryPenddingShopsNum(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	$sql="select count(*) counts from __PREFIX__shops where shopStatus=0 and shopFlag=1";
	 	$rs = $this->query($sql);
	 	$rd['num'] = $rs[0]['counts'];
	 	return $rd;
	 }
	 
	 /**
	  * 批量修改精品状态
	  */
	 public function changeBestStatus(){
	     $rd = array('status'=>-1);
	     $m = M('shops');
	     $id = I('id',0);
	     $m->isAdminBest = I('status',0);
	     $rs = $m->where('shopId in('.$id.")")->save();
	     if(false !== $rs){
	         $rd['status'] = 1;
	     }
	     return $rd;
	 }
	 /**
	  * 批量修改推荐状态
	  */
	 public function changeRecomStatus(){
	     $rd = array('status'=>-1);
	     $m = M('shops');
	     $id = I('id',0);
	     $m->isAdminRecom = I('status',0);
	     $rs = $m->where('shopId in('.$id.")")->save();
	     if(false !== $rs){
	         $rd['status'] = 1;
	     }
	     return $rd;
	 }
	 
};
?>
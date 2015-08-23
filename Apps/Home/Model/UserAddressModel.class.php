<?php
 namespace Home\Model;
/**
 * 会员地址服务类
 */
class UserAddressModel extends BaseModel {
    /**
	  * 新增
	  */
	 public function add(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["userId"] = (int)session('WST_USER.userId');
		$data["userName"] = I("userName");
		$data["areaId2"] = I("areaId2");
		if(I("areaId1")){
			$data["areaId1"] = I("areaId1");
		}else{
			$sql ="SELECT parentId FROM __PREFIX__areas WHERE areaId='".$data["areaId2"]."' AND areaFlag=1";
			$ars = $this->queryRow($sql);
			$data["areaId1"] = $ars["parentId"];
		}
		
		$data["areaId3"] = I("areaId3");
		$data["communityId"] = I("communityId");
		if(I("userPhone")!=''){
			$data["userPhone"] = I("userPhone");
		}else{
		    $data["userTel"] = I("userTel");
		}
		
		$data["address"] = I("address");
		$data["isDefault"] = I("isDefault",0);
		$data["addressFlag"] = 1;
		$data["createTime"] = date('Y-m-d H:i:s');
	    if($this->checkEmpty($data,true)){	
	    	$data["userPhone"] = I("userPhone");
	    	$data["userTel"] = I("userTel");
	    	$data["postCode"] = I("postCode");
			$m = M('user_address');
			$rs = $m->add($data);
			if(false !== $rs){
				$rd['status']= $rs;
				if(I("isDefault")==1){
					//修改所有的地址为非默认
					$m->isDefault = 0;
					$m->where('userId='.(int)session('WST_USER.userId')." and addressId!=".$rs)->save();
				}
			}
		}
		return $rd;
	 } 

	 public function addAPP(){
	 	$d=D('areas');

	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["userId"] = I('userId');//(int)session('WST_USER.userId');
		$data["userName"] = I("user_name");
		$data["areaId1"] = $d->getId(I('map_address_province'),'province');
		$data["areaId2"] = $d->getId(I('map_address_city'),'city');
		$data["areaId3"] = $d->getId(I('map_address_district'),'district');
		$data["communityId"] = I("communityId",0);
		if(I("user_phoneNumber")!=''){
			$data["userPhone"] = I("user_phoneNumber");
		}else{
		    $data["userTel"] = I("userTel");
		}
		
		$data["address"] = I("user_address");
		$data["addressDetail"]=I("user_address_detail");
		$data["isDefault"] = I("isDefault",0);
		$data["addressFlag"] = 1;
		$data["createTime"] = date('Y-m-d H:i:s');
	    if($this->checkEmpty($data,true)){	
	    	$data["userPhone"] = I("user_phoneNumber");
	    	$data["userTel"] = I("userTel",123456);
	    	$data["postCode"] = I("postCode",0);
			$m = M('user_address');
			$rs = $m->add($data);
			//echo "once";
			if(false !== $rs){
				$rd['status']= $rs;
				if(I("isDefault")==1){
					//修改所有的地址为非默认
					$m->isDefault = 0;
					$m->where('userId='.I('userId')." and addressId!=".$rs)->save();
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
	 	$id = I("id",0);
		$data = array();
		$data["userName"] = I("userName");
		//$data["userPhone"] = I("userPhone");
	    if(I("userPhone")!=''){
			$data["userPhone"] = I("userPhone");
		}else{
		    $data["userTel"] = I("userTel");
		}
		$data["areaId2"] = I("areaId2");
		$data["areaId3"] = I("areaId3");
		$data["communityId"] = I("communityId");
		$data["address"] = I("address");
		
		if($this->checkEmpty($data,true)){	
			$m = M('user_address');
			$data["userPhone"] = I("userPhone");
			$data["userTel"] = I("userTel");
			$data["postCode"] = I("postCode");
			$data["isDefault"] = I("isDefault");
			$rs = $m->where("userId=".(int)session('WST_USER.userId')." and addressId=".$id)->save($data);
			if(false !== $rs){
				$rd['status']= 1;
				if(I("isDefault")==1){
					//修改所有的地址为非默认
					$m->isDefault = 0;
					$m->where('userId='.(int)session('WST_USER.userId')." and addressId!=".$id)->save();
				}
			}
		}
		return $rd;
	 } 
	 /**
	  * 获取指定对象
	  */
     public function get(){
	 	$m = M('user_address');
		return $m->where("addressId=".I('id')." and userId=".(int)session('WST_USER.userId'))->find();
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList($userId){
	     $m = M('user_address'); 
	     $sql = "select ua.*,a1.areaName areaName1,a2.areaName areaName2,a3.areaName areaName3,c.communityName
	              from __PREFIX__user_address ua 
	              left join __PREFIX__areas a1 on a1.areaId=ua.areaId1 and a1.isShow=1 and a1.areaFlag=1
	              left join __PREFIX__areas a2 on a2.areaId=ua.areaId2 and a2.isShow=1 and a2.areaFlag=1
	              left join __PREFIX__areas a3 on a3.areaId=ua.areaId3 and a3.isShow=1 and a3.areaFlag=1
	              left join __PREFIX__communitys c on c.communityId=ua.communityId and c.isShow=1
	              where ua.userId=".(int)$userId;
		 return $m->query($sql);
	  }
	  
     /**
	  * 根据用户以及所在城市获取列表
	  */
	  public function queryByUserAndCity($userId,$cityId){
	     $m = M('user_address'); 
	     $sql = "select ua.*,a1.areaName areaName1,a2.areaName areaName2,a3.areaName areaName3,c.communityName
	              from __PREFIX__user_address ua 
	              left join __PREFIX__areas a1 on a1.areaId=ua.areaId1 and a1.isShow=1 and a1.areaFlag=1
	              left join __PREFIX__areas a2 on a2.areaId=ua.areaId2 and a2.isShow=1 and a2.areaFlag=1
	              left join __PREFIX__areas a3 on a3.areaId=ua.areaId3 and a3.isShow=1 and a3.areaFlag=1
	              left join __PREFIX__communitys c on c.communityId=ua.communityId and c.isShow=1
	              where ua.userId=".(int)$userId." and a2.areaId=".$cityId;
		 return $m->query($sql);
	  }
	  
	 /**
	  * 删除
	  */
	 public function del(){
	 	$rd = array('status'=>-1);
	    $m = M('user_address');
	    $rs = $m->where("userId=".(int)session('WST_USER.userId')." and addressId=".I('id'))->delete();
		if(false !== $rs){
		   $rd['status']= 1;
		}
		return $rd;
	 }
	/**
	 * 购物过程中获取用户地址
	 */
	public function getUserAddressInfo(){
		$m = M('user_address'); 
		$addressId = I("addressId");
		$sql ="SELECT * FROM __PREFIX__user_address WHERE addressId=$addressId AND addressFlag=1 and userId=".(int)session('WST_USER.userId');
		$rs = $this->queryRow($sql);
		if(empty($rs))return array();
		$area3List = self::getDistricts($rs["areaId2"]);
		$rs["area3List"] = $area3List;
		
		$collegesList = self::getCommunitys($rs["areaId3"]);
		$rs["communitysList"] = $collegesList;
		return $rs;
	}

	public function getUserAddressApp(){
		$m = M('user_address');
		$userId = I('userId');
		$addrInfo = $m->where("userId=".$userId)->select();
		$addrList=array();
		foreach ($addrInfo as $key => $value) {
			$tmp=array();
			$tmp['user_name']=$value['userName'];
			if(!empty($value['userPhone'])){
				$tmp['user_phoneNumber']=$value['userPhone'];
			}else{
				if(!empty($value['userTel']))
					$tmp['user_phoneNumber']=$value['userTel'];
			}
			$tmp['user_address']=$value['address'];
			$tmp['user_address_detail']=$value['addressDetail'];
			$addrList[]=$tmp;
		}
		return $addrList;
	}
	
	public function getAllCitys(){
		$m = M('areas'); 
		$sql = "SELECT * FROM __PREFIX__areas WHERE areaType = 1 AND areaFlag = 1 AND isShow =1";		
		$rs = $m->query($sql);		
		return $rs;
	}	
	
	
	public function getDistricts($cityId){		
		$m = M('areas'); 
		$sql = "SELECT * FROM __PREFIX__areas WHERE parentId=$cityId  AND areaFlag = 1 AND areaType = 2 AND isShow =1";		
		$rs = $m->query($sql);		
		return $rs;
		
	}	
	
	public function getCommunitys($districtId){	
			
		$m = M('communitys'); 
		$sql = "SELECT * FROM __PREFIX__communitys WHERE areaId3=$districtId  AND isService = 1 AND isShow =1 ORDER BY communitySort";		
		$rs = $m->query($sql);		
		return $rs;
		
	}	
	
	/**
	 * 获取门店服务社区
	 * 
	 * @param unknown_type $countryId
	 * @param unknown_type $shopId
	 */
	public function getServiceCommunitys($communityId,$shopId){
		
		$m = M('communitys'); 
		$sql = "SELECT c.collegeId,c.collegeName from __PREFIX__communitys c, __PREFIX__shops_communitys sc 
				WHERE c.communityId=sc.communityId AND sc.communityId>0 AND sc.areaId3 = '$communityId' AND sc.shopId = $shopId AND communityFlag = 1 
				GROUP BY sc.communityId ORDER BY communitySort";
		$rs = $m->query($sql);	
		return $rs;
		
	}
	
	/**
	 * 获取门店配送区
	 * 
	 * @param unknown_type $shopId
	 */
	public function getShopCommunitysId($shopId){
	 	$m = M('communitys'); 
	 	$sql = "SELECT communityId FROM __PREFIX__shops_communitys WHERE shopId = $shopId ";
		$communitys = $m->query($sql);
		$communitysId = array();
		for($i=0;$i<count($communitys);$i++){
			$communitysId[] = $communitys[$i]["communityId"];
		}
		return implode(",",$communitysId) ;
	}
	
	
	public function getDistrictsOption($cityId){		
		$m = M('areas'); 
		$sql = "SELECT areaId as id,areaName as name FROM __PREFIX__areas WHERE parentId=$cityId  AND areaFlag = 1 AND areaType = 2 AND isShow =1";		
		$rs = $m->query($sql);		
		return $rs;
		
	}	
	
	public function getCommunitysOption($districtId){	
			
		$m = M('communitys'); 
		$sql = "SELECT communityId as id,communityName as name FROM __PREFIX__communitys WHERE areaId3=$districtId  AND isService = 1 AND isShow =1 ORDER BY communitySort";		
		$rs = $m->query($sql);		
		return $rs;
		
	}
	
	/**
	 * 获取地址详情
	 */
	public function getAddressDetails($addressId){
		$m = M('user_address');
		$addressId = $addressId?$addressId:I("addressId");
		$sql ="SELECT * FROM __PREFIX__user_address WHERE addressId=$addressId AND addressFlag=1"; //and userId=".(int)session('WST_USER.userId');
		file_put_contents("session.txt", session('WST_USER.userId'));
		$address = $this->queryRow($sql);
		if(empty($address))return array();
		
		$areaId2 = $address["areaId2"];
		$areaId3 = $address["areaId3"];
		$communityId = $address["communityId"];
		
		$sql = "SELECT areaId ,areaName FROM __PREFIX__areas WHERE areaId=$areaId2  AND areaFlag = 1 AND isShow =1";		
		$rs = $this->queryRow($sql);
		$cityName = $rs["areaName"];//市
		
		$sql = "SELECT areaId ,areaName FROM __PREFIX__areas WHERE areaId=$areaId3  AND areaFlag = 1 AND isShow =1";
		$rs = $this->queryRow($sql);
		$districtsName = $rs["areaName"];//区
		
		$sql = "SELECT communityId ,communityName FROM __PREFIX__communitys WHERE communityId=$communityId  AND isService = 1 AND isShow =1";		
		$rs = $this->queryRow($sql);
		$communityName = $rs["communityName"];//社区
		
		$address["paddress"] = $cityName ." ". $districtsName ." ". $communityName;
		return $address ;
	}
	
};
?>
<?php
namespace Home\Model;
/**
 * 区域服务类
 */
class AreasModel extends BaseModel {
	/**
	  * 获取门店的服务县区 
	  */ 
	public function getDistrictsByShop($obj){
		$shopId = $obj["shopId"];
	 	$sql = "SELECT ar.areaId , ar.areaName, sa.shopId 
			 	FROM __PREFIX__areas ar , __PREFIX__shops_communitys sa 
			 	WHERE  ar.areaId = sa.areaId3 AND sa.shopId = $shopId AND sa.communityId>0 GROUP BY areaId";
	 	return $this->query($sql);
	 }
	
	/**
	  * 获取门店的社区
	  */
 	public function getShopCommunitys($obj){
 		$shopId = $obj["shopId"];
 		$areaId2 = $obj["areaId2"];
	 	$sql = "SELECT c.communityId id, c.communityName name
	 			FROM __PREFIX__communitys c , __PREFIX__shops_communitys sa 
	 			WHERE  c.communityId = sa.communityId AND sa.shopId = $shopId AND sa.communityId>0 Order by communitySort";
	 	$communitys = array();
	 	$communitys[$areaId2] = $this->query($sql);
	 	return $communitys;
	 }
	 
	 /**
	  * 获取列表[带社区]
	  */
	  public function queryAreaAndCommunitysByList($parentId){
	     $m = M('areas');
		 $rs = $m->where('areaFlag=1 and parentId='.$parentId)->field('areaId,areaName')->select();
		 if(count($rs)>0){
		 	$m = M('communitys');
		 	foreach ($rs as $key =>$v){
		 		$r = $m->where('communityFlag=1 and areaId3='.$v['areaId'])->field('communityId,communityName')->select();
		 		if(!empty($r))$rs[$key]['communitys'] = $r;
		 	}
		 }
		 return $rs;
	  }
     /**
	 * 获取区域信息
	 */
	 public function getArea($areaId){
	  	 $m = M('areas');
		 return $m->where('areaFlag=1 and isShow=1 and areaId='.$areaId)->find();
	 }
	  
	/**
	  * 获取城市下的区
	  */
	  public function getDistricts($parentId){
		 return $this->cache('WST_CACHE_CITY_003_'.$parentId,31536000)->where('areaFlag=1 and isShow=1 and parentId='.$parentId)->field('areaId,areaName')->order('parentId, areaSort')->select();
	  }
	    
	  /**
	   * 获取省份列表
	   */
	  public function getProvinceList(){
	  	$rslist = $this->cache('WST_CACHE_CITY_001',31536000)->where('isShow=1 AND areaFlag = 1 AND areaType=0')->field('areaId,areaName')->order('parentId, areaSort')->select();
	  	foreach ($rslist as $key =>$row){
	  		$rs[$row["areaId"]] = $row;
	  	}
	  	return $rs;
	  }
	  
	  /**
	   * 获取所有城市-根据字母分类
	   */
	  public function getCityGroupByKey(){
	  	$rslist = $this->cache('WST_CACHE_CITY_000',31536000)->where('isShow=1 AND areaFlag = 1 AND areaType=1')->field('areaId,areaName,areaKey')->order('areaKey, areaSort')->select();
	  	foreach ($rslist as $key =>$row){
	  		$rs[$row["areaKey"]][] = $row;
	  	}
	  	return $rs;
	  }
	  
	  /**
	   * 通过省份获取城市列表
	   */
	  public function getCityListByProvince($provinceId = 0){
	  	$rslist = $this->cache('WST_CACHE_CITY_002_'.$provinceId,31536000)->where('isShow=1 AND areaFlag = 1 AND areaType=1 AND parentId='.$provinceId)->field('areaId,areaName')->order('parentId, areaSort')->select();
	  	foreach ($rslist as $key =>$row){
	  		$rs[] = $row;
	  	}
	  	return $rs;
	  }
	  
	  /**
	   * 定位所在城市
	   */
	  public function getDefaultCity(){
	  	$areaId2 = I('city',0);
	  	if($areaId2>0){
	  		session('areaId2',$areaId2);
	  	}else{
	  		$areaId2 = (int)session('areaId2');
	  	}

	  	//检验城市有效性
	  	if($areaId2>0){
	  		$m = D('Home/Areas');
	  		$sql ="SELECT areaId FROM __PREFIX__areas WHERE isShow=1 AND areaFlag = 1 AND areaType=1 AND areaId=".$areaId2;
	  		$rs = $m->query($sql);
	  		if($rs[0]['areaId']=='')$areaId2 = 0;
	  	}else{
	  		$areaId2 = (int)$_COOKIE['areaId2'];
	  	}
	  	//定位城市
	  	if($areaId2==0){
	  		//IP定位
	  		$Ip = new \Org\Net\IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
	  		$area = $Ip->getlocation(get_client_ip());
	  		if($area['area']!=""){
	  			$m = D('Home/Areas');
	  			$sql ="SELECT areaId FROM __PREFIX__areas WHERE isShow=1 AND areaFlag = 1 AND areaType=1 AND areaName like '$cityName'";
	  			$rs = $m->query($sql);
	  			if($rs[0]["areaId"]>0){
	  				$areaId2 = $rs[0]["areaId"];
	  			}else{
	  				$areaId2 = C(DEFAULT_CITY);
	  			}
	  		}else{
	  			$areaId2 = C(DEFAULT_CITY);
	  		}
	  	}
	  	setcookie("areaId2", $areaId2, time()+3600*24*90);
	  	return $areaId2;
	  
	  }
	/*
	 *
	 *根据经纬度获取省份、市、区的ID
	 *areaType只能为province、city、district
	 *areaType=province,获取省份ID
	 *areaType=city,获取市ID
	 *areaTyep=district,获取区的ID
	*/  
	public function getId($areaName,$areaType){
		$areasId=M('areas')->field("areaId,parentId")->where("areaName='".$areaName."'")->select();
		if(count($areasId)==1)
			return $areasId[0]['areaId'];
		if($areaType=="province"){
			foreach ($areasId as $key => $value) {
				if($value['parentId']==0)
					return $value['areaId'];
			}
		}
		if($areaType=="city"){
			foreach ($areasId as $key => $value) {
				if($value['parentId']!=0)
					return $value['areaId'];
			}
		}
	}
}
<?php
namespace Home\Model;
define(EARTH_RADIUS,6371.393);
class LocationModel extends BaseModel{
	/**
	 *根据中心坐标(lng,lat)和半径，获取圆的外切正方形的四个顶点
	 *@prama lng 中心经度
	 *@prama lat 中心纬度
	 *@prama distance 半径
	 *返回值：外切正方形四个顶点
	 *
	*/
	//private static $url="http://api.map.baidu.com/geocoder/v2/?";


	public function returnSquarePoint($lng, $lat,$distance){

		$dlng = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
		$dlng = rad2deg($dlng);


		$dlat = $distance/EARTH_RADIUS;
		$dlat = rad2deg($dlat);
		return array(
			'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
			'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
			'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
			'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng+$dlng)
		);
	}
	/*
	 *根据地址获取经纬度
	 *若获取地址失败：则返回状态码：401
	*/
	public function getCoordinate($addr){
		$url='http://api.map.baidu.com/geocoder/v2/?';
		$param=array(
				'address'	=>	$addr,
				'output'	=>	'json',
				'ak'	=>	'uSVSN5xuRGsePVAlMNYTAx91'
			);
		$result=get($url,$param);
		$position['lng']=$result["result"]["location"]["lng"];
		$position['lat']=$result["result"]["location"]["lat"];
		if(isset($position['lng'])&&isset($position['lat'])){
			return $position;
		}else{
			return "401";
		}
	}
	/*
	 *根据两个地点的经纬度计算两个地点之间的空间距离
	 *@prama lat1 第一个地点的纬度
	 *@prama lng1 第一个地点的经度
	 *@prama lat2 第二个地点的纬度
	 *@prama lng2 第二个地点的经度
	 *返回值：两个地点之间的距离，单位：米
	*/
	public function getDistance($lat1, $lng1, $lat2, $lng2){   

		// $url = "http://api.map.baidu.com/direction/v1/routematrix";   
		// $param =array(
		// 		'origins'	=>	$lat1.",".$lng1,
		// 		'destinations'	=>	$lat2.",".$lng2,
		// 		'output'	=>	'json',
		// 		'ak'	=>	'uSVSN5xuRGsePVAlMNYTAx91'
		// 	);
		// $response=$this->getRequest($url,$param);
		// return $response['result']['elements'][0]['distance']['value'];	//返回距离，单位为米
        $earthRadius = 6371393; //近似地球半径米
          // 转换为弧度
        $lat1 = ($lat1 * pi()) / 180;
        $lng1 = ($lng1 * pi()) / 180;
        $lat2 = ($lat2 * pi()) / 180;
        $lng2 = ($lng2 * pi()) / 180;
         // 使用半正矢公式  用尺规来计算
        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  
       	$stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        return round($calculatedDistance);
   }

   	/*
   	 *将商家按离原点的距离排序
   	 *@prama origin_lng 原点经度
   	 *@prama origin_lat 原点纬度
   	 *@prama shop 要排序的商家
   	 *返回值：排好序的商家，以数组形式返回
   	*/
    public function orderByDistance($origin_lng,$origin_lat,$shop=array()){
   		if(!is_array($shop))
   			return "orderByDistance():商家列表不是数组";
   		//$time_start=microtime_float();
   		foreach ($shop as $key => $value) {
   			$distance=$this->getDistance($origin_lat,$origin_lng,$value['lat'],$value['lng']);
   			$shopAddr=$this->getAddr($value['lng'],$value['lat']);
   			//echo "商铺地址：".$shopAddr."<br/>";
   			$shop[$key]['distance']=$distance;
   		}
   		usort($shop, 'compareDistance');
   		//$time_end=microtime_float();
   		//$time=$time_end-$time_start;
   		//echo "getDistancetime=".$time."<br/>";
   		return $shop;
   }

   	public function getNearbyShop($origin_lng,$origin_lat,$distance=2.5){
		$corner = $this->returnSquarePoint($origin_lng,$origin_lat,$distance);
		$m = M('shops');
		$where="lng < ".$corner['right-top']['lng']." and lng > ".$corner['left-bottom']['lng']." and lat < ".$corner['right-top']['lat']." and lat > ".$corner['left-bottom']['lat'];
		//$time_start=microtime_float();
		$shops=$m->where($where)->select();
		//$time_end=microtime_float();
   		//$time=$time_end-$time_start;
   		//echo "querySqlTime=".$time."<br/>";
		$shops=$this->orderByDistance($origin_lng,$origin_lat,$shops);
		$shopsId=array();
		foreach ($shops as $key => $value) {
			$shopsId[]=$value['shopId'];
		}
		return $shopsId;
	}

	public function getAddrInfo($lng,$lat){
		$url='http://api.map.baidu.com/geocoder/v2/?';
		$param=array(
				'location'	=>	$lat.",".$lng,
				'output'	=>	'json',
				'ak'	=>	'uSVSN5xuRGsePVAlMNYTAx91'
			);
		$addrInfo = get($url,$param);
		return $addrInfo;
	}
	public function getAddr($lng,$lat){
		
		$addrInfo = $this->getAddrInfo($lng,$lat);
		//echo json_encode($addrInfo);
		$addr = $addrInfo['result']['formatted_address'];
		if(isset($addr)){
			return $addr;
		}else{
			return 402;
		}
	}

	// //根据经纬度获取省份ID
	// public function getProvinceId($lng,$lat){
	// 	$addrInfo=$this->getAddrInfo($lng,$lat);
	// 	$province = $addrInfo['result']['addressComponent']['province'];
	// 	return M('area')->field("areaId")->where("areaName=".$province)->select();
	// }
	// //根据经纬度获取市的ID
	// public function getCityId($lng,$lat){
	// 	$addrInfo=$this->getAddrInfo($lng,$lat);
	// 	$city = $addrInfo['result']['addressComponent']['city'];
	// 	return M('area')->field("areaId")->where("areaName=".$city)->select();
	// }
	// //根据经纬度获取区(洪山区，海定区)的ID
	// public function getDistrictId(){
	// 	$addrInfo=$this->getAddrInfo($lng,$lat);
	// 	$district = $addrInfo['result']['addressComponent']['district'];
	// 	return M('area')->field("areaId")->where("areaName=".$district)->select();
	// }
	/*
	 *
	 *根据经纬度获取省份、市、区的ID
	 *areaType只能为province、city、district
	 *areaType=province,获取省份ID
	 *areaType=city,获取市ID
	 *areaTyep=district,获取区的ID
	*/
	public function getId($lng,$lat,$areaType){
		$addrInfo=$this->getAddrInfo($lng,$lat);
		$areaName = $addrInfo['result']['addressComponent'][$areaType];
		echo $areaName."=";
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
?>
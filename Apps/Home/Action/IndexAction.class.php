<?php
namespace Home\Action;

// header("Location:shop.php");
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 首页控制器
 */
class IndexAction extends BaseAction {
	/**
	 * 获取首页信息
	 * 
	 */
    public function index(){
    	self::getBaseInfo();
   		$ads = D('Home/Ads');

   		$areaId2 = $this->getDefaultCity();

   		//首页主广告
   		$indexAds = $ads->getAds($areaId2,-1);
   		$this->assign('indexAds',$indexAds);
   		//分类广告
   		$catAds = $ads->getAdsByCat($areaId2);
   		$this->assign('catAds',$catAds);
   		if(I("changeCity")){
   			echo $_SERVER['HTTP_REFERER'];
   		}else{
   			$this->display("default/index");
   		}
		
    }
    /**
     * 广告记数
     */
    public function access(){
    	$ads = D('Home/Ads');
    	$ads->statistics(I('id'));
    	header("Location: ".I('url')); 
    }
    /**
     * 切换城市
     */
    public function changeCity(){
    	self::getBaseInfo();
    	$m = D('Home/Areas');
    	$areaId2 = $this->getDefaultCity();
    	$provinceList = $m->getProvinceList();
    	$cityList = $m->getCityGroupByKey();
    	$area = $m->getArea($areaId2);
    	$this->assign('provinceList',$provinceList);
    	$this->assign('cityList',$cityList);
    	$this->assign('area',$area);
    	$this->assign('areaId2',$areaId2);
    	$this->display("default/change_city");
    }
    /**
     * 跳到用户注册协议
     */
    public function toUserProtocol(){
    	$this->display("default/user_protocol");
    }
    
    /**
     * 修改切换城市ID
     */
    public function reChangeCity(){
    	$this->getDefaultCity();
    }
}
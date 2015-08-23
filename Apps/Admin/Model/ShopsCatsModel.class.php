<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 店铺分类服务类
 * ============================================================================
 */
use Think\Model;
class ShopsCatsModel extends BaseModel {
	 /**
	  * 获取列表
	  */
	  public function queryByList($shopId,$parentId){
	     $m = M('shops_cats');
		 return $m->where('shopId='.$shopId.' and catFlag=1 and parentId='.$parentId)->select();
	  }
	 
};
?>
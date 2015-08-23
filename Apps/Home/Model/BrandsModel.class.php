<?php
namespace Home\Model;
/**
 * 品牌服务类
 */
class BrandsModel extends BaseModel {
    /**
	  * 根据县区获取品牌列表
	  */
	public function queryBrandsByDistrict(){
		$areaId3 = (int)I("areaId3");
		$brandName = I("brandName");
		if($brandName==''){
			$brands = S("WST_BRANDS_001_".$areaId3);
			if(!$brands){
				$sql = "SELECT bs.brandId,bs.brandName,bs.brandIco FROM __PREFIX__brands bs,__PREFIX__shops sp,__PREFIX__goods g,__PREFIX__goods_cat_brands gcb
						WHERE bs.brandId=g.brandId AND g.shopId=sp.shopId AND gcb.brandId=bs.brandId AND bs.brandFlag = 1";
				if($areaId3>0){
					$sql .= " AND sp.areaId3 = $areaId3";
				}
				$sql.=" group by bs.brandId ";
				$brands = $this->query($sql);
				S("WST_BRANDS_001_".$areaId3,$brands,2592000);
			}
		}else{
			$sql = "SELECT bs.brandId,bs.brandName,bs.brandIco FROM __PREFIX__brands bs,__PREFIX__shops sp,__PREFIX__goods g,__PREFIX__goods_cat_brands gcb
						WHERE bs.brandId=g.brandId AND g.shopId=sp.shopId AND gcb.brandId=bs.brandId AND bs.brandFlag = 1";
			if($areaId3>0){
				$sql .= " AND sp.areaId3 = $areaId3";
			}
			if($brandName!=""){
				$sql .= " AND bs.brandName like '%$brandName%'";
			}
			$sql.=" group by bs.brandId ";
			$brands = $this->query($sql);
		}
		return $brands;
	}
	
     /**
	  * 获取列表
	  */
	  public function queryBrandsByCat($catId){
	  	 $rs = array('status'=>1);
	  	 $list = S("WST_BRANDS_002_".$catId);
	  	 if(!$list){
		     $sql = "select b.brandId,b.brandName from __PREFIX__goods_cat_brands cb,__PREFIX__brands b where cb.brandId=b.brandId and catId=".$catId;
		     $rs['list'] = $this->query($sql);
		     S("WST_BRANDS_002_".$catId,$list,2592000);
	  	 }
		 return $rs;
	  }
}
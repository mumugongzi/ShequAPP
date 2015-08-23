<?php
namespace Admin\Model;
/**
 * ============================================================================
 * 首页服务类
 * ============================================================================
 */
use Think\Model;
class IndexModel extends Model {
    /**
     * 获取商城配置文件
     */
	public function loadConfigs(){
		$sql = "select * from __PREFIX__sys_configs order by parentId asc,fieldSort asc";
		$rs = $this->query($sql);
		$configs = array();
		if(count($rs)>0){
			foreach ($rs as $key=>$v){
				$configs[$v['fieldCode']] = $v;
			}
		}
		unset($rs);
		return $configs;
	}
	/**
	 * 获取商品配置分类信息
	 */
    public function loadConfigsForParent(){
		$sql = "select * from ".$this->tablePrefix."sys_configs where fieldType!='hidden' order by parentId asc,fieldSort asc";
		$rs = $this->query($sql);
		$configs = array();
		if(count($rs)>0){
			foreach ($rs as $key=>$v){
				if($v['fieldType']=='radio' || $v['fieldType']=='select'){
					$v['txt'] = explode('||',$v['valueRangeTxt']);
					$v['val'] = explode(',',$v['valueRange']);
				}
				$configs[$v['parentId']][] = $v;
			}
		}
		unset($rs);
		return $configs;
	}
	/**
	 * 保存商城配置信息
	 */
	public function saveConfigsForCode(){
		$rd = array('status'=>-1);
		$sql = "select * from ".$this->tablePrefix."sys_configs where fieldType!='hidden' order by parentId asc,fieldSort asc";
		$rs = $this->query($sql);
		if(!empty($rs)){
			$m = M('sys_configs');
			foreach ($rs as $key => $v){
				$result = $m-> where('fieldCode="'.$v['fieldCode'].'"')->setField('fieldValue',I($v['fieldCode']));
				if(false === $result){
				    $rd['status']= -1;
				}
			}
			$rd['status'] = 1;
		}
		return $rd;
	}

	/**
	 * 一周动态
	 * @return [type] [description]
	 */
	public function getWeekInfo(){
		//用户
		$ret = array();
		$map = array('createTime'=>array('gt',date('Y-m-d H:i:s',time()-604800)),);//一周内
		$ret['userNew'] = M('Users')->where($map)->count();//新增用户
		//申请店铺
		$ret['shopApply'] = M('Shops')->where($map)->count();
		//新增商品
		$ret['goodsNew'] = M('goods')->where($map)->count();
		//新增订单
		$ret['ordersNew'] = M('orders')->where($map)->count();
		
		//新增店铺
		$map['shopStatus'] = 1;
		$ret['shopNew'] = M('Shops')->where($map)->count();
		return $ret;
	}

	/**
	 * 统计信息
	 * @return array 统计信息的数组
	 */
	public function getSumInfo(){
		$ret = array();
		$ret['userSum'] = M('Users')->count();//新增用户
		//申请店铺
		$ret['shopApplySum'] = M('Shops')->count();
		//商品
		$ret['goodsSum'] = M('goods')->count();
		//订单
		$ret['ordersSum'] = M('orders')->count();
		//订单总金额
		$ret['moneySum'] = M('orders')->sum('totalMoney');
		
		//店铺
		$ret['shopSum'] = M('Shops')->where('shopStatus = 1')->count();
		return $ret;
	}
}
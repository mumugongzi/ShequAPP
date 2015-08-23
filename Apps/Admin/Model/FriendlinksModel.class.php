<?php
namespace Admin\Model;
/**
 * ============================================================================
 * 社区服务类
 * ============================================================================
 */
use Think\Model;
class FriendlinksModel extends BaseModel {
    /**
     * 获取分页记录
     */
	public function queryPage(){
		$sql = "select * from __PREFIX__friendlinks order by friendlinkSort asc,friendlinkId asc";
		$rs = $this->pageQuery($sql);
		return $rs;
	}
	/**
	 * 新增
	 */
	public function add(){
		$rd = array('status'=>-1);
		$data = array();
		$data['friendlinkIco'] = I('friendlinkIco');
		$data['friendlinkName'] = I('friendlinkName');
		$data['friendlinkUrl'] = I('friendlinkUrl');
		$data['friendlinkSort'] = I('friendlinkSort',0);
		if($this->checkEmpty($data)){
			$m = M('friendlinks');
			$rs = $m->add($data);
			if(false !== $rs){
				$rd['status']= 1;
			}
		}
		return $rd;
	}
	/**
	 * 编辑
	 */
    public function edit(){
    	$rd = array('status'=>-1);
		$m = M('friendlinks');
		$m->friendlinkIco = I('friendlinkIco');
		$m->friendlinkName = I('friendlinkName');
		$m->friendlinkUrl = I('friendlinkUrl');
		$m->friendlinkSort = I('friendlinkSort',0);
		if($this->checkEmpty($data)){
			$rs = $m->where("friendlinkId=".I('id'))->save();
			if(false !== $rs){
				$rd['status']= 1;
			}
		}
		return $rd;
	}
	/**
	 * 获取
	 */
	public function get(){
		$m = M('friendlinks');
		return $m->where("friendlinkId=".I('id'))->find();
	}
	/**
	 * 删除
	 */
	public function del(){
		$rd = array('status'=>-1);
		$m = M('friendlinks');
		$rs = $m->delete(I('id'));
		if(false !== $rs){
			$rd['status']= 1;
		}
		return $rd;
	}
}
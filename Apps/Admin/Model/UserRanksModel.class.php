<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 会员服务类
 * ============================================================================
 */
use Think\Model;
class UserRanksModel extends BaseModel {
    /**
	  * 新增
	  */
	 public function add(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["rankName"] = I("rankName");
		$data["startScore"] = I("startScore");
		$data["endScore"] = I("endScore");
		$data["rebate"] = I("rebate");
		$data["createTime"] = date('Y-m-d H:i:s');
		if($this->checkEmpty($data)){
			$m = M('user_ranks');
			$rs = $m->add($data);
			if(false !== $rs){
				$rd['status']= 1;
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
		$m = M('user_ranks');
		$data = array();
		$data['rankName'] = I("rankName");
		$data['startScore'] = I("startScore");
		$data['endScore'] = I("endScore");
		$data['rebate'] = I("rebate");
		if($this->checkEmpty($data)){
			$rs = $m->where("rankId=".I('id'))->save($data);
			if(false !== $rs){
				$rd['status']= 1;
			}
		}
		return $rd;
	 } 
	 /**
	  * 获取指定对象
	  */
     public function get(){
	 	$m = M('user_ranks');
		return $m->where("rankId=".I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('user_ranks');
	 	$sql = "select * from __PREFIX__user_ranks order by rankId desc";
		$rs = $m->pageQuery($sql);
		return $rs;
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	    $m = M('user_ranks');
	     $sql = "select * from __PREFIX__user_ranks order by rankId desc";
		 $rs = $m->find($sql);
	  }
	  
	 /**
	  * 删除
	  */
	 public function del(){
	 	$rd = array('status'=>-1);
		$m = M('user_ranks');
	    $rs = $m->delete(I('id'));
		if($rs){
			$rd['status']= 1;
		}
		return $rd;
	 }
};
?>
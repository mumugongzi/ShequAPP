<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 角色服务类
 * ============================================================================
 */
use Think\Model;
class RolesModel extends BaseModel {
    /**
	  * 新增
	  */
	 public function add(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["roleName"] = I("roleName");
		$data["grant"] = I("grant");
		$data["createTime"] = date('Y-m-d H:i:s');
		$data["roleFlag"] = 1;
	    if($this->checkEmpty($data)){
			$m = M('roles');
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
	 	$m = M('roles');
		$m->roleName = I("roleName");
		$m->grant = I("grant");
	    if($this->checkEmpty($data)){
			$rs = $m->where("roleId=".$id)->save();
			if(false !== $rs){
				$rd['status']= 1;
				//实时更新当前用户权限
				if(session('WST_STAFF.staffRoleId')==$id)session('WST_STAFF.grant',explode(',',I("grant")));
			}
		}
		return $rd;
	 } 
	 /**
	  * 获取指定对象
	  */
     public function get(){
	 	$m = M('roles');
		return $m->where("roleId=".I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('roles');
	 	$sql = "select * from __PREFIX__roles order by roleId desc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('roles');
		 return $m->select();
	  }
	  
	 /**
	  * 删除
	  */
	 public function del(){
	 	$rd = array('status'=>-1);
	 	$m = M('roles');
	    $rs = $m->delete(I('id'));
		if(false !== $rs){
			$rd['status']= 1;
		}
		return $rd;
	 }
};
?>
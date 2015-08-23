<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 银行服务类
 * ============================================================================
 */
use Think\Model;
class BanksModel extends BaseModel {
    /**
	  * 新增
	  */
	 public function add(){
	 	$rd = array('status'=>-1);
		$data = array();
		$data["bankName"] = I("bankName");
		$data["bankFlag"] = 1;
		if($this->checkEmpty($data,true)){
			$m = M('banks');
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
	 	$id = (int)I("id",0);
	    
		$m = M('banks');
		$data["bankId"] = I("id");
		$data["bankName"] = I("bankName");
		if($this->checkEmpty($data)){	
			$rs = $m->where("bankId=".I('id'))->save($data);
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
	 	$m = M('banks');
		return $m->where("bankId=".I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('banks');
	 	$sql = "select * from __PREFIX__banks where bankFlag=1 order by bankId desc";
		$rs = $m->pageQuery($sql);
		return $rs;
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('banks');
		 $rs = $m->where('bankFlag=1')->select();
		 return $rs;
	  }
	  
	 /**
	  * 删除
	  */
	 public function del(){
	 	$rd = array('status'=>-1);
	 	$m = M('banks');
		$rs = $m->delete(I('id'));
		if($rs){
		   $rd['status']= 1;
		}
		return $rd;
	 }
};
?>
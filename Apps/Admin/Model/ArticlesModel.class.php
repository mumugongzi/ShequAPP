<?php
 namespace Admin\Model;
/**
 * ============================================================================
  * 文章服务类
 * ============================================================================
 */
use Think\Model;
class ArticlesModel extends BaseModel {
    /**
	  * 新增
	  */
	 public function add(){
	 	$rd = array('status'=>-1);
	 	$id = I("id",0);
		$data = array();
		$data["catId"] = I("catId");
		$data["articleTitle"] = I("articleTitle");
		$data["isShow"] = I("isShow",0);
		$data["articleContent"] = I("articleContent");
		$data["articleKey"] = I("articleKey");
		$data["staffId"] = (int)session('WST_STAFF.staffId');
		$data["createTime"] = date('Y-m-d H:i:s');
	    if($this->checkEmpty($data,true)){
			$m = M('articles');
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
		$data = array();
		$data["catId"] = I("catId");
		$data["articleTitle"] = I("articleTitle");
		$data["isShow"] = I("isShow",0);
		$data["articleContent"] = I("articleContent");
		$data["articleKey"] = I("articleKey");
		$data["staffId"] = (int)session('WST_STAFF.staffId');
	    if($this->checkEmpty($data,true)){	
			$m = M('articles');
		    $rs = $m->where("articleId=".I('id',0))->save($data);
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
	 	$m = M('articles');
		return $m->where("articleId=".I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
        $m = M('articles');
	 	$sql = "select a.articleTitle,a.articleId,a.isShow,a.createTime,c.catName,s.staffName
	 	    from __PREFIX__articles a,__PREFIX__article_cats c,__PREFIX__staffs s 
	 	    where a.catId=c.catId and a.staffId = s.staffId ";
	 	if(I('articleTitle')!='')$sql.=" and articleTitle like '%".I('articleTitle')."%'";
	 	$sql.=' order by articleId desc';
		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('articles');
	     $sql = "select * from __PREFIX__articles order by articleId desc";
		 $rs = $m->find($sql);
	  }
	  
	 /**
	  * 删除
	  */
	 public function del(){
	 	$rd = array('status'=>-1);
	    $m = M('articles');
	    $rs = $m->delete(I('id'));
		if(false !== $rs){
		   $rd['status']= 1;
		}
		return $rd;
	 }
	 /**
	  * 显示分类是否显示/隐藏
	  */
	 public function editiIsShow(){
	 	$rd = array('status'=>-1);
	 	if(I('id',0)==0)return $rd;
	 	$m = M('articles');
	 	$m->isShow = (I('isShow')==1)?1:0;
	 	$rs = $m->where("articleId=".I('id',0))->save();
	    if(false !== $rs){
			$rd['status']= 1;
		}
	 	return $rd;
	 }
};
?>
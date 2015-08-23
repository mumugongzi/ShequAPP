<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 * 登录日志控制器
 * ============================================================================
 */
class LogLoginsAction extends BaseAction{
   /**
	 * 查看
	 */
	public function toView(){
		$this->isLogin();
		$this->checkPrivelege('dlrz_00');
		$m = D('Admin/LogLogins');
		if(I('id')>0){
			$object = $m->get();
			$this->assign('object',$object);
		}
		$this->view->display('/loglogins/view');
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
		$this->checkPrivelege('dlrz_00');
		$m = D('Admin/LogLogins');
    	$page = $m->queryByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize']);
    	$page['pager'] = $pager->show();
    	$this->assign('Page',$page);
    	$this->assign('startDate',I('startDate',date('Y-m-d')));
    	$this->assign('endDate',I('endDate',date('Y-m-d')));
        $this->display("/loglogins/list");
	}
};
?>
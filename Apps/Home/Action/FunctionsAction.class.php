<?php
namespace Home\Action;
/**
 * 功能函数控制器
 */
class FunctionsAction extends BaseAction {
    
	
	
	/**
	 * 用户登录验证
	 */
	public function checkLogin(){
		$rv = array('status'=>-1);
		$loginName = I('loginName');
		$userPwd = I('loginPwd');
		//$rememberPwd = I('rememberPwd');
		$sql ="SELECT * FROM __PREFIX__users WHERE (loginName='".$loginName."' OR userEmail='".$loginName."' OR userPhone='".$loginName."') AND userFlag=1 and userStatus=1 ";
		$rss = $this->query($sql);
		if(!empty($rss)){
			$rs = $rss[0];
			if($rs['loginPwd']!=md5($userPwd.$rs['loginSecret']))return $rv;
			if($rs['userFlag'] == 1 && $rs['userStatus']==1){
				$data = array();
				$data['lastTime'] = date('Y-m-d H:i:s');
				//$data['lastIP'] = get_client_ip();
				$m = M('users');
		    	$m->where(" userId=".$rs['userId'])->data($data)->save();
		    	//如果是店铺则加载店铺信息
		    	if($rs['userType']>=1){
		    		$s = M('shops');
			 		  $shops = $s->where('userId='.$rs['userId']." and shopFlag=1")->find();
			 		  if(!empty($shops))$rs = array_merge($shops,$rs);
		    	}
		    	//记录登录日志
				$data = array();
				$data["userId"] = $rs['userId'];
				$data["loginTime"] = date('Y-m-d H:i:s');
				//$data["loginIp"] = get_client_ip();
				M('log_user_logins')->add($data);
			}
			$rv = $rs;
			//setcookie("loginName", $loginName, time()+3600*24*60);
			/*if($rememberPwd == "on"){			
				setcookie("loginPwd", $userPwd, time()+3600*24*60);
			}else{		
				setcookie("loginPwd", "", time()-3600);
			}*/
		}
		return $rv;
	}



	


	
    
}
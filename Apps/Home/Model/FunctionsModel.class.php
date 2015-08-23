<?php
namespace Home\Model;
/**
 * 功能函数
 */
class FunctionsModel extends BaseModel {
    
	
	
	/**
	 * 用户登录验证
	 */
	public function checkLogin($s){
		$rv = array('status'=>-1);
		$loginName = I('s');
		echo'name';
		dump($loginName);
		echo 'pwd';
		dump($loginPwd);
		$userPwd = I('loginPwd');
		//$rememberPwd = I('rememberPwd');
		$sql ="SELECT * FROM __PREFIX__users WHERE (loginName='".$loginName."' OR userEmail='".$loginName."' OR userPhone='".$loginName."') AND userFlag=1 and userStatus=1 ";
		$rss = $this->query($sql);
		echo'rss';
		dump($rss);
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


	/**
	 * 获取订单商品信息
	 */
	public function getOrdersGoods($obj){	
			
		$orderId = $obj;
		
		$sql = "SELECT g.*,og.goodsNums as goodsNums,og.goodsPrice as goodsPrice 
				FROM __PREFIX__order_goods og, __PREFIX__goods g 
				WHERE og.orderId = $orderId AND og.goodsId = g.goodsId ";		
		$rs = $this->query($sql);	
		
		return $rs;
		
	}
	
	/**
	 * 
	 * 获取订单商品详情
	 */
	public function getOrdersGoodsDetails($obj){	
			
		$orderId = $obj["orderId"];
		$sql = "SELECT g.*,og.goodsNums as ogoodsNums,og.goodsPrice as ogoodsPrice ,ga.id as gaId
				FROM __PREFIX__order_goods og, __PREFIX__goods g 
				LEFT JOIN __PREFIX__goods_appraises ga ON g.goodsId = ga.goodsId AND ga.orderId = $orderId
				WHERE og.orderId = $orderId AND og.goodsId = g.goodsId";		
		$rs = $this->query($sql);	
		return $rs;
		
	}
	

	/**
	 * 
	 * 获取短信验证码
	 */

	public function sendSMS(){
        //初始化必填
        
		$options['accountsid']='d2803ccc3d9e01bee1411fffa470c82e';
		$options['token']='18114fb11ec0750bb1fb04a7040685c5';
        //初始化 $options必填
        $ucpass = new \Org\Com\Ucpaas($options);
                
                //随机生成4位验证码
        srand((double)microtime()*10000);//create a random number feed.
        $ychar="0,1,2,3,4,5,6,7,8,9";
        $list=explode(",",$ychar);
        for($i=0;$i<4;$i++){
        $randnum=rand(0,9); // 10+26;
        $authnum.=$list[$randnum];
        }
        //短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
        
		$appId = "56f7b0c480fd4312ba0786ddcb55cd0b";
		//$to = "18410006007";
		//$to = "13070161613";
		//$to = "13070161631";
		$to = I('userPhoneNumber');
		//dump($to);
		
		$templateId = "11882";
		$param=$authnum;
		
		//dump($authnum);
        $arr=$ucpass->templateSMS($appId,$to,$templateId,$param);
        //$obj=json_decode($arr,true); 
        //dump($obj["resp"]["templateSMS"]["smsId"]);
               
    }

    public function send($userPhoneNumber,$phoneVerify){

        //初始化必填
        $options['accountsid']='86597d32066008befb5479550f5152e6';
		$options['token']='c3cd1162a0b6caa75a836df899f71ba2';
		/*$options['accountsid']='d2803ccc3d9e01bee1411fffa470c82e';
		$options['token']='18114fb11ec0750bb1fb04a7040685c5';*/
        //初始化 $options必填
        $ucpass = new \Org\Com\Ucpaas($options);
                
                //随机生成4位验证码
        srand((double)microtime()*10000);//create a random number feed.
        $ychar="0,1,2,3,4,5,6,7,8,9";
        $list=explode(",",$ychar);
        for($i=0;$i<4;$i++){
        $randnum=rand(0,9); // 10+26;
        $authnum.=$list[$randnum];
        }
        //短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
        $appId = "9d14a5cfc8334ee6b3fbdbfff02f6514";
		//$appId = "56f7b0c480fd4312ba0786ddcb55cd0b";
		//$to = "18410006007";
		//$to = "13070161613";
		//$to = "13070161631";
		//$to = I('userPhoneNumber');
		$to = $userPhoneNumber;
		$phoneVerify = $phoneVerify;
		//dump($phoneVerify);
		//$phoneVerifyCode = 5555;
		$pvc = empty($phoneVerify)?$authnum:$phoneVerify;
		//dump(isset($_POST['phoneVerify']));
		//dump($authnum);
		//dump($pvc);

		//dump($to);
		$templateId = "6492";
		//$templateId = "11882";
		//$param=$authnum;
		$param="ninhao,".$pvc;
		//dump($authnum);
        $arr=$ucpass->templateSMS($appId,$to,$templateId,$param);
        //dump($arr);
        //return $arr;
        $obj=json_decode($arr,true); 

        //dump($obj["resp"]["respCode"]);
        return $obj["resp"]["respCode"];
          
    }
    


	
    
}
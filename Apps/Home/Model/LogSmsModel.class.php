<?php
namespace Home\Model;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 短信服务类
 */
class LogSmsModel extends BaseModel {
	/**
	 * 插入并发送短讯记录
	 */
	public function sendSMS($smsSrc,$phoneNumber,$content,$smsFunc,$smsCode){
		$rv = array('status'=>-1);
		
		
		$USER = session('WST_USER');
		$userId = empty($USER)?0:$USER['userId'];
		//dump($userId);
		$m = M('log_sms');
		//检测是否超过每日短信发送数
		$date = date('Y-m-d');
		$rsCount = $m->where('smsPhoneNumber=%s and createTime>"%s 00:00:00" and createTime<="%s 23:59:59"',array($phoneNumber,$date,$date))->getField("count(smsId) counts");
		//dump($rsCount);
		//dump($GLOBALS['CONFIG']['smsLimit']['fieldValue']);
		if($rsCount<(int)$GLOBALS['CONFIG']['smsLimit']['fieldValue']){
			
			//$code = WSTSendSMS($phoneNumber,$content);
			$msms = D('Functions');
			$code =$msms->send($phoneNumber,$smsCode);
			//dump($code);
			if($code == 000000){
			$rv['status'] = 1;
				}
			
			$data = array();
			$data['smsSrc'] = $smsSrc;
			$data['smsUserId'] = $userId;
			$data['smsPhoneNumber'] = $phoneNumber;
			$data['smsContent'] = $content;
			$data['smsReturnCode'] = $code;
			$data['smsCode'] = $smsCode;
			$data['smsFunc'] = $smsFunc;
			$data['createTime'] = date('Y-m-d H:i:s');
			$m->add($data);
			//$rv['status'] = ($code==1)?1:-1;

			//$rv['status'] = 1;
		}else{
			$rv = array('status'=>-2);
		}
		return $rv;
	}

	
}
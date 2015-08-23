<?php
namespace Home\Model;
/**
 * 友情连接服务类
 */
class FriendlinksModel extends BaseModel {
	/**
     * 获取友情链接
     */
	public function getFriendlinks(){
		return $this->cache('WST_CACHE_FRIENDLINK_000',areaId3,31536000)->order('friendlinkSort asc')->select();
	}
}
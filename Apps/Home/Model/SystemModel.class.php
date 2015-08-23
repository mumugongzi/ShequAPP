<?php
namespace Home\Model;
/**
 * 系统服务类
 */
class SystemModel extends BaseModel {
	protected $tableName = 'sys_configs'; 
    /**
     * 获取商城配置文件
     */
	public function loadConfigs(){
		$sql = "select * from __PREFIX__sys_configs order by parentId asc,fieldSort asc";
		$rs = $this->query($sql);
		$configs = array();
		if(count($rs)>0){
			foreach ($rs as $key=>$v){
				$configs[$v['fieldCode']] = $v;
			}
		}
		unset($rs);
		return $configs;
	}
	/**
	 * 获取商品配置分类信息
	 */
    public function loadConfigsForParent(){
		$sql = "select * from __PREFIX__sys_configs where fieldType!='hidden' order by parentId asc,fieldSort asc";
		$rs = $this->query($sql);
		$configs = array();
		if(count($rs)>0){
			foreach ($rs as $key=>$v){
				if($v['fieldType']=='radio' || $v['fieldType']=='select'){
					$v['txt'] = explode('||',$v['valueRangeTxt']);
					$v['val'] = explode(',',$v['valueRange']);
				}
				$configs[$v['parentId']][] = $v;
			}
		}
		unset($rs);
		return $configs;
	}
}
<?php
namespace App\Api;

/**
 * 1.2 会员反馈接口
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class MemberAdvise extends BaseApi {

  public function getRules() {
  
    return $this->rules([
    
      'create' => [
      
        'member_id' => 'member_id|int|true||会员id',
        'advise' => 'advise|string|true||会员意见'
      
      ],

      'listQuery' => [
      
        'member_name' => 'member_name|string|false||会员名称',
        'sex' => 'sex|int|false||性别',
        'fields' => 'fields|string|false||字段',
        'order' => 'order|string|false||排序',
        'page' => 'page|int|false||页码',
        'page_size' => 'page_size|int|false||每页条数'
      
      ]
    
    ]);
  
  }

  /**
   * 新建反馈意见
   * @desc 新建反馈意见
   *
   * @return int id
   */
  public function create() {
  
    return $this->dm->create($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询反馈列表
   * @desc 查询反馈列表
   *
   * @return array list
   */
  public function listQuery() {
  
    return $this->dm->listQuery($this->retriveRuleParams(__FUNCTION__));
  
  }


}

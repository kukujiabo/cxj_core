<?php
namespace App\Model;

/**
 * 【模型层】用户评论关联视图
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-24
 */
class MemberComment extends BaseModel {

  protected $_table = 'v_member_comment';

  protected $_queryOptionRule = [
  
    'root_id' => 'in' 

  ];

}

<?php
namespace App\Model;

/**
 * 专辑
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-05
 */
class Album extends BaseModel {

  protected $_queryOptionRule = [
  
    'title' => 'like',

    'id' => 'in',

    'member_id' => 'in',

    'author_id' => 'range'
  
  ];

}

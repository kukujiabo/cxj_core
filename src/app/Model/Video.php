<?php
namespace App\Model;

/**
 * 视频
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-05
 */
class Video extends BaseModel {

  protected $_queryOptionRule = [
  
    'title' => 'like',

    'id' => 'in',

    'created_at' => 'range',

    'sort' => 'range',

    'times' => 'range',

    'brief' => 'like'
  
  ];

}

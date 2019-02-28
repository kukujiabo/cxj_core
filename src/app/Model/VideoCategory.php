<?php
namespace App\Model;

/**
 * 视频分类
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-03
 */
class VideoCategory extends BaseModel {

  protected $_queryOptionRule = [
  
    'name' => 'like',

    'id' => 'in'
  
  ];

}

<?php
namespace App\Service\Resource;

use App\Service\Crm\MemberSv;
use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 图片资源服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-31
 */
class ImageSv extends BaseService {

  use CurdSv;

  public function addImageResource($imgId, $url, $module, $relatId = '', $base64 = '') {

    $newImg = array(
    
      'img_id' => $imgId,

      'url' => $url,

      'module' => $module,

      'relat_id' => $relatId,

      'base64' => $base64,

      'created_at' => date('Y-m-d H:i:s')
    
    );
  
    $imgId = $this->add($newImg);
  
    switch($module) {
    
      case 1:

        $this->updateMemberPortrait($relatId, $url);

      break;
    
      case 2:

      break;
    
    }
    
    return $imgId;
  
  }

  /**
   * 批量添加图片资源
   *
   * @param array rs
   * @param int module
   * @param int relatId
   *
   * @return int num
   */
  public function batchCreate($rs, $module, $relatId) {
  
    $newImages = [];

    foreach($rs as $r) {
    
      $newImg = array(
      
        'img_id' => $r['img_id'] ? $r['img_id'] : md5(time() . rand(10000, 99999)),

        'url' => $r['url'],

        'module' => $module,

        'relat_id' => $relatId,

        'created_at' => date('Y-m-d H:i:s')
      
      );

      array_push($newImages, $newImg);
    
    }
  
    return $this->batchAdd($newImages);
  
  }

  /**
   * 批量删除图片资源
   *
   * @param int relatId
   * @param int module
   *
   * @return int num
   */
  public function batchDelete($module, $relatId) {
  
    return $this->batchRemove(array('relat_id' => $relatId, 'module' => $module));
  
  }

  /**
   * 更新用户头像信息
   *
   * @param int $id
   * @param string $url
   *
   * @return
   */
  public function updateMemberPortrait($id, $url) {
  
    $msv = new MemberSv();

    $msv->editMember($id, array('portrait' => $url));
  
  }

}

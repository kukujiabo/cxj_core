<?php
namespace App\Service\Components\Wechat;

use App\Library\Http;
use App\Service\Components\Qiniu\QiniuSv;

/**
 * 微信工具类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class WechatTools {

  /**
   * 获取微信 获取小程序码（临时场景）
   *
   * @param string accessToken
   *
   * @return string bytes of image
   */
  public function getMiniTempCode($accessToken, $scene, $page, $width, $autoColor, $lineColor, $hyaline) {
  
    $url = str_replace( '{ACCESS_TOKEN}', $accessToken, WechatApi::GET_SMALL_PROGRAM_TEMPORARY_CODE );

    if (!isset($autoColor)) {
    
      $autoColor = true;
    
    }
    if (!$lineColor) {
    
      $lineColor = [ 'r' => 0, 'g' => 0, 'b' => 0 ];
    
    }
    if (!isset($hyaline)) {
    
      $hyaline = true;
    
    }

    $data = [
    
      'scene' => $scene,

      'path' => $page,

      'width' => $width,

      'auto_color' => $autoColor,

      'line_color' => $lineColor,

      'is_hyaline' => $hyaline
    
    ];

    $params = json_encode($data);
  
    $stream = Http::httpPost($url, $params, null, null, null, 'raw');

    return $stream;
  
  }


}

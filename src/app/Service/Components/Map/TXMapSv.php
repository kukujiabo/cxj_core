<?php
namespace App\Service\Components\Map;

use App\Service\System\ConfigSv;
use App\Library\Http;

class TXMapSv {

  /**
   * 根据地址获取坐标
   *
   */
  public function getQqAddress($address) {

    $config = new ConfigSv();

    $qq_key = $config->getConfig('qq_key');

    $origin_uri = \PhalApi\DI()->config->get('qq.get_coordinate_uri');

    $origin_uri = str_replace('{ADDRESS}', $address, $origin_uri);

    $origin_uri = str_replace('{KEY}', $qq_key, $origin_uri);

    $result = Http::httpGet($origin_uri);

    return json_decode($result, true);

  }

  /**
   * 根据坐标获取地址
   *
   */
  public function getQqLocation($lat, $lng) {
  
    $config = new ConfigSv();

    $qq_key = $config->getConfig('qq_key');

    $origin_uri = \PhalApi\DI()->config->get('qq.get_address_uri');

    $origin_uri = str_replace('{LAT}', $lat, $origin_uri);

    $origin_uri = str_replace('{LNG}', $lng, $origin_uri);

    $origin_uri = str_replace('{KEY}', $qq_key, $origin_uri);

    $result = Http::httpGet($origin_uri);

    return json_decode($result, true);
  
  }

  /**
   * 计算坐标距离
   */
  public function getOneToManyDistance($from, $to) {
  
    $config = new ConfigSv();

    $qq_key = $config->getConfig('qq_key');

    $origin_uri = \PhalApi\DI()->config->get('qq.get_distance_uri');

    $origin_uri = str_replace('{FROM}', $from, $origin_uri);

    $origin_uri = str_replace('{TO}', $to, $origin_uri);

    $origin_uri = str_replace('{KEY}', $qq_key, $origin_uri);

    $result = Http::httpGet($origin_uri);

    return json_decode($result, true);
  
  }

}

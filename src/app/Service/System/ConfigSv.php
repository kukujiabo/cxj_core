<?php
namespace App\Service\System;

use App\Service\BaseService;
use App\Model\Config;
use Core\Service\CurdSv;
use Qiniu\Auth;

/**
 * 配置服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class ConfigSv extends BaseService {

  public static $configValues = array();

  use CurdSv;

  /**
   * 根据key读取配置
   *
   * return string $value
   */
  public function getConfig($kname) {
  
    if (self::$configValues[$kname]) {
    
      return self::$configValues[$kname];

    }

    $config = $this->findOne(array('k_name' => $kname));

    if ($config) {

      self::$configValues[$kname] = $config['val'];
 
      return $config['val'];
    
    } else {
    
      return null;

    }

  }

  /**
   *  编辑配置
   *
   * @param string $accessKey
   * @param string $accessSecret
   *
   * @return boolean $id
   */
  public function editConfig($module, $subModule, $kname, $value, $title = '') {

    $config = $this->findOne(array('k_name' => $kname));

    if (!$config) {
    
      $newConf = [

        'module' => $module,

        'sub_module' => $subModule,

        'k_name' => $kname,
      
        'val' => $value,

        'title' => $title,

        'created_at' => date('Y-m-d H:i:s')
      
      ];

      return $this->add($newConf);
      
    } else {

      return $this->update($config['id'], array('val' => $value));
    
    }
  
  }


}


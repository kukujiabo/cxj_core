<?php
namespace App\Common\Filter;

use PhalApi\Filter;
use App\Library\RedisClient;
use App\Exception\AuthException;
use App\Exception\ErrorCode;

/**
 * 请求鉴权过滤器
 *
 * @author Meroc chen <398515393@qq.com> 2017-12-02
 */
class AuthFilter implements Filter {

    /**
     * 权限校验
     */
    public function check() {

       if ($this->whiteList(\PhalApi\DI()->request->get('service'))) {
       
         return;
       
       }

       $headers = array(); 

       foreach ($_SERVER as $key => $value) { 

         if ('HTTP_' == substr($key, 0, 5)) { 

           $headers[str_replace('_', '-', substr($key, 5))] = $value; 

         } 

       }

    }

    /**
     * 检查白名单，白名单接口放行
     *
     * @param string $service
     *
     * @return boolean true/false
     */
    protected function whiteList($service) {

      $whiteList = \PhalApi\DI()->config->get('app.service_whitelist');

      return in_array($service, $whiteList);
    
    }

}


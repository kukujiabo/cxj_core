<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

class MemberLoginLogSv extends BaseService {
	
	use CurdSv;

	public function create($memberId, $type, $first, $op, $scene) {

		$newLog = [

			'login_at' => date('Y-m-d H:i:s'),

			'login_type' => $type,

			'first' => $first,

			'scene' => $scene,

			'member_id' => $memberId

		];

		if ($op['share_code']) {

			$newLog['share_code'] = $op['share_code'];

			$newLog['resource_type'] = 2;

		} elseif ($op['scene']) {

      $prefix = substr($op['scene'], 0, 3);

      $key = str_replace($prefix, '', $op['scene']);

      if ($prefix == 'shc') {

        $newLog['share_code'] = $key ;

        $newLog['resource_type'] = 3;

      } elseif ($prefix == 'rid') {

        $newLog['relat_id'] = $key;

        $newLog['resource_type'] = 4;

      } elseif ($prefix == 'shp') {

        $newLog['relat_id'] = $key ;

        $newLog['resource_type'] = 5;

      }

		} else {

			$newLog['resource_type'] = 1;

		}

		return $this->add($newLog);

	}


	public function getInfoList($data) {

		$query = [];

		if($data['member_name']) {

			$query['member_name'] = $data['member_name'];

		}

		$logInfoSv = new VMemberLoginInfoSv();

		return $logInfoSv->queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);

	}

}
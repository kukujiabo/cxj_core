<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Library\RedisClient;
use Core\Service\CurdSv;

class MemberLabelSv extends BaseService {
		
	use CurdSv;

	public function batchCreate($options) {

		$labelIds = explode(',', $options['label_ids']);

		$datas = [];

		foreach($labelIds as $labelId) {

			$data = [

				'member_id' => $options['member_id'],

				'label_id' => $labelId,

				'created_at' => date('Y-m-d H:i:s')

			];

			array_push($datas, $data);

		}

		$this->batchRemove([ 'member_id' => $options['member_id'] ]);

		$result = $this->batchAdd($datas);

		if ($result) {

    	$key = md5("member_detail_{$options['member_id']}");

    	RedisClient::set('member_infos', $key, '');		

		}

		return $result;

	}


	public function getAll($options) {

		$query = [];

		if ($options['member_id']) {

			$query['member_id'] = $options['member_id'];

		}
		if ($options['label_id']) {

			$query['label_id'] = $options['label_id'];

		}

		return $this->all($query);

	}


}
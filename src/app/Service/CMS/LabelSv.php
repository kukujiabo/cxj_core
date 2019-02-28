<?php
namespace App\Service\CMS;

use App\Service\BaseService;
use Core\Service\CurdSv;

class LabelSv extends BaseService {
	
	use CurdSv;

	public function getAll($options) {

		$query = [];

		if ($options['cata']) {

			$query['cata'] = $options['cata'];

		}

		return $this->all($query);

	}

}
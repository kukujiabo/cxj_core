<?php
namespace App\Api;

/**
 * 8.1 标签接口
 */
class Label extends BaseApi {
	
	public function getRules() {

		return $this->rules([

 			'getAll' => [

 				'cata' => 'cata|int|false||标签分类'

 			]

		]);

	}

	/**
	 * 查询全部标签
	 * @查询全部标签
	 *
	 * @return array data
	 */
	public function getAll() {

		return $this->dm->getAll($this->retriveRuleParams(__FUNCTION__));

	}

}
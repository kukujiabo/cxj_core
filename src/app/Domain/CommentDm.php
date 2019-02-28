<?php
namespace App\Domain;

use App\Service\CMS\CommentSv;

/**
 * 评论处理域
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-24
 */
class CommentDm {

  protected $_csv;

  public function __construct() {
  
    $this->_csv = new CommentSv();
  
  }

  /**
   * 添加评论
   * 
   * @param array options
   * @param int memberId
   * @param int module
   * @param int objectId
   * @param int rootId
   * @param int replyTo
   * @param string content
   *
   * @return int id
   */
  public function create($options) {
  
    return $this->_csv->create($options);
  
  }

  /**
   * 根据评论对象id获取评论列表
   *
   * @param int objectId
   * @param int module
   * @param int page
   * @param int pageSize
   *
   * @return array list
   */
  public function getDetail($options) {
  
    return $this->_csv->getDetail($options);
  
  }

  /**
   * 用户评论列表
   *
   * @param array options
   *
   * @return array list
   */
  public function getList($options) {
  
    return $this->_csv->getList($options);
  
  }

  /**
   * 用户评论列表
   *
   * @param array options
   *
   * @return array list
   */
  public function remove($options) {

    return $this->_csv->remove($options['id']);

  }

}

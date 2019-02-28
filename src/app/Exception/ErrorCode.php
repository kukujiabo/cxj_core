<?php
namespace App\Exception;

/**
 * 错误码定义
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-22
 */
class ErrorCode {

  /**
   * MemberSv
   */
  public $APMISCODE = '100001';
  
  public $APMISMSG = '账号和密码不匹配！';

  public $AEPTCODE = '100002';

  public $AEPTMSG = '账户不存在！';

  public $RGEPTACCTCODE = '100003！';

  public $RGEPTACCTMSG = '账户名不可为空！';

  public $WOLDPASSCODE = '100004';

  public $WOLDPASSMSG = '旧密码错误！';

  /**
   * MobileVerifyCodeSv
   */
  public $VRCODEEPCODE = '200001';

  public $VRCODEEPMSG = '验证码不能为空！';

  public $VRMOBILEEPTCODE = '200002';

  public $VRMOBILEEPTMSG = '手机号不能为空！';

  public $VMTIMECODE = '200003';

  public $VRMOBILWRONGCODE = '200004';

  public $VRMOBILWRONGMSG = '验证码错误或已失效，请重新发送！';

  /**
   * AuthorSv
   */
  public $AUDITTINGCODE = '300001';

  public $AUDITTINGMSG = '信息在审核中！';

  public $AUEXISTCODE = '300002';

  public $AUEXISTMSG = '该用户已经是作者了！';

  /**
   * AlbumSv
   */
  public $NOTAUTHORCODE = '400001';

  public $NOTAUTHORMSG = '不是作者！';

  public $ABNOTFOUNDCODE = '400002';

  public $ABNOTFOUNDMSG = '专辑不存在！！';
    
  /**
   * COMMON
   */
  public $NOMEMCODE = '111101';

  public $NOMEMMSG = '找寻不到会员！';

  /**
   * SUBMAIL
   */
  public $TMPIDMISSCODE = '500001';

  public $TMPIDMISSMSG = '模版id不能为空！';

  /**
   * VIDEO
   */
  public $VDMISSCODE = '600001';

  public $VDMISSMSG = '视频不存在！';

  public $VDEMPTYCODE = '600002';

  public $VDEMPTYMSG = '更新内容不能为空！';

  /**
   * 赠品操作
   */
  public $CHECKCODEINVALIDMSG = '核销码错误！';

  public $CHECKCODEINVALIDCODE = '110001';

  public $CHECKINVALIDREWARDMSG = '无效的赠品！';

  public $CHECKINVALIDREWARDCODE = '110002';


  /**
   * 
   */
  public $ORIGINREWARDEXISTMSG = '已经领取了原始赠品';

  public $ORIGINREWARDEXISTCODE = '120001';

  /**
   * 微信解密错误
   */
  public $DECRYPTEDFAILEDCODE = '900001';

}

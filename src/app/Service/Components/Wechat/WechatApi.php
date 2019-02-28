<?php
namespace App\Service\Components\Wechat;

class WechatApi {

  CONST WECHATPAY_EXPIRE       = '60'; // 微信支付请求超时时间

  CONST WECHAT_PAY_NOTIFY_URL  = 'http://wxapi.txrt.cn/App/Pay/wechatPayNotify'; //微信支付回调地址

  CONST WECHAT_PAY_IP          = '139.196.175.163'; //微信支付IP，仅对于扫码支付需要配置

  CONST WECHAT_UNIFIED_PAY     = 'https://api.mch.weixin.qq.com/pay/unifiedorder'; //微信统一支付地址

  CONST WECHAT_CODE            = 'weixin://wxpay/bizpayurl?appid={APPID}&mch_id={MID}&nonce_str={STR}&product_id={PRODUCT}&time_stamp={TIME}&sign={SIGN}';
  
  CONST DEVELOPER_WECHAT_ACCESS_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid={APPID}&secret={APPSECRET}&code={CODE}&grant_type=authorization_code'; // app  微信获取 access_token 地址

  CONST DEVELOPER_WECHAT_ONER_USER_INFO = 'https://api.weixin.qq.com/sns/userinfo?access_token={ACCESS_TOKEN}&openid={OPENID}'; // app  微信获取账户信息
  
  // 静默授权
  CONST BASE_CODE_URI = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid={APPID}&redirect_uri={REDIRECT_URI}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
  // 用户手动同意
  CONST USER_INFO_CODE_URI = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid={APPID}&redirect_uri={REDIRECT_URI}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
  // 获取微信用户的access_token openid
  CONST USER_ACCESS_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid={APPID}&secret={APPSECRET}&code={CODE}&grant_type=authorization_code';
  // 获取用户信息
  CONST SNS_API_USER_INFO = 'https://api.weixin.qq.com/sns/userinfo?access_token={ACCESS_TOKEN}&openid={OPENID}&lang={LANG}';
  // 刷新微信用户的access_token
  CONST GET_ACCESS_TOKENS = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={APPID}&grant_type=refresh_token&refresh_token={REFRESH_TOKEN}';
  // 验证access_token是否有效
  CONST verify_SUBSCRIBE = 'https://api.weixin.qq.com/sns/auth?access_token={ACCESS_TOKEN}&openid={OPENID}';
  // 获取 access_token 基础授权
  CONST GET_ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={APPID}&secret={APPSECRET}';
  // 获取关注用户的信息
  CONST GET_SUBSCRIBE = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token={ACCESS_TOKEN}&openid={OPENID}&lang={zh_CN}';
  // 获取api_ticket
  CONST GET_JSAPI_TICKET = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={ACCESS_TOKEN}&type=jsapi';
  // 公众号推送请求连接
  CONST WECHAT_PUSH = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={ACCESS_TOKEN}';
  // 微信公众号模版ID
  CONST TEMPLATE_ID = 'jRwnIztE13nztcqoXFd8AwhJLkXe_4iqpN6aGnzXMD0';
  // 小程序 code 换取 session_key 和 openid 接口地址
  CONST GET_MIN_OPENID = 'https://api.weixin.qq.com/sns/jscode2session?appid={APPID}&secret={APPSECRET}&js_code={CODE}&grant_type=authorization_code';
  
  // 获取小程序码（永久有效，数量有限制）
  CONST GET_SMALL_PROGRAM_CODE = 'https://api.weixin.qq.com/wxa/getwxacode?access_token={ACCESS_TOKEN}';
  // 获取小程序码（永久有效，临时使用的业务场景）
  CONST GET_SMALL_PROGRAM_TEMPORARY_CODE = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={ACCESS_TOKEN}';
  // 获取小程序二维码（适用于需要的码数量较少的业务场景）
  CONST GET_SMALL_PROGRAM_QR_CODE = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token={ACCESS_TOKEN}';
  // 获取TICKET
  CONST GET_TICKET = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={TOKENPOST}';
  // 获取带参数的二维码
  CONST GET_QR_CODE = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={TICKET}';
  // 上传商户图标至微信服务器
  CONST UPLOADING_LOGO = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token={ACCESS_TOKEN}';
  //创建公众号菜单
  CONST CREATE_WPS_MENU = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={ACCESS_TOKEN}";
  
  CONST GET_WPS_MENU = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token={ACCESS_TOKEN}';
  // 获取微信素材
  CONST GET_MATERIAL = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token={ACCESS_TOKEN}';
  
  CONST GET_PRIMARY_TEMPLATES = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={ACCESS_TOKEN}';

  CONST GET_TEMPLATE_ID = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token={ACCESS_TOKEN}';

  CONST SEND_MINI_TMP_MSG = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token={ACCESS_TOKEN}';

}

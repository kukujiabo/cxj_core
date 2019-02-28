create table `admin` (
  `id` int auto_increment comment '数据行序号',
  `mobile` varchar(11) not null comment '手机号',
  `password` varchar(20) not null comment '密码',
  `admin_name` varchar(20) default null comment '管理员名称',
  `email` varchar(100) default null comment '管理员邮箱',
  `sex` int(4) default 3 comment '会员性别：1.男，2.女，3.保密',
  `protrait` varchar(500) default null comment '管理员头像',
  `wx_pbopenid` varchar(50) default null comment '微信公众号openid',
  `wx_unionid` varchar(50) default null comment '微信unionid',
  `wx_mnopenid` varchar(50) default null comment '微信小程序openid',
  `state` int(4) default 1 comment '管理员状态：1.有效，0.禁用',
  `last_login_time` datetime default null comment '最后登录时间',
  `created_at` datetime default null comment '创建时间',
  `updated_at` timestamp default current_timestamp comment '信息更新时间',
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='管理员表';

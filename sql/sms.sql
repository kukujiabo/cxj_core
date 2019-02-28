create table `sms` (
  `id` int auto_increment,
  `tmp_id` varchar(10) comment '短信模版id',
  `content` varchar(200) comment '发送内容',
  `mobile` varchar(11) comment '手机号',
  `state` int(4) comment '短信状态：0:待发送，1.发送成功，-1.发送失败',
  `err_msg` varchar(200) comment '发送失败报错信息',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='短信表';


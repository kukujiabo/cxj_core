create table `user_point` (
  `id` int auto_increment,
  `uid` int comment '用户id',
  `bid` int comment '商户id',
  `point` int comment '积分',
  `symbol` int comment '增减',
  `ptype` int comment '积分类型',
  `remark` varchar(200) comment '备注',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp,
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='用户积分表';

create table `account` (
  `id` int auto_increment,
  `uid` int comment '用户id',
  `bid` int comment '商户id',
  `point` int comment '积分',
  `money` float comment '金额',
  `created_at` datetime comment '备注',
  `updated_at` timestamp default current_timestamp,
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='用户积分表';

create table `reward` (
  `id` int auto_increment,
  `reward_name` varchar(50) not null comment '赠品名称',
  `thumbnail` varchar(200) not null comment '赠品图标',
  `brief` varchar(200) not null comment '赠品简介',
  `shop_id` int not null comment '赠品所属门店',
  `status` int default 1 comment '赠品有效状态：1.有效，2.无效',
  `start_time` datetime comment '活动开始时间',
  `end_time` datetime comment '活动结束时间',
  `created_at` datetime not null comment '创建时间',
  `updated_at` timestamp default current_timestamp comment '更新时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='赠品表';

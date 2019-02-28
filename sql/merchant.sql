drop table if exists `merchant`;
create table `merchant` (
  `id` int auto_increment,
  `mcode` varchar(9) comment '商户号',
  `mname` varchar(100) comment '商户名称',
  `brief` varchar(200) comment '商户简介',
  `image_text` text comment '图文详情',
  `thumbnail` varchar(200) comment '头像', 
  `ext_1` varchar(200) comment '预留字段1',
  `ext_2` varchar(200) comment '预留字段2',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp comment '更新时间',
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='商户表';


drop table if exists `shop`;
create table `shop` (
  `id` int auto_increment,
  `mid` int comment '商户id',
  `shop_name` varchar(100) comment '门店名称',
  `thumbnail` varchar(200) comment '头像',
  `brief` varchar(200) comment '简介',
  `image_text` text comment '图文详情',
  `shop_address` varchar(200) comment '门店地址',
  `latitude` double comment '维度',
  `longitude` double comment '经度',
  `ext_1` varchar(200) comment '预留字段1',
  `ext_2` varchar(200) comment '预留字段2',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp comment '更新时间',
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='门店表';


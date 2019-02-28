create table `commodity_image` (
  `id` int auto_increment,
  `commodity_id` int not null comment '商品id',
  `module` int not null comment '商品所属模块',
  `sort` int not null comment '图片排序',
  `status` int not null comment '图片状态：1.可用，0.不可用',
  `created_at` datetime not null comment '创建时间',
  `updated_at` timestamp default current_timestamp comment '更新时间',
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='商品图片表';

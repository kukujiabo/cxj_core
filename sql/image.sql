create table `image` (
  `id` int auto_increment,
  `img_id` varchar(50) not null,
  `url` varchar(500) comment '图片地址',
  `base64` text comment '图片base64编码', 
  `module` int default 0 comment '所属模块',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp,
  primary key(`id`),
  unique(`img_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='图片表';

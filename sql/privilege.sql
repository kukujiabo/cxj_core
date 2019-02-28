create table `service` (
  `id` int auto_increment,
  `service_name` varchar(50) comment '服务名称',
  `service_title` varchar(50) comment '服务标题',
  `pic` varchar(200) comment '图标地址',
  `is_dev` int(4) comment '是否仅开发者模式可用',
  `in_auth` int(4) comment '是否控制权限',
  `state` int(4) comment '是否启用，1.启用，0.禁用',
  `description` varchar(400) comment '描述',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp comment '更新时间',
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='接口服务表';

create table `func` (
  `id` int auto_increment,
  `func_name` varchar(50) comment '功能名称',
  `func_title` varchar(50) comment '功能标题',
  `pic` varchar(200) comment '图标地址',
  `service_id` int comment '所属服务',
  `is_dev` int(4) comment '是否仅开发者模式可用',
  `in_auth` int(4) comment '是否控制权限',
  `state` int(4) comment '是否启用，1.启用，0.禁用',
  `description` varchar(400) comment '描述',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp comment '更新时间',
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='服务功能表';

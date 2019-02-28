create table `sys_config` (
  `id` int auto_increment comment '表序号',
  `module` varchar(50) comment '所属模块',
  `sub_module` varchar(50) comment '所属子模块',
  `key` varchar(50) comment '配置键名',
  `value` varchar(500) comment '配置键值',
  `remark` varchar(200) comment '配置项说明',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp comment '更新时间',
  primary key(`id`),
  unique(`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='系统配置表';

create table `auth` (
  `id` int auto_increment,
  `service_name` varchar(50),
  `service_path` varchar(100),
  `created_at` datetime,
  `updated_at` timestamp,
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='权限表';

CREATE TABLE `search_hitory` (
  `id` int auto_increment,
  `member_id` int not null,
  `content` varchar(100),
  `created_at` datetime,
  `updated_at` timestamp default CURRENT_TIMESTAMP,
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='管理员表';

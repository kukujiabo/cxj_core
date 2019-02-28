create table `feedback` (
  `id` int auto_increment,
  `member_id` int not null comment '用户id',
  `content` text default null comment '反馈内容',
  `category` int default 0 comment '意见分类',
  `viewed` int(4) default 0 comment '是否已阅',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp comment '更新时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='反馈意见表';

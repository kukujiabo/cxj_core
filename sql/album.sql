create table `album` (
  `id` int auto_increment,
  `album_name` varchar(100) comment '专辑名称',
  `author_id` int comment '作者id',
  `member_id` int comment '用户id',
  `title` varchar(100) comment '专辑标题',
  `brief` varchar(500) comment '专辑简介',
  `cover` varchar(200) comment '专辑封面',
  `state` int comment '专辑状态：0.禁用，1.可用',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp comment '更新时间',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='专辑表';

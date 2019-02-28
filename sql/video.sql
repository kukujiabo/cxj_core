create table `video` (
  `id` int auto_increment comment '表序号',
  `out_id` varchar(50) comment '视频资源id',
  `member_id` int comment '用户id',
  `category_id` int comment '分类id',
  `album_id` int comment '相册id',
  `title` varchar(25) comment '视频标题',
  `cover` varchar(500) comment '视频封面',
  `url` varchar(500) comment '视频url',
  `status` int default 0 comment '视频状态：1.通过审核，0.未审核，-1 不通过',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp,
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='视频表';


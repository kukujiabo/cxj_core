CREATE TABLE `video_category` (
  `id` int auto_increment,
  `name` varchar(20) not null comment '分类名称',
  `parent` int not null default 0 comment '上级分类id',
  `description` varchar(200) comment '分类描述',
  `display_order` int default 0 comment '分类排序：值越大越靠前',
  `status` int default 1 comment '分类状态：1.启用，0.禁用',
  `thumbnail` varchar(200) default null comment '分类图标',
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='视频分类';

create table `comments` (
  `id` int auto_increment,
  `member_id` int(10) not null comment '用户id',
  `reply_to` int(10) not null comment '回复评论id',
  `content` varchar(200) not null comment '评论内容',
  `status` int(4) default 1 comment '评论状态：1.可见，0.不可见',
  `forbid` int(4) default 0 comment '禁止：1.是，0.否',
  `favorite` int(8) default 0 comment '点赞人数',
  `created_at` datetime comment '创建时间',
  `updated_at` timestamp default current_timestamp,
  primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='评论表';

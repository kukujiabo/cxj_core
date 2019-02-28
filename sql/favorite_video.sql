create table `video_favorite` (
 `id` int auto_increment,
 `video_id` int not null comment '视频id',
 `member_id` int not null comment '用户id',
 `active` int default 1 comment '是否有效',
 `created_at` datetime,
 `updated_at` timestamp default current_timestamp,
 primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='喜欢的视频';

create table `video_collection` (
 `id` int auto_increment,
 `video_id` int not null comment '视频id',
 `member_id` int not null comment '用户id',
 `active` int default 1 comment '是否有效',
 `created_at` datetime,
 `updated_at` timestamp default current_timestamp,
 primary key(`id`)
) engine=innodb default charset=utf8 avg_row_length=148 comment='用户收藏视频';

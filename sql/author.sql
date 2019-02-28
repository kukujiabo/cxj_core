create table `author` (
`id` int auto_increment,
`account_name` varchar(20) comment '账户名称',
`account_type` int(10) comment '账户类型',
`video_brief` varchar(200) comment '视频简介',
`workout_show` text comment '作品链接',
`business_entity` varchar(100) comment '运营主体，账户类型为2时有效',
`company_address` varchar(200) comment '公司地址，账户类型为2时有效',
`website` varchar(200) comment '公司网址，账户类型为2时有效',
`weibo` varchar(50) comment '新浪微博，账户类型为2时有效',
`business_license` varchar(200) comment '营业执照，账户类型为2时有效',
`contact` varchar(50) comment '联系人姓名',
`email` varchar(50) comment '联系人邮箱',
`mobile` varchar(11) comment '联系人手机号',
`wechat` varchar(30) comment '联系人微信号',
`qq` varchar(20) comment '联系人微信号',
`remark` varchar(500) comment '其他信息',
primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=148 COMMENT='作者资料';

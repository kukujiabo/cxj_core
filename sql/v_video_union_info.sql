create view v_video_union_info as select
a.*, b.name category_name, b.status category_staus, b.brief category_brief, b.display_order category_order,
c.title album_name, c.status as album_status, c.cover album_cover, c.brief album_brief
from video a
left join video_category b
on a.category_id = b.id
left join album c on a.album_id = c.id

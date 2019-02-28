create view  `v_member_comment` as 
select 
a.member_name, 
a.member_identity, 
a.mobile, 
a.member_type,
a.portrait,
b.*
from 
member a,
comments b
where a.id = b.member_id

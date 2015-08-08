create or replace view top_10_O_count
as
select * from (select * from top_10_calls where lower(type) = 'outgoing'
order by total_count desc) where rownum <= 10

create or replace view top_10_I_count
as
select * from (select * from top_10_calls where lower(type) = 'incoming'
order by total_count desc) where rownum <= 10;

create or replace view top_10_I_duration
as
select * from (select * from top_10_calls where lower(type) = 'incoming'
order by total_duration desc) where rownum <= 10;

create or replace view top_10_O_duration
as
select * from (select * from top_10_calls where lower(type) = 'outgoing'
order by total_duration desc) where rownum <= 10;

select * from (select * from top_10_calls where lower(type) = 'outgoing'
order by total_duration desc) where rownum <= 10;

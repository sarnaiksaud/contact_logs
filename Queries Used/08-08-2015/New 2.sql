select * from (select * from top_10_calls order by total_count desc) where rownum <= 10
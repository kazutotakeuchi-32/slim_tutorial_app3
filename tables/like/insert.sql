INSERT INTO likes (user_id, article_id ) VALUES (1,1)
INSERT INTO likes (user_id, article_id ) VALUES (1,1)
INSERT INTO likes (user_id, article_id ) VALUES (1,3)
INSERT INTO likes (user_id, article_id )
 VALUES (1,4)

 select id, (select count(id)  from likes group by article_id) as いいね数 from users ;
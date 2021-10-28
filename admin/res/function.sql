DELIMITER $$

DROP PROCEDURE IF EXISTS get_vedio_details $$
CREATE PROCEDURE get_vedio_details(IN fb_id varchar(50),IN vedio_id INT(20))

  BEGIN
        DECLARE countLikes varchar(50);
        DECLARE countcomment varchar(50);
        DECLARE video_like_dislike varchar(50);

        SET countLikes = (SELECT count(*) as countLikes from video_like_dislike where video_id=vedio_id);
        SET countcomment = (SELECT count(*) as countcomment from video_comment where video_id=vedio_id);
        SET video_like_dislike =(SELECT count(*) as liked from video_like_dislike where video_id=vedio_id and fb_id=fb_id);
        SELECT ifnull(countLikes,0) as countLikes,ifnull(countcomment,0) as countcomment,ifnull(video_like_dislike,0) as video_like_dislike;
  END; $$

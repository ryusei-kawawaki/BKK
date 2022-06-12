ALTER TABLE 
    bkk.comments 
    ADD CONSTRAINT comments_FK_user_id2 
    FOREIGN KEY (user_id) 
    REFERENCES bbk.users(id)
;
ALTER TABLE 
    bkk.comments 
    ADD CONSTRAINT comments_FK_post_id 
    FOREIGN KEY (post_id) 
    REFERENCES bbk.posts(id)
;
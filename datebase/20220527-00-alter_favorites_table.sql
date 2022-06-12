ALTER TABLE 
    bkk.favorites 
    ADD CONSTRAINT favorites_FK_post_id 
    FOREIGN KEY (post_id) 
    REFERENCES bbk.posts(id)
;

ALTER TABLE 
    bkk.favorites 
    ADD CONSTRAINT favorites_FK_user_id 
    FOREIGN KEY (user_id) 
    REFERENCES bbk.users(id)
;
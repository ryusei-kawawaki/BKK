ALTER TABLE 
    bkk.posts 
    ADD CONSTRAINT posts_FK_user_id 
    FOREIGN KEY (user_id) 
    REFERENCES bbk.users(id)
;
ALTER TABLE 
    bkk.posts 
    ADD CONSTRAINT posts_FK_tag_id
    FOREIGN KEY (tag_id) 
    REFERENCES bbk.tags(id)
;

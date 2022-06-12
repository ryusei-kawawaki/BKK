CREATE TABLE bkk.favorites (
	id INT auto_increment NULL COMMENT 'いいねID',
	post_id INT NOT NULL COMMENT '投稿ID',
	user_id INT NOT NULL COMMENT 'いいね保存者ID',
	CONSTRAINT favorites_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;


CREATE TABLE bkk.posts (
	id INT auto_increment NULL COMMENT '投稿認識ID',
	user_id INT NULL COMMENT 'ユーザーID',
	tag_id INT NOT NULL COMMENT 'タグID',
	good INT NULL COMMENT 'いいね',
	body varchar(255) NOT NULL COMMENT '投稿内容',
	deleted_at DATETIME NULL COMMENT '削除日時',
	created_at DATETIME NOT NULL COMMENT '登録日時',
	updated_at DATETIME NULL COMMENT 'アップデート日時',
	CONSTRAINT posts_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

CREATE TABLE bkk.comments (
	id INT auto_increment NULL COMMENT 'コメントID',
	user_id INT NULL COMMENT 'ユーザーID',
	post_id INT NOT NULL,
	body varchar(255) NULL COMMENT 'コメント内容',
	created_at DATETIME NOT NULL COMMENT 'コメント作成日時',
	updated_at DATETIME NULL COMMENT 'コメント編集日時',
	deleted_at DATETIME NULL COMMENT 'コメント削除日時',
	CONSTRAINT comments_pk PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

CREATE TABLE bkk.users (
	id INT auto_increment NULL COMMENT 'ユーザーID',
	name varchar(255) NOT NULL COMMENT 'ユーザー名',
	email varchar(255) NOT NULL COMMENT 'メールアドレス',
	password varchar(500) NOT NULL COMMENT 'パスワード',
	created_at DATETIME NOT NULL COMMENT '登録日時',
	updated_at DATETIME NULL COMMENT 'アップデート日時',
	deleted_at DATETIME NULL COMMENT '退会日時',
	CONSTRAINT users_pk PRIMARY KEY (id),
	CONSTRAINT users_un UNIQUE KEY (email)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

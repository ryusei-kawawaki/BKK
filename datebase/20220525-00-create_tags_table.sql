CREATE TABLE bkk.tags (
	id INT auto_increment NULL COMMENT 'タグ',
	name varchar(255) NOT NULL COMMENT 'タグの名前',
	created_at DATETIME NOT NULL COMMENT 'タグ作成日時',
	updated_at DATETIME NULL COMMENT 'タグ編集日時',
	deleted_at DATETIME NULL COMMENT 'タグ削除日時',
	CONSTRAINT tags_pk PRIMARY KEY (id),
	CONSTRAINT tags_un UNIQUE KEY (name)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

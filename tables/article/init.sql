use test;

--  CONSTRAINT fk_department_id
--     FOREIGN KEY (department_id) 
--     REFERENCES departments (department_id)
--     ON DELETE RESTRICT ON UPDATE RESTRICT

-- user_id BIGINT(11)  NOT NULL,
-- FOREIGN KEY(user_id) REFERENCES users(id),

-- articlesテーブル(記事)

CREATE TABLE articles (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(120) NOT NULL,
  content TEXT NOT NULL,
  user_id INT(11) UNSIGNED NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_user_id
    FOREIGN KEY (user_id)
    REFERENCES users (id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
);



-- CREATE TABLE articles (
--   id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
--   title VARCHAR(120) NOT NULL,
--   content TEXT NOT NULL,
--   -- user_id INT(11) UNSIGNED NOT NULL FOREIGN KEY REFERENCES users(id),
--   created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
--   updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--   CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT
-- );

  
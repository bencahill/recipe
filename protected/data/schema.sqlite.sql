CREATE TABLE tbl_user (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	username VARCHAR(128) NOT NULL,
	password VARCHAR(128) NOT NULL,
	salt VARCHAR(128) NOT NULL,
	email VARCHAR(128) NOT NULL
);

CREATE TABLE tbl_recipe (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  description TEXT,
  notes TEXT,
  source TEXT,
  servings INTEGER,
  serving_unit TEXT,
  create_time INTEGER NOT NULL,
  update_time INTEGER,
  sections TEXT NOT NULL,
  category_id INTEGER NOT NULL,
  author_id INTEGER NOT NULL,
  CONSTRAINT FK_recipe_author FOREIGN KEY (author_id)
    REFERENCES tbl_user (id) ON DELETE CASCADE ON UPDATE RESTRICT
  CONSTRAINT FK_recipe_category FOREIGN KEY (category_id)
    REFERENCES tbl_category (id) ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE tbl_ingredient (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  quantity TEXT NOT NULL,
  measurement TEXT NOT NULL,
  ingredient TEXT NOT NULL,
  position INTEGER,
  recipe_id INTEGER NOT NULL,
  section_id INTEGER NOT NULL,
  CONSTRAINT FK_ingredient_recipe FOREIGN KEY (recipe_id)
    REFERENCES tbl_recipe (id) ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE tbl_category (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL
);

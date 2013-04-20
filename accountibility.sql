CREATE TABLE "class" (
	"id" serial PRIMARY KEY,
	"graduate" smallint DEFAULT NULL
);

CREATE TABLE "student" (
	"id" serial PRIMARY KEY,
	"class" integer DEFAULT NULL,
	"name" varchar(100) DEFAULT NULL,
	"code" varchar(100) DEFAULT NULL,
	UNIQUE ("code"),
	FOREIGN KEY ("class") REFERENCES class("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE "subject" (
	"id" serial PRIMARY KEY,
	"class" integer DEFAULT NULL,
	"name" varchar(100) DEFAULT NULL,
	FOREIGN KEY ("class") REFERENCES class("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE "section" (
	"id" serial PRIMARY KEY,
	"subject" integer DEFAULT NULL,
	"name" varchar(100) DEFAULT NULL,
	"point" integer DEFAULT NULL,
	FOREIGN KEY ("subject") REFERENCES subject("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE "period" (
	"id" serial PRIMARY KEY,
	"first" date DEFAULT NULL,
	"last" date DEFAULT NULL
);

CREATE TABLE "assignment" (
	"id" serial PRIMARY KEY,
	"section" integer DEFAULT NULL,
	"period" integer DEFAULT NULL,
	"name" varchar(100) DEFAULT NULL,
	"note" text DEFAULT NULL,
	"point" integer DEFAULT NULL,
	FOREIGN KEY ("section") REFERENCES section("id") ON UPDATE CASCADE ON DELETE SET NULL,
	FOREIGN KEY ("period") REFERENCES period("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE "grade" (
	"id" serial PRIMARY KEY,
	"assignment" integer DEFAULT NULL,
	"student" integer DEFAULT NULL,
	"note" text DEFAULT NULL,
	"point" integer DEFAULT NULL,
	FOREIGN KEY ("assignment") REFERENCES assignment("id") ON UPDATE CASCADE ON DELETE SET NULL,
	FOREIGN KEY ("student") REFERENCES student("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE "demerit" (
	"id" serial PRIMARY KEY,
	"student" integer DEFAULT NULL,
	"date" date DEFAULT NULL,
	"note" text DEFAULT NULL,
	"point" integer DEFAULT NULL,
	FOREIGN KEY ("student") REFERENCES student("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE layout (
  idlayout INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_layout INTEGER UNSIGNED NULL,
  PRIMARY KEY(idlayout)
);

CREATE TABLE running_text (
  idrunning_text INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  isi TEXT NULL,
  PRIMARY KEY(idrunning_text)
);

CREATE TABLE users (
  idusers INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NULL,
  password VARCHAR(255) NULL,
  level ENUM('admin','general') NULL,
  PRIMARY KEY(idusers)
);

CREATE TABLE agenda (
  idagenda INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  judul INTEGER UNSIGNED NULL,
  tanggal VARCHAR(255) NULL,
  mulai VARCHAR(255) NULL,
  selesai VARCHAR(255) NULL,
  deskripsi TEXT NULL,
  PRIMARY KEY(idagenda)
);

CREATE TABLE tema (
  idtema INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idusers INTEGER UNSIGNED NOT NULL,
  nama_tema VARCHAR(255) NULL,
  css VARCHAR(255) NULL,
  PRIMARY KEY(idtema),
  INDEX tema_FKIndex1(idusers),
  FOREIGN KEY(idusers)
    REFERENCES users(idusers)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE gallery (
  idgallery INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idusers INTEGER UNSIGNED NOT NULL,
  nama_gambar VARCHAR(255) NULL,
  deskripsi TEXT NULL,
  PRIMARY KEY(idgallery),
  INDEX gallery_FKIndex1(idusers),
  FOREIGN KEY(idusers)
    REFERENCES users(idusers)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE berita (
  idberita INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idusers INTEGER UNSIGNED NOT NULL,
  judul VARCHAR(255) NULL,
  isi LONGTEXT NULL,
  waktu TIMESTAMP NULL,
  gambar VARCHAR(255) NULL,
  PRIMARY KEY(idberita),
  INDEX berita_FKIndex1(idusers),
  FOREIGN KEY(idusers)
    REFERENCES users(idusers)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);



begin transaction;

Create TABLE administrateur
    (
    id_ad integer primary Key,
	login varchar (20) not null,
    password varchar(50) not null
    );

CREATE TABLE account
    (
	id_ac integer primary Key,
	nom varchar (20),
	prenom varchar (20) ,
	login varchar (20) Unique not null,
	mail varchar (100)
    );

CREATE TABLE dossier
    (
	id_dos  integer primary Key,
	dossier	 varchar (200) not null,
	index varchar(20) not null,
	id_dos_parent integer references dossier (id_dos)
    );

CREATE TABLE attribution
    (
	id_a integer primary Key,
	id_ac integer references account (id_ac),
	id_dos integer references dossier (id_dos),
	id_l bool,
	id_e bool
    );

CREATE TABLE modifs
    (
	id_modifs integer primary Key,
	modif bool
    );

commit;
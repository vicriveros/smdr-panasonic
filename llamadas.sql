CREATE TABLE llamadas
(
  extension numeric,
  direccion character varying(1),
  int_ex numeric,
  device1 character varying,
  name1 character varying,
  device2 character varying,
  name2 character varying,
  duracion character varying,
  fecha date NOT NULL,
  hora time without time zone NOT NULL,
  nro character varying,
  id serial NOT NULL,
  CONSTRAINT pk_llamadas PRIMARY KEY (id)
)

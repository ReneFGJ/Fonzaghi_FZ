CREATE TABLE cad_complemento (
  id_cmp SERIAL NOT NULL,
  cmp_cliente CHAR(7) ,
  cmp_cliente_seq CHAR(2) ,
  cmp_salario DOUBLE ,
  cmp_salario_complementar DOUBLE ,
  cmp_estado_civil CHAR(1) ,
  cmp_estado_civil_tempo INTEGER ,
  cmp_profissao CHAR(100) ,
  cmp_experiencia_vendas INTEGER ,
  cmp_patrimonio CHAR(1) ,
  cmp_imovel_tempo INTEGER ,
  cmp_valor_aluguel DOUBLE ,
  cmp_emprego_tempo INTEGER ,
  cmp_propaganda CHAR(1) ,
  cmp_propaganda2 CHAR(1) ,
  cmp_log CHAR(10) ,
  cmp_data INTEGER ,
  cmp_lastupdate_log CHAR(10) ,
  cmp_lastupdate INTEGER ,
  cmp_status CHAR(1)  DEFAULT '1',
  PRIMARY KEY(id_cmp)
);

CREATE TABLE cad_endereco (
  id_end SERIAL NOT NULL,
  end_cliente CHAR(7) ,
  end_rua CHAR(100) ,
  end_numero CHAR(10) ,
  end_bairro CHAR(30) ,
  end_cidade CHAR(30) ,
  end_estado CHAR(2) ,
  end_cep CHAR(8) ,
  end_latitude CHAR(20) ,
  end_longitude CHAR(20) ,
  end_complemento CHAR(30) ,
  end_status CHAR(1) ,
  PRIMARY KEY(id_end)
);

CREATE TABLE cad_pessoa (
  id_pes SERIAL NOT NULL,
  pes_cliente CHAR(7) ,
  pes_cliente_seq CHAR(2) DEFAULT '00',
  pes_nome CHAR(100) ,
  pes_cpf CHAR(11) ,
  pes_rg CHAR(15) ,
  pes_nasc INTEGER ,
  pes_naturalidade CHAR(30) ,
  pes_genero CHAR(1) ,
  pes_pai CHAR(100) ,
  pes_mae CHAR(100) ,
  pes_avalista CHAR(1)  DEFAULT 'P',
  pes_avalista_cod CHAR(7) ,
  pes_data INTEGER ,
  pes_lastupdate INTEGER ,
  pes_status CHAR(1)  DEFAULT '@',
  PRIMARY KEY(id_pes)
);

CREATE TABLE cad_referencia (
  id_ref SERIAL NOT NULL,
  ref_cliente CHAR(7) ,
  ref_cliente_seq CHAR(2) ,
  ref_nome CHAR(30) ,
  ref_cep CHAR(8) ,
  ref_observacao TEXT ,
  ref_data INTEGER ,
  ref_grau CHAR(1) ,
  ref_status CHAR(1)  DEFAULT '@',
  ref_ativo CHAR(1)  DEFAULT '1',
  PRIMARY KEY(id_ref)
);

CREATE TABLE cad_referencia_tipo (
  id_ret SERIAL NOT NULL,
  ret_codigo CHAR(7),  
  ret_nome CHAR(30) ,
  ret_status CHAR(1) ,
  PRIMARY KEY(ret_codigo)
);

CREATE TABLE cad_telefone (
  id_tel SERIAL NOT NULL,
  tel_cliente CHAR(7) ,
  tel_cliente_seq CHAR(2) ,
  tel_ddd CHAR(3) ,
  tel_numero CHAR(9) ,
  tel_tipo CHAR(1) ,
  tel_data INTEGER DEFAULT 0 ,
  tel_validado CHAR(1) ,
  tel_status CHAR(1) ,
  PRIMARY KEY(id_tel)
);

CREATE TABLE cad_pessoa_log (
  id_log int(11) NOT NULL AUTO_INCREMENT,
  log_cliente varchar(7) DEFAULT NULL COMMENT 'C�digo do cliente',
  log_data int(11) DEFAULT NULL COMMENT 'Data de lan�amento',
  log_login varchar(15) DEFAULT NULL COMMENT 'Login de quem efetuou o registro.',
  log_acao varchar(100) DEFAULT NULL COMMENT 'Descri��o da a��o realizada.',
  log_status_registro varchar(1) DEFAULT NULL COMMENT 'Status do lan�amento que gerou o registro.(@,A,T,C,R)',
  log_status int(1) DEFAULT '1' COMMENT 'Ativo- 1 ou inativo - 0',
  PRIMARY KEY (id_log)
)




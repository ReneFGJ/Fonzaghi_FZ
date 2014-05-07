CREATE TABLE cad_complemento (
  id_cmp INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cmp_cliente VARCHAR(7) NULL,
  cmp_cliente_seq VARCHAR(2) NULL,
  cmp_salario DOUBLE NULL,
  cmp_salario_complementar DOUBLE NULL,
  cmp_estado_civil VARCHAR(1) NULL,
  cmp_estado_civil_tempo INTEGER NULL,
  cmp_profissao VARCHAR(100) NULL,
  cmp_experiencia_vendas INTEGER NULL,
  cmp_patrimonio VARCHAR(1) NULL,
  cmp_imovel_tempo INTEGER NULL,
  cmp_valor_aluguel DOUBLE NULL,
  cmp_emprego_tempo INTEGER NULL,
  cmp_propaganda VARCHAR(1) NULL,
  cmp_propaganda2 VARCHAR(1) NULL,
  cmp_log VARCHAR(10) NULL,
  cmp_data INTEGER NULL,
  cmp_lastupdate_log VARCHAR(10) NULL,
  cmp_lastupdate INTEGER NULL,
  cmp_status VARCHAR(1) NULL DEFAULT 1,
  PRIMARY KEY(id_cmp)
);

CREATE TABLE cad_endereco (
  id_end INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  end_cliente VARCHAR(7) NULL,
  end_rua VARCHAR(100) NULL,
  end_numero VARCHAR(10) NULL,
  end_bairro VARCHAR(30) NULL,
  end_cidade VARCHAR(30) NULL,
  end_estado VARCHAR(2) NULL,
  end_cep VARCHAR(8) NOT NULL,
  end_latitude VARCHAR(20) NULL,
  end_longitude VARCHAR(20) NULL,
  end_complemento VARCHAR(30) NULL,
  end_status VARCHAR(1) NULL,
  PRIMARY KEY(id_end)
);

CREATE TABLE cad_pessoa (
  id_pes INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  pes_codigo VARCHAR(7) NULL,
  pes_cliente VARCHAR(7) NULL,
  pes_cliente_seq VARCHAR(2) NULL DEFAULT 00,
  pes_nome VARCHAR(100) NULL,
  pes_cpf VARCHAR(11) NULL,
  pes_rg VARCHAR(15) NULL,
  pes_nasc INTEGER NULL,
  pes_naturalidade VARCHAR(30) NULL,
  pes_genero VARCHAR(1) NULL,
  pes_pai VARCHAR(100) NULL,
  pes_mae VARCHAR(100) NULL,
  pes_avalista VARCHAR(1) NULL DEFAULT P,
  pes_avalista_cod VARCHAR(7) NULL,
  pes_data INTEGER NULL,
  pes_lastupdate INTEGER NULL,
  pes_status VARCHAR(1) NULL DEFAULT @,
  PRIMARY KEY(id_pes)
);

CREATE TABLE cad_referencia (
  id_ref INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  ref_cliente VARCHAR(7) NULL,
  ref_cliente_seq VARCHAR(2) NULL,
  ref_nome VARCHAR(30) NULL,
  ref_cep VARCHAR(8) NULL,
  ref_observacao TEXT NULL,
  ref_data INTEGER NULL,
  ref_grau VARCHAR(1) NULL,
  ref_status VARCHAR(1) NULL DEFAULT @,
  ref_ativo VARCHAR(1) NULL DEFAULT 1,
  PRIMARY KEY(id_ref)
);

CREATE TABLE cad_referencia_tipo (
  ret_codigo VARCHAR(7) NOT NULL,
  id_ret INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  ret_nome VARCHAR(30) NULL,
  ret_status VARCHAR(1) NULL,
  PRIMARY KEY(ret_codigo)
);

CREATE TABLE cad_telefone (
  id_tel INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tel_cliente VARCHAR(7) NULL,
  tel_cliente_seq VARCHAR(2) NULL,
  tel_ddd VARCHAR(3) NULL,
  tel_numero VARCHAR(9) NULL,
  tel_tipo VARCHAR(1) NULL,
  tel_data INTEGER UNSIGNED NULL,
  tel_validado VARCHAR(1) NULL,
  tel_status VARCHAR(1) NULL,
  PRIMARY KEY(id_tel)
);





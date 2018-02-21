CREATE TABLE usuario(
	id INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR(255) NOT NULL,
	senha VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE tarefa(
  id INT NOT NULL AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  descricao VARCHAR(100) NOT NULL,
  ativo INT NOT NULL DEFAULT 1,
  caminho VARCHAR(255) NOT NULL UNIQUE,
  data_criacao DATETIME NOT NULL DEFAULT NOW(),
  data_alteracao DATETIME NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

CREATE TABLE agendamento(
  id INT NOT NULL AUTO_INCREMENT,
  id_tarefa INT NOT NULL,
  id_usuario INT NOT NULL,
  frequencia INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_tarefa) REFERENCES tarefa(id),
  FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

CREATE TABLE log_tarefa(
  id INT NOT NULL AUTO_INCREMENT,
  id_agendamento INT NOT NULL,
  log BLOB NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_agendamento) REFERENCES agendamento(id)
);

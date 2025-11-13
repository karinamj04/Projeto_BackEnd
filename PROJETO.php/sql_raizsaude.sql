CREATE DATABASE IF NOT EXISTS raiz_saude;
USE raiz_saude;

-- -------------------------
-- Tabela: especialidades
-- -------------------------
CREATE TABLE especialidades (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- -------------------------
-- Tabela: medicos
-- -------------------------
CREATE TABLE medicos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    id_especialidade INT(11),
    FOREIGN KEY (id_especialidade) REFERENCES especialidades(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- -------------------------
-- Tabela: usuarios
-- -------------------------
CREATE TABLE usuarios (
    cpf VARCHAR(14) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100),
    nomeMaterno VARCHAR(100),
    sexo VARCHAR(15),
    endereco VARCHAR(100),
    bairro VARCHAR(50),
    estado VARCHAR(2),
    cep VARCHAR(9),
    cidade VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(200) NOT NULL,
    trocar_senha TINYINT(1) DEFAULT 0,
    telefoneCelular VARCHAR(15),
    DataNascimento DATE,
    tipo ENUM('paciente', 'admin', 'recepcionista') DEFAULT 'paciente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -------------------------
-- Tabela: logs_autenticacao
-- -------------------------
CREATE TABLE logs_autenticacao (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(14),
    email VARCHAR(100),
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    segundo_fator VARCHAR(50),
    status ENUM('sucesso', 'falha'),
    FOREIGN KEY (cpf) REFERENCES usuarios(cpf)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- -------------------------
-- Tabela: agendamentos
-- -------------------------
CREATE TABLE agendamentos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(200),
    cpf_paciente VARCHAR(14),
    id_especialidade INT(11),
    id_medico INT(11),
    data_consulta DATE,
    horario TIME,
    status ENUM('pendente', 'confirmada', 'cancelada', 'realizada', 'nao_realizada') DEFAULT 'pendente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    telefone VARCHAR(20),
    FOREIGN KEY (cpf_paciente) REFERENCES usuarios(cpf)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_especialidade) REFERENCES especialidades(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (id_medico) REFERENCES medicos(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- === PACIENTES ===
INSERT INTO usuarios (
    cpf, nome, sobrenome, nomeMaterno, sexo, endereco, bairro, estado, cep, cidade,
    email, senha, trocar_senha, telefoneCelular, DataNascimento, tipo
) VALUES
('123.456.789-00', 'Ana', 'Souza', 'Maria Souza', 'Feminino', 'Rua das Flores, 45', 'Centro', 'SP', '01010-000', 'São Paulo',
 'ana.souza@gmail.com', '', 1, '(11) 91234-5678', '1998-03-12', 'paciente'),

('987.654.321-11', 'Beatriz', 'Santos', 'Claudia Santos', 'Feminino', 'Av. Atlântica, 200', 'Copacabana', 'RJ', '22021-001', 'Rio de Janeiro',
 'beatriz.santos@gmail.com', '', 1, '(21) 99876-5432', '2001-07-28', 'paciente'),

('456.789.123-22', 'Camila', 'Oliveira', 'Sandra Oliveira', 'Feminino', 'Rua Bahia, 150', 'Savassi', 'MG', '30140-120', 'Belo Horizonte',
 'camila.oliveira@gmail.com', '', 1, '(31) 99777-8899', '1995-11-09', 'paciente');


-- === ADMINISTRADORES ===
INSERT INTO usuarios (
    cpf, nome, sobrenome, nomeMaterno, sexo, endereco, bairro, estado, cep, cidade,
    email, senha, trocar_senha, telefoneCelular, DataNascimento, tipo
) VALUES
('111.222.333-44', 'João', 'Pereira', 'Lúcia Pereira', 'Masculino', 'Rua XV de Novembro, 100', 'Centro', 'PR', '80020-310', 'Curitiba',
 'joao.pereira@clinica.com', '', 1, '(41) 98888-1122', '1988-02-10', 'admin'),

('555.666.777-88', 'Mariana', 'Costa', 'Helena Costa', 'Feminino', 'Rua das Palmeiras, 58', 'Boa Viagem', 'PE', '51020-090', 'Recife',
 'mariana.costa@clinica.com', '', 1, '(81) 97777-2233', '1992-09-15', 'admin'),

('999.888.777-66', 'Carlos', 'Almeida', 'Fernanda Almeida', 'Masculino', 'Av. Brasil, 400', 'Jardins', 'SP', '01430-000', 'São Paulo',
 'carlos.almeida@clinica.com', '', 1, '(11) 93456-7788', '1985-05-20', 'admin');

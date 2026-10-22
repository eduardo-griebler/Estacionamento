CREATE DATABASE IF NOT EXISTS db_estacionamento
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
 
USE db_estacionamento;

CREATE TABLE veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(10) UNIQUE NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    tipo ENUM(
        'Carro',
        'Moto'
    ) NOT NULL
);

SELECT * FROM veiculos;

CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    veiculo_id INT,
    data_entrada DATETIME NOT NULL,
    data_saida DATETIME NULL,
    valor_pago DECIMAL(8,2) NULL,
    status ENUM(
        'No Pátio',
        'Finalizado'
    ) DEFAULT 'No Pátio',
    FOREIGN KEY (veiculo_id)
        REFERENCES veiculos(id)
);

create view  vw_veiculos_no_patio as select 
	mov.id as movimentacao_id,
	v.placa as placa,
	v.modelo as modelo,
	v.tipo as tipo,
    date_format(mov.data_entrada, '%d/%m/%Y %H:%i') as data_entrada_formatada,
	(timestampdiff(minute, mov.data_entrada, now()) / 60) as hora_decorridas
from movimentacoes mov
join veiculos v on mov.veiculo_id = v.id
where mov.status = 'No Pátio';

delimiter //
create procedure sp_registrar_saida(
	in in_movimentacao_id int,
	in in_valor_hora decimal(8,2)
)
begin
	
	declare v_data_entrada datetime;
    declare v_total_horas int;
    declare v_valor_pago decimal(10,2);
    
    -- 1. Busca a data de entrada da movimentação específica
    select data_entrada 
    into v_data_entrada 
    from movimentacoes
    where id = in_movimentacao_id and status = 'No Pátio';
    
    -- 2. Calcula a quantidade de horas (arredondando para cima com base na diferença em minutos)
    -- TIMESTAMPDIFF calcula a diferença em minutos, dividimos por 60 e usamos CEIL para arredondar para cima.
    set v_total_horas = ceil(timestampdiff(minute, v_data_entrada, now()) / 60.0);
    
    -- Garante pelo menos 1 hora cobrada, se necessário
    if v_total_horas < 1 then
        set v_total_horas = 1;
    end if;
    
    -- 3. Calcula o valor total a ser pago
    set v_valor_pago = v_total_horas * in_valor_hora;
    
    -- 4. Atualiza o registro com a data de saída, o valor e o novo status
    update movimentacoes 
    set data_saida = now(), 
        valor_pago = v_valor_pago, 
        status = 'Finalizado'
    where id = in_movimentacao_id;
		
end //
DELIMITER $$

CREATE TRIGGER trg_validar_entrada_duplicada
BEFORE INSERT ON movimentacoes
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT 1
        FROM movimentacoes
        WHERE veiculo_id = NEW.veiculo_id
        AND status = 'No Pátio'
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Bloqueado: Este veículo já se encontra estacionado no pátio!';
    END IF;
END$$

DELIMITER ;

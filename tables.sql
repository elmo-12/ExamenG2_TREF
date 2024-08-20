CREATE TABLE cliente (
    id_cliente INT PRIMARY KEY,
    DNI CHAR(8) PRIMARY KEY,
    nombres VARCHAR(100),
    direccion VARCHAR(150)
);

CREATE TABLE video (
    id_video INT PRIMARY KEY,
    stock INT,
    descripcion VARCHAR(200),
    precio DECIMAL(10, 2)
);

CREATE TABLE ficha (
    id_ficha INT PRIMARY KEY,
    id_cliente INT,
    fecha_Venta DATE,
    total DECIMAL(10, 2)
);

CREATE TABLE detalle_ficha (
    id_detalle INT PRIMARY KEY,
    id_ficha INT,
    id_video INT,
    precio DECIMAL(10, 2),
    cantidad INT
);


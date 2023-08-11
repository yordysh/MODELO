


CREATE TABLE T_ZONA_AREAS(
	
	COD_ZONA CHAR(3) PRIMARY KEY ,
	NOMBRE_T_ZONA_AREAS VARCHAR(50) NULL,
	FECHA DATETIME DEFAULT GETDATE() NULL,
	VERSION NCHAR(2) NULL,
)


CREATE TABLE T_INFRAESTRUCTURA(
	
	COD_INFRAESTRUCTURA CHAR(3) PRIMARY KEY ,
	COD_ZONA CHAR(3), 
	NOMBRE_INFRAESTRUCTURA VARCHAR(50) NOT NULL,
	NDIAS INT NULL,
	FECHA DATETIME NULL,
	VERSION NCHAR(2) NULL,
	USUARIO VARCHAR(15) NULL,
	FOREIGN KEY (COD_ZONA) REFERENCES T_ZONA_AREAS(COD_ZONA)
)


CREATE TABLE T_FRECUENCIA(
	
	COD_FRECUENCIA CHAR(3) PRIMARY KEY ,
	COD_ZONA CHAR(3), 
	NOMBRE_FRECUENCIA VARCHAR(50) NOT NULL,
	FECHA DATETIME DEFAULT GETDATE(),
	VERSION NCHAR(2) NULL,
	OBSERVACION VARCHAR(100),
    ACCION_CORRECTIVA VARCHAR(100),
    VERIFICACION VARCHAR(30),
	FOREIGN KEY (COD_ZONA) REFERENCES T_ZONA_AREAS(COD_ZONA)
)



CREATE TABLE T_VERSION(
	COD_VERSION INT IDENTITY(1,1) NOT NULL,
	VERSION CHAR(2) NULL,
	 FECHA_VERSION DATETIME DEFAULT GETDATE(),

)


CREATE TABLE T_ALERTA (
  COD_ALERTA INT IDENTITY(1,1) PRIMARY KEY,
  COD_INFRAESTRUCTURA CHAR(3) ,
  FECHA_CREACION DATETIME DEFAULT GETDATE(),
  FECHA_TOTAL DATETIME,
  FECHA_ACORDAR DATETIME,
  FECHA_EJECUCION DATETIME,
  ESTADO CHAR(2) DEFAULT 'P',
  OBSERVACION VARCHAR(100),
  N_DIAS_POS INT NULL,
  FECHA_POSTERGACION DATETIME,
  POSTERGACION CHAR(2) DEFAULT 'NO',
  CALIFICACION CHAR(1),
 
  COD_PERSONAL CHAR(5),
  FECHA_REALIZADA DATETIME,
  ACCION_CORRECTIVA VARCHAR(80),
  VERIFICACION_REALIZADA VARCHAR(30),
  FOREIGN KEY (COD_INFRAESTRUCTURA) REFERENCES T_INFRAESTRUCTURA(COD_INFRAESTRUCTURA)
);
CREATE TABLE T_USUARIO(
	ID_USUARIO INT IDENTITY(1,1) NOT NULL,
	USUARIO VARCHAR(20),
	CLAVE VARCHAR(20)

)


CREATE TABLE T_SOLUCIONES(
	ID_SOLUCIONES INT IDENTITY(1,1) PRIMARY KEY,
	NOMBRE_INSUMOS VARCHAR(50)
)
CREATE TABLE T_PREPARACIONES(
	ID_PREPARACIONES INT IDENTITY(1,1) PRIMARY KEY,
	ID_SOLUCIONES INT,
	NOMBRE_PREPARACION VARCHAR(80),
	FOREIGN KEY (ID_SOLUCIONES) REFERENCES T_SOLUCIONES(ID_SOLUCIONES)
)
CREATE TABLE T_CANTIDAD(
	ID_CANTIDAD INT IDENTITY(1,1) PRIMARY KEY,
	ID_PREPARACIONES INT,
	CANTIDAD_PORCENTAJE VARCHAR(20),
	FOREIGN KEY (ID_PREPARACIONES) REFERENCES T_PREPARACIONES(ID_PREPARACIONES)
)

CREATE TABLE T_L(
	ID_L INT IDENTITY(1,1) PRIMARY KEY ,
	CANTIDAD_LITROS VARCHAR(20),
)

CREATE TABLE T_ML(
	ID_ML INT IDENTITY(1,1),
	ID_CANTIDAD INT,
	ID_L INT,
	CANTIDAD_MILILITROS VARCHAR(10),
	FOREIGN KEY (ID_CANTIDAD) REFERENCES T_CANTIDAD(ID_CANTIDAD),
	FOREIGN KEY (ID_L) REFERENCES T_L(ID_L)
)

CREATE TABLE T_UNION(
	ID_UNION INT IDENTITY(1,1),
	NOMBRE_INSUMOS VARCHAR(50),
    NOMBRE_PREPARACION VARCHAR(80),
    CANTIDAD_PORCENTAJE VARCHAR(20),
    CANTIDAD_LITROS VARCHAR(20),
	CANTIDAD_MILILITROS VARCHAR(10),
	FECHA DATETIME DEFAULT GETDATE(),
	OBSERVACION VARCHAR(100),
    ACCION_CORRECTIVA VARCHAR(100),
    VERIFICACION VARCHAR(30)
	
)


CREATE TABLE T_CONTROL_MAQUINA(
	COD_CONTROL_MAQUINA CHAR(3) PRIMARY KEY ,
	COD_ZONA CHAR(3), 
	NOMBRE_CONTROL_MAQUINA VARCHAR(50),
    N_DIAS_CONTROL VARCHAR(20),
	FECHA DATETIME DEFAULT GETDATE(),
	VERSION NCHAR(2) NULL,
	OBSERVACION VARCHAR(100),
    ACCION_CORRECTIVA VARCHAR(100),
    FOREIGN KEY (COD_ZONA) REFERENCES T_ZONA_AREAS(COD_ZONA)
)

CREATE TABLE T_ALERTA_CONTROL_MAQUINA (
  COD_ALERTA_CONTROL_MAQUINA INT IDENTITY(1,1) PRIMARY KEY,
  COD_CONTROL_MAQUINA CHAR(3) ,
  FECHA_CREACION DATETIME DEFAULT GETDATE(),
  FECHA_TOTAL DATETIME,
  FECHA_ACORDAR DATETIME,
  ESTADO CHAR(2) DEFAULT 'P',
  OBSERVACION VARCHAR(100),
  N_DIAS_POS INT NULL,
  FECHA_POSTERGACION DATETIME,
  POSTERGACION CHAR(2) DEFAULT 'NO',
  ACCION_CORRECTIVA VARCHAR(80),
  FOREIGN KEY (COD_CONTROL_MAQUINA) REFERENCES T_CONTROL_MAQUINA(COD_CONTROL_MAQUINA)
)

CREATE TABLE T_PRODUCTO_ENVASES (
  COD_PRODUCTO_ENVASE CHAR(6) PRIMARY KEY,
  COD_PRODUCTO CHAR(6) ,
  FECHA_CREACION DATETIME DEFAULT GETDATE(),
  VERSION CHAR(6),
  ESTADO CHAR(2) DEFAULT 'A',

 
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO)
)

CREATE TABLE T_PRODUCTO_PREVILIFE (
  COD_PRODUCTO_PREVILIFE CHAR(6) PRIMARY KEY,
  COD_PRODUCTO CHAR(6) ,
  ABR_PRODUCTO_PREVILIFE CHAR(6),
  FECHA_CREACION DATETIME DEFAULT GETDATE(),
  VERSION CHAR(6),
  ESTADO CHAR(2) DEFAULT 'A',
 
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO)
)

CREATE TABLE T_PRODUCTO_INSUMOS (
  COD_PRODUCTO_INSUMOS CHAR(6) PRIMARY KEY,
  COD_INSUMOS CHAR(6),
  COD_PRODUCTO CHAR(6) ,
  FECHA_CREACION DATETIME DEFAULT GETDATE(),
  VERSION CHAR(6),
  ESTADO CHAR(2) DEFAULT 'A',
 
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO)
)

CREATE TABLE T_REGISTRO_ENVASES(
  COD_REGISTRO_ENVASES CHAR(9) PRIMARY KEY,
  N_BACHADA CHAR(6),
  CANT_NECESITO CHAR(9),
  FECHA_LOTE DATETIME,
  COD_PRODUCTO CHAR(6),
  COD_PRODUCCION CHAR(9),
  VERSION CHAR(6),

 
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_PRODUCCION) REFERENCES T_PRODUCCION(COD_PRODUCCION)
)

CREATE TABLE T_VERSION_GENERAL(
	 COD_VERSION INT IDENTITY(1,1) NOT NULL,
	 VERSION CHAR(3) NULL,
	 NOMBRE VARCHAR(15) ,
	 TIPO VARCHAR(10),
	 FECHA_VERSION DATETIME DEFAULT GETDATE(),	 

)

CREATE TABLE T_AVANCE_INSUMOS(
  COD_AVANCE_INSUMOS CHAR(9) PRIMARY KEY,
  COD_PRODUCTO CHAR(6),
  COD_PRODUCCION CHAR(9),
  CANTIDAD_ENVASES VARCHAR(15),
  CANTIDAD_TAPAS VARCHAR(15),
  CANTIDAD_SCOOPS VARCHAR(15),
  CANTIDAD_ALUPOL VARCHAR(15),
  CANTIDAD_CAJAS VARCHAR(15),
  FECHA DATETIME DEFAULT GETDATE(),
  
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_PRODUCCION) REFERENCES T_PRODUCCION(COD_PRODUCCION)
)

CREATE TABLE T_TMPFORMULACION(
 COD_FORMULACION char(5) NOT NULL,
 COD_PERSONAL char(5),
 COD_CATEGORIA char(5),
 COD_PRODUCTO char(6),
 FEC_GENERADO datetime,
 HOR_GENERADO char(8),
 CAN_FORMULACION numeric(7,2),
 MER_FORMULACION numeric(7,3),
 UNI_MEDIDA char(10),
 USU_REGISTRO varchar(30),
 FEC_REGISTRO datetime,
 USU_MODIFICO varchar(30),
 FEC_MODIFICO datetime,
 MAQUINA varchar(50),
)
CREATE TABLE T_TMPFORMULACION_ENVASES(
   COD_ENPR numeric(18,0) NOT NULL,
   COD_PRODUCTO char(6) NOT NULL,
   COD_FORMULACION char(5) NOT NULL,
   ESTADO char(1),
   USU_REGISTRO varchar(30),
   FEC_REGISTRO datetime,
   USU_MODIFICO varchar(30),
   FEC_MODIFICO datetime,
   MAQUINA varchar(50),
   CANTIDA numeric(9,3),
)


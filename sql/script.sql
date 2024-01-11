


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

CREATE TABLE T_AVANCE_INSUMOS(
  COD_AVANCE_INSUMOS CHAR(9) PRIMARY KEY,
  N_BACHADA CHAR(6),
  COD_PRODUCTO CHAR(6),
  COD_PRODUCCION CHAR(9),
  CANTIDAD VARCHAR(15),
  CANTIDAD_ENVASES VARCHAR(15),
  CANTIDAD_TAPAS VARCHAR(15),
  CANTIDAD_SCOOPS VARCHAR(15),
  CANTIDAD_ALUPOL VARCHAR(15),
  CANTIDAD_CAJAS VARCHAR(15),
  FECHA VARCHAR(50),
  
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_PRODUCCION) REFERENCES T_PRODUCCION(COD_PRODUCCION)
)


CREATE TABLE T_VERSION_GENERAL(
	 COD_VERSION INT IDENTITY(1,1) NOT NULL,
	 VERSION CHAR(3) NULL,
	 NOMBRE VARCHAR(30) ,
	 TIPO CHAR(3) DEFAULT 'M',
	 FECHA_VERSION DATETIME DEFAULT GETDATE(),	 

)

CREATE TABLE T_PRODUCTO(
  COD_PRODUCTO char(6) PRIMARY KEY,
  COD_CATEGORIA char(5),
  DES_PRODUCTO varchar(80),
  UNI_MEDIDA varchar(30),
  STOCK_MINIMO numeric(5,2),
  ABR_PRODUCTO varchar(20),
           
)

CREATE TABLE T_AVANCE_INSUMOS(
  COD_AVANCE_INSUMOS char(9),
  N_BACHADA char(6),
  COD_PRODUCTO char(6),
  COD_PRODUCCION char(9),
  CANTIDAD varchar(15),
  CANTIDAD_ENVASES varchar(15),
  CANTIDAD_TAPAS varchar(15),
  CANTIDAD_SCOOPS varchar(15),
  CANTIDAD_ALUPOL varchar(15),
  CANTIDAD_CAJAS varchar(15),
  LOTE VARCHAR(50)
)

CREATE TABLE T_TMPPRODUCCION(
 COD_PRODUCCION char(9) PRIMARY KEY,
 FEC_GENERADO datetime,
 HOR_GENERADO char(8),
 FEC_VENCIMIENTO datetime,
 COD_REQUERIMIENTO char(9),
 COD_CATEGORIA char(5),
 COD_PRODUCTO char(6),
 NUM_PRODUCION_LOTE char(8),
 CAN_PRODUCCION numeric(9,2),
 CANTIDAD_PRODUCIDA numeric(9,2),
 ESTADO CHAR(1) DEFAULT 'P',
 OBSERVACION varchar(200),
 MER_PRODUCCION numeric(9,2),
 UNI_MEDIDA char(10),
 BARRA_INICIO CHAR(9),
 BARRA_FIN CHAR(9),
 EST_PRODUCCION char(1),
 USU_REGISTRO varchar(30),
 FEC_REGISTRO datetime,
 USU_MODIFICO varchar(30),
 FEC_MODIFICO datetime,
 MAQUINA varchar(50),
 EXTERNO char(1),
 COD_ALMACEN char(5),
 N_PRODUCCION_G char(10),
 CAN_INGRESO int,
 CAN_CAJA int,
   FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
 )
 
 
 CREATE TABLE T_TMPPRODUCCION_ITEM(
 COD_PRODUCCION char(9),
 COD_PRODUCTO char(6),
 CAN_PRODUCCION numeric(9,2),
 PRIMARY KEY (COD_PRODUCTO,COD_PRODUCCION),
 FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
 FOREIGN KEY (COD_PRODUCCION) REFERENCES T_TMPPRODUCCION(COD_PRODUCCION),
 )
 
  CREATE TABLE T_TMPPRODUCCION_ENVASE(
 COD_PRODUCCION char(9),
 COD_PRODUCTO char(6),
 CAN_PRODUCCION_ENVASE numeric(9,2),
 PRIMARY KEY (COD_PRODUCTO,COD_PRODUCCION),
 FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
 FOREIGN KEY (COD_PRODUCCION) REFERENCES T_TMPPRODUCCION(COD_PRODUCCION),
 )

CREATE TABLE T_TMPFORMULACION(
    COD_FORMULACION char(5)NOT NULL,
    COD_PERSONAL char(5),
    COD_CATEGORIA char(5),
    COD_PRODUCTO char(6),
    FEC_GENERADO datetime,
    HOR_GENERADO char(8),
    CAN_FORMULACION numeric(7,2),
    MER_FORMULACION numeric(7,3),
    UNI_MEDIDA char(10),
    USU_REGISTRO varchar(30),
    FEC_REGISTRO datetime DEFAULT GETDATE(),
    USU_MODIFICO varchar(30),
    EC_MODIFICO datetime,
    MAQUINA varchar(50),
    FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO)
)
CREATE TABLE T_TMPFORMULACION_ENVASE(
 COD_ENPR INT IDENTITY(1,1),
 COD_PRODUCTO char(6) NOT NULL,
 COD_FORMULACION char(5),
 ESTADO char(1)default '0',
 USU_REGISTRO varchar(30),
 FEC_REGISTRO datetime DEFAULT GETDATE(),
 USU_MODIFICO varchar(30),
 FEC_MODIFICO datetime,
 MAQUINA varchar(50),
 CANTIDA numeric(9,3),
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO)
)

CREATE TABLE T_TMPFORMULACION_ITEM(
 COD_FORMULACION char(5),
 COD_PRODUCTO char(6),
 CAN_FORMULACION numeric(9,3),
 EST_FORMULACION char(1),
 USU_REGISTRO varchar(30),
 FEC_REGISTRO datetime DEFAULT GETDATE(),
 USU_MODIFICO varchar(30),
 FEC_MODIFICO datetime,
 MAQUINA varchar(50)
 FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO)
 )
 
  CREATE TABLE T_TMPREQUERIMIENTO(
  COD_REQUERIMIENTO char(9) PRIMARY KEY,
  CANTIDAD NUMERIC(9,2),
  COD_PERSONAL CHAR(5),
  ESTADO CHAR(1) DEFAULT 'P',
  FECHA DATETIME DEFAULT GETDATE(),
  COD_CONFIRMACION CHAR(9),
  HORA CHAR(8),
 )
  CREATE TABLE T_TMPREQUERIMIENTO_ITEM(
  COD_REQUERIMIENTO char(9),
  COD_PRODUCTO char(6),
  CANTIDAD NUMERIC(9,2),
  ESTADO CHAR(1) DEFAULT 'P',
  CANTIDAD_APROBADA VARCHAR(20),
  FEC_APROBADA VARCHAR(50),
  COD_APROBADA VARCHAR(20),
  PRIMARY KEY (COD_PRODUCTO,COD_REQUERIMIENTO),
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_REQUERIMIENTO) REFERENCES T_TMPREQUERIMIENTO(COD_REQUERIMIENTO)
 )
 
 CREATE TABLE T_TMPREQUERIMIENTO_INSUMO(
  COD_REQUERIMIENTO char(9),
  COD_PRODUCTO char(6),
  COD_PRODUCTO_ITEM char(6),
  CANTIDAD NUMERIC(9,2),
   PRIMARY KEY (COD_PRODUCTO,COD_REQUERIMIENTO),
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_REQUERIMIENTO) REFERENCES T_TMPREQUERIMIENTO(COD_REQUERIMIENTO)
 )
 
 CREATE TABLE T_TMPREQUERIMIENTO_ENVASE(
  COD_REQUERIMIENTO char(9),
  COD_PRODUCTO char(6),
  COD_PRODUCTO_ITEM char(6),
  CANTIDAD NUMERIC(9,2),
  PRIMARY KEY (COD_PRODUCTO,COD_REQUERIMIENTO),
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_REQUERIMIENTO) REFERENCES T_TMPREQUERIMIENTO(COD_REQUERIMIENTO)
 )
 
 
  CREATE TABLE T_TMPORDEN_COMPRA(
  COD_ORDEN_COMPRA char(9)  PRIMARY KEY,
  COD_REQUERIMIENTO char(9),
  COD_REQUERIMIENTOTEMP char(9),
  FECHA DATETIME DEFAULT GETDATE(),
  CANTIDAD NUMERIC(9,2),
  ESTADO CHAR(1) DEFAULT 'P',
  FECHA_REALIZADA DATE,
  HORA CHAR(8),
  TOTAL NUMERIC(9,2) DEFAULT 0,
  COD_PROVEEDOR CHAR(5),
  FOREIGN KEY (COD_PROVEEDOR) REFERENCES T_PROVEEDOR(COD_PROVEEDOR),
  FOREIGN KEY (COD_REQUERIMIENTO) REFERENCES T_TMPREQUERIMIENTO(COD_REQUERIMIENTO),
 )
 
  CREATE TABLE T_TMPORDEN_COMPRA_ITEM(
  COD_ORDEN_COMPRA char(9),
  COD_PRODUCTO CHAR(6),
  CANTIDAD_INSUMO_ENVASE NUMERIC(9,2),
  CANTIDAD_MINIMA NUMERIC(9,2),
  MONTO NUMERIC(9,2),
  ESTADO CHAR(1) DEFAULT 'P',
  COD_TMPCOMPROBANTE CHAR(9),

  PRIMARY KEY (COD_PRODUCTO,COD_ORDEN_COMPRA),
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_ORDEN_COMPRA) REFERENCES T_TMPORDEN_COMPRA(COD_ORDEN_COMPRA),
 
 )
  
  CREATE TABLE T_TMPORDEN_COMPRA_IMAGENES (
   CODIGO_IMAGENES INT IDENTITY(1,1) PRIMARY KEY,
   COD_ORDEN_COMPRA CHAR(9),
   IMAGEN IMAGE,

   FOREIGN KEY (COD_ORDEN_COMPRA) REFERENCES T_TMPORDEN_COMPRA(COD_ORDEN_COMPRA)
)
 
 CREATE TABLE T_TMPALMACEN_INSUMOS(
  COD_ALIN INT IDENTITY(1,1),
  COD_ALMACEN char(5),
  COD_PRODUCTO char(6),
  STOCK_ACTUAL numeric(9,3),
  STOCK_MINIMO numeric(9,0),
  PRECIO_COMPRA numeric(7,2),
  STOCK_ANTERIOR numeric(9,3),
  FEC_MODIFICO datetime,
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
 )
 
 
  CREATE TABLE T_TMPCANTIDAD_MINIMA(
  COD_CANTIDAD_MINIMA CHAR(7),
   COD_PRODUCTO char(6),
   CANTIDAD_MINIMA numeric(9,3),
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
   )


  CREATE TABLE T_TMPAVANCE_INSUMOS_PRODUCTOS(
  COD_AVANCE_INSUMOS CHAR(9) PRIMARY KEY,
  N_BACHADA CHAR(6),
  COD_PRODUCTO CHAR(6),
  COD_PRODUCCION CHAR(9),
  CANTIDAD VARCHAR(15),
  FECHA DATETIME DEFAULT GETDATE(),


  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_PRODUCCION) REFERENCES T_TMPPRODUCCION(COD_PRODUCCION)
)

CREATE TABLE T_TMPAVANCE_INSUMOS_PRODUCTOS_ITEM(
  COD_AVANCE_INSUMOS CHAR(9),
  COD_PRODUCTO CHAR(6),
  CANTIDAD VARCHAR(15),

  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
   FOREIGN KEY (COD_AVANCE_INSUMOS) REFERENCES T_TMPAVANCE_INSUMOS_PRODUCTOS(COD_AVANCE_INSUMOS)
)

CREATE TABLE T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASES(
  COD_AVANCE_INSUMOS CHAR(9),
  COD_PRODUCTO CHAR(6),
  CANTIDAD VARCHAR(15),
  LOTE VARCHAR(80),

  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
   FOREIGN KEY (COD_AVANCE_INSUMOS) REFERENCES T_TMPAVANCE_INSUMOS_PRODUCTOS(COD_AVANCE_INSUMOS)
)


CREATE TABLE T_ALMACEN_PRODUCTOS(
  COD_INGRESO CHAR(9),
  COD_PRODUCTO CHAR(6),
  COD_ALMACEN CHAR(5),
  NUM_LOTE CHAR(9),

  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
   
)

CREATE TABLE T_TMPPRODUCCION_BARRAS(
  COD_PRODUCCION_BARRAS CHAR(9),
  COD_PRODUCCION CHAR(9),
  COD_PRODUCTO CHAR(6),
  NUM_LOTE CHAR(9),
  EST_IMPRESION CHAR(1) DEFAULT '0',
  EST_ALMACEN CHAR(1) DEFAULT '0',
  USU_REGISTRO VARCHAR(30),
  FEC_REGISTRO DATETIME DEFAULT GETDATE(),
  USU_MODIFICO VARCHAR(30),
  FEC_MODIFICO DATETIME,
  MAQUINA VARCHAR(50),

  FOREIGN KEY (COD_PRODUCCION) REFERENCES T_TMPPRODUCCION(COD_PRODUCCION),
   FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
   
)

  CREATE TABLE [dbo].[T_TMPPRODUCCION_BARRAS_GRUPO](
	[CODIGO] [numeric](18, 0) IDENTITY(1,1) NOT NULL,
	[COD_PRODUCTO] [char](6) NULL,
	[DES_PRODUCTO] [varchar](50) NULL,
	[N_CAJA] [int] NULL,
	[CANTIDAD] [int] NULL,
	[ABR_PRODUCTO] [char](3) NULL,
	[BARRA_INI] [numeric](7, 0) NULL,
	[BARRA_FIN] [numeric](7, 0) NULL,
	[EST_IMPRESION] [char](1) NULL,
	[COD_PRODUCCION] [char](9) NULL,
	[NUM_LOTE] [char](9) NULL,
	[PRODUCCION] [char](10) NULL,
	[FECHA] [datetime] NULL,
	[FEC_VENCIMIENTO] [datetime] NULL,
	[N_PRODUCCION_G] [char](10) NULL,
	
   FOREIGN KEY (COD_PRODUCCION) REFERENCES T_TMPPRODUCCION(COD_PRODUCCION),
   FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
	)
 
   CREATE TABLE T_TMPCOMPROBANTE(
	
	COD_TMPCOMPROBANTE CHAR(9) PRIMARY KEY,
	COD_PROVEEDOR CHAR(5), 
	COD_EMPRESA CHAR(5),
	OFICINA CHAR(5),
	TIPO_MONEDA CHAR(1),
	F_PAGO CHAR(1),
	FECHA_REALIZADA DATE,
	COD_USUARIO CHAR(5),
	COD_ORDEN_COMPRA CHAR(9),
	MONTO_TOTAL NUMERIC(9,2),
	ESTADO CHAR(1) DEFAULT 'P',
	OBSERVACION VARCHAR(200),
	HORA CHAR(8),

	FOREIGN KEY (COD_USUARIO) REFERENCES T_USUARIO(COD_USUARIO),
	FOREIGN KEY (COD_ORDEN_COMPRA) REFERENCES T_TMPORDEN_COMPRA(COD_ORDEN_COMPRA),
)

  CREATE TABLE T_TMPCOMPROBANTE_ITEM(
	
	COD_TMPCOMPROBANTE CHAR(9) ,
	SERIE VARCHAR(20),
	CORRELATIVO VARCHAR(20),
	COD_EMPRESA CHAR(5),
	TIPO_MONEDA CHAR(1),
	F_PAGO CHAR(1),
	FECHA_EMISION DATE,
	HORA VARCHAR(50),
	FECHA_ENTREGA DATE,
	TIPO_COMPROBANTE CHAR(1),
	PDF IMAGE,
	OBSERVACION VARCHAR(200),
	COD_USUARIO CHAR(5),
	
	PRIMARY KEY (COD_USUARIO,COD_TMPCOMPROBANTE),
	FOREIGN KEY (COD_USUARIO) REFERENCES T_USUARIO(COD_USUARIO),
	FOREIGN KEY (COD_TMPCOMPROBANTE) REFERENCES T_TMPCOMPROBANTE(COD_TMPCOMPROBANTE),
)
   
   
    CREATE TABLE [dbo].[T_USUARIO](
	[COD_USUARIO] [char](5) NOT NULL PRIMARY KEY,
	[USU_USUARIO] [varchar](15) NULL,
	[PAS_USUARIO] [char](8) NULL,
	[EST_USUARIO] [char](1) NULL,
	[COD_PERSONAL] [char](5) NULL,
	[USU_REGISTRO] [varchar](30) NULL,
	[FEC_REGISTRO] [datetime] NULL,
	[USU_MODIFICO] [varchar](30) NULL,
	[FEC_MODIFICO] [datetime] NULL,
	[MAQUINA] [varchar](50) NULL,
	[COINCIDENCIA] [char](8) NULL,
	)
	
	
	CREATE TABLE [dbo].[T_TIPOCAMBIO](
	[CODIGO] [numeric](18, 0) IDENTITY(1,1) NOT NULL,
	[FECHA] [datetime] NULL,
	[COMPRA] [numeric](7, 3) NULL,
	[VENTA] [numeric](7, 3) NULL,
	[COD_USUARIO] [char](5) NULL,
	[MAQUINA] [varchar](50) NULL,
	[FEC_REGISTRO] [datetime] NULL,
	)
	
	CREATE TABLE [dbo].[T_TMPCAB_MENU](
	[ID_MENU] [char](3) NOT NULL PRIMARY KEY,
	[NOMBRE] [varchar](100) NULL,
	[URL] [varchar](100) NULL,
	[ESTADO] [char](1) NULL
     )
     
   CREATE TABLE [dbo].[T_TMPSUB_MENUS](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ID_MENU] [char](3) NULL,
	[ID_SUBMENU1] [char](3) NOT NULL PRIMARY KEY,
	[SUB_NOMBRE1] [varchar](100) NULL,
	[URL1] [varchar](100) NULL,
	[IDSUBMENU1] [char](3) NULL,
	[IDSUBMENU2] [char](3) NULL,
	[SUB_NOMBRE2] [varchar](100) NULL,
	[URL2] [varchar](100) NULL,
	[ESTADO1] [char](1) NULL,
	[ESTADO2] [char](1) NULL,
	
	FOREIGN KEY (ID_MENU) REFERENCES T_TMPCAB_MENU(ID_MENU),
    )
    
    CREATE TABLE T_TMPPERMISOS(
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ANEXO] [char](4) NULL,
	[MENU] [char](3) NULL,
	[SUB_MENU1] [char](3) NULL,
	[SUB_MENU2] [char](3) NULL,
	
	FOREIGN KEY (MENU) REFERENCES T_TMPCAB_MENU(ID_MENU),
	FOREIGN KEY (SUB_MENU1) REFERENCES T_TMPSUB_MENUS(ID_SUBMENU1),
    ) 
    
    CREATE TABLE T_TMPCONTROL_RECEPCION_COMPRAS(
	
	COD_TMPCONTROL_RECEPCION_COMPRAS CHAR(9) PRIMARY KEY,
	CODIGO_PERSONAL CHAR(5),
	FECHA DATE DEFAULT GETDATE(),
	CODIGO_REQUERIMIENTO CHAR(9),
	ESTADO CHAR(1) DEFAULT 'P'
    ) 
    
   CREATE TABLE T_TMPCONTROL_RECEPCION_COMPRAS_ITEM(
	
	COD_TMPCONTROL_RECEPCION_COMPRAS CHAR(9),
	COD_TMPCOMPROBANTE CHAR(9),
	CODIGO_LOTE CHAR(9),
	COD_PRODUCTO CHAR(6),
	FECHA_VENCIMIENTO DATE,
    GUIA CHAR(1),
    BOLETA CHAR(1),
    FACTURA CHAR(1),
    PRIMARIO CHAR(1),
    SECUNDARIO CHAR(1),
    SACO CHAR(1),
    CAJA CHAR(1),
    CILINDRO CHAR(1),
    BOLSA CHAR(1),
    ENVASE CHAR(1),
    CERTIFICADO CHAR(1),
    ROTULACION CHAR(1),
    APLICACION CHAR(1),
    HIGIENE CHAR(1),
    INDUMENTARIA CHAR(1),
    LIMPIO CHAR(1),
    EXCLUSIVO CHAR(1),
    HERMETICO CHAR(1),
    AUSENCIA CHAR(1),
    FECHA_GENERADA DATE DEFAULT GETDATE(),
    OBSERVACION VARCHAR(200)
    
    PRIMARY KEY (COD_TMPCOMPROBANTE,COD_TMPCONTROL_RECEPCION_COMPRAS,COD_PRODUCTO),
    FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
    FOREIGN KEY (COD_TMPCONTROL_RECEPCION_COMPRAS) REFERENCES T_TMPCONTROL_RECEPCION_COMPRAS(COD_TMPCONTROL_RECEPCION_COMPRAS),
    FOREIGN KEY (COD_TMPCOMPROBANTE) REFERENCES T_TMPCOMPROBANTE(COD_TMPCOMPROBANTE),
    ) 
    
      
   CREATE TABLE T_TMPCONTROL_RECEPCION_COMPRAS_OBSERVACION(
	
	COD_TMPCONTROL_RECEPCION_COMPRAS CHAR(9),
	FECHA DATE,
	OBSERVACION VARCHAR(200),
	ACCION_CORRECTIVA VARCHAR(200),
	
	FOREIGN KEY (COD_TMPCONTROL_RECEPCION_COMPRAS) REFERENCES T_TMPCONTROL_RECEPCION_COMPRAS(COD_TMPCONTROL_RECEPCION_COMPRAS),

   )
   
   
  CREATE TABLE T_TMPORDEN_COMPRATEMP(
  COD_ORDEN_COMPRA char(9)  PRIMARY KEY,
  COD_REQUERIMIENTO char(9),
  COD_REQUERIMIENTOTEMP char(9),
  FECHA DATETIME DEFAULT GETDATE(),
  CANTIDAD NUMERIC(9,2),
  ESTADO CHAR(1) DEFAULT 'P',
  FECHA_REALIZADA DATE,
  HORA CHAR(8),
  TOTAL NUMERIC(9,2) DEFAULT 0,
  COD_PROVEEDOR CHAR(5),

 )
 
  CREATE TABLE T_TMPORDEN_COMPRA_ITEMTEMP(
  COD_ORDEN_COMPRA char(9),
  COD_PRODUCTO CHAR(6),
  CANTIDAD_INSUMO_ENVASE NUMERIC(9,2),
  CANTIDAD_MINIMA NUMERIC(9,2),
  MONTO NUMERIC(9,2),
  F_PAGO CHAR(1),
  ESTADO CHAR(1) DEFAULT 'P',
  COD_TMPCOMPROBANTE CHAR(9),
  PRIMARY KEY (COD_PRODUCTO,COD_ORDEN_COMPRA),
  FOREIGN KEY (COD_PRODUCTO) REFERENCES T_PRODUCTO(COD_PRODUCTO),
  FOREIGN KEY (COD_ORDEN_COMPRA) REFERENCES T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA)
 )
 
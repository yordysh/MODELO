<?php   
    require_once('../menulista/index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script type="text/javascript" src="./js/jsreportekardex.js"></script>
    <link rel="stylesheet" href="./css/select2.min.css">
    <script src="./js/select2.min.js"></script>
    <title>Covifarma</title>
</head>
<style>
main {
  width: 100%;
  margin: 0 auto;
  padding: 4em;
  height: 57%;
}

.btnbuscar{
    float: right;
  }

@media screen and (max-width: 992px) {
  main {
    width: 100%;
    margin: 0 auto;
   
    height: 57%;
  }


} 

@media screen and (max-width: 768px) {
  main {
    width: 100%;
    margin: 0 auto;
    padding: 6em 0 0 1em;
    height: 57%;
  }
}
</style>
<body>
    <main>
            <div class="g-4 row">
                <div class="row g-5 top-div">
                    <center><label class="title">REPORTE KARDEX</label></center>
                </div>
                
                    <div class="form-outline mb-1 col-md-3">
                        <label> Producto</label>
                        <select id="slcproducto" class="form-select form-select-sm" >
                        </select>
                    </div>
                    <div class="form-outline mb-1 col-md-3">
                        <label>LOTES</label>
                        <select id="slclote" class="form-select form-select-sm" >
                            <option selected value="">SELECCIONE LOTE</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>FECHA INI</label>
                        <input type="date" id="txtfechaini" name="txtfechaini" class="form-control form-control-sm"/>
                    </div>
                    <div class="col-md-3 mb-4">
                        <label>FECHA FIN</label>
                        <input type="date" id="txtfechafin" name="txtfechafin" class="form-control form-control-sm"/>
                    </div>
            </div> 
            <div  class="row g-4">
                    <div class="col-md-12 g-4">
                        <button  type="button" id="btnbuscar" class="btnbuscar btn btn-sm btn-primary">Buscar</button>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive">
                <table class="table" id="tbtablakardex">
                    <thead>
                        <tr>
                        <th scope="col">INSUMO</th>
                        <th scope="col">LOTE</th>
                        <th scope="col">FECHA</th>
                        <th scope="col">DESCRIPCIÓN</th>
                        <th scope="col">INGRESO</th>
                        <th scope="col">SALIDA</th>
                        <th scope="col">SALDO</th>
                        </tr>
                    </thead>
                    <tbody id="tbdreportekardex">
                    </tbody>
                </table>
                </div>
            </div>   
    </main>
</body>
</html>
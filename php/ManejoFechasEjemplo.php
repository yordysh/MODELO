<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="shortcut icon" href="img/logo-mywebsite-urian-viera.svg" />
    <title>Recorrer un rango de Fechas con PHP :: WebDeveloper Urian Viera</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"> -->
    <style>
        h4 {
            padding: 0px !important;
            color: crimson;
            margin-bottom: 35px;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" style="background-color: #563d7c !important;">
        <span class="navbar-brand">
            <!-- <img src="img/logo-mywebsite-urian-viera.svg" alt="Web Developer Urian Viera" width="120"> -->
            xd
        </span>
    </nav>

    <div class="container mt-5 p-5">

        <h4 class="text-center">Recorrer un rango de Fechas con PHP</h4>
        <hr>


        <div class="row text-center" id="capa">
            <div class="col-md-6">
                <strong>Registrar Empleado</strong>
            </div>
        </div>
        <!-- <div class="col mt-2">
            <label for="fechaInicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" required="true">
        </div> -->
        <div class="col mt-2">
            <label for="fechaFin" class="form-label">Numero de días</label>
            <input type="text" class="form-control" name="numerodias" id="numerodias" required="true">
        </div>
        <div class="col mt-2">
            <button class="btn btn-primary" onclick="calcularDiasRestantes()">Calcular</button>
        </div>
        <div id="resultado"></div>



    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Incluye la librería SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.addEventListener('load', function() {
            // Código a ejecutar cuando se cargue completamente la página
            alert('¡Bienvenido a la página!');
        });
    </script>


    <script>
        function calcularDiasRestantes() {
            var numerodias = document.getElementById("numerodias").value;

            // Envío de la solicitud AJAX al servidor
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "procesar.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    // Mostrar la alerta con SweetAlert
                    // swal("Días restantes", response, "info");
                    Swal.fire({
                        title: 'Días restantes',
                        text: response,
                        icon: 'info'
                    });
                }
            };
            xhr.send("numerodias=" + numerodias);
        }
    </script>
    <!-- 
    <script>
        $(document).ready(function() {
            $('#calcularDias').click(function() {
                var fechaInicio = $('#fechaInicio').val();
                var numeroDias = $('#numerodias').val();

                $.ajax({
                    url: 'procesar.php',
                    method: 'POST',
                    data: {
                        fechaInicio: fechaInicio,
                        numeroDias: numeroDias
                    },
                    success: function(response) {
                        // Utiliza Swal.fire para mostrar la alerta
                        Swal.fire({
                            title: 'Días restantes',
                            text: response,
                            icon: 'info'
                        });
                    }
                });
            });
        });
    </script> -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</body>

</html>
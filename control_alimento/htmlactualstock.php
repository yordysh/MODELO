<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsivePO.css">
    <title>Document</title>
</head>

<body>
    <?php
    require_once('../menulista/index.php');
    ?>
    <main>
        <section>
            <div class="container row">
                <div class="md-6">
                    <!-- <button href="../control_alimento/pdf-lista-stock-actual.php" class="btn btn-success">Pdf stock actual</button> -->
                    <a class="btn btn-success " href="#" onclick="generarPDF()">Pdf stock actual</a>
                </div>
            </div>
        </section>
    </main>
    <script src="./js/bootstrap.min.js"></script>
    <script>
        function generarPDF() {
            // Enviar los valores a tu script de generación de PDF
            var url = "../control_alimento/pdf-lista-stock-actual.php";
            window.open(url, "_blank");
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include('layouts/utilities.php'); ?>
    <title>TEST ENVIA</title>
    <meta property="og:type" content="website" />
    <title>Document</title>
</head>
<body>
    <div id="wrapper">
        <section>
            <div>
                Numero de ordenes generadas <span id="nOrders" >  </span>.
            </div>
            <div>
                <div>
                <input id="socketOn" class="btn" type="button" value="hacer compra"/>
                </div>
            </div>
        </section>
    </div> 
       <script src="assets/js/index.js?v=<?php echo(rand(1,99999)); ?>"></script>
       <script src="assets/js/constant.js?v=<?php echo(rand(1,99999)); ?>"></script>
</body>
</html>

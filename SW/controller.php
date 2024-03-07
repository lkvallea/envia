<?php
   include ('WSheaders.php');

if (! empty($_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'createLabel':
            include ('cLabels.php');
            $labels = new cLabels();
            $labels->createLabel();
            break;
        case 'testConection':
            include ('cLabels.php');
            $labels = new cLabels();
            $labels->testConection();
            var_dump($labels);
            break;
    }
}else{
 header('location:http://localhost:8080/envia/');
}

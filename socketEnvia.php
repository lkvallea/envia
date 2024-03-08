<?php
// Configurar las opciones del servidor WebSocket
//$host = 'localhost';
$host = 'TU IP';
$port = 9090;
$address = "0.0.0.0";

// Crear un socket para el servidor WebSocket
if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() falló: razón: " . socket_strerror(socket_last_error()) . "\n";
} else {
    socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
    //bind socket to specified host
    if (socket_bind($socket, $address, $port) === false) {

        echo "socket_bind() falló: razón: " . socket_strerror(socket_last_error($socket)) . "\n";
    }
    //listen to port

    if (socket_listen($socket, 5) === false) {

        echo "socket_listen() falló: razón: " . socket_strerror(socket_last_error($socket)) . "\n";
    }

    echo "Servidor WebSocket iniciado en $host:$port\n";

    $clients = array($socket);

    while (true) {
        // Aceptar nuevas conexiones
        $nuevo_cliente = socket_accept($socket);
        // Agregar el nuevo cliente a la lista de clientes
        $clients[] = $nuevo_cliente;
        // Mostrar información sobre el nuevo cliente
        $direccion_cliente = '';
        socket_getpeername($nuevo_cliente, $direccion_cliente);
        echo "Nuevo cliente conectado: $direccion_cliente\n";
        // Leer el mensaje enviado por el cliente
        perform_handshaking($nuevo_cliente);
        socket_getpeername($nuevo_cliente, $ip);
        $nuevas_ordenes = check_new_orders();
        send_message($nuevas_ordenes);      
    }
}

function send_message($nuevas_ordenes)
{
    global $clients;
    sleep(1);
    foreach ($clients as $changed_socket) {
        $content = $nuevas_ordenes;
        $msg = chr(129) . chr(strlen($content)) . $content;
        @socket_write($changed_socket, $msg, strlen($msg));
    }

    return true;
}

function perform_handshaking($client)
{
    $request = socket_read($client, 5000);
    preg_match('#Sec-WebSocket-Key: (.*)\r\n#', $request, $matches);
    $key = base64_encode(pack(
        'H*',
        sha1($matches[1] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')
    ));
    $headers = "HTTP/1.1 101 Switching Protocols\r\n";
    $headers .= "Upgrade: websocket\r\n";
    $headers .= "Connection: Upgrade\r\n";
    $headers .= "Sec-WebSocket-Version: 13\r\n";
    $headers .= "Sec-WebSocket-Accept: $key\r\n\r\n";
    socket_write($client, $headers, strlen($headers));
}

function check_new_orders(){
    $host = "TU IP:TU PUERTO";
    $ursql = "envia";
    $pass = "As6zUNeFi._I97ng";
    $db = "envia";
    $conn = new mysqli($host,$ursql,$pass,$db);
    if ($conn->connect_error) {
        echo("Connection failed: " . $conn->connect_error);
    }

    try {
        $mysql = "SELECT COUNT(trackingNumber) as numLabels FROM labels WHERE trackingNumber != 'NULL'; ";
        $stmt = $conn->prepare($mysql);
        $stmt->execute();
        $stmt->bind_result($numero_ordenes);
        $stmt->fetch();
        $stmt->close();
        $conn->close();
        return $numero_ordenes;
    } catch (Exception $e) {
        $stmt = array(
            'error' => $e->getMessage()
        );
        $stmt->close();
        $conn->close();
        echo json_encode($stmt);
    }
    
}
// Cerrar el socket del servidor
socket_close($socket);

<?php
include('cConections.php');

class cLabels extends cConections
{

    public function testConection()
    {
        $mysql = "SELECT DISTINCT id FROM labels WHERE id != ?";
        $tPr = "i";
        $vPr = [
            '0'
        ];
        $sqlResult = $this->stmtExecution($mysql, $tPr, $vPr);
        $result = $sqlResult->get_result();
        $sqlResult->close();
    }

    public function createLabel()
    {

        $response = $this->call_socket();
        $request_body = json_encode($this->request_body);
        $authorization = "Authorization: Bearer " . $this->token;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->environment,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $request_body,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                $authorization
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
       // $response = json_decode($this->responseEnviaTestGenerate);
        if (isset($response->meta) && $response->meta == 'generate') {
            $mysql = "INSERT INTO labels (trackingNumber) VALUES (?) ";
            $tPr = "s";
            $vPr = [
                $response->data[0]->trackingNumber
            ];
            $sqlResult = $this->stmtExecution($mysql, $tPr, $vPr);
            if ($sqlResult->affected_rows > 0) {
                $response = [
                    "meta" => "OK",
                    "msg" => "ok",
                    "socket" => $this->call_socket()
                ];
            } else {
                $response = [
                    "meta" => "error",
                    "msg" => "no se pudo agrear datos a la base"
                ];
            }
            $sqlResult->close();
            $this->connection->close();
        } else {
            $response = [
                "meta" => $response->meta,
                "msg" => $response->error->message
            ];
        }

        echo json_encode($response);
    }

    private function call_socket()
    {
        $host = "TU IP";
        $puerto = 9090;
        $fp = stream_socket_client($host . ":" . $puerto, $errno, $errstr);
        if (!$fp) {
            $response = "ERROR: $errno - $errstr<br />\n";
        } else {
            $headers = $this->perform_handshaking();
            fwrite($fp, $headers);
            $response = fread($fp, 5000);
            fclose($fp);
        }
        return $response;
    }

    public function perform_handshaking()
    {
        $sec_websocket_key = $this->create_sec_websocket_key();
        $key = base64_encode(pack(
            'H*',
            sha1($sec_websocket_key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')
        ));
        $headers = "HTTP/1.1 101 Switching Protocols\r\n";
        $headers .= "Upgrade: websocket\r\n";
        $headers .= "Connection: Upgrade\r\n";
        $headers .= "Sec-WebSocket-Version: 13\r\n";
        $headers .= "Sec-WebSocket-Key: $key\r\n\r\n";
        return $headers;
    }

    public function create_sec_websocket_key()
    {
        $websocket_key = substr(str_shuffle($this->sec_key_char), 0, 8) . "-" .
            substr(str_shuffle($this->sec_key_char), 0, 4) . "-" .
            substr(str_shuffle($this->sec_key_char), 0, 4) . "-" .
            substr(str_shuffle($this->sec_key_char), 0, 4) . "-" .
            substr(str_shuffle($this->sec_key_char), 0, 12);
        return $websocket_key;
    }
}

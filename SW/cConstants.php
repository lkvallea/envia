<?php


class cConstants{
        
    public $host = "localhost:3306";

    public $ursql = "envia";

    public $pass = "As6zUNeFi._I97ng";

    public $db = "envia";

    public $token = "62004bcaf2ae9432a25d9d6d2d2bd44279d9539349d94e2fab658eb7c4ad9d77";

    public $environment = "https://api-test.envia.com/ship/generate/";

    public $sec_key_char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    public $request_body = [
        "origin" => [
            "name" => "LUIS ENRIQUE VALLE ASCENCIO",
            "company" => "envia",
            "email" => "LK.VALLE.A@GMAIL.COM",
            "phone" => "5585321524",
            "street" => "BAHIA  LOS SANTOS",
            "number" => "1",
            "district" => "Verónica Anzures",
            "city" => "Ciudad de México",
            "state" => "CX",
            "country" => "MX",
            "postalCode" => "11300",
            "reference" => ""
        ],
        "destination" => [
            "name" => "luis valle",
            "company" => null,
            "email" => "lk.valle.a@gmail.com",
            "phone" => "5585321524",
            "street" => "francisco villa",
            "number" => "100",
            "district" => "San Carlos",
            "city" => "Ecatepec de Morelos",
            "state" => "EM",
            "country" => "MX",
            "postalCode" => "55080",
            "reference" => ""
        ],
        "packages" => [
            [
                "content" => "camisetas rojas",
                "amount" => 1,
                "type" => "envelope",
                "dimensions" => [
                    "length" => 1,
                    "width" => 5,
                    "height" => 2
                ],
                "weightt" => 1,
                "insurance" => 5,
                "declaredValue" => 400,
                "weightUnit" => "KG",
                "lengthUnit" => "CM"
            ]
        ],
        "shipment" => [
            "carrier" => "dhl",
            "service" => "ground",
            "type" => 1
        ],
        "settings" => [
            "printFormat" => "PDF",
            "printSize" => "PAPER_4X6",
            "default" => 0
        ]
    ];

    public $responseEnviaTestGenerate = '{
        "meta": "generate",
        "data": [
          {
            "carrier": "ups",
            "service": "ground",
            "trackingNumber": "1Z68W99A4297214308",
            "trackUrl": "https://envia.com/rastreo?label=1Z68W99A4297214308&cntry_code=us",
            "label": "https://s3.us-east-2.amazonaws.com/enviapaqueteria/uploads/ups/1Z68W99A42972143081118461362db7dbe1c.pdf",
            "additionalFiles": [],
            "totalPrice": 257.12,
            "currentBalance": 8230.67,
            "currency": "MXN"
          }
        ]
      }';
}
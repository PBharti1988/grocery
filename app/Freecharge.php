<?php

namespace App;

class Freecharge
{

    public function checksum($params)
    {
        $data['method'] = "POST";
        $data['params'] = $params;
        //$data['url'] = url('/public/fc-sdk/api/vi/coi/checksum');
        $data['url'] = "https://qrestro.com/sodhis/public/fc-sdk/api/vi/coi/checksum";
        return $this->authQuery($data);
    }

    public function txnStatus($params)
    {
        $data['method'] = "GET";
        $data['params'] = $params;
        $platformId = $params['platformId'];
        $merchantTxnId = $params['merchantTxnId'];
        $merchantId = $params['merchantId'];
        $checksum = $params['checksum'];
        $data['url'] = "https://checkout-sandbox.freecharge.in/api/v1/co/transaction/status?platformId=$platformId&merchantTxnId=$merchantTxnId&merchantId=$merchantId&checksum=$checksum&txnType=CUSTOMER_PAYMENT";

        $ch = curl_init($data['url']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $data['method']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function placeOrder($params)
    {
        $data['method'] = "POST";
        $data['params'] = $params;
        $data['url'] = "https://qrestro.com/sodhis/api/place-order";

        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode("admin:p@btvp#5")
        );

        $ch = curl_init($data['url']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $data['method']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['params']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    private function authQuery($data)
    {
        $ch = curl_init($data['url']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $data['method']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['params']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}

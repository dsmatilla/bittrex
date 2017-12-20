<?php
// Donate to
// BTC : 1BLsrDyoG5r1U82b1FKC9gLARntJZmxQRx
// LTC : LVBNoytMn6CSDFDAefVJGwf4uHPZJzn29q
// ETH : 0x6d08f4d413087472cdff9acaa89373768dadd932
// Thank you
class Bittrex
{
    private $apikey;
    private $apisecret;

    public function __construct($apikey, $apisecret)
    {
        $this->apikey = $apikey;
        $this->apisecret = $apisecret;
    }

    public function __destruct()
    {
        unset($this->apikey);
        unset($this->apisecret);
    }

    private function request($method, $params = null) {
        $nonce = time();
        $url = "https://bittrex.com/api/v1.1/".$method."?apikey=".$this->apikey."&nonce=".$nonce;
        if($params) {
            $url .= "&".http_build_query($params);
        }

        $sign = hash_hmac('sha512',$url,$this->apisecret);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('apisign:'.$sign));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res);
    }

    public function getMarkets() {
        $method = "public/getmarkets";
        return $this->request($method);
    }

    public function getCurrencies() {
        $method = "public/getcurrencies";
        return $this->request($method);
    }

    public function getTicker($market) {
        $method = "public/getticker";
        $params = Array(
            "market" => $market
        );
        return $this->request($method, $params);
    }

    public function getMarketSummaries() {
        $method = "public/getmarketsummaries";
        return $this->request($method);
    }

    public function getMarketSummary($market) {
        $method = "public/getmarketsummary";
        $params = Array(
            "market" => $market
        );
        return $this->request($method, $params);
    }

    public function getOrderBook($market, $type) {
        $method = "public/getorderbook";
        $params = Array(
            "market" => $market,
            "type" => $type
        );
        return $this->request($method, $params);
    }

    public function getMarketHistory($market) {
        $method = "public/getmarkethistory";
        $params = Array(
            "market" => $market
        );
        return $this->request($method, $params);
    }

    public function buyLimit($market, $quantity, $rate) {
        $method = "market/buylimit";
        $params = Array(
            "market" => $market,
            "quantity" => $quantity,
            "rate" => $rate
        );
        return $this->request($method, $params);
    }

    public function sellLimit($market, $quantity, $rate) {
        $method = "market/selllimit";
        $params = Array(
            "market" => $market,
            "quantity" => $quantity,
            "rate" => $rate
        );
        return $this->request($method, $params);
    }

    public function cancel($uuid) {
        $method = "market/cancel";
        $params = Array(
            "uuid" => $uuid
        );
        return $this->request($method, $params);
    }

    public function getOpenOrders($market) {
        $method = "market/getopenorders";
        $params = Array(
            "market" => $market
        );
        return $this->request($method. $params);
    }

    public function getBalances() {
        $method = "account/getbalances";
        return $this->request($method);
    }

    public function getBalance($currency) {
        $method = "account/getbalance";
        $params = Array(
            "currency" => $currency
        );
        return $this->request($method, $params);
    }

    public function getDepositAddress($currency) {
        $method = "account/getdepositaddress";
        $params = Array(
            "currency" => $currency
        );
        return $this->request($method, $params);
    }

    public function withdraw($currency, $quantity, $address, $paymentid) {
        $method = "account/withdraw";
        $params = Array(
            "currency" => $currency,
            "quantity" => $quantity,
            "address" => $address,
            "paymentid" => $paymentid
        );
        return $this->request($method, $params);
    }

    public function getOrder($uuid) {
        $method = "account/getorder";
        $params = Array(
            "uuid" => $uuid
        );
        return $this->request($method, $params);
    }

    public function getOrderHistory($market) {
        $method = "account/getorderhistory";
        $params = Array(
            "market" => $market
        );
        return $this->request($method, $params);
    }

    public function getWithdrawalHistory($currency) {
        $method = "account/getwithdrawalhistory";
        $params = Array(
            "currency" => $currency
        );
        return $this->request($method, $params);
    }

    public function getDepositHistory($currency) {
        $method = "account/getdeposithistory";
        $params = Array(
            "currency" => $currency
        );
        return $this->request($method, $params);
    }
}
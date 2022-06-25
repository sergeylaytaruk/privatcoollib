<?php

namespace PrivatCoolLib;

class Exchange
{
    private $url;
    private $from;
    private $to;
    private $amount;
    private $rate = 0;

    public function __construct($from, $to, $amount)
    {
        $this->from = strtoupper($from);
        $this->to = strtoupper($to);
        $this->amount = floatval($amount);
        $this->url = "https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5";
        $this->getRate();
    }

    private function getRate()
    {
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($resp, true);
        $this->findRate($resp);
    }

    private function findRate(array $resp)
    {
        foreach ($resp as $item) {
            if (strtoupper($item['ccy']) == $this->from && strtoupper($item['base_ccy']) == $this->to) {
                $this->rate = floatval($item['buy']);
            }
        }
    }

    public function toDecimal(): string
    {
        $sum = floatval($this->amount * $this->rate);
        return number_format($sum, 2, '.', '');
    }
}
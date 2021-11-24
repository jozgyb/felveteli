<?php
class Arfolyam_Model
{
    private SoapClient $client;

    public function __construct()
    {
        $this->client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
    }

    public function getMonthlyExchangeRates(?string $startDate, ?string $endDate, ?string $currencyNames)
    {
        $query = array('startDate' => $startDate, 'endDate' => $endDate, 'currencyNames' => $currencyNames);
        try {
            $havi_arfolyam = (array)simplexml_load_string($this->client->GetExchangeRates($query)->GetExchangeRatesResult);
        } catch (SoapFault $e) {
            var_dump($e);
        }
        return $havi_arfolyam;
    }

    public function getDailyExchangeRates(?string $day, ?string $currencyNames)
    {
        $query = array('startDate' => $day, 'endDate' => $day, 'currencyNames' => $currencyNames);
        try {
            $napi_arfolyam = (array)simplexml_load_string($this->client->GetExchangeRates($query)->GetExchangeRatesResult);
        } catch (SoapFault $e) {
            var_dump($e);
        }
        return $napi_arfolyam;
    }

    public function getDateLimits()
    {
        try {
            $info = (array)simplexml_load_string($this->client->GetInfo()->GetInfoResult);
        } catch (SoapFault $e) {
            var_dump($e);
        }
        return array('FirstDate' => $info['FirstDate'], 'LastDate' => $info['LastDate']);
    }

    public function getCurrencies()
    {
        return (array)simplexml_load_string($this->client->GetCurrencies()->GetCurrenciesResult);
    }
}

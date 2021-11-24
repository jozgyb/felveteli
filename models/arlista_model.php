<?php

class Arlista_Model
{
    private SoapClient $client;
    
    public function __construct()
    {
        $this->client = new SoapClient(SERVER_ROOT . 'soap/suti.wsdl');
    }

    public function getSutik($mentes)
    {
        if(empty($mentes))
        {
            return $this->client->getMentesSutik();
        }

        return $this->client->getMentesSutik($mentes);
    }
}

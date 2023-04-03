<?php

namespace RS\ChronopostApi\Wsdl;

use SoapClient;
use RS\ChronopostApi\Client;

class QuickcostServiceWS extends Client {

    const WSDL_QUICK_COST_SERVICE = "https://ws.chronopost.fr/quickcost-cxf/QuickcostServiceWS?wsdl";

    public function __construct(
        public int $accountNumber = null,
        public string $password = null,
        public string $depCountryCode = 'FR',
        public string $depZipCode = null,
        public string $arrCountryCode = 'FR',
        public string $arrZipCode = null,
        public string $arrCity = null,
        public string $productCode,
        public string $type = "M",
        public string $service = "0",
        public ?string $shippingDate = date('d/m/Y'),
    ) {
        parent::__construct(self::WSDL_QUICK_COST_SERVICE);
    }

    public function calculateDeliveryTime(): array
    {
        $params = [
            'depCountryCode' => $this->depCountryCode,
            'depZipCode' => $this->depZipCode,
            'arrCountryCode' => $this->arrCountryCode,
            'arrZipCode' => $this->arrZipCode,
            'arrCity' => $this->arrCity,
            'productCode' => $this->productCode,
            'type' => $this->type,
            'service' => $this->service,
            'shippingDate' => $this->shippingDate,
        ];

        return $this->client->calculateDeliveryTime($params);
    }

    public function calculateProducts($weight): array
    {
        $params = [
            'accountNumber' => $this->accountNumber,
            'password' => $this->password,
            'depCountryCode' => $this->depCountryCode,
            'depZipCode' => $this->depZipCode,
            'arrCountryCode' => $this->arrCountryCode,
            'arrZipCode' => $this->arrZipCode,
            'type' => $this->type,
            'weight' => $weight,
        ];

        return $this->client->calculateProducts($params);
    }

    public function quickCost($weight) {
        $params = [
            'accountNumber' => $this->accountNumber,
            'password' => $this->password,
            'depCode' => $this->depZipCode,
            'arrCode' => $this->arrZipCode,
            'weight' => $weight,
            'productCode' => $this->productCode,
            'type' => $this->type,
        ];

        return $this->client->quickCost($params);
    }

}


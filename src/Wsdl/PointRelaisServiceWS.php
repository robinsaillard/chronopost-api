<?php

namespace RS\ChronopostApi\Wsdl;

use DateTime;
use SoapClient;
use RS\ChronopostApi\Client;

class PointRelaisServiceWS extends Client {

    const WSDL_POINT_RELAIS_SERVICE = "https://ws.chronopost.fr/recherchebt-ws-cxf/PointRelaisServiceWS?wsdl";

    public function __construct(
        public int $accountNumber,
        public string $password,
        public ?string $address = null,
        public string $zipCode = null,
        public string $city = null,
        public string $countryCode = "FR",
        public string $type = "T",
        public string $productCode = "86",
        public string $service = "L",
        public ?float $weight = null,
        public string $shippingDate = date('d/m/Y'),
        public ?int $maxPointChronopost = 25,
        public int $maxDistanceSearch = 10,
        public int $holidayTolerant = 1,
        public string $language = "FR",
        public string $version = "2.0",
    ) {
        parent::__construct(self::WSDL_POINT_RELAIS_SERVICE);
    }


    /**
     * @param string $countryCode (FR, EN, DE, ES, IT...)
     * @param string $zipCode
     * @param string $city
     * @param ?string $address
     * @param ?float $weight
     * @param ?string $lang (FR, EN, DE, ES, IT...)
     */
    public function find(string $countryCode, string $zipCode, string $city, string $address = null, float $weight = null, string $lang = "FR"): array
    {
        $params = [
            'accountNumber' => $this->accountNumber,
            'password' => $this->password,
            'address' => $address,
            'zipCode' => $zipCode,
            'city' => $city,
            'countryCode' => $countryCode,
            'type' => $this->type,
            'productCode' => $this->productCode,
            'service' => $this->service,
            'weight' => $weight,
            'shippingDate' => $this->shippingDate,
            'maxPointChronopost' => $this->maxPointChronopost,
            'maxDistanceSearch' => $this->maxDistanceSearch,
            'holidayTolerant' => $this->holidayTolerant,
            'language' => $lang,
            'version' => $this->version,
        ];

        $response = $this->client->recherchePointChronopostInter($params);

        return $response;
    }
}



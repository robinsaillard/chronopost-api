<?php

namespace RS\ChronopostApi\Wsdl;

use DateTime;
use RS\ChronopostApi\Client;

class PointRelaisServiceWS extends Client {

    const WSDL_POINT_RELAIS_SERVICE = "https://ws.chronopost.fr/recherchebt-ws-cxf/PointRelaisServiceWS?wsdl";

    /**
     * @param int $accountNumber
     * @param string $password 
     * @param string $language (FR, EN, DE, ES, IT...)
     * @param string $version (2.0)
     */
    public function __construct(
        public int $accountNumber,
        public string $password,
        public string $language = "FR",
        public string $version = "2.0",
    ) {
        parent::__construct(self::WSDL_POINT_RELAIS_SERVICE);
    }


    /**
     * @param string $countryCode (FR, EN, DE, ES, IT...)
     * @param string $zipCode
     * @param string $city
     * @param string $shippingDate
     * @param ?string $address
     * @param ?float $weight
     * @param ?string $type 
     * @param ?string $productCode
     * @param ?string $service
     * @param ?int $maxDistanceSearch
     * @param ?int $holidayTolerant
     * @param ?int $maxPointChronopost
     */
    public function find(
        string $countryCode, string $zipCode, string $city, string $shippingDate, string $address = null,
        float $weight = null, string $type = "T", string $productCode = "86", 
        string $service = "L", int $maxDistanceSearch = 10, int $holidayTolerant = 1, int $maxPointChronopost = 25 
        )
    {
        $params = [
            'accountNumber' => $this->accountNumber,
            'password' => $this->password,
            'address' => $address,
            'zipCode' => $zipCode,
            'city' => $city,
            'countryCode' => $countryCode,
            'type' => $type,
            'productCode' => $productCode,
            'service' => $service,
            'weight' => $weight,
            'shippingDate' => $shippingDate,
            'maxPointChronopost' => $maxPointChronopost,
            'maxDistanceSearch' => $maxDistanceSearch,
            'holidayTolerant' => $holidayTolerant,
            'language' => $this->language,
            'version' => $this->version,
        ];

        $response = $this->client->recherchePointChronopostInter($params);

        return $response;
    }

    public function findById(string $id) {
        $params = [
            'accountNumber' => $this->accountNumber,
            'password' => $this->password,
            'identifiant' => $id,
        ];

        $response = $this->client->rechercheDetailPointChronopost($params);

        return $response;
    }
}





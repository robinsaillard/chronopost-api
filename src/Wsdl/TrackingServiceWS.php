<?php

namespace RS\ChronopostApi\Wsdl;

use DateTime;
use RS\ChronopostApi\Client;



class TrackingServiceWS extends Client {

    const WSDL_TRACKING_SERVICE = "https://ws.chronopost.fr/tracking-cxf/TrackingServiceWS?wsdl";

    /**
     * @param int $accountNumber
     * @param string $password 
     * @param string $language (FR, EN, DE, ES, IT...)
     * @param string $version (2.0)
     */
    public function __construct(
        public int $accountNumber,
        public string $password,
        public string $language = "fr_FR",
        public string $version = "2.0",
    ) {
        parent::__construct(self::WSDL_TRACKING_SERVICE);
    }

    public function track(DateTime $dateDeposit = new DateTime(), DateTime $dateEndDeposit  = new DateTime(), string $sendersRef = "", string $serviceCode = "", string $parcelState = "ANY", string $consigneesCountry ="", string $consigneesRef = "", string $consigneesZipCode = "") {
        $params = [
            'accountNumber' => $this->accountNumber,
            'password' => $this->password,
            'language' => $this->language,
            'version' => $this->version,
            'consigneesCountry' => $consigneesCountry,
            'consigneesRef' => $consigneesRef,
            'consigneesZipCode' => $consigneesZipCode,
            'dateDeposit' => $dateDeposit->format('d/m/Y'),
            'dateEndDeposit' => $dateEndDeposit->format('d/m/Y'),
            'parcelState' => $parcelState,
            'serviceCode' => $serviceCode
        ];

        return $this->client->trackSearch($params);
    }

}

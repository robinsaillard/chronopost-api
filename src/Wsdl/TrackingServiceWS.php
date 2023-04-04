<?php

namespace RS\ChronopostApi\Wsdl;

use RS\ChronopostApi\Client;



class TrackingServiceWS extends Client {

    const WSDL_TRACKING_SERVICE = "https://ws.chronopost.fr/tracking-cxf/TrackingServiceWS?wsdl";

    public function __construct(

    ) {
        parent::__construct(self::WSDL_TRACKING_SERVICE);
    }

}
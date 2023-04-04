<?php

namespace RS\ChronopostApi\Wsdl;

use RS\ChronopostApi\Client;

class CreneauServiceWS extends Client {

    const WSDL_CRENEAU_SERVICE = "https://ws.chronopost.fr/rdv-cxf/services/CreneauServiceWS?wsdl";

    public function __construct(

    ) {
        parent::__construct(self::WSDL_CRENEAU_SERVICE);
    }

}



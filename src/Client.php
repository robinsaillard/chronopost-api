<?php

namespace RS\ChronopostApi;

abstract class Client {

    const WSDL_SHIPPING_SERVICE = "https://ws.chronopost.fr/shipping-cxf/ShippingServiceWS?wsdl";
    const WSDL_TRACKING_SERVICE = "https://ws.chronopost.fr/tracking-cxf/TrackingServiceWS?wsdl";
    const WSDL_POINT_RELAIS_SERVICE = "https://ws.chronopost.fr/recherchebt-ws-cxf/PointRelaisServiceWS?wsdl";
    const WSDL_CRENEAU_SERVICE = "https://ws.chronopost.fr/rdv-cxf/services/CreneauServiceWS?wsdl";
    const WSDL_QUICK_COST_SERVICE = "https://ws.chronopost.fr/quickcost-cxf/QuickcostServiceWS?wsdl";

    public function __construct() {
        
    }

}
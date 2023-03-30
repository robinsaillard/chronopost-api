<?php

namespace RS\ChronopostApi;

use SoapClient;
abstract class Client {

    const WSDL_SHIPPING_SERVICE = "https://ws.chronopost.fr/shipping-cxf/ShippingServiceWS?wsdl";
    const WSDL_TRACKING_SERVICE = "https://ws.chronopost.fr/tracking-cxf/TrackingServiceWS?wsdl";
    const WSDL_POINT_RELAIS_SERVICE = "https://ws.chronopost.fr/recherchebt-ws-cxf/PointRelaisServiceWS?wsdl";
    const WSDL_CRENEAU_SERVICE = "https://ws.chronopost.fr/rdv-cxf/services/CreneauServiceWS?wsdl";
    const WSDL_QUICK_COST_SERVICE = "https://ws.chronopost.fr/quickcost-cxf/QuickcostServiceWS?wsdl";
    
    protected SoapClient $client;
    public function __construct(
        public ?string $wsdl = null,
        public array $options = []
    ) {
        $this->client = new SoapClient($wsdl, $options);
    }

    public function getClient(): SoapClient
    {
        return $this->client;
    }

    public function setClient(SoapClient $client): void
    {
        $this->client = new SoapClient($this->wsdl, $this->options);
    }

    public function getWsdl(): string
    {
        return $this->wsdl;
    }

    public function setWsdl(string $wsdl): void
    {
        $this->wsdl = $wsdl;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

}
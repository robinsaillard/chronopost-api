<?php

namespace RS\ChronopostApi;

abstract class Client {

    
    const WSDL_TRACKING_SERVICE = "https://ws.chronopost.fr/tracking-cxf/TrackingServiceWS?wsdl";
    const WSDL_POINT_RELAIS_SERVICE = "https://ws.chronopost.fr/recherchebt-ws-cxf/PointRelaisServiceWS?wsdl";
    const WSDL_CRENEAU_SERVICE = "https://ws.chronopost.fr/rdv-cxf/services/CreneauServiceWS?wsdl";
    const WSDL_QUICK_COST_SERVICE = "https://ws.chronopost.fr/quickcost-cxf/QuickcostServiceWS?wsdl";


        private SoapClient $client;
        public function __construct(
            private string $wsdl,
            private array $options = []
        ) {
        }

        public function init()
        {
            $this->client = new SoapClient();
        }

        public function connect()
        {
            $this->client->__setLocation($this->wsdl);
        }

        public function call(string $method, array $params)
        {
            return $this->client->__soapCall($method, $params);
        }



        public function getClient(): SoapClient
        {
            return $this->client;
        }

        public function setClient(SoapClient $client): void
        {
            $this->client = $client;
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
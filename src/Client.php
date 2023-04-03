<?php

namespace RS\ChronopostApi;

use SoapClient;
abstract class Client {

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
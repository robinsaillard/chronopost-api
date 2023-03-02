<?php

use RS\ChronopostApi\Client;

class TrackingServiceWS extends Client {

    const WSDL_SHIPPING_SERVICE = "https://ws.chronopost.fr/shipping-cxf/ShippingServiceWS?wsdl";

    public function __construct(
        private array $esdValue = [],
        private array $headerValue = [],
        private array $shipperValue = [],
        private array $customerValue = [],
        private array $recipientValue = [],
        private array $refValue = [],
        private array $skybillValue = [],
        private array $skybillParamsValue = [],
        private string $password = "",
        private string $version = "2.0",
        private string $modeRetour = "",
        private int $numberOfParcel = 1,
        private ?string $multiParcel = null,
        private array $scheduledValue = []
    ) {
        parent::construct(WSDL_SHIPPING_SERVICE);
    }

    public function getShippingInfo($shippingNumber) {
        $params = [
            'shippingNumber' => $shippingNumber
        ];
        return $this->client->getShippingInfo($params);
    }

    public function getReservedSkybill($skybillNumber) {
        $params = [
            'skybillNumber' => $skybillNumber
        ];
        return $this->client->getReservedSkybill($params);
    }

    public function getReservedSkybillWithType($skybillNumber, $skybillType) {
        $params = [
            'skybillNumber' => $skybillNumber,
            'skybillType' => $skybillType
        ];
        return $this->client->getReservedSkybillWithType($params);
    }


    /**
     * @param int $accountNumber Numéro de compte contractualisé avec chronopost
     * @param ?int $subAccount Numéro de sous compte (optionnel)
     * @param ?string $identWebPro Identifiant webpro (optionnel)
     * @param ?string $idEmit Valeur fixe : CHRFR  (optionnel)
     */
    public function setHeaderValue(int $accountNumber, int $subAccount = null,  string $identWebPro = "", string $idEmit = "CHRFR") : self
    {
        $this->headerValue = [
            'accountNumber' => $accountNumber,
            'idEmit' => $idEmit,
            'identWebPro' => $identWebPro,
            'subAccount' => $subAccount
        ];
        return $this;
    }

    /**
     * @param Datetime $closingDateTime Date et Heure de fermeture du lieu d’enlèvement
     * @param string $refEsdClient Référence client
     * @param float $height Hauteur du colis en cm (0 si inconnu)
     * @param float $length Longueur du colis en cm (0 si inconnu)
     * @param float $width Largeur du colis en cm (0 si inconnu)
     * @param Datetime $retrievalDateTime Date et Heure d’enlèvement souhaité
     * @param string $shipperBuildingFloor N° de bâtiment, étage de l’enlèvement
     * @param string $shipperCarriesCode Code porte du bâtiment de l’enlèvement
     * @param string $shipperServiceDirection Nom du service, direction de l’enlèvement
     * @param string $specificInstructions Instructions particulières de l’enlèvement
     * @param bool $ltAImprimerParChronopost Indique si l’étiquette doit être imprimée en agence avant l’enlèvement
     * @param int $nombreDePassageMaximum A positionner à 1
     * @param ?string $codeDepotColReq Code du dépôt de collecte
     * @param ?string $numColReq Numéro de la collecte
     * */
    public function setEsdValue(
        Datetime $closingDateTime, string $refEsdClient, float $height, float $length, float $width,
        Datetime $retrievalDateTime, string $shipperBuildingFloor, string $shipperCarriesCode,
        string $shipperServiceDirection, string $specificInstructions, bool $ltAImprimerParChronopost = 0,
        int $nombreDePassageMaximum = 1, string $codeDepotColReq = "", string $numColReq = "") : self
    {
        $result = [
            'closingDateTime' => $closingDateTime->format('Y-m-dTH:i:s'),
            'refEsdClient' => $refEsdClient,
            'height' => $height,
            'length' => $length,
            'width' => $width,
            'retrievalDateTime' => $retrievalDateTime->format('Y-m-dTH:i:s'),
            'shipperBuildingFloor' => $shipperBuildingFloor,
            'shipperCarriesCode' => $shipperCarriesCode,
            'shipperServiceDirection' => $shipperServiceDirection,
            'specificInstructions' => $specificInstructions,
            'numColReq' => $numColReq
        ];
        if ($ltAImprimerParChronopost) {
            $result['ltAImprimerParChronopost'] = 1;
        }
        if ($nombreDePassageMaximum > 0) {
            $result['nombreDePassageMaximum'] = 1;
        }
        if ($codeDepotColReq != "") {
            $result['codeDepotColReq'] = $codeDepotColReq;
        }
        $this->esdValue = $result;
        return $this;
    }

    /**
     * @param string $shipperAdress1 Adresse de l’expéditeur
     * @param ?string $shipperAdress2 Complément d’adresse de l’expéditeur (optionnel)
     * @param string $shipperCity Ville de l’expéditeur
     * @param string $shipperCivility Civilité de l’expéditeur (E : Madame |L : Mademoiselle |M : Monsieur)
     * @param ?string $shipperContactName Nom de l’expéditeur (obligatoire si ESD)
     * @param string $shipperCountry Code pays de l’expéditeur
     * @param ?string $shipperCountryName Nom du pays de l’expéditeur
     * @param string $shipperEmail Email de l’expéditeur
     * @param ?string $shipperMobilePhone Mobile de l’expéditeur
     * @param string $shipperName Nom de l’expéditeur
     * @param ?string $shipperName2 Complément de nom de l’expéditeur (optionnel)
     * @param string $shipperPhone Phone de l’expéditeur
     * @param ?int $shipperPreAlert Pre-alerte de l’expéditeur (0 : pas de préalerte | 11 : préalerte mail expéditeur)
     * @param string $shipperZipCode Code postal de l’expéditeur
     * @param ?string $shipperType Type d’expéditeur (0 : particulier | 1 : professionnel)
     */
    public function setShipperValue(
        string $shipperAdress1, string $shipperCity, string $shipperCivility, string $shipperCountry,
        string $shipperEmail, string $shipperName, string $shipperPhone, int $shipperPreAlert = 0,
        string $shipperZipCode, string $shipperAdress2 = "", string $shipperContactName = "",
        string $shipperCountryName = "", string $shipperMobilePhone = "", string $shipperName2 = "",
        string $shipperType = "0") : self
    {
        $this->shipperValue = [
            'shipperAdress1' => $shipperAdress1,
            'shipperAdress2' => $shipperAdress2,
            'shipperCity' => $shipperCity,
            'shipperCivility' => $shipperCivility,
            'shipperContactName' => $shipperContactName,
            'shipperCountry' => $shipperCountry,
            'shipperCountryName' => $shipperCountryName,
            'shipperEmail' => $shipperEmail,
            'shipperMobilePhone' => $shipperMobilePhone,
            'shipperName' => $shipperName,
            'shipperName2' => $shipperName2,
            'shipperPhone' => $shipperPhone,
            'shipperPreAlert' => $shipperPreAlert,
            'shipperType' => $shipperType,
            'shipperZipCode' => $shipperZipCode
        ];
        return $this;
    }


    /**
     * @param string $customerAdress1 Adresse du destinataire
     * @param ?string $customerAdress2 Complément d’adresse du destinataire (optionnel)
     * @param string $customerCity Ville du destinataire
     * @param string $customerCivility Civilité du destinataire (E : Madame |L : Mademoiselle |M : Monsieur)
     * @param ?string $customerContactName Nom du destinataire (obligatoire si ESD)
     * @param string $customerCountry Code pays du destinataire
     * @param ?string $customerCountryName Nom du pays du destinataire
     * @param string $customerEmail Email du destinataire
     * @param ?string $customerMobilePhone Mobile du destinataire
     * @param string $customerName Nom du destinataire
     * @param ?string $customerName2 Complément de nom du destinataire (optionnel)
     * @param string $customerPhone Phone du destinataire
     * @param ?int $customerPreAlert Pre-alerte du destinataire (optionnel)
     * @param string $customerZipCode Code postal du destinataire
     * @param ?string $printAsSender Imprime le destinataire comme expéditeur (Y : Customer imprimé | N : Sender imprimé)
     * */
    public function setCustomerValue(
        string $customerAdress1, string $customerCity, string $customerCivility, string $customerCountry,
        string $customerEmail, string $customerName, string $customerPhone, string $customerZipCode,
        string $customerAdress2 = "", string $customerContactName = "", string $customerCountryName = "",
        string $customerMobilePhone = "", string $customerName2 = "", int $customerPreAlert = 0,
        string $printAsSender = "N")
    {
        $this->customerValue  = [
            'customerAdress1' => $customerAdress1,
            'customerAdress2' => $customerAdress2,
            'customerCity' => $customerCity,
            'customerCivility' => $customerCivility,
            'customerContactName' => $customerContactName,
            'customerCountry' => $customerCountry,
            'customerCountryName' => $customerCountryName,
            'customerEmail' => $customerEmail,
            'customerMobilePhone' => $customerMobilePhone,
            'customerName' => $customerName,
            'customerName2' => $customerName2,
            'customerPhone' => $customerPhone,
            'customerPreAlert' => $customerPreAlert,
            'customerZipCode' => $customerZipCode,
            'printAsSender' => $printAsSender
        ];
        return $this;
    }

    /**
     * @param string $customerSkybillNumber Numéro de colis client, tronqué à 15 caractères
     * @param string $PCardTransactionNumber Numéro de transaction PCard (réserver à Chronopost)
     * @param string $recipientRef Référence du destinataire
     * @param string $shipperRef Référence de l’expéditeur
     * @param string $idRelais Identifiant du relais (uniquement si point relais)
     * @return array refValue
     */
    public function setRefValue(
        string $customerSkybillNumber = "", string $PCardTransactionNumber = "", string $recipientRef = "",
        string $shipperRef = "", string $idRelais = "")
    {
        if (strlen($customerSkybillNumber) > 15)
            $customerSkybillNumber = substr($customerSkybillNumber, 0, 15);
        $result = []; 
        if ($customerSkybillNumber != "")
            $result['customerSkybillNumber'] = $customerSkybillNumber;
        if ($PCardTransactionNumber != "")
            $result['PCardTransactionNumber'] = $PCardTransactionNumber;
        if ($recipientRef != "")
            $result['recipientRef'] = $recipientRef;
        if ($shipperRef != "")
            $result['shipperRef'] = $shipperRef;
        if ($idRelais != "")
            $result['idRelais'] = $idRelais;
        return $result;
    }

    /**
     * @param string $bulkNumber Nombre de colis (default : 1)
     * @param ?string $codCurrency Code devise du montant COD (EUR)
     * @param ?int $codValue Montant COD
     * @param ?string $content1 Description du contenu du colis (optionnel)
     * @param ?string $content2 Description du contenu du colis (optionnel)
     * @param ?string $content3 Description du contenu du colis (optionnel)
     * @param ?string $content4 Description du contenu du colis (optionnel)
     * @param ?string $content5 Description du contenu du colis (optionnel)
     * @param ?string $customsCurrency Code devise de la valeur déclarée (EUR)
     * @param ?int $customsValue Valeur déclarée
     * @param string $evtCode Code événement (champ fix : DC)
     * @param ?string $insuredCurrency Code devise de l’assurance (EUR)
     * @param ?int $insuredValue Montant assurance
     * @param ?string $masterSkybillNumber Numéro de colis maitre
     * @param ?string $objectType Type d’objet (DOC = Document | MAR = Marchandise)
     * @param string $productCode Code produit (voir documentation chronopost ex : Chrono 13H : 01)
     * @param ?string $service Service (optionnel)
     * @param DateTime $shipDate Date d’expédition
     * @param int $shipHour Heure d’expédition
     * @param ?string $skybillRank Rang du colis (optionnel)
     * @param float $weight Poids du colis
     * @param string $weightUnit Unité de poids (KGM)
     * @param float $height Hauteur du colis
     * @param float $length Longueur du colis
     * @param float $width Largeur du colis
     * @param ?string $as Code de livraison (optionnel)
     * @param ?string $subAccount Numéro de sous-compte (optionnel)
     * @param ?string $toTheOrderOf Ordre du chèque pour un contre remboursement (optionnel)
     * @param ?string $alternateProductCode Code produit alternatif (optionnel)
     */

    public function setSkybillValue(
        int $bulkNumber = 1, string $evtCode = "DC", string $productCode = "01", DateTime $shipDate, int $shipHour,
        float $weight, string $weightUnit = "KGM", float $height, float $length, float $width,
        string $codCurrency = "", int $codValue = 0, string $content1 = "", string $content2 = "", string $content3 = "",
        string $content4 = "", string $content5 = "", string $customsCurrency = "", int $customsValue = 0,
        string $insuredCurrency = "", int $insuredValue = 0, string $masterSkybillNumber = "", string $objectType = "",
        string $service = "", string $skybillRank = "", string $as = "", string $subAccount = "",
        string $toTheOrderOf = "", string $alternateProductCode = "") {
            $result = [
                'bulkNumber' => $bulkNumber,
                'evtCode' => $evtCode,
                'productCode' => $productCode,
                'shipDate' => $shipDate->format('Y-m-dTH:i:s'),
                'shipHour' => $shipHour,
                'weight' => $weight,
                'weightUnit' => $weightUnit,
                'height' => $height,
                'length' => $length,
                'width' => $width,
                'latitude',
                'longitude',
                'portCurrency',
                'portValue',
                'qualite',
                'source',
                'carrier',
                'skybillNumber',
                'skybillBackNumber',
                'labelNumber',

            ];
            if ($codCurrency != "")
                $result['codCurrency'] = $codCurrency;
            if ($codValue != 0)
                $result['codValue'] = $codValue;
            if ($content1 != "")
                $result['content1'] = $content1;
            if ($content2 != "")
                $result['content2'] = $content2;
            if ($content3 != "")
                $result['content3'] = $content3;
            if ($content4 != "")
                $result['content4'] = $content4;
            if ($content5 != "")
                $result['content5'] = $content5;
            if ($customsCurrency != "")
                $result['customsCurrency'] = $customsCurrency;
            if ($customsValue != 0)
                $result['customsValue'] = $customsValue;
            if ($insuredCurrency != "")
                $result['insuredCurrency'] = $insuredCurrency;
            if ($insuredValue != 0)
                $result['insuredValue'] = $insuredValue;
            if ($masterSkybillNumber != "")
                $result['masterSkybillNumber'] = $masterSkybillNumber;
            if ($objectType != "")
                $result['objectType'] = $objectType;
            if ($service != "")
                $result['service'] = $service;
            if ($skybillRank != "")
                $result['skybillRank'] = $skybillRank;
            if ($as != "")
                $result['as'] = $as;
            if ($subAccount != "")
                $result['subAccount'] = $subAccount;
            if ($toTheOrderOf != "")
                $result['toTheOrderOf'] = $toTheOrderOf;
            if ($alternateProductCode != "")
                $result['alternateProductCode'] = $alternateProductCode;
            $this->skybillValue = $result;
            return $this;
        }

        /**
         * @param string $skybillParamsValue [PDF|PPR|SPD|THE|Z 2 D|JSON|ZPL|SLT|XML|THEPSG|Z 2 DPSG]
         * @param ?string $duplicata [Y|N] Impression d’une LT avec un duplicata (sans code à barre)
         * @param ?int $withReservation [0|1|2] 0 par défaut, sans réservation 1 avec réservation 2 avec réservation et le premier 2 format de la LT spécifiée dans mode
         * @return array skybillParamsValue
         */
        public function setSkybillParamsValue(string $skybillParamsValue = "PDF", string $duplicata = "N", int $withReservation = 0) {
            $result = [
                'skybillParamsValue' => $skybillParamsValue,
                'duplicata' => $duplicata,
                'withReservation' => $withReservation,
            ];
            $this->skybillParamsValue = $result;
            return $this;
        }


        /**
         * @param string $password Mot de passe
         * @param string $modeRetour [1|2|3|4] 1 mail à shipperEmail 2 pas de mail 3 imprimé en bureau de poste et SMS 4 mail au produit shop 2 shop 
         * @param int $numberOfParcel Nombre de colis
         * @param ?string $version (2)
         * @param ?string $multiParcel (N) [Y|N] Expédition multi colis
         * @return array general
         */
        public function general(string $password, string $modeRetour = "1", int $numberOfParcel = 1, string $version = "2", string $multiParcel = "N") {
            $this->password = $password;
            $this->modeRetour = $modeRetour;
            $this->numberOfParcel = $numberOfParcel;
            $this->version = $version;
            $this->multiParcel = $multiParcel;
            return $this;
        }


        /**
         * @param array $appointmentValue Sous structure des informations
         * @param DateTime $expirationDate Date limite de consommation (Chronofresh)
         * @param DateTime $sellByDate Date limite de consommation
         * @return array scheduledValue
         */
        public function setScheduledValue(array $appointmentValue, DateTime $expirationDate, DateTime $sellByDate) {
            $result = [
                'appointmentValue' => $this->appointmentValue,
                'expirationDate' => $expirationDate->format('Y-m-d'),
                'sellByDate' => $sellByDate->format('Y-m-d'),
            ];
            $this->scheduledValue = $result;
            return $this;
        }

        /**
         * @param DateTime $timeSlotEndDate Date et heure de fin de créneau
         * @param DateTime $timeSlotStartDate Date et heure de début de créneau
         * @param ?string $timeSlotTariffLevel (N1)
         * @return array appointmentValue
         */
        public function setAppointmentValue(DateTime $timeSlotEndDate, DateTime $timeSlotStartDate, string $timeSlotTariffLevel = "N1") {
            $result = [
                'timeSlotEndDate' => $timeSlotEndDate->format('Y-m-dTH:i:s'),
                'timeSlotStartDate' => $timeSlotStartDate->format('Y-m-dTH:i:s'),
                'timeSlotTariffLevel' => $timeSlotTariffLevel,
            ];
            $this->appointmentValue = $result;
            return $this;
        }



        /**
         * shippingMultiParcelV4
         * @return array shippingMultiParcelV4
         */
        public function shippingMultiParcelV4() {
            $result = [
                'esdValue' => $this->esdValue,
                'headerValue' => $this->headerValue,
                'shipperValue' => $this->shipperValue,
                'customerValue' => $this->customerValue,
                'recipientValue' => $this->recipientValue,
                'refValue' => $this->refValue,
                'skybillValue' => $this->skybillValue,
                'skybillParamsValue' => $this->skybillParamsValue,
                'password' => $this->password,
                'version' => $this->version,
                'modeRetour' => $this->modeRetour,
                'numberOfParcel' => $this->numberOfParcel,
                'multiParcel' => $this->multiParcel,
                'scheduledValue' => $this->scheduledValue,
            ];
            return $result;
        }
}
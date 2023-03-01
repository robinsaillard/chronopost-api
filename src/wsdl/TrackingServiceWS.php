<?php

use RS\ChronopostApi\Client;

class TrackingServiceWS extends Client {

    const WSDL_SHIPPING_SERVICE = "https://ws.chronopost.fr/shipping-cxf/ShippingServiceWS?wsdl";

    public function __construct() {
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

    //shippingMultiParcelV4
    public function shippingMultiParcelV4($shipper, $recipient, $refValue, $password, $service, $skybillValue, $mode, $multiParcel) {
        $params = [
            'shipper' => $shipper,
            'recipient' => $recipient,
            'refValue' => $refValue,
            'password' => $password,
            'service' => $service,
            'skybillValue' => $skybillValue,
            'mode' => $mode,
            'multiParcel' => $multiParcel
        ];
        return $this->client->call("shippingMultiParcelV4", $params);
    }


    /**
     * @param int $accountNumber Numéro de compte contractualisé avec chronopost
     * @param ?int $subAccount Numéro de sous compte (optionnel)
     * @param ?string $identWebPro Identifiant webpro (optionnel)
     * @param ?string $idEmit Valeur fixe : CHRFR  (optionnel)
     * @return array headerValue
     */
    public function headerValue(int $accountNumber, int $subAccount = null,  string $identWebPro = "", string $idEmit = "CHRFR")
    {
        return [
            'accountNumber' => $accountNumber,
            'idEmit' => $idEmit,
            'identWebPro' => $identWebPro,
            'subAccount' => $subAccount
        ];
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
     * @return array esdValue
     * */
    public function esdValue(
        Datetime $closingDateTime, string $refEsdClient, float $height, float $length, float $width,
        Datetime $retrievalDateTime, string $shipperBuildingFloor, string $shipperCarriesCode,
        string $shipperServiceDirection, string $specificInstructions, bool $ltAImprimerParChronopost = 0,
        int $nombreDePassageMaximum = 1, string $codeDepotColReq = "", string $numColReq = "")
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
        return $result;
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
     * @return array shipperValue
     */
    public function shipperValue(
        string $shipperAdress1, string $shipperCity, string $shipperCivility, string $shipperCountry,
        string $shipperEmail, string $shipperName, string $shipperPhone, int $shipperPreAlert = 0,
        string $shipperZipCode, string $shipperAdress2 = "", string $shipperContactName = "",
        string $shipperCountryName = "", string $shipperMobilePhone = "", string $shipperName2 = "",
        string $shipperType = "0")
    {
        return [
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
    public function customerValue(
        string $customerAdress1, string $customerCity, string $customerCivility, string $customerCountry,
        string $customerEmail, string $customerName, string $customerPhone, string $customerZipCode,
        string $customerAdress2 = "", string $customerContactName = "", string $customerCountryName = "",
        string $customerMobilePhone = "", string $customerName2 = "", int $customerPreAlert = 0,
        string $printAsSender = "N")
    {
        return [
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
    }

    /**
     * @param string $customerSkybillNumber Numéro de colis client, tronqué à 15 caractères
     * @param string $PCardTransactionNumber Numéro de transaction PCard (réserver à Chronopost)
     * @param string $recipientRef Référence du destinataire
     * @param string $shipperRef Référence de l’expéditeur
     * @param string $idRelais Identifiant du relais (uniquement si point relais)
     * @return array refValue
     */
    public function refValue(
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
     * @param ?string $latitude Type d’objet (réserver à Chronopost)
     * @param ?string $longitude Type d’objet (réserver à Chronopost)
     * @param ?string $masterSkybillNumber Numéro de colis maitre
     * @param ?string $objectType Type d’objet (DOC = Document | MAR = Marchandise)
     * @param ?string $portCurrency Code devise du port (EUR réservé à Chronopost)
     * @param ?int $portValue Montant du port (réservé à Chronopost)
     * @param string $productCode Code produit (voir documentation chronopost ex : Chrono 13H : 01)
     * @param ?string $service Service (optionnel)
     * @param DateTime $shipDate Date d’expédition
     * @param int $shipHour Heure d’expédition
     * @param ?string $skybillRank Rang du colis (optionnel)
     * @param 
     */

}
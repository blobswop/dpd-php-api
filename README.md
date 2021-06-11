# PHP DPD Germany API 

## About

PHP wrapper for [DPD Germany](https://esolutions.dpd.com/entwickler/dpdwebservices.aspx) SOAP API.

Using:

- LoginService version 2.0
- ParcelLifeCycleService version 2.0
- ShipmentService version 4.4

## Requirements

This library uses PHP 8.0+

## Installation

It is recommended that you install the PHP UPS API library [through composer](http://getcomposer.org/). To do so,
run the Composer command to install the latest stable version of PHP DPD API:

```bash
$ composer require blobswop/dpd-php-api
```

## Table Of Content
1. [Authorization](#authorization)
2. [Create order](#createOrder) (get tracking number and generate label)
3. [Track parcel](#track)

<a name="authorization"></a>
### Authorization

```php
// set development environment
\Dpd\Api::dev();
$response = null;

try {
    $response = \Dpd\Api::me()->auth(
        new \Dpd\Business\Credentials('sandboxdpd', 'password', 'en_US')
    );
    
    if ($response instanceof \Dpd\Business\AuthenticationFault) {
        // authentication fault
        print_r($response);     
    } elseif ($response instanceof \Dpd\Business\Login) {
        // authentication success - save token
        print_r($response);
    }
} catch(\Throwable $e) {
    print_r($e);
}
```
Example response for authentication fault:
```bash
Dpd\Business\AuthenticationFault Object
(
    [errorCode:protected] => LOGIN_8
    [errorMessage:protected] => The combination of user and password is invalid.
)
```

Example response for success authentication:
```bash
Dpd\Business\Login Object
(
    [delisId:protected] => sandboxdpd
    [customerUid:protected] => sandboxdpd
    [authToken:protected] => LT***RR
    [depot:protected] => 0998
)
```

<a name="createOrder"></a>
### Create order

```php
// set development environment
\Dpd\Api::dev();
$response = null;

try {
    $authentication =
        (new \Dpd\Business\Authentication)
            ->setDelisId('sandboxdpd')
            ->setAuthToken('L***R')
            ->setMessageLanguage('en_US');

    $storeOrders =
        (new \Dpd\Business\StoreOrders())
            ->setPrintOptions(
                (new \Dpd\Business\PrintOptions())
                    ->addPrintOption(
                        (new \Dpd\Business\PrintOption())
                            ->setPaperFormatA4()
                            ->setOutputFormat(\Dpd\Business\OutputFormatType::multipageImage())
                    )
                    ->setSplitByParcel(true)
            )
            ->addOrder(
                (new \Dpd\Business\ShipmentServiceData())
                    ->setGeneralShipmentData(
                        (new \Dpd\Business\GeneralShipmentData())
                            ->setProductDpdClassic()
                            ->setSendingDepot('0141')
                            ->setMpsWeight(500)
                            ->setMpsVolume(100 * 10 * 50)
                            ->setSender(
                                (new \Dpd\Business\AddressWithType())
                                    ->setAddressTypeCommercial()
                                    ->setName1('Sender Company GmbH')
                                    ->setName2('Company Sender Person')
                                    ->setStreet('Residenzstraße')
                                    ->setHouseNo(1)
                                    ->setCountry('DE')
                                    ->setZipCode('80333')
                                    ->setCity('München')
                            )
                            ->setRecipient(
                                (new \Dpd\Business\AddressWithType())
                                    ->setAddressTypePrivate()
                                    ->setName1('Person Name')
                                    ->setStreet('Neue Mainzer Str.')
                                    ->setHouseNo('52-58')
                                    ->setCountry('DE')
                                    ->setZipCode('60311')
                                    ->setCity('Frankfurt am Main')
                            )
                            ->setIdentificationNumber('Your-Shipment-Id')
                            ->setMpsCustomerReferenceNumber1('Customer reference 1')
                    )
                    ->addParcel(
                        (new \Dpd\Business\Parcel())
                            ->setWeight(500)
                            ->setAddServiceParcelBox()
                    )
                    ->setProductAndServiceData(
                        (new \Dpd\Business\ProductAndServiceData())
                            ->setOrderTypeConsignment()
                            ->setFood(false)
                    )
            )
            ->addOrder(
                (new \Dpd\Business\ShipmentServiceData())
                    ->setGeneralShipmentData(
                        (new \Dpd\Business\GeneralShipmentData())
                            ->setProductDpdClassic()
                            ->setSendingDepot('0141')
                            ->setMpsWeight(500)
                            ->setMpsVolume(100 * 10 * 50)
                            ->setSender(
                                (new \Dpd\Business\AddressWithType())
                                    ->setAddressTypeCommercial()
                                    ->setName1('Sender Company GmbH')
                                    ->setName2('Company Sender Person')
                                    ->setStreet('Residenzstraße')
                                    ->setHouseNo(1)
                                    ->setCountry('DE')
                                    ->setZipCode('80333')
                                    ->setCity('München')
                            )
                            ->setRecipient(
                                (new \Dpd\Business\AddressWithType())
                                    ->setAddressTypePrivate()
                                    ->setName1('Person Name')
                                    ->setStreet('Neue Mainzer Str.')
                                    ->setHouseNo('52-58')
                                    ->setCountry('DE')
                                    ->setZipCode('60311')
                                    ->setCity('Frankfurt am Main')
                            )
                            ->setIdentificationNumber('Your-Return-Shipment-Id')
                            ->setMpsCustomerReferenceNumber1('Customer reference 1')
                    )
                    ->addParcel(
                        (new \Dpd\Business\Parcel())
                            ->setWeight(500)
                            ->setAddServiceParcelBox()
                            ->setReturns(true)
                    )
                    ->setProductAndServiceData(
                        (new \Dpd\Business\ProductAndServiceData())
                            ->setOrderTypeConsignment()
                            ->setFood(false)
                    )
            );

    $response = \Dpd\Api::me()->storeOrders($authentication, $storeOrders);
    
    if ($response instanceof \Dpd\Business\AuthenticationFault) {
        // authentication fault
        print_r($response);     
    } elseif ($response instanceof \Dpd\Business\StoreOrdersResponseType) {
    
        print_r($response);
        
        foreach ($response->getShipmentResponses() as $shipmentResponse) {
            if (
                $shipmentResponse instanceof \Dpd\Business\ShipmentResponse
                && $shipmentResponse->getParcelInformation() instanceof \Dpd\Business\ParcelInformationType
                && $shipmentResponse->getParcelInformation()->getParcelLabelNumber()
                && $shipmentResponse->getParcelInformation()->getOutput() instanceof \Dpd\Business\OutputType
                && $shipmentResponse->getParcelInformation()->getOutput()->getContent()
            ) {
                if ($shipmentResponse->getParcelInformation()->getOutput()->getFormat() == \Dpd\Business\OutputFormatType::TYPE_PDF) {
                    file_put_contents($shipmentResponse->getParcelInformation()->getParcelLabelNumber() . '.pdf', $shipmentResponse->getParcelInformation()->getOutput()->getContent());
                } elseif ($shipmentResponse->getParcelInformation()->getOutput()->getFormat() == \Dpd\Business\OutputFormatType::TYPE_MULTIPAGE_IMAGE) {
                    file_put_contents($shipmentResponse->getParcelInformation()->getParcelLabelNumber() . '.gif', $shipmentResponse->getParcelInformation()->getOutput()->getContent());
                }
            }
        }
    }
} catch(\Throwable $e) {
    // process exception
}
```

Example response for authentication fault:
```bash
Dpd\Business\AuthenticationFault Object
(
    [errorCode:protected] => LOGIN_5
    [errorMessage:protected] => The authtoken is invalid
)
```

Example response for incorrect request:
```bash
Dpd\Business\StoreOrdersResponseType Object
(
    [shipmentResponses:protected] => Array
        (
            [0] => Dpd\Business\ShipmentResponse Object
                (
                    [identificationNumber:protected] => Your-Shipment-Id
                    [faults:protected] => Dpd\Business\FaultCodeType Object
                        (
                            [faultCode:protected] => COMMON_7
                            [message:protected] => mpsWeight
                        )

                )

            [1] => Dpd\Business\ShipmentResponse Object
                (
                    [identificationNumber:protected] => Your-Return-Shipment-Id
                    [faults:protected] => Dpd\Business\FaultCodeType Object
                        (
                            [faultCode:protected] => COMMON_7
                            [message:protected] => mpsWeight
                        )

                )

        )

)
```

Example success response:
```bash
Dpd\Business\StoreOrdersResponseType Object
(
    [shipmentResponses:protected] => Array
        (
            [0] => Dpd\Business\ShipmentResponse Object
                (
                    [identificationNumber:protected] => Your-Shipment-Id
                    [mpsId:protected] => MPS0998505320867120210611
                    [parcelInformation:protected] => Dpd\Business\ParcelInformationType Object
                        (
                            [parcelLabelNumber:protected] => 09985053208671
                            [output:protected] => Dpd\Business\OutputType Object
                                (
                                    [format:protected] => MULTIPAGE_IMAGE
                                    [content:protected] => BINARY LABEL DATA
                                )
                        )
                )
            [1] => Dpd\Business\ShipmentResponse Object
                (
                    [identificationNumber:protected] => Your-Return-Shipment-Id
                    [mpsId:protected] => MPS0998505320867220210611
                    [parcelInformation:protected] => Dpd\Business\ParcelInformationType Object
                        (
                            [parcelLabelNumber:protected] => 09985053208672
                            [output:protected] => Dpd\Business\OutputType Object
                                (
                                    [format:protected] => MULTIPAGE_IMAGE
                                    [content:protected] => BINARY LABEL DATA
                                )
                        )
                )
        )
)
```
and labels will be saved in `09985053208666.gif` and `09985053208667.gif` files

<a name="track"></a>
### Track parcel

```PHP
\Dpd\Api::dev();
$response = null;

try {
    $authentication =
        (new \Dpd\Business\Authentication)
            ->setDelisId('sandboxdpd')
            ->setAuthToken('L***R')
            ->setMessageLanguage('en_US');

    $response = 
        \Dpd\Api::me()->getTrackingData(
            $authentication,
            new \Dpd\Business\GetTrackingData('09981122330100')
        );
    
    if ($response instanceof \Dpd\Business\AuthenticationFault) {
        // authentication fault
        print_r($response);  
    } elseif ($response instanceof \Dpd\Business\TrackingResult) {
        print_r($response);
    }
} catch(\Throwable $e) {
    print_r($e);
}
```

Example response for authentication fault:
```bash
Dpd\Business\AuthenticationFault Object
(
    [errorCode:protected] => LOGIN_5
    [errorMessage:protected] => The authtoken is invalid
)
```

Example response for unexisted :
```bash
Dpd\Business\AuthenticationFault Object
(
    [errorCode:protected] => LOGIN_5
    [errorMessage:protected] => The authtoken is invalid
)
```

Example success response:
```bash
Dpd\Business\TrackingResult Object
(
    [shipmentInfo:protected] => Dpd\Business\ShipmentInfo Object
        (
            [serviceDescription:protected] => Dpd\Business\ContentItem Object
                (
                    [label:protected] => Dpd\Business\ContentLine Object
                        (
                            [content:protected] => Your DPD service: 
                            [bold:protected] => 
                            [paragraph:protected] => 
                        )

                    [content:protected] => Dpd\Business\ContentLine Object
                        (
                            [content:protected] => DPD CLASSIC C.O.D.
                            [bold:protected] => 
                            [paragraph:protected] => 
                        )

                    [linkTarget:protected] => 
                )
            [status:protected] => SHIPMENT
            [label:protected] => Dpd\Business\ContentLine Object
                (
                    [content:protected] => Shipment information
                    [bold:protected] => 1
                    [paragraph:protected] => 
                )
            [description:protected] => Dpd\Business\ContentItem Object
                (
                    [content:protected] => Dpd\Business\ContentLine Object
                        (
                            [content:protected] => Details of your shipment
                            [bold:protected] => 
                            [paragraph:protected] => 
                        )
                    [linkTarget:protected] => 
                )
            [statusHasBeenReached:protected] => 
            [isCurrentStatus:protected] => 
            [showContactInfo:protected] => 
        )
    [statusInfo:protected] => Array
        (
            [0] => Dpd\Business\StatusInfo Object
                (
                    [status:protected] => ACCEPTED
                    [label:protected] => Dpd\Business\ContentLine Object
                        (
                            [content:protected] => Parcel handed to DPD
                            [bold:protected] => 1
                            [paragraph:protected] => 
                        )
                    [description:protected] => Dpd\Business\ContentItem Object
                        (
                            [content:protected] => Dpd\Business\ContentLine Object
                                (
                                    [content:protected] => DPD has received your parcel.
                                    [bold:protected] => 
                                    [paragraph:protected] => 
                                )
                            [linkTarget:protected] => 
                        )
                    [statusHasBeenReached:protected] => 
                    [isCurrentStatus:protected] => 1
                    [showContactInfo:protected] => 
                )
            [1] => Dpd\Business\StatusInfo Object
                (
                    [status:protected] => AT_SENDING_DEPOT
                    [label:protected] => Dpd\Business\ContentLine Object
                        (
                            [content:protected] => In transit
                            [bold:protected] => 1
                            [paragraph:protected] => 
                        )
                    [description:protected] => Dpd\Business\ContentItem Object
                        (
                            [content:protected] => Dpd\Business\ContentLine Object
                                (
                                    [content:protected] => The parcel is at the parcel dispatch centre.
                                    [bold:protected] => 
                                    [paragraph:protected] => 
                                )
                            [linkTarget:protected] => 
                        )
                    [statusHasBeenReached:protected] => 
                    [isCurrentStatus:protected] => 
                    [showContactInfo:protected] => 
                )
            [2] => Dpd\Business\StatusInfo Object
                (
                    [status:protected] => ON_THE_ROAD
                    [label:protected] => Dpd\Business\ContentLine Object
                        (
                            [content:protected] => At parcel delivery centre
                            [bold:protected] => 1
                            [paragraph:protected] => 
                        )
                    [description:protected] => Dpd\Business\ContentItem Object
                        (
                            [content:protected] => Dpd\Business\ContentLine Object
                                (
                                    [content:protected] => Your parcel is on its way to the parcel delivery centre.
                                    [bold:protected] => 
                                    [paragraph:protected] => 
                                )
                            [linkTarget:protected] => 
                        )
                    [statusHasBeenReached:protected] => 
                    [isCurrentStatus:protected] => 
                    [showContactInfo:protected] => 
                )
            [3] => Dpd\Business\StatusInfo Object
                (
                    [status:protected] => AT_DELIVERY_DEPOT
                    [label:protected] => Dpd\Business\ContentLine Object
                        (
                            [content:protected] => Parcel out for delivery
                            [bold:protected] => 1
                            [paragraph:protected] => 
                        )
                    [description:protected] => Dpd\Business\ContentItem Object
                        (
                            [content:protected] => Dpd\Business\ContentLine Object
                                (
                                    [content:protected] => At parcel delivery centre.
                                    [bold:protected] => 
                                    [paragraph:protected] => 
                                )
                            [linkTarget:protected] => 
                        )
                    [statusHasBeenReached:protected] => 
                    [isCurrentStatus:protected] => 
                    [showContactInfo:protected] => 
                )
            [4] => Dpd\Business\StatusInfo Object
                (
                    [status:protected] => DELIVERED
                    [label:protected] => Dpd\Business\ContentLine Object
                        (
                            [content:protected] => Parcel delivered
                            [bold:protected] => 1
                            [paragraph:protected] => 
                        )
                    [description:protected] => Dpd\Business\ContentItem Object
                        (
                            [content:protected] => Dpd\Business\ContentLine Object
                                (
                                    [content:protected] => Your parcel has been delivered successfully.
                                    [bold:protected] => 
                                    [paragraph:protected] => 
                                )

                            [linkTarget:protected] => 
                        )
                    [statusHasBeenReached:protected] => 
                    [isCurrentStatus:protected] => 
                    [showContactInfo:protected] => 
                )
        )
)
```
<?php

    ini_set( 'display_errors', 1 );

    // postpaid development server for Kansys
    $AccessToken           =       'C5A84E66-8282-472E-873E-6C2272DE7EC7';
    $ServiceAddress        =       'https://mockservice.newcomobile.com/BeALIVWebService.asmx?wsdl';
    $ServiceHost           =       'mockservice.newcomobile.com';

    # primary plans
    $setRequest             =       '<?xml version="1.0" encoding="utf-8"?>
                                        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                                            <soap:Body>
                                                <GetCustomerBundlesAndAvailableBundlesV2 xmlns="http://BeALIVWebService.newcomobile.com/">
                                                    <Token>'. $AccessToken .'</Token>
                                                    <Frequency>ALL</Frequency>
                                                    <PlanType>P</PlanType>
                                                    <PhoneNumber>2428997061</PhoneNumber>
                                                </GetCustomerBundlesAndAvailableBundlesV2>
                                            </soap:Body>
                                        </soap:Envelope>';

    $setConnect        =       curl_init();

    # set curl parameters  
    curl_setopt( $setConnect, CURLOPT_HEADER, FALSE);
    curl_setopt( $setConnect, CURLOPT_POST, TRUE );
    curl_setopt( $setConnect, CURLOPT_RETURNTRANSFER, TRUE );

    # sends the soap server url, along with the soap envelope and 
    # and required headers
    curl_setopt( $setConnect, CURLOPT_URL, trim( $ServiceAddress ) );
    curl_setopt( $setConnect, CURLOPT_CUSTOMREQUEST, 'POST' );
    curl_setopt( $setConnect, CURLOPT_POSTFIELDS, trim( $setRequest ) );
    curl_setopt( $setConnect, CURLOPT_HTTPHEADER, [ 'Content-type: text/xml; charset=utf-8',                                                                                                                            
                                                    'SOAPAction: "http://BeALIVWebService.newcomobile.com/GetCustomerBundlesAndAvailableBundlesV2"' ] );

    # accepts the login information returned by compass
    $getResponse  = curl_exec( $setConnect );

    # closes the thread and frees up resources for the next
    # time a connection attempt is made.                                                                                                                            
    curl_close( $setConnect );     

    include 'XmlToArray.php';

    $GetPlans                   =                   XmlToArray::parse( $getResponse, true, true )['soap:Envelope']['soap:Body']['GetCustomerBundlesAndAvailableBundlesV2Response']['GetCustomerBundlesAndAvailableBundlesV2Result']['Data']['AvailablePlans']['Plan'];

    $connect                    =                   mysqli_connect( 'localhost', 'root','root', 'AlivCommerce' );

    foreach( $GetPlans as $ID => $PlanSet ) :

        $PlanID                 =                   $PlanSet['PlanID'];
        $PlanName               =                   $PlanSet['PlanName'];
        $PlanGroup              =                   $PlanSet['PlanGroupID'];
        $PlanGroupName          =                   $PlanSet['PlanGroup'];
        $PlanDesc               =                   str_replace( ",", "", $PlanSet['PlanDescription'] );
        $PlanCost               =                   $PlanSet['PlanAmount'];

        $insert                 =                   mysqli_query( $connect, 'INSERT INTO Plans (PlanID, PlanName, PlanGroupID, PlanGroupName, PlanDescription, PlanCost) 
                                                                                         VALUES( "'. $PlanID .'", 
                                                                                                 "'. $PlanName .'", 
                                                                                                 "'. $PlanGroup .'", 
                                                                                                 "'. $PlanGroupName .'", 
                                                                                                 "'. $PlanDesc .'", 
                                                                                                 "'. number_format( $PlanCost * 1.12, 2 ) .'");');

                                                                                                 echo 'INSERT INTO Plans ( PlanID, PlanName, PlanGroupID, PlanGroupName, PlanDescription, PlanCost ) 
                                                                                                 VALUES( "'. $PlanID .'", 
                                                                                                         "'. $PlanName .'", 
                                                                                                         "'. $PlanGroup .'", 
                                                                                                         "'. $PlanGroupName .'", 
                                                                                                         "'. $PlanDesc .'", 
                                                                                                         "'. number_format( $PlanCost * 1.12, 2 ) .'" );';

        
        print_r( mysqli_errno( $connect ) );
        echo ' - ';
        print_r( mysqli_error( $connect ) );
        print_r( mysqli_num_rows( $insert ) );
        
    endforeach;

    mysqli_close( $connect );

?>

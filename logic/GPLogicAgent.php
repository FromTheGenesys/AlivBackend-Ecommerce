<?php

    class GPLogicAgent extends gpLogic {
        
        public function __construct() {

            parent::__construct();                                
            gpSecurity::enforceSession();
            
        }

        public function OrderStatus( $StatusID = false ) {

            $StatusIDs                  =                   [ 1     =>  'Pending',
                                                              2     =>  'Processing', 
                                                              3     =>  'Completed', 
                                                              4     =>  'Out For Delivery', 
                                                              5     =>  'Delivered' ];

            if ( empty( $StatusID ) ) :
                
                return $StatusIDs;
                
            else:

                return $StatusIDs[ $StatusID ];

            endif;

        }


        public function GetPendingOrders() {

            # get aliv accounts
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Orders.*,
                                                                                                DeviceAccessories.AccessoryName,
                                                                                                DeviceAccessories.AccessoryDescription,
                                                                                                DeviceAccessories.AccessoryCost,
                                                                                                Plans.PlanName,
                                                                                                Plans.PlanDescription,
                                                                                                Plans.PlanCost,
                                                                                                Devices.DeviceName

                                                                                      FROM      Orders
                                                                                      LEFT JOIN DeviceAccessories
                                                                                      ON        DeviceAccessories.AccessoryID = Orders.OrderAccessories
                                                                                      
                                                                                      LEFT JOIN Plans
                                                                                      ON        Plans.PlanID = Orders.OrderPlan

                                                                                      LEFT JOIN Devices
                                                                                      ON        Devices.DeviceID = Orders.OrderDevice

                                                                                      WHERE     Orders.OrderStatus  = "1"' );

            return $getData;

        }

        public function GetMyOrders() {

            # get aliv accounts
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Orders.*,
                                                                                                DeviceAccessories.AccessoryName,
                                                                                                DeviceAccessories.AccessoryDescription,
                                                                                                DeviceAccessories.AccessoryCost,
                                                                                                Plans.PlanName,
                                                                                                Plans.PlanDescription,
                                                                                                Plans.PlanCost,
                                                                                                Devices.DeviceName

                                                                                      FROM      Orders
                                                                                      LEFT JOIN DeviceAccessories
                                                                                      ON        DeviceAccessories.AccessoryID = Orders.OrderAccessories
                                                                                      
                                                                                      LEFT JOIN Plans
                                                                                      ON        Plans.PlanID = Orders.OrderPlan

                                                                                      LEFT JOIN Devices
                                                                                      ON        Devices.DeviceID = Orders.OrderDevice

                                                                                      WHERE     Orders.OrderAgent  = "'. $_SESSION['sessAcctID'] .'"' );

            return $getData;

        }

        public function ProcessAcceptOrder() {

            # get elible plans
            $getData                     =                  $this->GPLogicData->update( 'Orders',
                                                                                        'OrderAgent     =   "'. $_SESSION['sessAcctID'] .'",
                                                                                         OrderStatus    =   "2",
                                                                                         OrderAgentStarted = "'. date('Y-m-d H:i:s') .'"',                                                                                                                                                                                                                       
                                                                                        'WHERE     Orders.OrderID = "'. $_POST['OrderID'] .'"' );   
          
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Orders.*
                                                                                
                                                                                      FROM      Orders                                                                                     
                                                                                      WHERE     Orders.OrderID = "'. $_POST['OrderID'] .'"' );

            ### TEST ENVIRONMENT ###
            $payload     =   '{ "APILogin" : "MTc2MGYxMWQyMGY0ZWU2MWY5MTAxNzg5MzM5ZDQzNGI=", "APIPswd" : "8dc0684d0d86c05a52afb85949c0a5c2" }';
            $request     =   curl_init();

            curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/session/login' );                    
            curl_setopt( $request, CURLOPT_POST, TRUE);                    
            curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
            
            # sends the soap server url, along with the soap envelope and required headers                    
            curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $request, CURLOPT_HEADER, 0);
            curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
            curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json; charset=utf-8',
                                                        'GN-OPToken: 0891efb1-c21e-4ec9-f11c-860341ed6aa8' ] );

            # execute transaction and return result
            $response = curl_exec( $request );

            // closes the thread and frees up resources for the next
            // time a connection attempt is made. ( avoid memory leaks ).
            curl_close( $request );

            $jresponse      =       json_decode( $response );
        

            $Number         =       str_replace( "-", "", str_replace( "(", "", str_replace( ")", "", str_replace( " ", "", $getData['data'][0]['OrderCustMobile'] ) ) ) );

            $payload        =       '{ "Destination" : "1'. $Number .'", 
                                       "Message" : "'. $_POST['sms'] .'" }';
       
            $request     =   curl_init();
            curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/sms/send' );                    
            curl_setopt( $request, CURLOPT_POST, TRUE);                    
            curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
        
            # sends the soap server url, along with the soap envelope and required headers                    
            curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $request, CURLOPT_HEADER, 0);
            curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
            curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json', 'GN-AccessToken: '. $jresponse->{'GN-AccessToken'}  ] );

            # execute transaction and return result
            $response = curl_exec( $request );

            curl_close( $request );
                                                                                      
            header( 'Location: '. gpConfig['URLPATH'] .'agent/order/'. $getData['data'][0]['OrderGUID'] );                                                                                      


        }

        public function GetOrderByGUID( $OrderGUID ) {

            # get elible plans
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Orders.*,
                                                                                                Plans.PlanName,
                                                                                                Plans.PlanCost,
                                                                                                DeviceAccessories.AccessoryName,
                                                                                                DeviceAccessories.AccessoryCost,
                                                                                                DeviceAccessories.AccessoryCover,
                                                                                                DeviceAccessories.AccessoryDescription,
                                                                                                Devices.DeviceName,
                                                                                                Devices.DeviceDescription,
                                                                                                Devices.DeviceCost,
                                                                                                Devices.DeviceSKU,
                                                                                                Devices.DeviceCover,
                                                                                                DeviceImages.ImageName,
                                                                                                Administrators.AdminFirst,
                                                                                                Administrators.AdminLast
                                                                                
                                                                                      FROM      Orders        
                                                                                      LEFT JOIN Plans
                                                                                      ON        Plans.PlanID = Orders.OrderPlan
                                                                                      
                                                                                      LEFT JOIN DeviceAccessories
                                                                                      ON        DeviceAccessories.AccessoryID = Orders.OrderAccessories

                                                                                      LEFT JOIN Devices
                                                                                      ON        Devices.DeviceID = Orders.OrderDevice

                                                                                      LEFT JOIN DeviceImages
                                                                                      ON        DeviceImages.DeviceID = Devices.DeviceID

                                                                                      LEFT JOIN Administrators
                                                                                      ON        Administrators.AdminID = Orders.OrderDeliveryAssignment

                                                                                      WHERE     Orders.OrderGUID = "'. $OrderGUID.'"' );

            return $getData;

        }

        public function ProcessUpdateOrderByGUID( $OrderGUID ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Orders.*,
                                                                                                Administrators.AdminFirst,
                                                                                                Administrators.AdminLast
                                                                                
                                                                                      FROM      Orders                
                                                                                      LEFT JOIN Administrators
                                                                                      ON        Administrators.AdminID = Orders.OrderDeliveryAssignment 

                                                                                      WHERE     Orders.OrderID = "'. $_POST['OrderID'] .'"' );

            ### TEST ENVIRONMENT ###
            $payload     =   '{ "APILogin" : "MTc2MGYxMWQyMGY0ZWU2MWY5MTAxNzg5MzM5ZDQzNGI=", "APIPswd" : "8dc0684d0d86c05a52afb85949c0a5c2" }';
            $request     =   curl_init();

            curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/session/login' );                    
            curl_setopt( $request, CURLOPT_POST, TRUE);                    
            curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
            
            # sends the soap server url, along with the soap envelope and required headers                    
            curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $request, CURLOPT_HEADER, 0);
            curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
            curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json; charset=utf-8',
                                                         'GN-OPToken: 0891efb1-c21e-4ec9-f11c-860341ed6aa8' ] );

            # execute transaction and return result
            $response = curl_exec( $request );

            // closes the thread and frees up resources for the next
            // time a connection attempt is made. ( avoid memory leaks ).
            curl_close( $request );

            $jresponse      =       json_decode( $response );
        

            $Number         =       str_replace( "-", "", str_replace( "(", "", str_replace( ")", "", str_replace( " ", "", $getData['data'][0]['OrderCustMobile'] ) ) ) );

            $payload        =       '{ "Destination" : "1'. $Number .'", 
                                       "Message" : "'. $_POST['sms'] .'" }';

                                       echo $payload;
       
            $request     =   curl_init();
            curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/sms/send' );                    
            curl_setopt( $request, CURLOPT_POST, TRUE);                    
            curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
        
            # sends the soap server url, along with the soap envelope and required headers                    
            curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $request, CURLOPT_HEADER, 0);
            curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
            curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json', 'GN-AccessToken: '. $jresponse->{'GN-AccessToken'}  ] );

            # execute transaction and return result
            $response = curl_exec( $request );

            curl_close( $request );
            
            # get elible plans
            $getData                     =                  $this->GPLogicData->update( 'Orders',
                                                                                        'OrderStatus    =   "3"',                                                                                                                                                                                                                       
                                                                                        'WHERE     Orders.OrderGUID = "'. $OrderGUID .'"' );   


        }

        public function ProcessAssignOrderByGUID( $OrderGUID ) {


            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Orders.*,
                                                                                                Administrators.AdminFirst,
                                                                                                Administrators.AdminLast
                                                                                
                                                                                      FROM      Orders                
                                                                                      LEFT JOIN Administrators
                                                                                      ON        Administrators.AdminID = Orders.OrderDeliveryAssignment 

                                                                                      WHERE     Orders.OrderID = "'. $_POST['OrderID'] .'"' );

            ### TEST ENVIRONMENT ###
            $payload     =   '{ "APILogin" : "MTc2MGYxMWQyMGY0ZWU2MWY5MTAxNzg5MzM5ZDQzNGI=", "APIPswd" : "8dc0684d0d86c05a52afb85949c0a5c2" }';
            $request     =   curl_init();

            curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/session/login' );                    
            curl_setopt( $request, CURLOPT_POST, TRUE);                    
            curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
            
            # sends the soap server url, along with the soap envelope and required headers                    
            curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $request, CURLOPT_HEADER, 0);
            curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
            curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json; charset=utf-8',
                                                        'GN-OPToken: 0891efb1-c21e-4ec9-f11c-860341ed6aa8' ] );

            # execute transaction and return result
            $response = curl_exec( $request );

            // closes the thread and frees up resources for the next
            // time a connection attempt is made. ( avoid memory leaks ).
            curl_close( $request );

            $jresponse      =       json_decode( $response );
        

            $Number         =       str_replace( "-", "", str_replace( "(", "", str_replace( ")", "", str_replace( " ", "", $getData['data'][0]['OrderCustMobile'] ) ) ) );

            
            $payload        =       '{ "Destination" : "1'. $Number .'", 
                                       "Message" : "your recent aliv order is ready for delivery. aliv concierge agent '. $getData['data'][0]['AdminFirst'] .' '. $getData['data'][0]['AdminLast'] .' will be delivering your device." }';

       
            $request     =   curl_init();
            curl_setopt( $request, CURLOPT_URL, 'https://sandbox.gnstudios.dev/projects/api/v1/sms/send' );                    
            curl_setopt( $request, CURLOPT_POST, TRUE);                    
            curl_setopt( $request, CURLOPT_RETURNTRANSFER, TRUE );
        
            # sends the soap server url, along with the soap envelope and required headers                    
            curl_setopt( $request, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $request, CURLOPT_HEADER, 0);
            curl_setopt( $request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );      
            curl_setopt( $request, CURLOPT_HTTPHEADER, [ 'Content-type: text/json', 'GN-AccessToken: '. $jresponse->{'GN-AccessToken'}  ] );

            # execute transaction and return result
            $response = curl_exec( $request );

            curl_close( $request );


            # get elible plans
            $getData                     =                  $this->GPLogicData->update( 'Orders',
                                                                                        'OrderStatus    =   "4",
                                                                                         OrderDeliveryAssignment  = "'. $_POST['DeliveryAssignment'] .'",
                                                                                         OrderDeliveryAssignmentDate = "'. date('Y-m-d H:i:s') .'"',                                                                                                                                                                                                                       
                                                                                        'WHERE  Orders.OrderGUID = "'. $OrderGUID .'"' );   


        }

        public function GetDeliveryConcierge() {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Administrators.*
                                                                                
                                                                                      FROM      Administrators                                                                                     
                                                                                      WHERE     Administrators.AdminStatus  = "A"
                                                                                      AND       Administrators.AdminRole    = "D"' );

            return $getData;                                                                                      

        }

        public function SearchOrders() {

            $Query                      =                   '';

            if ( !empty( $_POST['OrderID'] ) ) :

                $Query              .=                  ' AND Orders.OrderID = "'. $_POST['OrderID'] .'%" ';

            endif;

            if ( $_POST['OrderStatus'] != '*' ) :

                $Query              .=                  ' AND Orders.OrderStatus = "'. $_POST['OrderStatus'] .'" ';

            endif;
            

            $Query                  .=                  ' AND Orders.OrderCreated BETWEEN "'. $_POST['StartDate'] .' 00:00:00" 
                                                                                      AND "'. $_POST['StopDate'] .' 23:59:59 " ';


            $getData                  =                  $this->GPLogicData->sql( 'SELECT    Orders.*,
                                                                                             Plans.PlanName,
                                                                                                Plans.PlanCost,
                                                                                                DeviceAccessories.AccessoryName,
                                                                                                DeviceAccessories.AccessoryCost,
                                                                                                DeviceAccessories.AccessoryCover,
                                                                                                DeviceAccessories.AccessoryDescription,
                                                                                                Devices.DeviceName,
                                                                                                Devices.DeviceDescription,
                                                                                                Devices.DeviceCost,
                                                                                                Devices.DeviceSKU,
                                                                                                Devices.DeviceCover,
                                                                                                DeviceImages.ImageName,
                                                                                                Administrators.AdminFirst,
                                                                                                Administrators.AdminLast
                                                                                
                                                                                      FROM      Orders        
                                                                                      LEFT JOIN Plans
                                                                                      ON        Plans.PlanID = Orders.OrderPlan
                                                                                      
                                                                                      LEFT JOIN DeviceAccessories
                                                                                      ON        DeviceAccessories.AccessoryID = Orders.OrderAccessories

                                                                                      LEFT JOIN Devices
                                                                                      ON        Devices.DeviceID = Orders.OrderDevice

                                                                                      LEFT JOIN DeviceImages
                                                                                      ON        DeviceImages.DeviceID = Devices.DeviceID

                                                                                      LEFT JOIN Administrators
                                                                                      ON        Administrators.AdminID = Orders.OrderDeliveryAssignment                                                                               
                                                                                   WHERE     Orders.OrderID  > "0"
                                                                                   ' . $Query );

            return $getData;                                                                                                                                                                

        }
    }
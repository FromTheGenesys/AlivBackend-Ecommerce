<?php

    class GPLogicGlobal extends gpLogic {
        
        public function __construct() {

            parent::__construct();                    

        }

        public function setAccessLevel() {

            if ( isset( $_SESSION['SessionIsStarted'] ) ) :

                if ( $_SESSION['sessAcctRole'] == 3 ) :

                    define( '_ACCESS_', 'senior/' );
                    define( '_HFPARAMS_', [ 'header' => 'Senior/Header', 'footer' => 'Senior/Footer' ] );
                    
                elseif ( $_SESSION['sessAcctRole'] == 4 ) : 

                    define( '_ACCESS_', 'csr/' );
                    define( '_HFPARAMS_', [ 'header' => 'CSR/Header', 'footer' => 'CSR/Footer' ] );

                elseif ( $_SESSION['sessAcctRole'] == 5 ) : 

                    define( '_ACCESS_', 'operations/' );
                    define( '_HFPARAMS_', [ 'header' => 'Operations/Header', 'footer' => 'Operations/Footer' ] );

                endif;

                define( '_AUTHPARAMS_', [ 'header' => 'Auth/Header', 'footer' => 'Auth/Footer' ] );
                
            endif;

        }

        public function setModuleAccess( $ModuleName ) {

            // check for Module Access
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    ModuleRegister.ModuleID
                                                                                
                                                                                      FROM      ModuleRegister
                                                                                      WHERE     ModuleRegister.ModuleName     =   "'. $ModuleName .'"' );

            
            if ( $getData['count'] == 0 ) :

                return false;

            else:

                if ( in_array( $getData['data'][0]['ModuleID'], explode( ',', $_SESSION['sessLocationModules'] ) ) ) :

                    return true;

                else:

                    return false;

                endif;
                
            endif;
            
        }

        public function CurrencyRounding( $Amount ) {

           // ensure that there are two digits
           $Amount         =       number_format( $Amount, 2, '.', '' );

           // $D = dollar, $C = coins
           list( $D, $C )  =       explode( '.', $Amount );    

           // focus digit
           $Digit          =       $C[1];
           
           // if the digit is less than or equal to two ( round down to zero )
           if ( $Digit <=  '2' ) :

               $NewCoins       =        $C[0] . '0';
               $NewAmount      =        $D .'.'. $NewCoins;
               $RoundValue     =        $NewAmount;

               
           // if the digit is between 3 and 5, round up to 5
           // else, if the digit if 5 to 7, round down to 5                
           elseif( ( $Digit >= '3' ) AND ( $Digit <= '7' ) ) :

               $NewCoins       =        $C[0] . '5';
               $NewAmount      =        $D .'.'. $NewCoins;
               $RoundValue     =        $NewAmount;

               

           // else, the amount should be incremented to the nearest tenth                
           else :

               $NewCoins       =        $C[0] + 1;
               $RoundValue     =        $D + ( $NewCoins / 10 );

           endif;

           return $RoundValue;

        }


        /**
         * 
         * @name    SetBankData
         * 
         * @desc    Sets all Banks to be used in DropZone
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         * 
         * @param   MIXED $BankID ( Optional )
         * 
         * @return  MIXED $getData
         * 
         */
        public function SetBankData ( $BankID = false ) {
            
            $setBankData          =         array( '1'  =>  'Bank To The Bahamas',
                                                   '2'  =>  'CIBC / First Caribbean',
                                                   '3'  =>  'Commonwealth Bank',
                                                   '4'  =>  'Fidelity Bank',
                                                   '5'  =>  'Royal Bank',
                                                   '6'  =>  'Scotia Bank' );
                
            if ( empty( $BankID ) ) :
                
                return $setBankData;
            
            else :
                
                return $setBankData[ $BankID ];
                
            endif;
            
        }

        /**
         * 
         * @name    SetCardTypes
         * 
         * @desc    Sets all Card Types 
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         * 
         * @param   MIXED $CardType ( Optional )
         * 
         * @return  MIXED $getData
         * 
         */
        public function SetCardTypes ( $CardType = false ) {
            
            $CardTypes          =             [  1  =>  'Visa',
                                                 2  =>  'MasterCard' ];
                
            if ( empty( $CardType ) ) :
                
                return $CardTypes;
            
            else :
                
                return $CardTypes[ $CardType ];
                
            endif;
            
        }

        /**
         * 
         * @name    SetPaymentMethods
         * 
         * @desc    Sets all Methods 
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         * 
         * @param   MIXED $CardType ( Optional )
         * 
         * @return  MIXED $getData
         * 
         */
        public function SetPaymentMethods ( $MethodType = false ) {
            
            $MethodTypes         =             [  1  =>  'Cash Payment',
                                                  2  =>  'Cheque Payment',
                                                  3  =>  'Card Payment',
                                                  4  =>  'Split Payment' ];
                
            if ( empty( $MethodType ) ) :
                
                return $MethodTypes;
            
            else :
                
                return $MethodTypes[ $MethodType ];
                
            endif;
            
        }

        public function ProcessRoleChange( $Mode ) {

            if ( $Mode == 1 ) :

                $_SESSION['sessAcctRole']   =   4;
                
            elseif ( $Mode == 2 ) :

                $_SESSION['sessAcctRole']   =   3;

            endif;

            header( 'Location: ' . gpConfig['URLPATH'] .'auth/' );

        }

        public function ProcessBranchChange() {

            if ( isset( $_POST['LocationID'] ) ) : 

                $_SESSION['sessAcctLocation']       =   $_POST['LocationID'];
                $_SESSION['sessAcctLocationName']   =   $this->GetLocation( $_POST['LocationID'] )['data'][0]['LocationName'];
                $_SESSION['sessLocationHours']      =   $this->GetLocation( $_POST['LocationID'] )['data'][0]['location_hours'];
                $_SESSION['sessLocationModules']    =   $this->GetLocation( $_POST['LocationID'] )['data'][0]['location_modules'];
                header( 'Location: ' . gpConfig['URLPATH'] .'auth/' );

            endif;

        }

        public function GetLocation( $LocationID ) {

            // get location
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    sysLocations.id,
                                                                                                UPPER( sysLocations.location_name ) AS LocationName,
                                                                                                sysLocations.location_hours
                                                                                
                                                                                      FROM      sysLocations
                                                                                      WHERE     sysLocations.id     =   "'. $LocationID .'"' );

            return $getData;

        }

        public function GetMessage() {

            // get message
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    SystemMessages.*
                                                                                
                                                                                      FROM      SystemMessages
                                                                                      WHERE     SystemMessages.MessageStatus     =   "A"
                                                                                      AND       SystemMessages.MessageFocus      =   "1"
                                                                                      AND       SystemMessages.MessageStart     <=   "'. date( 'Y-m-d H:i:s' ) .'" 
                                                                                      ' );

            if ( $getData['count'] > 0 ) :

                $setMessage      =    '';    
                
                if ( $getData['data'][0]['MessageLocation'] == '*' ) :

                    $setMessage     .=    '<div class="alert bg-warning text-dark border-warning">';
                    $setMessage     .=    '<marquee behavior="scroll" direction="left" class="text-dark">';
                    $setMessage     .=    $getData['data'][0]['MessageBody'];
                    $setMessage     .=    '</marquee>';
                    $setMessage     .=    '</div>';

                else:

                    if ( $_SESSION['sessAcctLocation'] == $getData['data'][0]['MessageLocation'] ) : 

                        $setMessage     .=    '<div class="alert bg-warning text-dark border-warning">';
                        $setMessage     .=    '<marquee behavior="scroll" direction="left" class="text-dark">';
                        $setMessage     .=    $getData['data'][0]['MessageBody'];
                        $setMessage     .=    '</marquee>';
                        $setMessage     .=    '</div>';

                    endif;

                endif;

            else:

                $setMessage      =    '';    
                
            endif;

            return $setMessage;

        }

    }
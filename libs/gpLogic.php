<?php

    class gpLogic {  
        
        public function __construct() {
            
            $this->GPLogicSession                 =       new gpSession();  
            
            /** 
             * @name            $this->GPLogicData   
             * @description     instantiate global database object             
             */
            $this->GPLogicData                    =       new gpDatabase();            
            $this->GPLogicData->host              =       gpDataCfg['HOST'];
            $this->GPLogicData->user              =       gpDataCfg['USER'];
            $this->GPLogicData->pswd              =       gpDataCfg['PWSD'];
            $this->GPLogicData->source            =       gpDataCfg['SOURCE'];
         
            /** 
             * @name            $this->GPLogicPDO
             * @description     instantiate global database object             
             */
            $this->GPLogicPDO                     =       new gpPDO( gpDataCfg2  );            
            

            /** 
             * @name            $this->PCModMail
             * @description     instantiate global email object
             *                  apply values to email object properties             
             */
            $this->GPLogicMail                    =       new PHPMailer();                        
            $this->GPLogicMail->IsSMTP();                           
            $this->GPLogicMail->Host              =       gpMailCfg['HOST'];
            $this->GPLogicMail->Port              =       gpMailCfg['PORT'];
            $this->GPLogicMail->Username          =       gpMailCfg['USER'];
            $this->GPLogicMail->Password          =       gpMailCfg['PSWD'];
            
            # active HTML in email
            $this->GPLogicMail->SMTPAuth          =       true;        
            $this->GPLogicMail->isHTML( true ); 

            /**
             * @desc    Implement Date/Time Library
             */            
            $this->GPLogicDateTime                =       new gpDateTime();

            /**
             * @desc    Implements Math Library
             */            
            $this->GPLogicMath                    =       new gpMath();

            /**
             * @desc Instantiates Messages Library
             */            
            $this->GPLogicMessages                =       new gpMessages();

            /**
             * @desc    Implements Janitor Library
             */            

            $this->GPLogicJanitor                 =       new gpJanitor();
            # never trust any data provided by the user;
            # invoke Janitor Library
            # clean all data
            $this->GPLogicJanitor->preventXSS();
            $this->GPLogicJanitor->setCSRFToken();
            $this->GPLogicJanitor->checkCSRFToken();

            # include PHPExcel
            include_once 'phpexcel/Classes/PHPExcel.php';
            include_once 'phpexcel/Classes/PHPExcel/IOFactory.php';
            include_once 'phpexcel/Classes/PHPExcel/Style.php';
            $this->GPLogicExcel         =   new PHPExcel();


            // include_once 'phpexcel/Classes/PHPExcel.php';
            // include_once 'phpexcel/Classes/PHPExcel/IOFactory.php';
            // include_once 'phpexcel/Classes/PHPExcel/Style.php';
            // $this->GPLogicExcel         =   new PHPExcel();

            // include_once 'spreadsheet/Speadsheet.php';
            // include_once 'spreadsheet/IOFactory.php';
            // include_once 'spreadsheet/Style.php';
            // include_once 'spreadsheet/Writer/Xlsx.php';

           
            // $sheet = $this->GPLogicSheets->getActiveSheet();
            // $this->GPLogicSheets->setCellValue('A1', 'Hello World !');

            // $writer = new Xlsx($this->GPLogicSheets);
            // $writer->save( gpConfig['BASEPATH'] . gpConfig['DATA'] . 'hello world.xlsx');
            
        }

        
        /**
         * 
         * @name    gpGenerateGUID
         * 
         * @desc    Generates a unique UUID
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         * 
         * @return  STRING $uuid
         * 
         */
        public function gpGenerateGUID() {
               
            if ( function_exists( 'com_create_guid' ) ) :
                 
                 return com_create_guid();
                 
            else :
                 
                 mt_srand( (double)microtime() * 10000 ); //optional for php 4.2.0 and up.
                 $charid   =    strtolower(md5(uniqid(rand(), true)));
                 $hyphen   =    chr(45); // "-"
                 
                 $uuid     =     substr($charid, 0, 8 )  . $hyphen
                                .substr($charid, 8, 4 )  . $hyphen
                                .substr($charid, 12, 4 ) . $hyphen
                                .substr($charid, 16, 4 ) . $hyphen
                                .substr($charid, 20,12 );
                 
                 return $uuid;
            
            endif; 
            
        }

        /**
         * 
         * @name    gpGenerateOTP
         * 
         * @desc    Generates a unique OTP
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         * 
         * @return  STRING $PIN
         * 
         */
        public function gpGenerateOTP() {
               
            $PIN            =       '';
            $Characters     =       '0123456789';

            for ( $i = 0; $i < 6; $i++) :
                
                $PIN        .=      $Characters[ rand( 0, strlen( $Characters ) - 1 ) ];
            
            endfor;
            
            return $PIN;
            
        }

        /**
         * 
         * @name    gpValidateEmail
         * 
         * @desc    Generates a unique OTP
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         * 
         * @return  STRING $uuid
         * 
         */
         public function gpValidateEmail( $EmailAddress ) {

            if ( filter_var( $EmailAddress, FILTER_VALIDATE_EMAIL ) == false ) :

                return FALSE;

            else:

                return TRUE;

            endif;

       }

       /**
        * 
        * @name    gpConfirmEmails
        * 
        * @desc    Confirms that the email address provided match
        * 
        * @author  Vincent J. Rahming <vincent@genesysnow.com>
        * 
        * @return  BOOLEAN
        * 
        */
       public function gpConfirmEmails( $EmailOne, $EmailTwo ) {

            if ( $EmailOne !== $EmailTwo ) :

                return false;

            else:

                return true;

            endif;

       }

       /**
        * 
        * @name    gpValidatePassword
        * 
        * @desc    Ensures that the password meets a minium standard for a strong
        *          passwords
        * 
        * @author  Vincent J. Rahming <vincent@genesysnow.com>
        * 
        * @return  BOOLEAN
        * 
        */
       public function gpValidatePassword( $Password ) {

            // the password must have at least one number
             if ( preg_match( '/[0-9]/', $Password ) == FALSE ) :
                
                return false;
                
             endif;
            
             // the password must have at least one captial letter
             if ( preg_match( '/[A-Z]/', $Password ) == FALSE ) :
                
                return false;
                
             endif;
             
             // the password must have at least one common letter
             if ( preg_match( '/[a-z]/', $Password ) == FALSE ) :
                
                return false;
                
             endif;
             
            // the password must have at least one special character
            if ( preg_match( '/[!@#$%^&*]/', $Password ) == FALSE ) :
                
                return false;
                
            endif;

            return true;

       }

       /**
        * 
        * @name    gpConfirmPasswords
        * 
        * @desc    Ensures that the password provided match        
        * 
        * @author  Vincent J. Rahming <vincent@genesysnow.com>
        * 
        * @return  BOOLEAN
        * 
        */
       public function gpConfirmPasswords( $PasswordOne, $PasswordTwo ) {

            if ( $PasswordOne !== $PasswordTwo ) :

                return false;

            else:

                return true;

            endif;

       }

    }
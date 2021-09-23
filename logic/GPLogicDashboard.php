<?php

    class GPLogicDashboard extends gpLogic {
        
        public function __construct() {

            parent::__construct();                    
            gpSecurity::enforceSession();

        }

        /**
         * @name    GetAllAccounts
         * @desc    Retrieves all accounts
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  MIXED ARRAY $getData 
         */
        public function GetAllAccounts() {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBManageAccounts.*
                                                                                                    
                                                                                      FROM          ESBManageAccounts
                                                                                      ORDER BY      ESBManageAccounts.AccountLast ASC' );

            return $getData;                                                                                      

        }


        /**
         * @name    GetAdminAccount
         * @desc    Retrieves single accounts
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  MIXED ARRAY $getData 
         */
        public function GetAdminAccount( string $AccountGUID ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBManageAccounts.*
                                                                                                    
                                                                                      FROM          ESBManageAccounts
                                                                                      WHERE         ESBManageAccounts.AccountGUID       =       "'. $AccountGUID .'"' );

            return $getData;                                                                                      

        }

        public function GetOperator( $OperatorToken ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBAPIAccess.*
                                                                                                    
                                                                                      FROM          ESBAPIAccess
                                                                                      WHERE         ESBAPIAccess.APIOperatorToken = "'. $OperatorToken .'"'
                                                                                    );

            return $getData;                                                                                    

        }

        private function _checkExistingAPIAccount( $AccountName ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBAPIAccess.RowID
                                                                                                    
                                                                                      FROM          ESBAPIAccess
                                                                                      WHERE         UPPER( ESBAPIAccess.APIAccessNam ) = "'. strtoupper( $AccountName ) .'"'
                                                                                    );

            if ( $getData['count']  == 0 ) :
                
                return false;

            else:

                return true;

            endif;

        }


        public function ProcessAddOperator() {

            # check required fields
            if ( empty( $_POST['OpName'] ) OR
                 empty( $_POST['OpThreshold'] ) )  :

                return 2;
                
            endif;

            # confirm that threshold is numberic
            if ( !is_numeric( $_POST['OpThreshold'] ) ) :

                return 3;

            endif;

            if ( $_POST['OpThreshold'] <= 0 ) :

                return 4;

            endif;

            # check to see if an existing name already exists 
            if ( $this->_checkExistingAPIAccount( $_POST['OpName'] ) ) :

                return 5;

            endif;

            # set data package
            $setInsertPackage           =                   [ 'fields'      =>         'APIAccessName,
                                                                                        APIUserID,
                                                                                        APIUserPswd,
                                                                                        APIUserStatus,                                                                                        
                                                                                        APIOperatorToken,
                                                                                        APIUserPage,
                                                                                        APIWhiteListAPI,
                                                                                        APIUserRequestThreshold,
                                                                                        APIUserCreated',

                                                               'values'      =>      [
                                                                                        strtoupper( str_replace( " ", "_", $_POST['OpName'] ) ),
                                                                                        $_POST['OpAPILogin'],
                                                                                        $_POST['OpAPIPswd'],
                                                                                        $_POST['OpStatus'],                                                                                        
                                                                                        $_POST['OpToken'],
                                                                                        $_POST['OpPage'],
                                                                                        $_POST['OpWhiteList'],
                                                                                        $_POST['OpThreshold'],
                                                                                        date('Y-m-d H:i:s') ] ];

            # update
            $setData                    =                   $this->GPLogicData->insert( 'ESBAPIAccess', $setInsertPackage ); 

            # add access for new operators
            $setSession                 =                   [ 'fields'      =>         'APIName,
                                                                                        OperatorID',

                                                               'values'      =>      [
                                                                                        'session',
                                                                                        $setData['insertID'] ] ];

            # insert session access
            $setSessionData             =                   $this->GPLogicData->insert( 'ESBAPIOperatorAccess', $setSession ); 

             # add toolbox access
             $setToolbox                =                    [ 'fields'      =>         'APIName,
                                                                                         OperatorID',

                                                               'values'      =>      [
                                                                                        'toolbox',
                                                                                        $setData['insertID'] ] ];

            # insert toolbox access
            $setSessionData             =                   $this->GPLogicData->insert( 'ESBAPIOperatorAccess', $setToolbox ); 

        }

        public function UpdateOperator( $OperatorToken ) {

            # check required fields
            if ( empty( $_POST['OpName'] ) OR
                 empty( $_POST['OpThreshold'] ) )  :

                return 2;
                
            endif;

            # confirm that threshold is numberic
            if ( !is_numeric( $_POST['OpThreshold'] ) ) :

                return 3;

            endif;

            if ( $_POST['OpThreshold'] <= 0 ) :

                return 4;

            endif;

            if ( $_POST['OpName'] != $_POST['OpNameOld'] ) : 

                # check to see if an existing name already exists 
                if ( $this->_checkExistingAPIAccount( $_POST['OpName'] ) ) :

                    return 5;

                endif;

            endif;


            # set data package
            $setUpdatePackage           =                   ' APIAccessName         =       ":AccessUserName",
                                                              APIUserStatus         =       "'. $_POST['OpStatus'] .'",
                                                              APIWhiteListAPI       =       "'. $_POST['OpWhiteList'] .'",
                                                              APIUserRequestThreshold =     ":UserThreshold"';

            # update
            $setData                    =                   $this->GPLogicData->update( 'ESBAPIAccess',
                                                                                        $setUpdatePackage,
                                                                                        'WHERE ESBAPIAccess.APIOperatorToken  =  "'. $OperatorToken .'"',
                                                                                        [ 'AccessUserName'  =>  strtoupper( trim( str_replace( " ", "_", $_POST['OpName'] ) ) ),
                                                                                          'UserThreshold'   =>  strtoupper( trim( $_POST['OpThreshold'] ) ) ] );

            return 1;

        }

        public function ProcessRemoveIP( $OperatorToken ) {

            $GetOperator                         =                   $this->GetOperator( $OperatorToken );

            # delete
            $setData                             =                   $this->GPLogicData->delete( 'ESBAPIWhitelistIP',
                                                                                                 'WHERE ESBAPIWhitelistIP.APIUserID  =  "'. $GetOperator['data'][0]['RowID'] .'"
                                                                                                  AND   ESBAPIWhitelistIP.APIAccessIP    =  "'. $_POST['IP'] .'"' );

            return 1;

        }

        public function GetOperatorTransactions( $RecordID, $StartDate, $StopDate ) {

            $this->GPLogicData->source            =                 'OnlineGaming';

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        Orders.*
                                                                                                    
                                                                                              FROM          Orders
                                                                                              WHERE         Orders.OperatorID  = "'. $RecordID .'"
                                                                                              AND           Orders.OrderCreated BETWEEN "'. $StartDate .' 00:00:00"
                                                                                                                                    AND "'. $StopDate .' 23:59:59"',
                                                                                              [ 'OperatorID'    =>  $RecordID ]                                                                                              
                                                                                            );

            return $getData;                                                                                              

        }

        public function GetAPIs() {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBAPIs.*
                                                                                                    
                                                                                              FROM          ESBAPIs
                                                                                              ORDER BY      ESBAPIs.APIName ASC'
                                                                                            );

            return $getData;                                                                                              

        }

        public function GetWhiteListIPs( $OperatorID ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBAPIWhiteListIP.*
                                                                                                    
                                                                                              FROM          ESBAPIWhiteListIP
                                                                                              WHERE         ESBAPIWhiteListIP.APIUserID  = "'. $OperatorID .'"'
                                                                                            );

            return $getData;                                                                                              

        }

        public function ProcessAddAPIs( $OperatorToken ) {

            if ( sizeof( $_POST['Access'] ) > 0 ) :

                # update
                $setData                    =                   $this->GPLogicData->update( 'ESBAPIAccess',
                                                                                            'APIUserSeats      =       "'. implode( ',', $_POST['Access'] ) .'"',
                                                                                            'WHERE ESBAPIAccess.APIOperatorToken  =  "'. $OperatorToken .'"');

                return 1;

            endif;

        }

        

        private function _checkExistingWhitelistIP( $OperatorID, $IPs) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBAPIWhiteListIP.RowID
                                                                                                    
                                                                                      FROM          ESBAPIWhiteListIP
                                                                                      WHERE         ESBAPIWhiteListIP.APIUserID     =   "'. $OperatorID .'"
                                                                                      AND           ESBAPIWhiteListIP.APIAccessIP   =   "'. $IPs .'"');

            if( $getData['count'] == 0 ) :

                return false;

            else:

                return true;

            endif;

        }


        public function ProcessAddWhiteListIP( $OperatorToken ) {

            $GetOperator                    =                   $this->GetOperator( $OperatorToken );
        
            foreach( explode( "\r", $_POST['WhiteList'] ) as $IPs ) :

                if ( $this->_checkExistingWhitelistIP( $GetOperator['data'][0]['RowID'], $IPs ) == false ) : 


                    # set data package
                    $setInsertPackage           =                   [ 'fields'      =>        'APIUserID,
                                                                                            APIAccessIP',

                                                                    'values'      =>      [ $GetOperator['data'][0]['RowID'],
                                                                                            $IPs
                                                                                            ] ];

                    # insert data
                    $setData                    =                   $this->GPLogicData->insert( 'ESBAPIWhiteListIP', $setInsertPackage ); 

                endif;

            endforeach;

        }


        public function GetOperatorSummary( $OperatorID, $StartDate, $StopDate ) {

            $this->GPLogicData->source            =                 'OnlineGaming';

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        SUM( Orders.OrderDeposited +
                                                                                                                 Orders.OrderCommission +
                                                                                                                 Orders.OrderVAT ) as OrderTotal,

                                                                                                            COUNT( Orders.OrderID ) as OrderCount     
                                                                                                    
                                                                                              FROM          Orders
                                                                                              WHERE         Orders.OperatorID  = "'. $OperatorID .'"
                                                                                              AND           Orders.OrderCreated BETWEEN "'. $StartDate .' 00:00:00"
                                                                                                                                    AND "'. $StopDate  .' 23:59:59"',
                                                                                             [ 'OperatorID'    =>  $OperatorID ] );

            return $getData;

        }

        public function ProcessDwldReport( $OperatorToken, $StartDate, $StopDate ) {

            $getOperator            =           $this->GetOperator( $OperatorToken );
            $getTransactions        =           $this->GetOperatorTransactions( $getOperator['data'][0]['RowID'], $StartDate, $StopDate );

            $this->bsfObjExcel->setActiveSheetIndex(0);        
            $this->bsfObjExcel->setActiveSheetIndex()->setCellValue('A1', 'OPERATOR TRANSACTION REPORT - '. strtoupper( $getOperator['data'][0]['APIAccessName'] ) )->mergeCells('A1:J1');
            $this->bsfObjExcel->setActiveSheetIndex()->setCellValue('A2', 'FROM '. date( 'M/d/Y', strtotime( $StartDate ) ) .' TO ' . date( 'M/d/Y', strtotime( $StopDate ) ) )->mergeCells('A2:J2')                                                    
                                                     ->setCellValue('A3', 'PATRON ID')
                                                     ->setCellValue('B3', 'NAME')
                                                     ->setCellValue('C3', 'DEPOSIT')
                                                     ->setCellValue('D3', 'COMMISSION')
                                                     ->setCellValue('E3', 'VAT')
                                                     ->setCellValue('F3', 'TOTAL')
                                                     ->setCellValue('G3', 'ACCT BALANCE')
                                                     ->setCellValue('H3', 'REFERENCE')
                                                     ->setCellValue('I3', 'AUTH')
                                                     ->setCellValue('J3', 'DATE');                                                  
                                                    
            $setDSRow  =   4;
            
            $TotalDeposit                =       0;
            $TotalCommission             =       0;
            $TotalFee                    =       0;

            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A1:J3' )->getFont()->setBold( true );
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A2' )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                              
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'O3:T3' )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                        
            
            foreach( $getTransactions['data'] as $DataSet ) :
            
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'A' . $setDSRow , $DataSet['OrderPatronID'] );
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'B' . $setDSRow , $DataSet['OrderLast'] .', '. $DataSet['OrderFirst']  );
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'C' . $setDSRow , $DataSet['OrderDeposited'] );
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'D' . $setDSRow , $DataSet['OrderCommission'] );
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'E' . $setDSRow , $DataSet['OrderVAT'] );
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'F' . $setDSRow , floatval( $DataSet['OrderDeposited'] + $DataSet['OrderCommission'] + $DataSet['OrderVAT'] ) );
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'G' . $setDSRow , $DataSet['OrderBalance'] );
                
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'H' . $setDSRow , $DataSet['OrderType'] .' ( x-'. $DataSet['OrderFour'] . ') ' );
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'I' . $setDSRow , $DataSet['OrderAuth'] );
                $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'J' . $setDSRow , date( 'M/d/Y h:i a', strtotime( $DataSet['OrderCreated'] ) ) );
                
                $this->bsfObjExcel->setActiveSheetIndex()->getRowDimension( $setDSRow )->setRowHeight( 20 );
                $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A' . $setDSRow .':J' . $setDSRow )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER );               
                $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'C'. $setDSRow .':G'. $setDSRow)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE );         
                $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'C'. $setDSRow .':G'. $setDSRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT ); 

                ++$setDSRow;
                                                        
            endforeach;       
            
                
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A' . $setDSRow )->getFont()->setBold( true );
            $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'C' . $setDSRow, '=SUM(C4:C' . ( $setDSRow - 1 ) .')' );
            $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'D' . $setDSRow, '=SUM(D4:D' . ( $setDSRow - 1 ) .')' );
            $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'E' . $setDSRow, '=SUM(E4:E' . ( $setDSRow - 1 ) .')' );
            $this->bsfObjExcel->setActiveSheetIndex()->setCellValue( 'F' . $setDSRow, '=SUM(F4:F' . ( $setDSRow - 1 ) .')' );
            

            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A' . $setDSRow .':J' . $setDSRow )->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setRGB( 'EEEEEE');
            $this->bsfObjExcel->setActiveSheetIndex()->getRowDimension( $setDSRow )->setRowHeight( 30 );
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A' . $setDSRow .':J' . $setDSRow )->getFont()->setBold( true );
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A' . $setDSRow .':J' . $setDSRow )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER );   
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'C'. $setDSRow .':F'. $setDSRow)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE );   
                
                                                
            # column dimensions
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('A')->setWidth(12);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('B')->setWidth(32);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('C')->setWidth(15);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('D')->setWidth(15);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('E')->setWidth(15);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('F')->setWidth(15);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('G')->setWidth(17);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('H')->setWidth(15);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('I')->setWidth(10);
            $this->bsfObjExcel->setActiveSheetIndex()->getColumnDimension('J')->setWidth(25);
            
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A1' )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER );      
            $this->bsfObjExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);                        
            $this->bsfObjExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);                        
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A2:J2' )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER );                              
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle( 'A3:J3' )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER );                              

            $this->bsfObjExcel->setActiveSheetIndex()->getRowDimension('1')->setRowHeight(45);
            $this->bsfObjExcel->setActiveSheetIndex()->getRowDimension('2')->setRowHeight(35);
            $this->bsfObjExcel->setActiveSheetIndex()->getRowDimension('3')->setRowHeight(30);
            
            
            # shading and background color
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle('A1:J1')->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setRGB( 'EEEEEE');
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle('A3:J3')->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setRGB( 'EEEEEE');
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle('A2:J2')->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setRGB( '4dbd74');
        
            # alignment
            $this->bsfObjExcel->setActiveSheetIndex()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                        
        
            # set protection
            $this->bsfObjExcel->setActiveSheetIndex()->getProtection()->setSheet(true);
            
            // Redirect output to a clientâ€™s web browser (Excel5) 
            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="TRANSACTION_REPORTS.xlsx"'); 
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter( $this->bsfObjExcel, 'Excel2007'); 
            $objWriter->save('php://output');

        }

        

        public function GetGUID() {

            return $this->gpGenerateGUID();

        }

      

        /**
         * @name    SetUserStatus
         * @desc    Provides a list of user statuses or a specific status if an argument is provided
         * @param   INT $StatusID | Optional
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  MIXED | STRING $setStatus 
         */
        public function SetUserStatus( $StatusID = false ) {

            $setStatus                  =                   [ 'A'     =>      'Active',
                                                              'I'     =>      'Inactive' ];

            if ( empty( $StatusID ) ) :
                
                return $setStatus;
            
            else:

                return $setStatus[ $StatusID ];

            endif;

        }

        /**
         * @name    GetAPIDirectory
         * @desc    Provides a list of files with a ws prefix           
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  MIXED | STRING $setDirectories 
         */
        public function GetAPIDirectory() {

            $setBasePath                    =                   str_replace( "manage/", "v1/", gpConfig['BASEPATH'] );
            $setDirectories                 =                   [];

            foreach( scandir( $setBasePath .'services/' ) as $setFileDir ) :

                if ( !is_dir( $setFileDir ) ) :

                    array_push( $setDirectories, strtolower( str_replace( ".php", "", substr( $setFileDir, 2 ) ) ) );

                endif;

            endforeach;

            return $setDirectories;

        }

        /**
         * @name    GetAPI
         * @desc    GetAPI collects the details of the API including name, status, description and exposure
         * @param   STRING $API Name of the API         
         * @return  MIXED $getData Returns the record of the API
         */
        public function GetAPI( $API ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBAPIs.*,
                                                                                                            IF ( ESBAPIs.APIStatus = "A", "Active", "Inactive" ) AS APIStatusDisplay,
                                                                                                            IF ( ESBAPIs.APIExposure = "1", "Public", "Private" ) AS APIExposureDisplay, 
                                                                                                            ( SELECT    COUNT( ESBAPIOperatorAccess.AccessID )

                                                                                                              FROM      ESBAPIOperatorAccess
                                                                                                              WHERE     ESBAPIOperatorAccess.APIName = ESBAPIs.APIName ) AS AssignmentCount

                                                                                              FROM          ESBAPIs
                                                                                              WHERE         ESBAPIs.APIName  = ":API"',
                                                                                             [ 'API'    =>  strtolower( $API ) ] );

            return $getData;

        }

        /**
         * @name    GetAPIAccess
         * @desc    GetAPIAccess Checks to determine if current operator has access to the current API
         * @param   STRING $OperatorID ID of the Operator
         * @param   STRING $API Name of the API         
         * @return  MIXED $getData Returns the record of the API
         */
        public function GetAPIAccess( $OperatorID, $API  ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBAPIOperatorAccess.*

                                                                                              FROM          ESBAPIOperatorAccess
                                                                                              WHERE         ESBAPIOperatorAccess.OperatorID  = ":OpID"
                                                                                              AND           ESBAPIOperatorAccess.APIName     = ":API"
                                                                                              
                                                                                              ',
                                                                                             [ 'OpID'   =>  strtolower( $OperatorID ),
                                                                                               'API'    =>  strtolower( $API )   
                                                                                             ] );

            return $getData;

        }

        /**
         * @name    GetAPIOperatorAccess
         * @desc    GetAPIOperatorAccess Checks to determine if current operator has access to the current API
         * @param   STRING $OperatorID ID of the Operator         
         * @return  MIXED $getData Returns the record of the API
         */
        public function GetAPIOperatorAccess( $OperatorID ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBAPIOperatorAccess.*

                                                                                              FROM          ESBAPIOperatorAccess
                                                                                              WHERE         ESBAPIOperatorAccess.OperatorID  = ":OpID"',
                                                                                             [ 'OpID'   =>  strtolower( $OperatorID ) ] );

            return $getData;

        }

        /**
         * @name    GetAPIByGUID
         * @desc    GetAPIByGUID collects the details of the API including name, status, description and exposure
         * @param   STRING $API Name of the API         
         * @return  MIXED $getData Returns the record of the API
         */
        public function GetAPIByGUID( $APIGUID ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBAPIs.*,
                                                                                                            IF ( ESBAPIs.APIStatus = "A", "Active", "Inactive" ) AS APIStatusDisplay,
                                                                                                            IF ( ESBAPIs.APIExposure = "1", "Public", "Private" ) AS APIExposureDisplay

                                                                                              FROM          ESBAPIs
                                                                                              WHERE         ESBAPIs.APIGUID  = ":APIGUID"',
                                                                                             [ 'APIGUID'    =>  strtolower( $APIGUID ) ] );

            return $getData;

        }

        /**
         * @name    GetAssignmentOperators
         * @desc    GetAPIByGUID collects the details of the API including name, status, description and exposure
         * @param   STRING $API Name of the API         
         * @return  MIXED $getData Returns the record of the API
         */
        public function GetAssignmentOperators( $APIName ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        DISTINCT( ESBAPIOperatorAccess.OperatorID ) AS OperatorID,                                                                                                            
                                                                                                            ESBAPIAccess.APIAccessName,
                                                                                                            ESBAPIAccess.APIOperatorToken
                                                                                                            

                                                                                              FROM          ESBAPIOperatorAccess
                                                                                              LEFT JOIN     ESBAPIAccess
                                                                                              ON            ESBAPIAccess.RowID  =   ESBAPIOperatorAccess.OperatorID
                                                                                              WHERE         ESBAPIOperatorAccess.APIName  = ":APIName"',
                                                                                             [ 'APIName'    =>  strtolower( $APIName ) ] );

            return $getData;

        }
        
        /**
         * @name    RegisterAPI
         * @desc    RegisterAPI add the details of the API including name, status, description and exposure to the database          
         * @return  INT $this->process result value
         */
        public function RegisterAPI() {

            if ( $this->_checkExistingAPIName( $_POST['APIName'] ) == true ) :

                return 2;

            endif;

            # set data package
            $setInsertPackage           =                   [ 'fields'      =>         'APIGUID,
                                                                                        APIName,
                                                                                        APIDesc,
                                                                                        APIExposure,
                                                                                        APIStatus,
                                                                                        APIRegisterDate',

                                                               'values'      =>      [
                                                                                        $this->gpGenerateGUID(),
                                                                                        strtolower( $_POST['APIName'] ),
                                                                                        $_POST['APIDesc'],
                                                                                        $_POST['APIExposure'],
                                                                                        'A',
                                                                                        date('Y-m-d H:i:s') ] ];

            # insert
            $setData                    =                   $this->GPLogicData->insert( 'ESBAPIs', $setInsertPackage ); 
            
            return 1;

        }

        /**
         * @name    ProcessUpdateAPI
         * @desc    ProcessUpdateAPI add the details of the API including name, status, description and exposure to the database          
         * @return  INT $this->process result value
         */
        public function ProcessUpdateAPI() {

            # set data package
            $setUpdatePackage           =                   'APIExposure        =       "'. $_POST['APIExposure'] .'",
                                                             APIStatus          =       "'. $_POST['APIStatus'] .'",
                                                             APIDesc            =       "'. $_POST['APIDesc'] .'"';

            # update
            $setData                    =                   $this->GPLogicData->update( 'ESBAPIs', $setUpdatePackage, 'WHERE APIName = "'. strtolower( $_POST['APIName'] ) .'"' ); 
            
            return 1;

        }

        /**
         * @name    GetRegisteredAPI
         * @desc    GetRegisteredAPI add the details of the API including name, status, description and exposure to the database          
         * @return  INT $this->process result value
         */
        public function GetRegisteredAPIs() {

            # get registered
            $getData                    =                   $this->GPLogicData->sql( 'SELECT    ESBAPIOperatorAccess.*,
                                                                                                ESBAPIs.APIGUID,
                                                                                                ESBAPIs.APIDesc,
                                                                                                ESBAPIs.APIExposure,
                                                                                                ESBAPIs.APIStatus,
                                                                                                ESBAPIs.APIRegisterDate
                                                                                                
                                                                                      FROM      ESBAPIOperatorAccess
                                                                                      LEFT JOIN ESBAPIs
                                                                                      ON        ESBAPIs.APIName     =       ESBAPIOperatorAccess.APIName
                                                                                      WHERE     ESBAPIOperatorAccess.OperatorID = "'. $_SESSION['sessOpID'] .'"' ); 

            return $getData;

        }


         /**
         * @name    ProcessGrantAPIAccess
         * @desc    ProcessGrantAPIAccess check the existing API Register to determine if the API being registered already exists
         * @param   STRING $OperatorToken Operator Token GUID
         * @return  INT $this->process result value
         */
        public function ProcessGrantAPIAccess( $OperatorToken ) {

            if ( empty( $_POST['Access'] ) ) :
                
                return 2;
                
            endif;

            # get operator
            $GetOperator                        =                   $this->GetOperator( $OperatorToken );

            foreach( $_POST['Access'] as $Access ) :

                # check to determine if the access specified does not already exist.                  
                if ( $this->_checkExistingAccess( $GetOperator['data'][0]['RowID'], $Access ) == false ) :

                    # set data package
                    $setInsertPackage           =                   [ 'fields'      =>         'APIName,
                                                                                                OperatorID',

                                                                      'values'      =>      [   strtolower( $Access ),
                                                                                                $GetOperator['data'][0]['RowID'] ] ];

                    # insert
                    $setData                    =                   $this->GPLogicData->insert( 'ESBAPIOperatorAccess', $setInsertPackage ); 

                endif;

            endforeach;

            return 1;
            
        }

        /**
         * @name    _checkExistingAPIName
         * @desc    _checkExistingAPIName check the existing API Register to determine if the API being registered already exists
         * @return  BOOLEN
         */
        private function _checkExistingAPIName( $APIName ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBAPIs.*
                                                                                                    
                                                                                              FROM          ESBAPIs
                                                                                              WHERE         LOWER( ESBAPIs.APIName )  = ":APIName"',
                                                                                              [ 'APIName'    =>  strtolower( $APIName ) ]                                                                                              
                                                                                            );

            if ( $getData['count'] == 0 ) :

                return false;

            else:

                return true;

            endif;

        }

        /**
         * @name    _checkExistingAccess
         * @desc    _checkExistingAccess check the existing API Access is registered for the current operator
         * @return  BOOLEN
         */
        private function _checkExistingAccess( string $OperatorID, string $API ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBAPIOperatorAccess.AccessID
                                                                                                    
                                                                                              FROM          ESBAPIOperatorAccess
                                                                                              WHERE         LOWER( ESBAPIOperatorAccess.APIName )  = ":APIName"
                                                                                              AND           OperatorID                             = "'. $OperatorID .'"',
                                                                                              [ 'APIName'    =>  strtolower( $API ) ]                                                                                              
                                                                                            );

            if ( $getData['count'] == 0 ) :

                return false;

            else:

                return true;

            endif;

        }

        /**
         * @name    ProcessRevokeAPI
         * @desc    ProcessRevokeAPI removes the API assignment from the operator in the ESBAPIOperatorAccess table
         * @param   INT $OperatorID ID of the operator
         * @param   STRING $Access Name of the API
         */
        public function ProcessRevokeAPI( string $OperatorID, string $Access ) {

            $this->GPLogicData->delete( 'ESBAPIOperatorAccess',
                                        'WHERE ESBAPIOperatorAccess.OperatorID  =  "'. $OperatorID .'"
                                         AND   ESBAPIOperatorAccess.APIName     =  "'. $Access .'"');

        }

         /**
         * @name    ProcessCreateAccount
         * @desc    ProcessCreateAccount allows for the creation of a system account         
         */
        public function ProcessCreateAccount() {

            # ensure required fields are present
            if ( empty( $_POST['AccountLast'] ) OR
                 empty( $_POST['AccountFirst'] ) OR 
                 empty( $_POST['AccountEmail'] ) OR
                 empty( $_POST['Password'][0] ) OR
                 empty( $_POST['Password'][1] ) ) :

                return 2;

            endif;

            # validate email
            if ( $this->gpValidateEmail( $_POST['AccountEmail'] ) == false ) :

                return 3;

            endif;

            # check to ensure that email does not already exist in system
            if ( $this->_checkExistingEmail( $_POST['AccountEmail'] ) == true ) :

                return 4;

            endif;

            # validate password
            if ( $this->gpValidatePassword( $_POST['Password'][0] ) == false ) :

                return 5;

            endif;

            # check matching password
            if ( $this->gpConfirmPasswords( $_POST['Password'][0], $_POST['Password'][1] ) == false ) :

                return 6;
                
            endif;

            $AccountGUID                          =                 $this->gpGenerateGUID();

            # set data package
            $setInsertPackage                     =                 [ 'fields'      =>         'AccountGUID,
                                                                                                AccountFirst,
                                                                                                AccountLast,
                                                                                                AccountEmail,
                                                                                                AccountPassword,
                                                                                                AccountStatus,
                                                                                                AccountCreated',

                                                                      'values'      =>      [   $AccountGUID,
                                                                                                strtoupper( $_POST['AccountFirst'] ),
                                                                                                strtoupper( $_POST['AccountLast'] ),
                                                                                                strtolower( $_POST['AccountEmail'] ),
                                                                                                md5( $_POST['Password'][0] ),
                                                                                                $_POST['Status'],
                                                                                                date('Y-m-d H:i:s') ] ];

            # insert
            $setData                              =                   $this->GPLogicData->insert( 'ESBManageAccounts', $setInsertPackage ); 

            header( 'Location: '. gpConfig['URLPATH'] . 'administrator/account/'. $AccountGUID .'/1' );

        }

        /**
         * @name    _checkExistingEmail         
         * @desc    _checkExistingEmail checks the user table to ensure that two email addresses are not present.
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         * @param   STRING $EmailAddress 
         * @return  BOOLEAN
         */
        private function _checkExistingEmail( string $EmailAddress ) {

            $getData                              =                 $this->GPLogicData->sql( 'SELECT        ESBManageAccounts.AccountEmail
                                                                                                    
                                                                                              FROM          ESBManageAccounts
                                                                                              WHERE         LOWER( ESBManageAccounts.AccountEmail )  = ":EmailAddress"',                                                                                              
                                                                                              [ 'EmailAddress'    =>    strtolower( $EmailAddress ) ]                                                                                              
                                                                                            );

            if ( $getData['count'] == 0 ) :

                return false;

            else:

                return true;

            endif;

        }


        /**
         * @name    GetAccount
         * @desc    GetAccount retrieves the details of a specified account
         * @param   STRING $AccountGUID 
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  MIXED ARRAY $getData 
         */
        public function GetAccount( string $AccountGUID ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBManageAccounts.*
                                                                                                    
                                                                                      FROM          ESBManageAccounts
                                                                                      WHERE         ESBManageAccounts.AccountGUID   =   ":AccountGUID"',
                                                                                      [ 'AccountGUID'   =>  $AccountGUID ] );

            return $getData;                                                                                      

        }

        /**
         * @name    ProcessResetPassword
         * @desc    ProcessResetPassword resets the password of a specific account
         * @param   STRING $AccountGUID 
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  MIXED ARRAY $getData 
         */
        public function ProcessResetPassword( string $AccountGUID ) {

            # ensure required fields are present
            if ( empty( $_POST['Password'][0] ) OR
                 empty( $_POST['Password'][0] ) ) :

                return 2;

            endif;

            # validate password
            if ( $this->gpValidatePassword( $_POST['Password'][0] ) == false ) :

                return 3;

            endif;

            # check existing password
            if ( $this->gpConfirmPasswords( $_POST['Password'][0], $_POST['Password'][1] ) == false ) :

                return 4;

            endif;

            # set data package
            $setUpdatePackage           =                   'AccountPassword    =       ":Password"';

            # update
            $setData                    =                   $this->GPLogicData->update( 'ESBManageAccounts', 
                                                                                        $setUpdatePackage, 
                                                                                        'WHERE AccountGUID = ":AccountGUID"', 
                                                                                        [ "Password"        =>      md5( $_POST['Password'][0] ), 
                                                                                          "AccountGUID"     =>      $AccountGUID ] ); 

            return 1;                                                                                          
            
        }

        /**
         * @name    ProcessUpdateAccount
         * @desc    ProcessUpdateAccount updates the account details of a specific account
         * @param   STRING $AccountGUID 
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  INT $this->process result value
         */
        public function ProcessUpdateAccount( string $AccountGUID ) {

            # ensure required fields are present
            if ( empty( $_POST['FirstName'] ) OR
                 empty( $_POST['LastName'] ) OR
                 empty( $_POST['EmailAddress'] ) ) :

                return 2;

            endif;

            # validate password
            if ( $this->gpValidateEmail( $_POST['EmailAddress'] ) == false ) :

                return 3;

            endif;

            # check existing password
            if ( $this->gpConfirmEmails( $_POST['EmailAddress'], $_POST['EmailAddressOld'] ) == false ) :

                if ( $this->_checkExistingEmail( $_POST['EmailAddress'] ) == false ) :

                    return 4;

                endif;

            endif;

            # set data package
            $setUpdatePackage           =                   'AccountFirst    =       ":FirstName",
                                                             AccountLast     =       ":LastName",
                                                             AccountEmail    =       ":EmailAddress",
                                                             AccountStatus   =       "'. $_POST['Status'] .'"';

            # update
            $setData                    =                   $this->GPLogicData->update( 'ESBManageAccounts', 
                                                                                        $setUpdatePackage, 
                                                                                        'WHERE AccountGUID = ":AccountGUID"', 
                                                                                        [ "FirstName"           =>      strtoupper( $_POST['FirstName'] ), 
                                                                                          "LastName"            =>      strtoupper( $_POST['LastName'] ), 
                                                                                          "EmailAddress"        =>      strtolower( $_POST['EmailAddress'] ), 
                                                                                          "AccountGUID"         =>      $AccountGUID ] ); 

            return 1;                                                                                          
            
        }

        public function ProcessDwldOperatorCreds( $OperatorToken ) {

            $GetOperator                =                   $this->GetOperator( $OperatorToken ); 

            
            $SetFilePath                =                   gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['DOWNLOADS'] .'_operator_credentials_.csv';
            $FileHandle                 =                   fopen( $SetFilePath, 'w+' );
                                                            fwrite( $FileHandle, "APILogin,APIPswd,OperatorToken" . "\r" );
                                                            fwrite( $FileHandle, $GetOperator['data'][0]['APIUserID'] .",". $GetOperator['data'][0]['APIUserPswd'] .",". $OperatorToken );
                                                            fclose( $FileHandle );

            # force download
            header( 'Content-Type: text/csv' );
            header( 'Content-Transfer-Encoding: Binary' );
            header( 'Content-disposition: attachment; filename=_operator_credentials_.csv' );
            readfile( gpConfig['URLPATH'] . gpConfig['DATA'] . gpConfig['DOWNLOADS'] .'_operator_credentials_.csv' );

        }


        public function GetRecentLogs( $ReturnAmount, $Operator, $API, $StartDate, $StopDate ) {

            $SQLAppend                  =                   NULL;

            if ( $Operator != '*' ) :

                $SQLAppend              .=                  ' AND APIUserID         =   "'. $Operator .'" ';

            endif;

            if ( $API != '*' ) :

                $SQLAppend              .=                  ' AND AccessResource    =   "'. $API .'" ';

            endif;

            if ( $ReturnAmount == '0' ) :

                $SQLLimit               =                  ' ORDER BY AccessTimeStamp DESC LIMIT 30 ';
            
            else:

                $SQLLimit               =                  ' ORDER BY AccessTimeStamp DESC LIMIT ' . abs( $ReturnAmount );

            endif;

            if ( !is_numeric( $ReturnAmount ) ) :

                $SQLLimit               =                  ' ORDER BY AccessTimeStamp DESC LIMIT 30 ';

            else:

                $SQLLimit               =                  ' ORDER BY AccessTimeStamp DESC LIMIT ' . abs( $ReturnAmount );    

            endif;

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBAPICentralLog.*,
                                                                                                    ( SELECT ESBAPIAccess.APIAccessName

                                                                                                      FROM   ESBAPIAccess
                                                                                                      WHERE  ESBAPIAccess.RowID = ESBAPICentralLog.APIUserID ) as OperatorName 
                                                                                                    
                                                                                      FROM          ESBAPICentralLog
                                                                                      
                                                                                      WHERE         ESBAPICentralLog.AccessTimeStamp BETWEEN "'. $StartDate .' 00:00:00" 
                                                                                                                                         AND "'. $StopDate .' 23:59:59"' . $SQLAppend . $SQLLimit );

            return $getData;                                                                                      

        }

        public function GetRecentErrorLogs( $ReturnAmount, $Operator, $API, $StartDate, $StopDate ) {

            $SQLAppend                  =                   NULL;

            if ( $Operator != '*' ) :

                $SQLAppend              .=                  ' AND APIUserID         =   "'. $Operator .'" ';

            endif;

            if ( $API != '*' ) :

                $SQLAppend              .=                  ' AND AccessResource    =   "'. $API .'" ';

            endif;

            if ( $ReturnAmount == '0' ) :

                $SQLLimit               =                  ' ORDER BY AccessTimeStamp DESC LIMIT 30 ';
            
            else:

                $SQLLimit               =                  ' ORDER BY AccessTimeStamp DESC LIMIT ' . abs( $ReturnAmount );

            endif;

            if ( !is_numeric( $ReturnAmount ) ) :

                $SQLLimit               =                  ' ORDER BY AccessTimeStamp DESC LIMIT 30 ';

            else:

                $SQLLimit               =                  ' ORDER BY AccessTimeStamp DESC LIMIT ' . abs( $ReturnAmount );    

            endif;

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBAPICentralErrorLogArchive.*,
                                                                                                    ( SELECT ESBAPIAccess.APIAccessName

                                                                                                      FROM   ESBAPIAccess
                                                                                                      WHERE  ESBAPIAccess.RowID = ESBAPICentralErrorLogArchive.APIUserID ) as OperatorName 
                                                                                                    
                                                                                      FROM          ESBAPICentralErrorLogArchive
                                                                                      
                                                                                      WHERE         ESBAPICentralErrorLogArchive.AccessTimeStamp BETWEEN "'. $StartDate .' 00:00:00" 
                                                                                                                                                     AND "'. $StopDate .' 23:59:59"' . $SQLAppend . $SQLLimit );

            return $getData;                                                                                      

        }

        public function GetUniversalSettings() {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBAPISettings.*,
                                                                                                    IF ( ESBAPISettings.TFA = "A", "Active", "Inactive" ) AS TFADisplay
                                                                                                    
                                                                                      FROM          ESBAPISettings' );

            return $getData;             

        }

        public function ProcessSettingUpdateTTL() {

            # update
            $setData                    =                   $this->GPLogicData->update( 'ESBAPISettings', 
                                                                                        'TTL = "'. $_POST['TTL'] .'"',
                                                                                        'WHERE RecordID = "1000001" '); 

        }

        public function ProcessSettingUpdateTFA() {

            # update
            $setData                    =                   $this->GPLogicData->update( 'ESBAPISettings', 
                                                                                        'TFA = "'. ( isset( $_POST['TFA'] ) ? "A" : "I" ) .'"',
                                                                                        'WHERE RecordID = "1000001" '); 

                                                                                        
        }

        public function GetErrorCodes() {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBAPIErrorCodes.*
                                                                                                    
                                                                                      FROM          ESBAPIErrorCodes
                                                                                      ORDER BY      ESBAPIErrorCodes.ErrorCode ASC
                                                                                       ');

            return $getData;

        }

        public function GetNextErrorCode() {

            $getData                    =                   $this->GPLogicData->max( 'ESBAPIErrorCodes',
                                                                                     'ErrorCode',                                                                                                    
                                                                                     NULL );

            return $getData['aggregate'] + 1;

        }

        public function ProcessDefineError( ) {

             # set data package
             $setInsertPackage                     =                 [ 'fields'      =>         'ErrorCode,
                                                                                                 ErrorAPI,
                                                                                                 ErrorMessage',

                                                                       'values'      =>      [  $_POST['ErrorCode'],
                                                                                                strtolower( $_POST['ErrorAPI'] ),
                                                                                                strtoupper( str_replace( " ", "_", $_POST['ErrorMessage'] ) ) ] ];

            # insert
            $setData                               =                 $this->GPLogicData->insert( 'ESBAPIErrorCodes', $setInsertPackage ); 

        }


        /**
         * @name    GetAPIErrors
         * @desc    GetAPIErrors will display all errors related to the specific API 
         * @param   STRING $APIName 
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  INT $this->process result value
         */
        public function GetAPIErrors( $APIName ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT        ESBAPIErrorCodes.*
                                                                                                    
                                                                                      FROM          ESBAPIErrorCodes
                                                                                      WHERE         LOWER( ESBAPIErrorCodes.ErrorAPI )  =   ":APIName"',
                                                                                      [ 'APIName'   =>  strtolower( $APIName ) ]  
                                                                                    );

            return $getData;     

        }

        /**
         * @name    ProcessUpdateError
         * @desc    ProcessUpdateError will update the specific error code based on the record id
         * @param   STRING $RecordID 
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  BOOLEAN
         */
        public function ProcessUpdateError( $RecordID ) {

            $getData                    =                   $this->GPLogicData->update( 'ESBAPIErrorCodes',
                                                                                        'ESBAPIErrorCodes.ErrorMessage      =   ":ErrorMessage"',
                                                                                        'WHERE ESBAPIErrorCodes.RecordID    =   ":RecordID"',
                                                                                      [ 'ErrorMessage'  =>  strtoupper( strtoupper( str_replace( " ", "_", $_POST['ErrorMessage'] ) ) ),
                                                                                        'RecordID'      =>  $RecordID ]  
                                                                                    );

            return $getData;     

        }

        /**
         * @name    ProcessDeleteError
         * @desc    ProcessDeleteError will update the specific error code based on the record id
         * @param   STRING $RecordID 
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  BOOLEAN
         */
        public function ProcessDeleteError( $RecordID ) {

            $getData                    =                   $this->GPLogicData->delete( 'ESBAPIErrorCodes',
                                                                                        'WHERE ESBAPIErrorCodes.RecordID    =   ":RecordID"',
                                                                                        [ 'RecordID'      =>  $RecordID ] );

            return $getData;     

        }

        /**
         * @name    GetAPIDailyUsageCount
         * @desc    GetAPIDailyUsageCount will update the specific error code based on the record id
         * @param   INT $API
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  BOOLEAN
         */
        public function GetAPIDailyUsageCount( string $APIName, int $APIID, $Date ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT    COUNT( ESBAPICentralLogArchive.APIUserID ) AS UsageCount

                                                                                      FROM      ESBAPICentralLogArchive
                                                                                      WHERE     ESBAPICentralLogArchive.AccessResource   =   "'. $APIName .'"
                                                                                      AND       ESBAPICentralLogArchive.APIUserID        =   "'. $APIID .'"
                                                                                      AND       ESBAPICentralLogArchive.AccessTimeStamp BETWEEN "'. $Date .' 00:00:00" 
                                                                                                                                            AND "'. $Date .' 23:59:59"');
                                                                                                                           
            return $getData;     

        }

        /**
         * @name    GetAPIDistinctUsage
         * @desc    GetAPIDistinctUsage will update the specific error code based on the record id
         * @param   INT $API
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  BOOLEAN
         */
        public function GetAPIDistinctUsage( string $API ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT    DISTINCT( ESBAPICentralLogArchive.APIUserID ) AS APIUser,
                                                                                                LOWER( ESBAPIAccess.APIAccessName ) AS APIAccesName

                                                                                      FROM      ESBAPICentralLogArchive
                                                                                      LEFT JOIN ESBAPIAccess
                                                                                      ON        ESBAPIAccess.RowID = ESBAPICentralLogArchive.APIUserID

                                                                                      WHERE     ESBAPICentralLogArchive.AccessResource   =   ":API"
                                                                                      AND       ESBAPICentralLogArchive.AccessTimeStamp BETWEEN "'. date( 'Y-m-d H:i:s', mktime( date('H'), date('i'), date('s'), date('m'), date('d') - 6, date('Y')) ) .'" 
                                                                                                                                            AND "'. date( 'Y-m-d H:i:s' ) .'"',
                                                                                     [ 'API'      =>  $API ] );

            return $getData;     

        }

        /**
         * @name    GetAPIUsageCount
         * @desc    GetAPIUsageCount will update the specific error code based on the record id
         * @param   INT $API
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  BOOLEAN
         */
        public function GetAPIUsageCount( string $APIName, int $APIID, $Date = false  ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT    COUNT( ESBAPICentralLogArchive.LogID ) AS UsageCount

                                                                                      FROM      ESBAPICentralLogArchive                                                                                      
                                                                                      WHERE     ESBAPICentralLogArchive.AccessResource   =   "'. $APIName .'"
                                                                                      AND       ESBAPICentralLogArchive.APIUserID        =   "'. $APIID .'"
                                                                                      AND       ESBAPICentralLogArchive.AccessTimeStamp BETWEEN "'. $Date .' 00:00:00" 
                                                                                                                                            AND "'. $Date .' 23:59:59"',
                                                                                     [ 'API'      =>  $APIName,
                                                                                       'APIID'    =>  $APIID ] );

            return $getData;     

        }

        /**
         * @name    GetAPIUsageTotal
         * @desc    GetAPIUsageTotal will update the specific error code based on the record id
         * @param   INT $API
         * @author  Vincent Rahming <vincent@genesysnow.com>
         * @return  BOOLEAN
         */
        public function GetAPIUsageTotal( string $APIName, $Date ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT    COUNT( ESBAPICentralLogArchive.LogID ) AS UsageTotal

                                                                                      FROM      ESBAPICentralLogArchive                                                                                      
                                                                                      WHERE     ESBAPICentralLogArchive.AccessResource   =   "'. $APIName .'"
                                                                                      AND       ESBAPICentralLogArchive.AccessTimeStamp BETWEEN "'. $Date .' 00:00:00" 
                                                                                                                                            AND "'. $Date .' 23:59:59"');

            return $getData;     

        }

        public function GetUsageWeek( $APIName ) {

            $getData                    =                   $this->GPLogicData->sql( 'SELECT    DISTINCT( LEFT ( ESBAPICentralLogArchive.AccessTimeStamp, 10 ) ) AS UsageDate

                                                                                      FROM      ESBAPICentralLogArchive                                                                                      
                                                                                      WHERE     ESBAPICentralLogArchive.AccessResource   =   "'. $APIName .'"                                                                                      
                                                                                      LIMIT     7');

            return $getData;     

        }

    }
<?php

    class gpDatabase extends gpRouter {
        
        # declare public properties
        public $host;
        public $user;
        public $pswd;
        public $source;
        
        public function __construct() {
            parent::__construct();
            
        }
        
        /**
         * @name    _connectOrCancel
         * @desc    Connects to MySQL Database using passed property values or fails
         */
        
        private function _connectOrCancel() {
            
            $connect    =   mysqli_connect( $this->host, $this->user, $this->pswd, $this->source );
            
            if ( !$connect ) :
                
                $this->_errorHandler( mysqli_connect_errno(), mysqli_connect_error() );
                
            else:
                
                return  $connect;
                
            endif;
            
        }
        
        /**
         * @name    _closeConnection
         * @type    PRIVATE
         * @desc    closes open thread ( $connect )
         * @param   resource $connect
         * @return  NULL
         */
        
        private function _closeConnection ( $connect ) {
            
            mysqli_close( $connect );            
            
        }
        
        /**
         * @name    _errorHandler
         * @desc    Displays error
         * @throws  Exception
         */
        
        private function _errorHandler( $setErrorNo, $setErrorMessage) {
            
            throw new Exception ( $setErrorNo .' - '. $setErrorMessage );
            
        }
        
        private function _filterInserts( $connect, $setData ) {
            
            # sanitize user input values           
            $setSeparator      =       1;
            $setSanitizeValues =       ' (';

            $count = 0;
            
            foreach( explode( ',', implode( ',', $setData['values'] ) ) as $setValue ) :
                
                $setValueOut          =        mysqli_real_escape_string( $connect, $setValue );
                
                $setSanitizeValues   .=       '"'. $setValueOut .'"';
                
                if ( $setSeparator < count( explode( ',', implode( ',', $setData['values'] ) ) ) ) :
                    
                    $setSanitizeValues   .=      ',';    
                    
                endif;
                
                ++$setSeparator;
                ++$count;
                
            endforeach;
            
            $setSanitizeValues  .=      ' ); ';
            
            return $setSanitizeValues;
            
        }
        
        /**
         * @name    _process 
         * @desc    Responsible for processing different types of SQL Statements
         * @param   RESOURCE $connect
         * @param   STRING $statement
         * @param   STRING $type
         * @return MIXED $setPackage
         */
        private function _process( $connect, $statement, $type ) {
            
            # execute code
            $setExecuteQuery    =       mysqli_query( $connect, $statement );
            
            # check for errors
            $setErrorCode       =       mysqli_errno( $connect );
            $setErrorDesc       =       mysqli_error( $connect );
            $setPackage         =       array();
            
            if ( $setErrorCode > 0 ) :
                
                # if there is an error
                # handle accordingly
                $setPackage['error']            =   $setErrorCode;
                $setPackage['message']          =   $setErrorDesc;
                
            else:
                
                # package results and return             
                $setPackage['error']            =   $setErrorCode;
                
                # based on type                
                if ( $type == 'SELECT' ) :
                    
                    $setPackage['rowcount']     =   mysqli_num_rows( $setExecuteQuery );
                    $setPackage['data']         =   $setExecuteQuery;
                    $setPackage['message']      =   $setErrorDesc;                    
                    
                elseif ( $type == 'INSERT' ) :
                    
                    $setPackage['lastID']       =   mysqli_insert_id( $connect );
                
                elseif ( ( $type == 'UPDATE' ) OR ( $type == 'DELETE' ) ):
                            
                    $setPackage['affected']     =   mysqli_affected_rows( $connect );
                
                elseif ( ( $type == 'AVERAGE' ) OR ( $type == 'COUNT' ) OR ( $type == 'MAX' ) OR ( $type == 'MIN' ) OR ( $type == 'SUM' ) ):
                
                    $setResult                  =   mysqli_fetch_assoc( $setExecuteQuery );
                    $setPackage['aggregate']    =   $setResult['aggregate'];
                    
                endif;
                
                # close connection
                $this->_closeConnection( $connect );
                
            endif;
            
            return $setPackage;
            
        }
        
        private function _setHolders( $connect, $setConditions, $setParams ) {
         
            foreach( $setParams as $id => $value ) :
            
                $value     =   mysqli_real_escape_string( $connect, htmlspecialchars( $value, ENT_NOQUOTES | ENT_HTML5 ) );
                $setConditions      =   str_replace( ":$id", $value, $setConditions );
                    
            endforeach;
            
            return $setConditions;
            
        }
        
        private function _setHolderData( $connect, $setData, $setParams ) {
            
            $setReturn      =       array();
            
            foreach( $setParams as $name => $value ) :
                
                $setReturn[ $name ]     =   mysqli_real_escape_string( $connect, $value );
                
            endforeach;
            
            foreach( $setParams as $id => $value ) :
                    
                $setData      =   str_replace( ":$id", "$value", $setData );
                    
            endforeach;
            
            return $setData;
            
        }
        
        /**
         * @name        average
         * @desc        average data from a specified column in a specified table 
         * @param       STRING $setTable name of the table where average will be performed 
         * @param       STRING $setColumn on which average will be executed
         * @param       STRING $setConditions any conditions to be applied to the update ( OPTIONAL )
         * @param       STRING $setParams any parameters that need to be prepared for entry into database ( OPTIONAL )
         * @param       STRING $setDistinct - if value needs to be distinct ( OPTIONAL )
         * @return      MIXED $setReturn
         */
        public function average ( $setTable, $setColumn, $setConditions = false, $setParams = false, $setDistinct = false ) {
            
            if ( !empty( $setDistinct ) AND ( strtoupper( $setDistinct ) == 'DISTINCT' ) ) :
                
                $setDistinct    =   ' DISTINCT ';
                
            endif; 
            
            $setPackage     =       array();
            
            # try to process
            try {
                
                $connect    =       $this->_connectOrCancel();
                $type       =       'AVERAGE';
                
            } catch (Exception $ex) {

                //$this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }
            
            if ( !empty( $setParams ) ) :
                
                $setColumn      =   $this->_setHolders( $connect, $setColumn, $setParams );
                $setConditions  =   $this->_setHolders( $connect, $setConditions, $setParams );
                
            endif;
            
            $setQuery       =       ' SELECT AVG ( '. $setDistinct . ' ' . $setColumn .' ) AS aggregate FROM '. $setTable . ' ' . $setConditions;      
            $setProcess     =       $this->_process( $connect, $setQuery, $type );      
            
            $setPackage['error']    =   $setProcess['error'];

            if ( $setPackage['error'] > 0 ) :

                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - affected rows
                $setPackage['aggregate'] =  $setProcess['aggregate'];

            endif;
            
            return $setPackage;
            
        }
        
        /**
         * @name        count
         * @desc        count data from a specified column in a specified table 
         * @param       STRING $setTable name of the table where count will be performed 
         * @param       STRING $setColumn on which average will be executed
         * @param       STRING $setConditions any conditions to be applied to the update ( OPTIONAL )
         * @param       STRING $setParams any parameters that need to be prepared for entry into database ( OPTIONAL )
         * @param       STRING $setDistinct - if value needs to be distinct ( OPTIONAL )
         * @return      MIXED $setReturn
         */
        public function count ( $setTable, $setColumn, $setConditions = false, $setParams = false, $setDistinct = false ) {
            
            if ( !empty( $setDistinct ) AND ( strtoupper( $setDistinct ) == 'DISTINCT' ) ) :
                
                $setDistinct    =   ' DISTINCT ';
                
            endif; 
            
            $setPackage     =       array();
            
            # try to process
            try {
                
                $connect    =       $this->_connectOrCancel();
                $type       =       'COUNT';
                
            } catch (Exception $ex) {

                //$this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }
            
            if ( !empty( $setParams ) ) :
                
                $setColumn      =   $this->_setHolders( $connect, $setColumn, $setParams );
                $setConditions  =   $this->_setHolders( $connect, $setConditions, $setParams );
                
            endif;
            
            $setQuery       =       ' SELECT COUNT( '. $setDistinct . ' ' . $setColumn .' ) AS aggregate FROM '. $setTable . ' ' . $setConditions;      
            
            $setProcess     =       $this->_process( $connect, $setQuery, $type );      
            
            $setPackage['error']    =   $setProcess['error'];

            if ( $setPackage['error'] > 0 ) :

                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - affected rows
                $setPackage['aggregate'] =  $setProcess['aggregate'];

            endif;
            
            return $setPackage;
            
        }
        
        /**
         * @name        delete
         * @desc        deletes data from a table 
         * @param       STRING $setTable name of the table where update will be performed 
         * @param       STRING $setData  data key value pair 
         * @param       STRING $setParams any conditions to be applied to the update ( OPTIONAL )
         * @return      MIXED $setReturn
         */
        public function delete ( $setTable, $setConditions = false, $setParams = false ) {
            
            $setPackage     =       array();
            
            try {
                
                $connect    =       $this->_connectOrCancel();
                $type       =       'DELETE';
                
            } catch (Exception $ex) {

                //$this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }
            
            if ( !empty( $setParams ) ) :
                
                $setConditions  =   $this->_setHolders( $connect, $setConditions, $setParams );
                
            endif;
            
            $setQuery       =       'DELETE FROM '. $setTable .' '. $setConditions;                        
            $setProcess     =       $this->_process( $connect, $setQuery, $type );           
                    
            $setPackage['error']    =   $setProcess['error'];

            if ( $setPackage['error'] > 0 ) :

                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - affected rows
                $setPackage['affected'] =   $setProcess['affected'];

            endif;
            
            return $setPackage;
            
        }
        
        /**
         * @name        insert
         * @desc        inserts data into a table 
         * @return      MIXED $setReturn
         */
        public function insert ( $setTable, $setData, $setIgnore = false ) {
             
            $setPackage     =       array();
            
            if ( !empty( $setIngore ) AND strtoupper( $setIgnore ) == 'IGNORE' ) :
                
                $setIgnore  =   ' IGNORE ';
                
            endif;
            
            try {
                
                $connect    =       $this->_connectOrCancel();
                $type       =       'INSERT';
                
            } catch (Exception $ex) {

                //$this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }
            
            $setQuery       =       " INSERT ". $setIgnore . " INTO " . $setTable ." ( ". $setData['fields'] ." ) VALUES ". $this->_filterInserts( $connect, $setData ) ;      
            
            
            $setProcess     =       $this->_process( $connect, $setQuery, $type );      
            
            $setPackage['error']    =   $setProcess['error'];

            if ( $setPackage['error'] > 0 ) :

                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - affected rows
                $setPackage['insertID'] =   $setProcess['lastID'];

            endif;
            
            return $setPackage;
            
        }
        
        /**
         * @name        max
         * @desc        get max value from a specified column in a specified table 
         * @param       STRING $setTable name of the table where max will be performed 
         * @param       STRING $setColumn on which max will be executed
         * @param       STRING $setConditions any conditions to be applied to the update ( OPTIONAL )
         * @param       STRING $setParams any parameters that need to be prepared for entry into database ( OPTIONAL )
         * @param       STRING $setDistinct - if value needs to be distinct ( OPTIONAL )
         * @return      MIXED $setReturn
         */
        public function max ( $setTable, $setColumn, $setConditions = false, $setParams = false, $setDistinct = false ) {
            
            if ( !empty( $setDistinct ) AND ( strtoupper( $setDistinct ) == 'DISTINCT' ) ) :
                
                $setDistinct    =   ' DISTINCT ';
                
            endif; 
            
            $setPackage     =       array();
            
            # try to process
            try {
                
                $connect    =       $this->_connectOrCancel();
                $type       =       'MAX';
                
            } catch (Exception $ex) {

                //$this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }
            
            if ( !empty( $setParams ) ) :
                
                $setColumn      =   $this->_setHolders( $connect, $setColumn, $setParams );
                $setConditions  =   $this->_setHolders( $connect, $setConditions, $setParams );
                
            endif;
            
            $setQuery       =       ' SELECT MAX( '. $setDistinct . ' ' . $setColumn .' ) AS aggregate FROM '. $setTable . ' ' . $setConditions;      
            
            $setProcess     =       $this->_process( $connect, $setQuery, $type );      
            
            $setPackage['error']    =   $setProcess['error'];

            if ( $setPackage['error'] > 0 ) :

                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - affected rows
                $setPackage['aggregate'] =  $setProcess['aggregate'];

            endif;
            
            return $setPackage;
            
        }
        
        /**
         * @name        min
         * @desc        get min value from a specified column in a specified table 
         * @param       STRING $setTable name of the table where min will be performed 
         * @param       STRING $setColumn on which min will be executed
         * @param       STRING $setConditions any conditions to be applied to the update ( OPTIONAL )
         * @param       STRING $setParams any parameters that need to be prepared for entry into database ( OPTIONAL )
         * @param       STRING $setDistinct - if value needs to be distinct ( OPTIONAL )
         * @return      MIXED $setReturn
         */
        public function min ( $setTable, $setColumn, $setConditions = false, $setParams = false, $setDistinct = false ) {
            
            if ( !empty( $setDistinct ) AND ( strtoupper( $setDistinct ) == 'DISTINCT' ) ) :
                
                $setDistinct    =   ' DISTINCT ';
                
            endif; 
            
            $setPackage     =       array();
            
            # try to process
            try {
                
                $connect    =       $this->_connectOrCancel();
                $type       =       'MIN';
                
            } catch (Exception $ex) {

                //$this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }
            
            if ( !empty( $setParams ) ) :
                
                $setColumn      =   $this->_setHolders( $connect, $setColumn, $setParams );
                $setConditions  =   $this->_setHolders( $connect, $setConditions, $setParams );
                
            endif;
            
            $setQuery       =       ' SELECT MIN( '. $setDistinct . ' ' . $setColumn .' ) AS aggregate FROM '. $setTable . ' ' . $setConditions;      
            
            $setProcess     =       $this->_process( $connect, $setQuery, $type );      
            
            $setPackage['error']    =   $setProcess['error'];

            if ( $setPackage['error'] > 0 ) :

                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - affected rows
                $setPackage['aggregate'] =  $setProcess['aggregate'];

            endif;
            
            return $setPackage;
            
        }
        
        /**
         * @name        sql
         * @desc        free form query
         * @return      MIXED $setReturn
         */
        public function sql ( $setQuery, $setParams = false ) {
            
            try {
                
                $connect    =   $this->_connectOrCancel();
                $type       =   'SELECT';
                
            } catch ( Exception $ex) {

                $this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }
            
            if ( !empty( $setParams ) ) :
                
                $setQuery       =   $this->_setHolders( $connect, $setQuery, $setParams );                
            
            endif;
            
//            echo $setQuery;
            
            $setProcess     =       $this->_process( $connect, $setQuery, $type );
            $setPackage     =       array();
            $setAssocData   =       array(); 
                    
            $setPackage['error']    =   $setProcess['error'];
            
            if ( $setPackage['error'] > 0 ) :
                
                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - count
                # - data
                
                $setPackage['count']    =   $setProcess['rowcount'];
            
                # process data for formatting
                while ( $getData = mysqli_fetch_assoc( $setProcess['data'] ) ) :
                    
                    array_push( $setAssocData, $getData );
                    
                endwhile;
                
                $setPackage['data']     =   $setAssocData;
                
            endif;
            
            return $setPackage;
            
        }
        
        /**
         * @name        sum
         * @desc        get sum value from a specified column in a specified table 
         * @param       STRING $setTable name of the table where sum will be performed 
         * @param       STRING $setColumn on which sum will be executed
         * @param       STRING $setConditions any conditions to be applied to the update ( OPTIONAL )
         * @param       STRING $setParams any parameters that need to be prepared for entry into database ( OPTIONAL )
         * @param       STRING $setDistinct - if value needs to be distinct ( OPTIONAL )
         * @return      MIXED $setReturn
         */
        public function sum ( $setTable, $setColumn, $setConditions = false, $setParams = false, $setDistinct = false ) {
            
            if ( !empty( $setDistinct ) AND ( strtoupper( $setDistinct ) == 'DISTINCT' ) ) :
                
                $setDistinct    =   ' DISTINCT ';
                
            endif; 
            
            $setPackage     =       array();
            
            # try to process
            try {
                
                $connect    =       $this->_connectOrCancel();
                $type       =       'SUM';
                
            } catch (Exception $ex) {

                //$this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }
            
            if ( !empty( $setParams ) ) :
                
                $setColumn      =   $this->_setHolders( $connect, $setColumn, $setParams );
                $setConditions  =   $this->_setHolders( $connect, $setConditions, $setParams );
                
            endif;
            
            $setQuery       =       ' SELECT SUM( '. $setDistinct . ' ' . $setColumn .' ) AS aggregate FROM '. $setTable . ' ' . $setConditions;                  
            $setProcess     =       $this->_process( $connect, $setQuery, $type );      
            
            $setPackage['error']    =   $setProcess['error'];

            if ( $setPackage['error'] > 0 ) :

                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - affected rows
                $setPackage['aggregate'] =  $setProcess['aggregate'];

            endif;
            
            return $setPackage;
            
        }
        
        /**
         * @name        update         
         * @desc        updates data in a table 
         * @param       STRING $setTable name of the table where update will be performed 
         * @param       STRING $setData  data key value pair 
         * @param       STRING $setParams any conditions to be applied to the update ( OPTIONAL )
         * @return      MIXED $setReturn
         */
        public function update ( $setTable, $setData, $setConditions = false, $setParams = false ) {
        
            $setPackage     =       array();
            
            try {
                
                $connect    =   $this->_connectOrCancel();
                $type       =   'UPDATE';
                
            } catch (Exception $ex) {

                $this->_errorHandler( $ex->getCode(), $ex->getMessage() );
                
            }            
            
            if ( !empty( $setParams ) ) :
                
                $setData    =       $this->_setHolders( $connect, $setData, $setParams );
                $setConditions  =   $this->_setHolders( $connect, $setConditions, $setParams );
                
            endif;
            
            $setQuery       =       ' UPDATE '. $setTable .  ' SET ' . $setData .' '. $setConditions;                  
            
            $setProcess     =       $this->_process( $connect, $setQuery, $type );      
            
            $setPackage['error']    =   $setProcess['error'];

            if ( $setPackage['error'] > 0 ) :

                # if there is an error in the query, then only display the message and nothing else
                $setPackage['message']  =   $setProcess['message'];
             
            else:
            
                # if there is no error, display the remaining data for the sql method
                # - affected rows
                $setPackage['affected'] =   $setProcess['affected'];

            endif;
            
            return $setPackage;
            
        }
        
    }
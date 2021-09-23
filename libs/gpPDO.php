<?php

    class gpPDO extends gpRouter {

        # declare properties
        private $_platform;
        private $_host;
        private $_user;
        private $_pswd;
        private $_source;
        private $_pdo;
        private $_charset;
        private const USE_SQL_DEBUG = true;

        public function __construct( array $params ) {
            parent::__construct();

            $this->_platform = $params['gpPLATFORM'] ?: 'mysql';
            $this->_host     = $params['gpHOST'] ?: '';
            $this->_source   = $params['gpSOURCE'] ?: '';
            $this->_user     = $params['gpUSER'] ?: '';
            $this->_pswd     = $params['gpPSWD'] ?: '';
            $this->_charset  = $params['gpCHARSET'] ?: 'utf8mb4';
            $this->_debug    = $params['gpDEBUG'] ?: true;

        }

        /**
         *
         * @name        _pdoconnect()
         *
         * @desc        Connects to MySQL Database using passed property values or fails
         *
         * @author      Vincent J. Rahming <vincent@genesysnow.com>
         *
         */
        private function _pdoconnect() {

          if ( !$this->_pdo ) :

              // connect using PDO
              $this->_pdo       =       new PDO( "{$this->_platform}:host={$this->_host};dbname={$this->_source};charset={$this->_charset}",
                                                   $this->_user, $this->_pswd );

          endif;

        }

        /**
         *
         * @name        sql
         *
         * @desc        executes all queries
         *
         * @author      Vincent J. Rahming <vincent@genesysnow.com>
         *
         * @param       string $sql Collects the query to be executed
         *
         * @param       array $params optional data to bind in PDO query
         *
         * @return      array [ error, count, data ]
         *
         */
        public function sql( $sql, array $params ) {

            try {

                // connect to the database using PDO
                $this->_pdoconnect();

            } catch ( Exception $ex ){

                return [ 'error'    =>  $ex->getCode(),
                         'message'  =>  $ex->getMessage() ];

            }

            // set query
            $query      =     implode( ' ', (array) $sql );

            // action verb
            $action     =     strtok( trim( $query ), ' ' );

            // prepare & bind params
            $statement  =     $this->_pdo->prepare( $query );

            if ( !empty( $params ) ) :

                foreach ( $params as $name => $value ) :

                  if (is_numeric( $value ) ) :

                    $type = PDO::PARAM_INT;

                  elseif ( is_bool( $value ) ) :

                    $type = PDO::PARAM_BOOL;

                  elseif ( is_null( $value ) ) :

                    $type = PDO::PARAM_NULL;

                  else :

                    $type = PDO::PARAM_STR;

                  endif;

                  $statement->bindParam( $name, $value, $type);
                  unset( $name, $value, $type );

                endforeach;

            endif;

            try {

                $statement->execute();
                $setErrorCode           =         ( $statement->errorCode() == 00000 ) ? 0 : $statement->errorCode();

                if ( $action == 'INSERT' ) :

                    $response     =    [ 'error'     =>  $setErrorCode,
                                         'insertID'  =>  $this->_pdo->lastInsertId() ];

                elseif ( ( $action == 'UPDATE' ) OR
                         ( $action == 'DELETE' ) ) :

                    $response     =    [ 'error'     =>  $setErrorCode,
                                         'affected'  =>  $statement->rowCount() ];

                elseif ( $action == 'SELECT' ) :

                    $response     =     [ 'error'    =>   $setErrorCode,
                                          'aggregate' =>  $statement->fetchAll( PDO::FETCH_ASSOC )[0]['aggregate'] ];

                endif;

                $statement->closeCursor();

            } catch( Exception $pdoex ) {

                if ( $this->_debug == TRUE ) :

                  $console              =     [ 'error'     =>   $pdoex->errorInfo[1],
                                                'message'   =>   $pdoex->getMessage(),
                                                'action'    =>   $action,
                                                'file'      =>   $pdoex->getTrace()[2]['file'],
                                                'line'      =>   $pdoex->getTrace()[2]['line'],
                                                'query'     =>   str_replace( "\n", "", 
                                                                 str_replace( "\t", "", 
                                                                 str_replace( "\s", "", 
                                                                 $pdoex->getTrace()[2]['args'][0] ) ) ),
                                                'args'      =>   $pdoex->getTrace()[2]['args'][1]
                                              ];

                  echo '<script>console.log('. json_encode( $console, JSON_HEX_TAG|JSON_PRETTY_PRINT|JSON_FORCE_OBJECT ) .');</script>';

                endif;

                $response  =   [ 'error'   =>    $pdoex->errorInfo[1],
                                 'message' =>    $pdoex->errorInfo[2] ];

            }

            unset( $this->_pdo );
            return $response;

        }

        /**
         *
         * @name        raw
         *
         * @desc        used to perform any type of MySQL query
         *
         * @author      Vincent J. Rahming <vincent@genesysnow.com>
         *
         * @param       string $sql Collects the query to be executed
         *
         * @param       array $params optional data to bind in PDO query
         *
         * @return      [ error, count, data ]
         *
         */
        public function raw( $sql, $params = false ) {

          // establish database connection
          try {

                $this->_pdoconnect();

          } catch( Exception $ex ) {

                // returns error if no connection is made
                return [ 'error'    =>  $ex->getCode(),
                         'message'  =>  $ex->getMessage() ];

          }

          // set query
          $query      =     implode( ' ', (array) $sql );

          // action verb
          $action     =     strtok( trim( $query ), ' ' );

          // prepare & bind params
          $statement  =     $this->_pdo->prepare( $sql );

          if ( !empty( $params ) ) :

              foreach ( $params as $name => $value ) :

                if (is_numeric( $value ) ) :

                  $type = PDO::PARAM_INT;

                elseif ( is_bool( $value ) ) :

                  $type = PDO::PARAM_BOOL;

                elseif ( is_null( $value ) ) :

                  $type = PDO::PARAM_NULL;

                else :

                  $type = PDO::PARAM_STR;

                endif;

                $statement->bindParam( $name, $value, $type);
                unset( $name, $value, $type );

              endforeach;

          endif;

          try {

              $statement->execute();

              // echo '<script>console.log('. json_encode( $statement->debugDumpParams(), JSON_HEX_TAG|JSON_PRETTY_PRINT|JSON_FORCE_OBJECT ) .');</script>';

              $response  =   [ 'error'  =>  ( $statement->errorCode() == 00000 ) ? 0 : $statement->errorCode(),
                               'count'  =>    $statement->rowCount(),
                               'data'   =>    $statement->fetchAll( PDO::FETCH_ASSOC ) ];

          } catch( PDOException $pdoex ) {

              if ( $this->_debug == TRUE ) :

                $console              =     [ 'error'     =>   $pdoex->errorInfo[1],
                                              'message'   =>   $pdoex->getMessage(),
                                              'action'    =>   $action,
                                              'file'      =>   $pdoex->getTrace()[2]['file'],
                                              'line'      =>   $pdoex->getTrace()[2]['line'],
                                              'query'     =>   str_replace( "\n", "", 
                                                               str_replace( "\t", "", 
                                                               str_replace( "\s", "", 
                                                               $pdoex->getTrace()[2]['args'][0] ) ) ),
                                              'args'      =>   $pdoex->getTrace()[2]['args'][1]
                                            ];

                echo '<script>console.log('. json_encode( $console, JSON_HEX_TAG|JSON_PRETTY_PRINT|JSON_FORCE_OBJECT ) .');</script>';

              endif;

              $response  =   [ 'error'   =>    $pdoex->errorInfo[1],
                               'message' =>    $pdoex->getMessage() ];

          }

          $statement->closeCursor();
          return $response;

        }

        /**
         *
         * @name        select
         *
         * @desc        used to perform any type of MySQL query
         *
         * @author      Vincent J. Rahming <vincent@genesysnow.com>
         *
         * @param       string $sql Collects the query to be executed
         *
         * @param       array $params optional data to bind in PDO query
         *
         * @return      [ error, count, data ]
         *
         */
        public function select( string $query, $data = false ) {

            if ( !empty( $data ) ) :

              return $this->raw( $query, $data );

            else:

              return $this->raw( $query );

            endif;

        }

        /**
         *
         *  @name     insert
         *
         *  @desc     inserts data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the insert will be performed
         *
         *  @param    array $set The associative arry of insert ( name => value ) pairs
         *
         *  @param    string $conditions Any condition to be applied to the update
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, affected ]
         *
         */
        public function insert( string $table, array $data, $ignoreFlag = false ) {

            // get the field names
            $getFields          =         array_keys( $data );

            // build query package
            $package            =         [ 'INSERT ',
                                            ( !empty( $ignoreFlag ) ? ' IGNORE ' : NULL  ),
                                            ' INTO '. $table,
                                            ' ('. implode( ',', $getFields ) .' ) ',
                                            ' VALUES( :'. implode( ',:', $getFields ) .') ' ];

            return $this->sql( $package, $data );

        }

        /**
         *
         *  @name     update
         *
         *  @desc     updates data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the update will be performed
         *
         *  @param    array $set The associative arry of updates ( name => value ) pairs
         *
         *  @param    string $conditions Any condition to be applied to the update
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, affected ]
         *
         */
        public function update( string $table, array $set, string $conditions, array $data ) {

          // build query package
          $package            =         [ 'UPDATE '. $table, ' SET ', implode( ',', $set ), $conditions ];
          return $this->sql( $package, $data );

        }

        /**
         *
         *  @name     delete
         *
         *  @desc     delete data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the delete will be performed
         *
         *  @param    string $conditions Any condition to be applied to the delete
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, affected ]
         *
         */
        public function delete( string $table, string $conditions, array $data ) {

          // build query package
          $package              =         [ 'DELETE FROM '. $table, $conditions, ];
          return $this->sql( $package, $data );

        }

        /**
         *
         *  @name     _processAggregates()
         *
         *  @desc     delete data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the delete will be performed
         *
         *  @param    string $conditions Any condition to be applied to the delete
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, affected ]
         *
         */
        private function _processAggregates( string $table, string $column, string $operation, string $conditions, array $data ) {

            // build query package
            $sql = [ 'SELECT ', $operation .'( '. $column .' ) AS aggregate ', 'FROM '. $table, $conditions ];
            return $this->sql( $sql, $data );

        }

        /**
         *
         *  @name     max
         *
         *  @desc     get the maximum value for a given field from the data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the operation will be performed
         *
         *  @param    string $column The name of the column on which the action is performed
         *
         *  @param    string $conditions Any condition to be applied to the operation
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, aggregate ]
         *
         */
        public function max( string $table, string $column, string $conditions, array $data ) {

            // build query package
            return $this->_processAggregates( $table, $column, 'MAX', $conditions, $data );

        }

        /**
         *
         *  @name     min
         *
         *  @desc     get the minimum value for a given field from the data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the operation will be performed
         *
         *  @param    string $column The name of the column on which the action is performed
         *
         *  @param    string $conditions Any condition to be applied to the operation
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, aggregate ]
         *
         */
        public function min( string $table, string $column, string $conditions, array $data ) {

            // build query package
            return $this->_processAggregates( $table, $column, 'MIN', $conditions, $data );

        }

        /**
         *
         *  @name     sum
         *
         *  @desc     get the sum value for a given field from the data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the operation will be performed
         *
         *  @param    string $column The name of the column on which the action is performed
         *
         *  @param    string $conditions Any condition to be applied to the operation
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, aggregate ]
         *
         */
        public function sum( string $table, string $column, string $conditions, array $data ) {

            // build query package
            return $this->_processAggregates( $table, $column, 'SUM', $conditions, $data );

        }

        /**
         *
         *  @name     count
         *
         *  @desc     get the count value for a given field from the data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the operation will be performed
         *
         *  @param    string $column The name of the column on which the action is performed
         *
         *  @param    string $conditions Any condition to be applied to the operation
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, aggregate ]
         *
         */
        public function count( string $table, string $column, string $conditions, array $data ) {

            // build query package
            return $this->_processAggregates( $table, $column, 'COUNT', $conditions, $data );

        }

        /**
         *
         *  @name     avg
         *
         *  @desc     get the count value for a given field from the data in a table
         *
         *  @author   Vincent J. Rahming <vincent@genesysnow.com>
         *
         *  @param    string $table The name of the table where the operation will be performed
         *
         *  @param    string $column The name of the column on which the action is performed
         *
         *  @param    string $conditions Any condition to be applied to the operation
         *
         *  @param    array $data The associative array of data to bind in PDO
         *
         *  @return   array [ error, aggregate ]
         *
         */
        public function avg( string $table, string $column, string $conditions, array $data ) {

            // build query package
            return $this->_processAggregates( $table, $column, 'AVG', $conditions, $data );

        }

    }

?>
<?php

    /** ***********************************************************
     * @name    Genesys Project Framework
     * @author  Vincent J. Rahming
     * @desc    Genesys Project Framework designed using MVC architecture
     * @created February 8th, 2018    
     * @file    gpConfig.php     
     **/

    class gpConfig {
         
        public function __construct() {

            # System Error Reporting Controls
            error_reporting( E_ALL & ~E_WARNING|E_NOTICE );
            ini_set( 'display_errors', 0 );
            
            # define system and file paths
            # all defined paths are named in UPPERCASE and has an underscore prefix (_)
            
            # *********************************************** #
            # GENESYS PROJECT GENERAL CONFIGURATION SETTINGS  #
            # *********************************************** #
            define( 'gpConfig',   [ 'ASSETS'      =>      'assets/',
                                    'BASEPATH'    =>      realpath('') .'/',
                                    'DATA'        =>      'data/',
                                    'DOWNLOADS'   =>      'downloads/',
                                    'IMAGES'      =>      'img/',
                                    'LIBS'        =>      'libs/',
                                    'LOGIC'       =>      'logic/',
                                    'LOGS'        =>      'logs/',
                                    'ROUTER'      =>      'router/',
                                    'RENDER'      =>      'render/',
                                    'TIMEOUT'     =>      15,
                                    'UPLOADS'     =>      'uploads/',                                    
                                    'URLPATH'     =>      'http://localhost/projects/aliv/ecommerce-backend/'
                                   ] );

           # *********************************************** #
            # GENESYS PROJECT DATABASE CONFIGURATION SETTINGS #
            # *********************************************** #
            define( 'gpDataCfg',  [ 'HOST'        =>      '',                                    
                                    'USER'        =>      '',
                                    'PWSD'        =>      '',
                                    'SOURCE'      =>      '' ] );

            # *********************************************** #
            # GENESYS PROJECT DATABASE CONFIGURATION SETTINGS #
            # *********************************************** #
            define( 'gpDataCfg2', [ 'gpHOST'        =>      '',                                    
                                    'gpUSER'        =>      '',
                                    'gpPSWD'        =>      '',
                                    'gpSOURCE'      =>      '',
                                    'gpPLATFORM'    =>      'mysql',
                                    'gpCHARSET'     =>      'utf8mb4',
                                    'gpDEBUG'       =>      true ] );
            
            # *********************************************** #
            # GENESYS PROJECT SECURITY CONFIGURATION SETTINGS #
            # *********************************************** #
            define( 'gpSecCfg',   [ 'ENC_METHOD'  =>      'AES_256_CBC',
                                    'SECRET_KEY'  =>      'ACESNEIGHTS',
                                    'SECRET_IV'   =>      'TAILFEATHER'] );
            
            # *********************************************** #
            # GENESYS PROJECT PAGE CONFIGURATION SETTINGS     #
            # *********************************************** #
            define( 'gpPageCfg',  [ 'FOOTER'      =>      '',
                                    'NAME'        =>      '',
                                    'KEYWORDS'    =>      '',
                                    'DESCRIPTION' =>      '',
                                    'AUTHOR'      =>      '',
                                    'TITLE'       =>      'Next MVP' ] ); 
            
            # *********************************************** #
            # GENESYS PROJECT VERSION CONTROL                 #
            # *********************************************** #
            define( 'gpVersCfg',  [ 'VERSION'     =>      '2.0',
                                    'DATE'        =>      '',
                                    'TITLE'       =>      'ALIV - eCommerce Back Office' ] ); 
            
            # *********************************************** #
            # GENESYS PROJECT MAIL CONFIGURATION SETTINGS     #
            # *********************************************** #
            define( 'gpMailCfg',  [ 'HOST'        =>      'mail.genesysnow.com',
                                    'USER'        =>      'noreply@genesysnow.com',
                                    'PSWD'        =>      'P@ssw0rd4685',
                                    'PORT'        =>       26 ] );
            
            # *********************************************** #
            # GENESYS PROJECT DEFAULTS CONFIGURATION SETTINGS #
            # *********************************************** #
            define( 'gpDefsCfg',  [ 'HEADER'       =>      'Header.php',
                                    'FOOTER'       =>      'Footer.php',                                    
                                    'ERROR'        =>      'Errors.php',
                                    'INDEX'        =>      'Index.php',
                                    'HOME'         =>      'Index.php' ] );
            
            # define path to other classes within the project scope
            set_include_path( get_include_path() . PATH_SEPARATOR . gpConfig['BASEPATH'] . gpConfig['LIBS'] );
            set_include_path( get_include_path() . PATH_SEPARATOR . gpConfig['BASEPATH'] . gpConfig['ROUTER'] );
            set_include_path( get_include_path() . PATH_SEPARATOR . gpConfig['BASEPATH'] . gpConfig['LOGIC'] );

            date_default_timezone_set('America/Nassau');
            
        }
         
     }

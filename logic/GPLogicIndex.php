<?php

    class GPLogicIndex extends gpLogic {
        
        public function __construct() {
            parent::__construct();            
        }
        
        public function routeToIndex() {

            if ( !isset( $_SESSION['SessionIsStarted'] ) )  :

                header( 'Location: '. gpConfig['URLPATH'] .'auth/logout'  );                

            elseif ( $_SESSION['sessAcctRole'] == 'A' ) : 

                # route to senior csr dashboard
                header( 'Location: '. gpConfig['URLPATH'] .'administrator'  );                

            elseif ( $_SESSION['sessAcctRole'] == 'O' ) : 

                # route to senior csr dashboard
                header( 'Location: '. gpConfig['URLPATH'] .'agent'  );                

            else:

                # only a CSR or Senior CSR can access the portal
                header( 'Location: '. gpConfig['URLPATH'] .'auth/logout'  );                

            endif;

        }
        
    }
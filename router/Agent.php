<?php

    class Agent extends gpRouter {
        
        public function __construct() {
            parent::__construct();

            
            define( '_ACCESS_', 'agent/' );
            define( '_FOLDER_', 'Agent/' );

            $this->render->LogicAgent        =   new GPLogicAgent();                    # include LogicAdministrator Library
            $this->render->LogicGlobal       =   new GPLogicGlobal();                           # include LogicGlobal Library           
            $this->render->setParams         =   [ 'header'  =>  _FOLDER_ . 'Header',
                                                   'footer'  =>  _FOLDER_ . 'Footer' ];         # include specific header and footer for Auth/ pages
        
            
        }
    
        public function getindex() {
            
            # if session is not active and started, force the login prompt
            $this->render->page( _FOLDER_ . 'Dashboard', $this->render->setParams  );
            
        }

        public function pending() {
            
            if ( isset( $_POST['btnAccept'] ) ) :

                $this->process                  =                   $this->render->LogicAgent->ProcessAcceptOrder();

            endif;

            $this->render->GetPending           =                   $this->render->LogicAgent->GetPendingOrders();
            $this->render->page( _FOLDER_ . 'Pending', $this->render->setParams  );

        }

        public function my() {

            $this->render->MyOrders             =                   $this->render->LogicAgent->GetMyOrders();
            $this->render->page( _FOLDER_ . 'MyOrders', $this->render->setParams  );

        }

        public function search() {

            if ( !isset( $_POST['btnSearch'] ) ) :

                $this->render->StartDate        =           date( 'Y-m-d', mktime( 0, 0, 0, date('m'), date('d') - 14, date('Y') ) ); 
                $this->render->StopDate         =           date( 'Y-m-d' ); 

            else:

                $this->render->StartDate        =           $_POST['StartDate']; 
                $this->render->StopDate         =           $_POST['StopDate']; 

            endif;

            if( isset( $_POST['btnSearch'] ) ) :

                $this->render->Search           =           $this->render->LogicAgent->SearchOrders();

            endif;

            $this->render->page( _FOLDER_ . 'Search', $this->render->setParams  );

        }

        public function order() {

            $this->render->OrderGUID           =                   func_get_arg( 0 );

            if ( isset( $_POST['btnUpdate'] ) ) :

                $this->process                =                    $this->render->LogicAgent->ProcessUpdateOrderByGUID( $this->render->OrderGUID );

            endif;

            if ( isset( $_POST['btnAssign'] ) ) :

                $this->process                =                    $this->render->LogicAgent->ProcessAssignOrderByGUID( $this->render->OrderGUID );

            endif;

            $this->render->GetOrder            =                   $this->render->LogicAgent->GetOrderByGUID( $this->render->OrderGUID );
            $this->render->GetConcierge        =                   $this->render->LogicAgent->GetDeliveryConcierge();
            $this->render->page( _FOLDER_ . 'Order', $this->render->setParams  );

        }


    }


<div class="container-fluid mt-4">

<div class="animated fadeIn">

    <div class="row">
    
        <div class="col-12">

            <div class="card border-white">

                <div class="card-body">  
                    
                    <h3 class="text-dark">AGENT <strong>DASHBOARD</strong></h3>
                    
                    <div class="alert alert-info border-info">
                        
                        Hello <span class="font-weight-bold"><?php echo $_SESSION['sessAcctFirst']; ?></span>. Select one of the available options below to begin.
                    </div>

                </div>
                
            </div>

            <div class="row">
                            
                    <div class="col-md"> 
                        
                        <div class="card text-center font-weight-normal hover">

                            <div class="card-body">
                                <a href="<?php echo gpConfig['URLPATH'] . _ACCESS_;; ?>pending/">
                                    <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/pending.png" style="width: 80px"/>
                                </a>
                                <h5 class="mt-3"><strong>PENDING ORDERS</strong></h5>
                                <div class="font-sm">Manage System Users</div>
                            </div>
                            
                        </div>
                        
                    </div>

                    <div class="col-md"> 
                        
                        <div class="card text-center font-weight-normal hover">

                            <div class="card-body">
                                <a href="<?php echo gpConfig['URLPATH'] . _ACCESS_;; ?>my/">
                                    <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/my.png" style="width: 80px"/>
                                </a>
                                <h5 class="mt-3"><strong>MY ORDERS</strong></h5>
                                <div class="font-sm">Manage Devices</div>
                                
                            </div>
                            
                        </div>
                        
                    </div>

                    <div class="col-md"> 
                        
                        <div class="card text-center font-weight-normal hover">

                            <div class="card-body">
                                <a href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>search/">
                                    <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/search.png" style="width: 80px"/>
                                </a>
                                <h5 class="mt-3"><strong>SEARCH ORDERS</strong></h5>
                                <div class="font-sm">Find Orders</div>
                                
                            </div>
                            
                        </div>
                        
                    </div>

                    <div class="col-md"> 
                        &nbsp; 
                    </div>
                
                    <div class="col-md"> 
                        &nbsp; 
                    </div>
                
                </div>

            </div>

        </div>
    
    </div>

</div>

</div>


<div class="container-fluid mt-4">

    <div class="animated fadeIn">

        <div class="row">
        
            <div class="col-12">

                <div class="card border-white">

                    <div class="card-body">  
                        
                        <h3 class="text-dark">ADMINISTRATOR <strong>DASHBOARD</strong></h3>
                        
                        <div class="alert alert-info border-info">
                            Hello <span class="font-weight-bold"><?php echo $_SESSION['sessAcctFirst']; ?></span>. Select one of the available options below to begin.
                        </div>

                    </div>
                    
                </div>

                <div class="row">
                                
                        <div class="col-md"> 
                            
                            <div class="card text-center font-weight-normal hover">

                                <div class="card-body">
                                    <a href="<?php echo gpConfig['URLPATH'] . _ACCESS_;; ?>accounts/">
                                        <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/accounts.png" style="width: 80px"/>
                                    </a>
                                    <h5 class="mt-3"><strong>MANAGE USERS</strong></h5>
                                    <div class="font-sm">Manage System Users</div>
                                </div>
                                
                            </div>
                            
                        </div>

                        <div class="col-md"> 
                            
                            <div class="card text-center font-weight-normal hover">

                                <div class="card-body">
                                    <a href="<?php echo gpConfig['URLPATH'] . _ACCESS_;; ?>devices/">
                                        <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/catalog.png" style="width: 80px"/>
                                    </a>
                                    <h5 class="mt-3"><strong>DEVICE CATALOG</strong></h5>
                                    <div class="font-sm">Manage Devices</div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>

                        <div class="col-md"> 
                            
                            <div class="card text-center font-weight-normal hover">

                                <div class="card-body">
                                    <a href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>reporting/">
                                        <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/reporting.png" style="width: 80px"/>
                                    </a>
                                    <h5 class="mt-3"><strong>REPORTING</strong></h5>
                                    <div class="font-sm">Data Driven System Reports</div>
                                    
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
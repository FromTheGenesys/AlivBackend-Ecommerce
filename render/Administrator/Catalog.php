

<div class="container-fluid mt-4">

<div class="animated fadeIn">

    <div class="row">
    
        <div class="col-12">

            <div class="card border-white">

                <div class="card-body">  
                    
                    <h3 class="text-dark">DEVICE <strong>CATALOG</strong></h3>
                    
                    <div class="alert alert-info border-info">
                        Hello <span class="font-weight-bold"><?php echo $_SESSION['sessFirstName']; ?></span>. Select one of the available options below to begin.
                    </div>

                    <button class="font-sm btn-dark btn-lg" type="button" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>administrator'"><i class="fa fa-desktop"></i>&nbsp;Dashboard</button>

                </div>
                
            </div>

            <div class="row">
                            
                    <div class="col-md"> 
                        
                        <div class="card text-center font-weight-normal hover">

                            <div class="card-body">
                                <a href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes/">
                                    <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/makeandmodel.png" style="width: 80px"/>
                                </a>
                                <h5 class="mt-3"><strong>MAKES & MODELS</strong></h5>
                                <div class="font-sm">Add/Manage Makes & Models</div>
                            </div>
                            
                        </div>
                        
                    </div>

                    <div class="col-md"> 
                        
                        <div class="card text-center font-weight-normal hover">

                            <div class="card-body">
                                <a href="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>attributes/">
                                    <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/attributes.png" style="width: 80px"/>
                                </a>
                                <h5 class="mt-3"><strong>ATTRIBUTES</strong></h5>
                                <div class="font-sm">Add/Manage Devices Attributes</div>
                                
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
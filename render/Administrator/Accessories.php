<div class="container-fluid mt-4">

  <div class="animated fadeIn">

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-body"> 

                    <h3>ALIV <strong>ACCESSORIES</strong></h3>

                    <?php if ( !isset( $this->setMessage ) ) : ?>

                        <div class="alert alert-primary border-primary">
                            <b class="font-weight-normal">View ALIV eCommerce Device Makes.</b>
                        </div>                    

                    <?php else: ?>

                        <?php echo $this->setMessage; ?>

                    <?php endif; ?>

                    <button class="font-sm btn-dark btn-lg" type="button" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>administrator'"><i class="fa fa-desktop"></i>&nbsp;Dashboard</button>
                    <button class="font-sm btn-success btn-lg" type="button" data-target="#AddMakes" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add Accessory</button>
                    
                </div>

            </div>

        </div>

    </div>



<!-- 
    <div class="row">

        <?php if ( $this->GetMakes['count'] == 0 ) : ?>

            <div class="alert alert-warning border-warning">
                There were no makes available.
            </div>

        <?php else: ?>

            <?php foreach( $this->GetMakes['data'] as $MakeSet ) : ?>

                <div class="row">

                    <div class="col-md-4">

                        <div class="card">

                            <div class="card-body">

                            </div><h4>AVAILABLE <strong>FOR MAPPING</strong></h4>

                        </div>

                    </div>

                    <div class="col-md-8">

                        <div class="card">

                            <div class="card-body">


                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>


    </div>
     -->
  </div>


  <div class="modal fade animated animate__animated animate__slideInLeft" id="AddMakes" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <form method="POST" enctype="multipart/form-data" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                  <div class="modal-header bg-success">
                      <h5 class="modal-title text-white">ADD <strong>DEVICE MAKE</strong></h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  
                  <div class="modal-body">

                      <div class="form-body text-dark"> 
                      
                          <div class="alert alert-success border-success">
                              Add multiple device makes ( brand names ) in the space provide below.  Please add each make ( brand ) on a new line.
                          </div>

                          <div class="row"> 

                              <div class="col-md-12"> 
                                    <strong>Make ( Brand ) Name</strong>
                              </div>
                              <div class="col-md-12"> 

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <input type="text" name="MakeName" class="form-control" value="" autocomplete="off" required placeholder="Make Name" />
                                  </div>

                              </div>

                              <div class="col-md-12 mt-3"> 
                                <strong>Description</strong>
                              </div>
                              <div class="col-md-12"> 

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <textarea name="MakeDesc" rows="4" placeholder="Description" class="form-control"></textarea>
                                  </div>

                              </div>

                              <div class="col-md-12 mt-3"> 
                                <strong>Logo</strong>
                              </div>
                              <div class="col-md-12"> 

                                  <div class="div mt-2 text-dark font-weight-normal">
                                    <input type="file" name="MakeLogo" class="form-control" value="" autocomplete="off" />
                                  </div>

                              </div>
                              <div class="col-md-12 mt-3 small"> 
                                 File must be ini *.png or *.jpg format and cannot exceed 2mb in size.
                              </div>

                          </div>
                          
                      </div>

                  </div>

                  <div class="modal-footer">                                                                                   
                      <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                      <button class="font-sm btn-lg btn-success font-weight-light" type="submit" name="btnAddMakes"><i class="fa fa-plus"></i>  Add Make(s)</button>                                                                        
                  </div>

              </form>
              
          </div>

      </div>

  </div>

</div>

<?php if ( $this->GetMakes['count'] > 0 ) : foreach( $this->GetMakes['data'] as $MakeSet ) : ?>

    <div class="modal fade animated" id="AddDevice_<?php echo $MakeSet['MakeID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="POST" enctype="multipart/form-data" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">ADD <strong>DEVICE DETAILS</strong></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">

                        <div class="form-body text-dark"> 
                        
                            <div class="alert alert-primary border-primary">
                                Enter the device details using the form below.
                            </div>

                            <div class="row"> 

                              <div class="col-md-12 mt-3"> 
                                    <strong>Device Name</strong>
                              </div>
                              <div class="col-md-12"> 

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <input type="text" name="DeviceName" class="form-control" value="" autocomplete="off" required placeholder="Device Name" />
                                  </div>

                              </div>

                              <div class="col-md-12 mt-3"> 
                                <strong>Description</strong>
                              </div>
                              <div class="col-md-12"> 

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <textarea name="DeviceDescription" rows="4" placeholder="Description" class="form-control"></textarea>
                                  </div>

                              </div>

                              <div class="col-md-6 mt-3"> 
                                <div> 
                                    <strong>Brand/Make</strong>
                                </div>
                                <div> 
                                    <div class="div mt-1 text-dark font-weight-normal">
                                        <select name="DeviceBrand" disabled class="form-control custom-select">
                                            <?php 

                                                foreach( $this->GetMakes['data'] as $MakeSetTwo ) :

                                                    echo '<option value="'. $MakeSetTwo['MakeID'] .'" ';

                                                    if ( $MakeSetTwo['MakeID'] == $MakeSet['MakeID'] ) : 

                                                        echo ' SELECTED ';

                                                    endif;

                                                    echo '>'. $MakeSetTwo['MakeName'] .'</option>';

                                                endforeach;

                                            ?>
                                        </select>
                                    </div>
                                </div>
                              </div>

                              <div class="col-md-6 mt-3"> 

                                <div> 
                                    <strong>Cost</strong>
                                </div>
                                <div> 
                                    <input type="text" name="DeviceCost" class="form-control mt-1" value="" autocomplete="off" />
                                </div>

                              </div>

                              <div class="col-md-6 mt-3"> 

                                <div> 
                                    <strong>SKU</strong>
                                </div>
                                <div> 
                                    <input type="text" name="DeviceSKU" class="form-control mt-1" value="" autocomplete="off" />
                                </div>

                              </div>

                              <div class="col-md-6  mt-3"> 

                                <div> 
                                    <strong>Status</strong>
                                </div>
                                <div> 
                                    <select name="DeviceStatus" class="mt-1 form-control custom-select">
                                        <option value="A">Active</option>                                        
                                        <option value="I">Inactive</option>
                                    </select>                                
                                </div>

                              </div>

                              <div class="col-md-12 mt-3"> 

                                 <div class="row">

                                    <div class="col-1 text-center">
                                        <input type="checkbox" id="CheckMinPlan" name="PlanRequired" value="1" />
                                    </div>
                                    <div class="col-11">
                                        This device requires minimum purchase plan ?
                                    </div>

                                 </div>
                                 
                              </div>

                              <div id="MinimumPlan" style="display: none;" class="col-12"> 

                                <div class="row">

                                    <div class="col-md-12 mt-3"> 
                                        <div> 
                                            <strong>Eligible Plans</strong>
                                        </div>
                                        <div> 
                                            <div class="div mt-1 text-dark font-weight-normal">
                                                <select name="DeviceMinimumPlan"  class="form-control custom-select w-100">
                                                    <?php 

                                                        foreach( $this->GetEligiblePlans['data'] as $PlanSet ) :

                                                            echo '<option value="'. $PlanSet['PlanID'] .'" ';

                                                            
                                                            echo '>'. $PlanSet['PlanName'] .'</option>';

                                                        endforeach;

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                
                                    </div>

                                </div>

                            </div>

                              <div class="col-md-12 mt-3"> 
                                <strong>Cover Image</strong>
                              </div>
                              <div class="col-md-12"> 

                                  <div class="div mt-2 text-dark font-weight-normal">
                                    <input type="file" name="DeviceCover" class="form-control" value="" autocomplete="off" />
                                  </div>

                              </div>
                              <div class="col-md-12 mt-3 small"> 
                                 File must be ini *.png or *.jpg format and cannot exceed 2mb in size.
                              </div>

                          </div>

                        </div>

                    </div>

                    <div class="modal-footer">                                 
                        <input type="hidden" value="<?php echo $MakeSet['MakeID']; ?>" name="MakeID" />                                                                                           
                        <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                        <button class="font-sm btn-lg btn-primary font-weight-light" type="submit" name="btnAddDevice"><i class="fa fa-plus"></i>  Add Devices</button>                                                                          
                    </div>

                </form>
                
            </div>

        </div>

    </div>

    <?php 
    
        $GetMakeDevices           =       $this->LogicAdmin->GetMakeDevices( $MakeSet['MakeID'] ); 
    
        if ( $GetMakeDevices['count'] > 0 ) : foreach( $GetMakeDevices['data'] as $DeviceSet ) : ?>

            <div class="modal fade animated" id="UpdateDevice<?php echo $DeviceSet['DeviceID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form method="POST"  action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                            <div class="modal-header bg-warning">
                                <h5 class="modal-title text-white">UPDATE <strong>DEVICE DETAILS</strong></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">

                                <div class="form-body text-dark"> 
                                
                                    <div class="alert alert-warning border-warning">
                                        Enter the updated device details using the form below.
                                    </div>

                                    <div class="row"> 

                                    <div class="col-md-12 mt-3"> 
                                            <strong>Device Name</strong>
                                    </div>
                                    <div class="col-md-12"> 

                                        <div class="div mt-2 text-dark font-weight-normal">
                                            <input type="text" name="DeviceName" class="form-control" value="<?php echo $DeviceSet['DeviceName']; ?>" autocomplete="off" required placeholder="Device Name" />
                                            <input type="hidden" name="DeviceNameOld" value="<?php echo $DeviceSet['DeviceName']; ?>" />
                                        </div>

                                    </div>

                                    <div class="col-md-12 mt-3"> 
                                        <strong>Description</strong>
                                    </div>
                                    <div class="col-md-12"> 

                                        <div class="div mt-2 text-dark font-weight-normal">
                                            <textarea name="DeviceDescription" rows="4" placeholder="Description" class="form-control"><?php echo $DeviceSet['DeviceDescription']; ?></textarea>
                                        </div>

                                    </div>

                                    <div class="col-md-6 mt-3"> 
                                        <div> 
                                            <strong>Brand/Make</strong>
                                        </div>
                                        <div> 
                                            <div class="div mt-1 text-dark font-weight-normal">
                                                <select name="DeviceBrand" disabled class="form-control custom-select">
                                                    <?php 

                                                        foreach( $this->GetMakes['data'] as $MakeSetTwo ) :

                                                            echo '<option value="'. $MakeSetTwo['MakeID'] .'" ';

                                                            if ( $MakeSetTwo['MakeID'] == $MakeSet['MakeID'] ) : 

                                                                echo ' SELECTED ';

                                                            endif;

                                                            echo '>'. $MakeSetTwo['MakeName'] .'</option>';

                                                        endforeach;

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3"> 

                                        <div> 
                                            <strong>Cost</strong>
                                        </div>
                                        <div> 
                                            <input type="text" name="DeviceCost" class="form-control mt-1" value="<?php echo $DeviceSet['DeviceCost']; ?>" autocomplete="off" />
                                        </div>

                                    </div>

                                    <div class="col-md-6 mt-3"> 

                                        <div> 
                                            <strong>SKU</strong>
                                        </div>
                                        <div> 
                                            <input type="text" name="DeviceSKU" class="form-control mt-1" value="<?php echo $DeviceSet['DeviceSKU']; ?>" autocomplete="off" />
                                        </div>

                                    </div>

                                    <div class="col-md-6  mt-3"> 

                                        <div> 
                                            <strong>Status</strong>
                                        </div>
                                        <div> 
                                            <select name="DeviceStatus" class="mt-1 form-control custom-select">
                                                <option value="A">Active</option>                                        
                                                <option value="I">Inactive</option>
                                            </select>                                
                                        </div>

                                    </div>

                                    <div class="col-md-12 mt-3"> 

                                        <div class="row">

                                            <div class="col-1 text-center">
                                                <input type="checkbox" id="CheckMinPlan" name="PlanRequired" value="1" <?php echo ( !empty( $DeviceSet['DevicePlanRequired'] ) ? ' CHECKED ' : NULL ); ?> />
                                            </div>
                                            <div class="col-11">
                                                This device requires minimum purchase plan ?
                                            </div>

                                        </div>
                                        
                                    </div>

                                    <div id="MinimumPlan" <?php echo ( empty( $DeviceSet['DevicePlanRequired'] ) ? 'style="display: none;" ' : NULL ); ?> class="col-12"> 

                                            <div class="row">

                                                <div class="col-md-12 mt-3"> 
                                                    <div> 
                                                        <strong>Eligible Plans</strong>
                                                    </div>
                                                    <div> 
                                                        <div class="div mt-1 text-dark font-weight-normal">
                                                            <select name="DeviceMinimumPlan"  class="form-control custom-select w-100">
                                                                <?php 

                                                                    foreach( $this->GetEligiblePlans['data'] as $PlanSet ) :

                                                                        echo '<option value="'. $PlanSet['PlanID'] .'" ';

                                                                        if ( $DeviceSet['DevicePlanRequired'] == $PlanSet['PlanID'] ) :

                                                                            echo ' SELECTED ';

                                                                        endif;
                                                                        
                                                                        echo '>'. $PlanSet['PlanName'] .'</option>';

                                                                    endforeach;

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                            
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">                                 
                                <input type="hidden" value="<?php echo $MakeSet['MakeID']; ?>" name="MakeID" />                                                                                           
                                <input type="hidden" value="<?php echo $DeviceSet['DeviceID']; ?>" name="DeviceID" />                                                                                           
                                <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                                <button class="font-sm btn-lg btn-warning font-weight-light" type="submit" name="btnUpdateDevice"><i class="fa fa-pencil"></i>  Update Device</button>                                                                          
                            </div>

                        </form>
                        
                    </div>

                </div>
            </div>
                
        <?php endforeach; endif; ?>

        <div class="modal fade animated" id="UpdateMake<?php echo $MakeSet['MakeID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <form method="POST" enctype="multipart/form-data" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                        <div class="modal-header bg-warning">
                            <h5 class="modal-title text-white">UPDATE <strong>DEVICE MAKE</strong></h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        
                        <div class="modal-body">

                            <div class="form-body text-dark"> 
                            
                                <div class="alert alert-warning border-warning">
                                    Update Make Details using the form below.
                                </div>

                                <div class="row"> 

                                    <div class="col-md-12"> 
                                            <strong>Make ( Brand ) Name</strong>
                                    </div>
                                    <div class="col-md-12"> 

                                        <div class="div mt-2 text-dark font-weight-normal">
                                            <input type="text" name="MakeName" class="form-control" value="<?php echo $MakeSet['MakeName']; ?>" autocomplete="off" required placeholder="Make Name" />
                                            <input type="hidden" name="MakeNameOld" value="<?php echo $MakeSet['MakeName']; ?>" />
                                        </div>

                                    </div>

                                    <div class="col-md-12 mt-3"> 
                                        <strong>Description</strong>
                                    </div>
                                    <div class="col-md-12"> 

                                        <div class="div mt-2 text-dark font-weight-normal">
                                            <textarea name="MakeDesc" rows="4" placeholder="Description" class="form-control"><?php echo $MakeSet['MakeDescription']; ?></textarea>
                                        </div>

                                    </div>
                                    <div class="col-md-12 mt-3"> 
                                        <strong>Status</strong>
                                    </div>
                                    <div class="col-md-12"> 

                                        <div class="div mt-2 text-dark font-weight-normal">
                                            <select name="MakeStatus" class="form-control custom-select">
                                                <option value="A" <?php echo ( ( $MakeSet['MakeStatus'] == 'A' ) ? 'SELECTED' : NULL ); ?>>Active</option>
                                                <option value="I" <?php echo ( ( $MakeSet['MakeStatus'] == 'I' ) ? 'SELECTED' : NULL ); ?>>Inactive</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-12 mt-3"> 
                                        <strong>Logo</strong>
                                    </div>

                                    <?php if ( !empty( $MakeSet['MakeLogo'] ) ) : ?>
                                    
                                        <div class="col-md-12"> 

                                            <div class="div mt-2 text-dark font-weight-normal">
                                                <img class="img-fluid" src="<?php echo gpConfig['URLPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] ?>Makes/<?php echo $MakeSet['MakeID']; ?>/<?php echo $MakeSet['MakeLogo']; ?>" />
                                            </div>

                                        </div>
                                        <div class="col-md-12"> 

                                            <div class="div mt-2 text-dark font-weight-normal text-left w-100 mb-5">
                                                <input type="checkbox" name="overwrite" value="1" /> Overwrite existing logo image
                                            </div>

                                        </div>
                                        
                                    <?php endif; ?>

                                    <div class="col-md-12"> 

                                        <div class="div mt-2 text-dark font-weight-normal">
                                            <input type="file" name="MakeLogo" class="form-control" value="" autocomplete="off" />
                                            <input type="hidden" name="MakeLogo" value="<?php echo $MakeSet['MakeLogo']; ?>" />
                                        </div>

                                    </div>
                                    <div class="col-md-12 mt-3 small"> 
                                        File must be ini *.png or *.jpg format and cannot exceed 2mb in size.
                                    </div>

                                </div>
                                
                            </div>

                        </div>

                        <div class="modal-footer">                                                                                   
                            <input type="hidden" value="<?php echo $MakeSet['MakeID']; ?>" name="MakeID" />
                            <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                            <button class="font-sm btn-lg btn-warning font-weight-light" type="submit" name="btnUpdateMake"><i class="fa fa-plus"></i>  Update Make Details</button>                                                                        
                        </div>

                    </form>
                    
                </div>

            </div>
        </div>

<?php endforeach; endif; ?>

 
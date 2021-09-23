<div class="container-fluid mt-4">

  <div class="animated fadeIn">

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-body"> 

                    <h3>ALIV <strong>DEVICE MAKES</strong></h3>

                    <?php if ( !isset( $this->setMessage ) ) : ?>

                        <div class="alert alert-primary border-primary">
                            <b class="font-weight-normal">View ALIV eCommerce Device Makes.</b>
                        </div>                    

                    <?php else: ?>

                        <?php echo $this->setMessage; ?>

                    <?php endif; ?>

                    <button class="font-sm btn-dark btn-lg" type="button" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>administrator'"><i class="fa fa-desktop"></i>&nbsp;Dashboard</button>
                    <button class="font-sm btn-success btn-lg" type="button" data-target="#AddMakes" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add Make</button>
                    
                </div>

            </div>

        </div>

    </div>

    <?php if ( $this->GetMakes['count'] == 0 ) : ?>

        <div class="row">

            <div class="card">

                <div class="card-body">

                    <div class="alert alert-warning border-warning">
                        There were no makes available.
                    </div>

                </div>

            </div>

        </div>

    <?php else: ?>

        <?php foreach ( $this->GetMakes['data'] as $MakeSet ) : ?>

            <div class="row">

                <div class="col-md-3">

                    <div class="card">

                        <div class="card-body text-center">

                            <h4 class="mt-3">MAKE <strong>DETAILS</strong></h4>

                            <div>
                                <img src="<?php echo gpConfig['URLPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] .'Makes/'. $MakeSet['MakeID']; ?>/<?php echo $MakeSet['MakeLogo']; ?>" class="img-fluid w-50 border-dark mt-3" />
                            </div>

                            <h4 class="mt-3"><strong><?php echo $MakeSet['MakeName']; ?></strong></h4>

                            <div class="text-small"><?php echo $MakeSet['MakeDescription']; ?></div>
                            <div class="small mt-4">Added on <?php echo date( 'd-M-Y \a\t h:i a', strtotime( $MakeSet['MakeCreated'] ) ); ?></div>

                        </div>

                    </div>

                </div>

                <div class="col-md-9">

                    <div class="card">

                        <div class="card-body">

                            <h4 class="mt-3"><?php echo $MakeSet['MakeName']; ?> <strong>DEVICES</strong></h4>
                            <?php $GetMakeDevices           =       $this->LogicAdmin->GetMakeDevices( $MakeSet['MakeID'] ); ?>

                            <?php if ( $GetMakeDevices['count'] == 0 ) : ?>

                                <div class="alert alert-warning border-warning">
                                    There were no <?php echo $MakeSet['MakeName']; ?> devices listed.
                                </div>

                                <?php if ( $MakeSet['MakeStatus'] == 'I' ) : ?>

                                    <div class="alert alert-pink border-pink">
                                        This brand has been disabled.
                                    </div>

                                <?php endif; ?>

                                <?php if ( $MakeSet['MakeStatus'] == 'A' ) : ?>
                                    <button class="font-sm btn-primary btn-lg" type="button" data-target="#AddDevice_<?php echo $MakeSet['MakeID']; ?>" data-toggle="modal"><i class="fa fa-mobile-phone"></i>&nbsp;Add Device</button>                                    
                                <?php endif; ?>

                                <button class="font-sm btn-warning btn-lg" type="button" data-target="#UpdateMake<?php echo $MakeSet['MakeID']; ?>" data-toggle="modal"><i class="fa fa-pencil"></i>&nbsp;Update Make Details</button>

                            <?php else: ?>


                                <div class="alert alert-primary border-primary">
                                    Please review all  <?php echo $MakeSet['MakeName']; ?> devices below.
                                </div>

                                 <?php if ( $MakeSet['MakeStatus'] == 'I' ) : ?>

                                    <div class="alert alert-pink border-pink">
                                        This brand has been disabled.
                                    </div>

                                <?php endif; ?>

                                <?php if ( $MakeSet['MakeStatus'] == 'A' ) : ?>
                                    <button class="font-sm btn-primary btn-lg" type="button" data-target="#AddDevice_<?php echo $MakeSet['MakeID']; ?>" data-toggle="modal"><i class="fa fa-mobile-phone"></i>&nbsp;Add Device</button>                                    
                                <?php endif; ?>

                                <button class="font-sm btn-warning btn-lg" type="button" data-target="#UpdateMake<?php echo $MakeSet['MakeID']; ?>" data-toggle="modal"><i class="fa fa-pencil"></i>&nbsp;Update Make Details</button>

                                <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm mt-3">
                                    <thead class="thead-light font-weight-normal">
                                        <tr>                  
                                            <th>Device Name</th>
                                            <th>SKU</th>
                                            <th class="text-right">Cost</th>                  
                                            <th class="text-left">Status</th>                                                                    
                                            <th class="text-left">Added</th>                                                                                        
                                            <th class="text-center">Attributes</th>                                    
                                            <th class="text-center">Accessories</th>                                    
                                            <th class="text-left">Task</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                
                                    <?php foreach( $GetMakeDevices['data'] as $DeviceSet ) : 
                                        
                                            $GetAccessories         =           $this->LogicAdmin->GetDeviceAccesories( $DeviceSet['DeviceID'] );
                                        ?>

                                        <tr>                  
                                            <td><?php echo $DeviceSet['DeviceName']; ?></td>
                                            <td><?php echo $DeviceSet['DeviceSKU']; ?></td>                                            
                                            <td class="text-right"><?php echo number_format( $DeviceSet['DeviceCost'], 2 ); ?></td>  
                                            <td><?php echo ( ( $DeviceSet['DeviceStatus'] == 'A' ) ? 'Active' : 'Inactive' ); ?></td>                                                      
                                            <td><?php echo date( 'd-M-Y \a\t H:i a', strtotime( $DeviceSet['DeviceCreated'] ) ); ?></td>                                                                                                                
                                            <td class="text-center"><?php echo empty( $DeviceSet['DeviceAttributes'] ) ? 0 : count( explode(',', $DeviceSet['DeviceAttributes'] ) ); ?></td>                                    
                                            <td class="text-center"><?php echo $GetAccessories['count']; ?></td>                                    
                                            <td class="text-left">
                                                <button class="btn-lg btn-pink font-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button"><i class="fa fa-tools"></i>  Options</button>    
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" data-target="#ShowDeviceAttributes<?php echo $DeviceSet['DeviceID']; ?>" data-toggle="modal"><i class="fa fa-gear text-pink"></i>Manage Device Attributes</a>                                        
                                                    <a class="dropdown-item" data-target="#AddAccessory<?php echo $DeviceSet['DeviceID']; ?>" data-toggle="modal"><i class="fa fa-cube text-purple"></i>Add Device Accessory</a>                                        

                                                    <?php if ( $GetAccessories['count'] > 0 ) : ?>
                                                        <a class="dropdown-item" data-target="#ViewAccessories<?php echo $DeviceSet['DeviceID']; ?>" data-toggle="modal"><i class="fa fa-cubes text-purple"></i>View Device Accessory</a>                                        
                                                    <?php endif; ?>

                                                    <a class="dropdown-item" data-target="#AddPhotos<?php echo $DeviceSet['DeviceID']; ?>" data-toggle="modal"><i class="fa fa-camera text-success"></i>Add Device Photos</a>                                      
                                                    <a class="dropdown-item" data-target="#ViewPhotos<?php echo $DeviceSet['DeviceID']; ?>" data-toggle="modal"><i class="fa fa-images text-success"></i>Manage Device Photos</a>                                      
                                                    <a class="dropdown-item" data-target="#UpdateDevice<?php echo $DeviceSet['DeviceID']; ?>" data-toggle="modal"><i class="fa fa-pencil text-warning"></i>Update Device Details</a>                                      
                                                </div>
                                            </td>                                    
                                        </tr>

                                    <?php endforeach; ?>

                                    </tbody>
                                </table>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>


            </div>

        <?php endforeach; ?>


    <?php endif; ?>


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

    
    <?php $GetAttributeSet  =   $this->LogicAdmin->GetAttributeSet( $MakeSet['MakeID'] );   ?>
    
    <?php 
    
        $GetMakeDevices           =       $this->LogicAdmin->GetMakeDevices( $MakeSet['MakeID'] ); 
        
        if ( $GetMakeDevices['count'] > 0 ) : foreach( $GetMakeDevices['data'] as $DeviceSet ) : ?>

            <div class="modal fade animated" id="AddAccessory<?php echo $DeviceSet['DeviceID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <form method="POST" enctype="multipart/form-data" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                                <div class="modal-header bg-purple">
                                    <h5 class="modal-title text-white">ADD <strong>DEVICE ACCESSORY</strong></h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                
                                <div class="modal-body">

                                    <div class="form-body text-dark"> 
                                    
                                        <div class="alert alert-purple border-purple">
                                            Enter the device accessory using the form below.
                                        </div>

                                        <div class="row"> 

                                        <div class="col-md-12 mt-3"> 
                                            <strong>Accessory Name</strong>
                                        </div>
                                        <div class="col-md-12"> 

                                            <div class="div mt-2 text-dark font-weight-normal">
                                                <input type="text" name="AccessoryName" class="form-control" value="" autocomplete="off" required placeholder="Accessory Name" />
                                            </div>

                                        </div>

                                        <div class="col-md-12 mt-3"> 
                                            <strong>Description</strong>
                                        </div>
                                        <div class="col-md-12"> 

                                            <div class="div mt-2 text-dark font-weight-normal">
                                                <textarea name="AccessoryDescription" rows="4" placeholder="Description" class="form-control"></textarea>
                                            </div>

                                        </div>

                                        <div class="col-md-6 mt-3"> 

                                            <div> 
                                                <strong>Cost ( VAT not included )</strong>
                                            </div>
                                            <div> 
                                                <input type="text" name="AccessoryCost" class="form-control mt-1" value="" autocomplete="off" />
                                            </div>

                                        </div>

                                        <div class="col-md-6  mt-3"> 

                                            <div> 
                                                <strong>Status</strong>
                                            </div>
                                            <div> 
                                                <select name="AccessoryStatus" class="mt-1 form-control custom-select">
                                                    <option value="A">Active</option>                                        
                                                    <option value="I">Inactive</option>
                                                </select>                                
                                            </div>

                                        </div>

                                        <div class="col-md-12 mt-3"> 
                                            <strong>Accssory Image</strong>
                                        </div>
                                        <div class="col-md-12"> 

                                            <div class="div mt-2 text-dark font-weight-normal">
                                                <input type="file" name="AccessoryCover" required class="form-control" value="" autocomplete="off" />
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
                                    <input type="hidden" value="<?php echo $DeviceSet['DeviceID']; ?>" name="DeviceID" />                                                                                           
                                    <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                                    <button class="font-sm btn-lg btn-purple font-weight-light" type="submit" name="btnAddAccessory"><i class="fa fa-plus"></i>  Add Accessory</button>                                                                          
                                </div>

                            </form>
                            
                        </div>

                    </div>

                </div>

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

            <div class="modal fade animated" id="AddPhotos<?php echo $DeviceSet['DeviceID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form method="POST" enctype="multipart/form-data" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                            <div class="modal-header bg-teal">
                                <h5 class="modal-title text-white">ADD <strong>DEVICE PHOTOS</strong></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">

                                <div class="form-body text-dark"> 
                                
                                    <div class="alert alert-teal border-teal">
                                        Browse your device for the photos that you wish to upload.  All photos must be in *.png or *.jpg format and cannot exceed 2mb in size.  You are permitted to upload a maximum of eight (8) photos per attempt.
                                    </div>

                                    <div class="row"> 
                                    
                                        <div class="col-md-12  mt-3"> 

                                            <div> 
                                                <strong>Photos</strong>
                                            </div>
                                            <div class="mt-2"> 
                                                <input type="file" name="DevicePhotos[]" multiple class="form-control" />                              
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">                                 
                                <input type="hidden" value="<?php echo $MakeSet['MakeID']; ?>" name="MakeID" />                                                                                           
                                <input type="hidden" value="<?php echo $DeviceSet['DeviceID']; ?>" name="DeviceID" />                                                                                           
                                <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                                <button class="font-sm btn-lg btn-teal font-weight-light" type="submit" name="btnUploadPhotos"><i class="fa fa-upload"></i>  Upload Device Photos</button>                                                                          
                            </div>

                        </form>
                        
                    </div>

                </div>
            </div>

            <div class="modal fade animated" id="ShowDeviceAttributes<?php echo $DeviceSet['DeviceID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form method="POST" enctype="multipart/form-data" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                            <div class="modal-header bg-pink">
                                <h5 class="modal-title text-white">MANAGE <strong>DEVICE ATTRIBUTES</strong></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">

                                <div class="form-body text-dark"> 
                                
                                    <div class="alert alert-pink border-pink">
                                        Check the boxes next to an attribute to apply them to the selected device.
                                    </div>

                                    <div class="row"> 

                                        <div class="col-md-12"> 

                                            <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm mt-3">
                                                <thead class="thead-light font-weight-normal">
                                                    <tr>
                                                        <th><i class="fa fa-check text-success"></i></th>                  
                                                        <th>Attribute Name</th>                                                                                        
                                                    </tr>
                                                </thead>

                                                <?php foreach( $GetAttributeSet['data'] as $AttributeSet ) : ?>

                                                    <tbody>
                                                        <tr>
                                                            <td><input type="checkbox" name="AttributeID[]" value="<?php echo $AttributeSet['AttributeID']; ?>" <?php echo ( in_array( $AttributeSet['AttributeID'], explode( ',', $DeviceSet['DeviceAttributes'] ) ) ? 'CHECKED' : NULL ); ?> /></td>
                                                            <td><?php echo $AttributeSet['AttributeName']; ?></td>
                                                        </tr>
                                                    </tbody>

                                                <?php endforeach; ?>
                                            </table>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">                                 
                                <input type="hidden" value="<?php echo $MakeSet['MakeID']; ?>" name="MakeID" />                                                                                           
                                <input type="hidden" value="<?php echo $DeviceSet['DeviceID']; ?>" name="DeviceID" />                                                                                           
                                <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                                <button class="font-sm btn-lg btn-pink font-weight-light" type="submit" name="btnAddAttribute"><i class="fa fa-plus"></i>  Add/Remove Selected Attributes</button>                                                                          
                            </div>

                        </form>
                        
                    </div>

                </div>
            </div>

            <?php $GetDevicePhotos = $this->LogicAdmin->GetDevicePhotos( $DeviceSet['DeviceID'] ); ?>

            <?php if ( $GetDevicePhotos['count'] > 0 ) : ?>

                <div class="modal fade animated" id="ViewPhotos<?php echo $DeviceSet['DeviceID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <form method="POST" enctype="multipart/form-data" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                                <div class="modal-header bg-teal">
                                    <h5 class="modal-title text-white">VIEW <strong>DEVICE PHOTOS</strong></h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                
                                <div class="modal-body">

                                    <div class="form-body text-dark"> 
                                    
                                        <div class="alert alert-teal border-teal">
                                            View all photos associated with this device below.
                                        </div>

                                        <div class="row"> 
                                        
                                            <div class="col-md-12  mt-3"> 

                                                <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm mt-3">
                                                    <thead class="thead-light font-weight-normal">
                                                        <tr>                  
                                                            <th class="text-center">Default</th>
                                                            <th>Photos</th>                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                
                                                    <?php foreach( $GetDevicePhotos['data'] as $ImageSet ) : ?>

                                                        <tr>                  
                                                            <td><input type="radio" <?php echo ( $ImageSet['ImageID'] == $DeviceSet['DeviceCover'] ) ? ' CHECKED ' : NULL; ?> class="form-control" name="DeviceCover" value="<?php echo $ImageSet['ImageID']; ?>" /></td>
                                                            <td>
                                                                <img class="form-control" src="<?php echo gpConfig['URLPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS']; ?>Devices/<?php echo $ImageSet['DeviceID']; ?>/<?php echo $ImageSet['ImageName']; ?>" />

                                                                <?php if ( $ImageSet['ImageID'] != $DeviceSet['DeviceCover'] ) : ?>
                                                                    <br />
                                                                    <input type="checkbox" name="DeletePhoto[]" value="<?php echo $ImageSet['ImageID']; ?>" />&nbsp;Delete This Image
                                                                <?php endif; ?>

                                                            </td>                                                                                                    
                                                        </tr>

                                                    <?php endforeach; ?>

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">                                 
                                    <input type="hidden" value="<?php echo $MakeSet['MakeID']; ?>" name="MakeID" />                                                                                           
                                    <input type="hidden" value="<?php echo $DeviceSet['DeviceID']; ?>" name="DeviceID" />                                                                                           
                                    <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                                    <button class="font-sm btn-lg btn-teal font-weight-light" type="submit" name="btnUpdatePhotos"><i class="fa fa-pencil"></i>  Update Device Photos</button>                                                                          
                                </div>

                            </form>
                            
                        </div>

                    </div>
                </div>

            <?php endif; ?>

            <?php $GetDeviceAccessories = $this->LogicAdmin->GetDeviceAccesories( $DeviceSet['DeviceID'] ); ?>

            <?php if ( $GetDeviceAccessories['count'] > 0 ) : ?>

                <div class="modal fade animated" id="ViewAccessories<?php echo $DeviceSet['DeviceID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <form method="POST" enctype="multipart/form-data" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>makes">

                                <div class="modal-header bg-purple">
                                    <h5 class="modal-title text-white">VIEW <strong>DEVICE ACCESSORIES</strong></h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                
                                <div class="modal-body">

                                    <div class="form-body text-dark"> 
                                    
                                        <div class="alert alert-purple border-purple">
                                            View all accessories associated with this device below.
                                        </div>

                                        <div class="row"> 
                                        
                                            <div class="col-md-12  mt-3"> 

                                                <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm mt-3">
                                                    <thead class="thead-light font-weight-normal">
                                                        <tr>                                                                              
                                                            <th>Accesories</th>                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                
                                                    <?php foreach( $GetDeviceAccessories['data'] as $AccessorySet ) : ?>

                                                        <tr>                                                                              
                                                            <td class="text-center">
                                                                <div class="row">

                                                                    <div class="col-md-12 mb-3">
                                                                        <img class="form-control w-100 text-center" src="<?php echo gpConfig['URLPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS']; ?>Accessories/<?php echo $AccessorySet['AccessoryID']; ?>/<?php echo $AccessorySet['AccessoryCover']; ?>" />
                                                                    </div>
                                                                    <div class="col-md-6 text-left"><h5><strong><?php echo $AccessorySet['AccessoryName']; ?></strong></h5></div>
                                                                    <div class="col-md-6 text-right"><h5><strong><?php echo number_format( $AccessorySet['AccessoryCost'], 2 ); ?></strong></h5></div>
                                                                    <div class="col-md-12 mt-3"><?php echo $AccessorySet['AccessoryDescription']; ?></div>
                                                                    <div class="col-md-12 mt-3 text-danger"><strong>
                                                                        <input type="checkbox" name="DeleteAccessory[]" value="<?php echo $AccessorySet['AccessoryID']; ?>" />&nbsp;Delete This Accessory </strong>
                                                                    </div>

                                                                </div>
                                                                
                                                            </td>                                                                                                    
                                                        </tr>

                                                    <?php endforeach; ?>

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">                                 
                                    <input type="hidden" value="<?php echo $MakeSet['MakeID']; ?>" name="MakeID" />                                                                                           
                                    <input type="hidden" value="<?php echo $DeviceSet['DeviceID']; ?>" name="DeviceID" />                                                                                           
                                                                                                                      
                                    <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                                    <button class="font-sm btn-lg btn-purple font-weight-light" type="submit" name="btnUpdateAccessories"><i class="fa fa-pencil"></i>  Update Device Accessories</button>                                                                          
                                </div>

                            </form>
                            
                        </div>

                    </div>
                </div>

            <?php endif; ?>
                
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

 
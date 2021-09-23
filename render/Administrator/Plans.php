<div class="container-fluid mt-4">

  <div class="animated fadeIn">

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-body"> 

                    <h3>ALIV <strong>PRIMARY PLANS</strong></h3>

                    <?php if ( !isset( $this->setMessage ) ) : ?>

                        <div class="alert alert-primary border-primary">
                            <b class="font-weight-normal">View ALIV Primary Plans below.</b>
                        </div>                    

                    <?php else: ?>

                        <?php echo $this->setMessage; ?>

                    <?php endif; ?>

                    <button class="font-sm btn-dark btn-lg" type="button" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>administrator'"><i class="fa fa-desktop"></i>&nbsp;Dashboard</button>
                    
                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <?php if ( $this->GetEligible['count'] > 0 ): ?>

                <div class="card border-success">

                    <div class="card-body">

                        <h4>ELIGIBLE <strong>FOR MAPPING</strong></h4>
                        <form method="POST" action="">

                            <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 mt-3 font-sm">
                                <thead class="thead-light font-weight-normal">
                                    <tr>                  
                                        <th class="text-center"><i class="fa fa-trash text-danger text-center"></i></th>
                                        <th>Priority</th>
                                        <th>Plan Name</th>
                                        <th>Plan Group</th>
                                        <th class="text-right">Plan Cost</th>                                                      
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach( $this->GetEligible['data'] as $PlanSet ) : ?>

                                        <tr>
                                            <td class="text-center">
                                                <div>
                                                    <i class="fa fa-trash text-danger text-center" data-target="#PlanData<?php echo $PlanSet['PlanID']; ?>" data-toggle="modal"></i>
                                                </div>                    
                                            </td>
                                            <td class="text-left">
                                                <div>
                                                    <input type="hidden" value="<?php echo $PlanSet['PlanID']; ?>" name="PlanID[]" />
                                                    <select name="Priority[]" class="form-control custom-select text-center w-50">
                                                        <?php

                                                            $count  =  1; 

                                                            while( $count <= $this->GetEligible['count'] ) :

                                                                echo '<option value="'. $count .'" ';

                                                                if ( $count == $PlanSet['PlanPriority'] ) :

                                                                    echo ' SELECTED ';

                                                                endif;

                                                                echo '>'. $count .'</option>';

                                                                ++$count;

                                                            endwhile;

                                                        ?>
                                                    </select>
                                                </div>                    
                                            </td>
                                            <td>
                                                <div><?php echo $PlanSet['PlanName']; ?></div>                    
                                            </td>
                                            <td>
                                                <div><?php echo $PlanSet['PlanGroupName'];  ?></div>                    
                                            </td>
                                            <td class="text-right">
                                                <div><?php echo $PlanSet['PlanCost']; ?></div>                    
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                            <button class="mt-3 btn-lg btn-danger font-sm" name="btnSortEligible"><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i> Adjust Priority</button>

                        </form>

                    </div>

                </div>

            <?php endif; ?>

            <div class="card">

                <div class="card-body">

                    <?php if ( $this->GetPlans['count'] == 0 ) : ?>

                        <div class="alert alert-warning border-warning">
                            There were no plans available.
                        </div>

                    <?php else: ?>

                        <h4>AVAILABLE <strong>FOR MAPPING</strong></h4>
                        <form method="POST" action="">

                            <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 mt-3 font-sm">
                                <thead class="thead-light font-weight-normal">
                                    <tr>                  
                                        <th class="text-center"><i class="fa fa-check text-success text-center"></i></th>
                                        <th>Plan Name</th>
                                        <th>Plan Group</th>
                                        <th class="text-right">Plan Cost</th>                                                      
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach( $this->GetPlans['data'] as $PlanSet ) : ?>

                                        <tr>
                                            <td class="text-center">
                                                <div>
                                                    <?php if ( $this->LogicAdmin->CheckPlanEligibility( $PlanSet['PlanID'] ) == true ) : ?>
                                                        <i class="fa fa-check text-check text-success"></i>
                                                    <?php else: ?>
                                                        <input type="checkbox" class="form-control  " name="PlanID[]" value="<?php echo $PlanSet['PlanID']; ?>" />
                                                    <?php endif; ?>
                                                </div>                    
                                            </td>
                                            <td>
                                                <div><?php echo $PlanSet['PlanName']; ?></div>                    
                                            </td>
                                            <td>
                                                <div><?php echo $PlanSet['PlanGroupName'];  ?></div>                    
                                            </td>
                                            <td class="text-right">
                                                <div><?php echo $PlanSet['PlanCost']; ?></div>                    
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                            <button class="mt-3 btn-lg btn-success font-sm" name="btnMakeEligible"><i class="fa fa-check"></i>Select Plan(s) For Mapping</button>

                        </form>

                    <?php endif; ?>
            
                </div>

            </div>

      </div>
      
    </div>
    
  </div>

  <div class="modal animate__animated animate__slideInLeft " id="SearchUserAccount" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <form method="POST" action="<?php echo gpConfig['URLPATH']; ?>administrator/accounts">

                  <div class="modal-header bg-primary">
                      <h5 class="modal-title text-white">SEARCH <strong>USER ACCOUNT</strong></h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  
                  <div class="modal-body">

                      <div class="form-body text-dark"> 
                      
                          <div class="alert alert-primary border-primary">
                              Enter the search parameters using the form below. Click the Search Accounts button to return results.
                          </div>

                          <div class="row"> 

                              <div class="col-md-6"> 

                                  <div class="div mt-3 text-dark font-weight-bold">
                                      First Name
                                  </div>

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <input name="FirstName" autocomplete="off" type="text"  placeholder="First Name" value="" class="font-sm form-control" />
                                  </div>

                              </div>

                              <div class="col-md-6">            

                                  <div class="div mt-3 text-dark font-weight-bold">
                                      Last Name
                                  </div>

                                  <div class="div mt-2 text-dark font-weight-normal">

                                      <input name="LastName" autocomplete="off" type="text"  placeholder="Last Name" value="" class="form-control font-sm" />
                                  </div>

                              </div>

                              <div class="col-md-12">    

                                  <div class="mt-3 text-dark font-weight-bold">
                                      Location
                                  </div>

                                  <div class="div mt-2 text-dark font-weight-normal">
                                    <select name="Locations" class="form-control form-control-lg custom-select font-sm">
                                        <option value="*" > --- ALL LOCATIONS ---</option>
                                        <?php

                                            foreach( $this->GetAllBranches['data'] as $BranchSet ) : if ( $BranchSet['location_status'] == 'A' ) :

                                            echo '<option value="'. $BranchSet['id'] .'"';

                                            // if ( $BranchSet['id'] == $MessageSet['MessageLocation'] ) :

                                            //     echo ' SELECTED ';

                                            // endif;

                                            echo '>'. strtoupper( $BranchSet['location_name'] ) .'</option>';

                                            endif; endforeach;

                                        ?>
                                    </select>
                                  </div>

                              </div>

                              <div class="col-md-12">    

                                  <div class="mt-3 text-dark font-weight-bold">
                                      Email Address
                                  </div>

                                  <div class="div mt-2 text-dark font-weight-normal">
                                    <input name="EmailAddres" autocomplete="off" type="text" placeholder="Email Address" value="" class="form-control font-sm" />
                                  </div>

                              </div>

                              <div class="col-md-6">    

                                  <div class=" mt-3 text-dark font-weight-bold">
                                      Status
                                  </div>

                                  <div class=" mt-2 text-dark font-weight-normal">

                                      <select name="Status" class="form-control custom-select font-sm font-sm">
                                          <option value="*" > --- SELECT ---</option>
                                          <option value="1">Active</option>
                                          <option value="2">Inactive</option>
                                      </select>

                                  </div>

                              </div>

                              <div class="col-md-6">    
                                &nbsp;
                              </div>

                          </div>
                          
                      </div>

                  </div>

                  <div class="modal-footer">                                                                                   
                      <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                      <button class="font-sm btn-lg btn-primary font-weight-light" type="submit" name="btnSearch"><i class="fa fa-search"></i> Search Accounts</button>                                                                        
                  </div>

              </form>
              
          </div>

      </div>

  </div>

  <div class="modal fade animated animate__animated animate__slideInLeft" id="AddAccount" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <form method="POST" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>/accounts">

                  <div class="modal-header bg-success">
                      <h5 class="modal-title text-white">ADD <strong>ACCOUNT</strong></h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  
                  <div class="modal-body">

                      <div class="form-body text-dark"> 
                      
                          <div class="alert alert-success border-success">
                              Add ALIV user account details using the form below.  The password is set to <strong>123456</strong> by default. The user will be required to reset their password on initial login.
                          </div>

                          <div class="row"> 

                              <div class="col-md-6"> 

                                  <div class="div mt-3 text-dark font-weight-bold">
                                      First Name
                                  </div>

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <input name="FirstName" autocomplete="off" type="text" required placeholder="First Name" value="" class="form-control form-control-lg" />
                                  </div>

                              </div>

                              <div class="col-md-6">            

                                  <div class="div mt-3 text-dark font-weight-bold">
                                      Last Name
                                  </div>

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <input name="LastName" autocomplete="off" type="text" required placeholder="Last Name" value="" class="form-control form-control-lg" />
                                  </div>

                              </div>

                              <div class="col-md-12">    

                                  <div class="mt-3 text-dark font-weight-bold">
                                      Email Address
                                  </div>

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <input name="EmailAddress" autocomplete="off" required type="email" placeholder="Email Address" value="" class="form-control form-control-lg" />                                      
                                  </div>

                              </div>

                              <div class="col-md-6">    

                                  <div class=" mt-3 text-dark font-weight-bold">
                                      Role
                                  </div>

                                  <div class=" mt-2 text-dark font-weight-normal">

                                      <select name="Role" class="form-control form-control-lg custom-select">
                                          <option value="A">Administrator</option>
                                          <option value="O">Agent</option>
                                      </select>

                                  </div>

                              </div>

                              <div class="col-md-6">    

                                  <div class=" mt-3 text-dark font-weight-bold">
                                      Network ID
                                  </div>

                                  <div class=" mt-2 text-dark font-weight-normal">

                                  <input name="LoginID" type="text" required value="" placeholder="Login" class="form-control form-control-lg" />

                                  </div>

                              </div>

                          </div>
                          
                      </div>

                  </div>

                  <div class="modal-footer">                                                                                   
                      <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                      <button class="font-sm btn-lg btn-success font-weight-light" type="submit" name="btnAddAccount"><i class="fa fa-plus"></i>  Add Account</button>                                                  
                      
                  </div>

              </form>
              
          </div>

      </div>

  </div>

</div>

<?php if ( $this->GetEligible['count'] > 0 ) : foreach( $this->GetEligible['data'] as $PlanSet ) : ?>

    <div class="modal fade animated" id="PlanData<?php echo $PlanSet['PlanID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="POST" action="<?php echo gpConfig['URLPATH']; ?>administrator/plans">

                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">RESET <strong>ACCOUNT PASSWORD</strong></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">

                        <div class="form-body text-dark"> 
                        
                            <div class="alert alert-danger border-danger">
                                Are you sure you want to remove this plan from the list of Eligible Plan Mappings
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">                                 
                        <input type="hidden" value="<?php echo $PlanSet['PlanID']; ?>" name="PlanID" />                                                                                           
                        <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                        <button class="font-sm btn-lg btn-danger font-weight-light" type="submit" name="btnRemovePlan"><i class="fa fa-trash"></i>  Remove Plan</button>                                                                          
                    </div>

                </form>
                
            </div>

        </div>

    </div>

<?php endforeach; endif; ?>

 
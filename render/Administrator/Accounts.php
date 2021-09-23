<div class="container-fluid mt-4">

  <div class="animated fadeIn">

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-body"> 

                    <h3>ALIV <strong>BACKEND USER ACCOUNTS</strong></h3>

                    <?php if ( !isset( $this->setMessage ) ) : ?>

                        <div class="alert alert-primary border-primary">
                            <b class="font-weight-normal">View accounts below.</b>
                        </div>                    

                    <?php else: ?>

                        <?php echo $this->setMessage; ?>

                    <?php endif; ?>

                    <button class="font-sm btn-dark btn-lg" type="button" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>administrator'"><i class="fa fa-desktop"></i>&nbsp;Dashboard</button>
                    <button class="font-sm btn-success btn-lg" type="button" data-target="#AddAccount" data-toggle="modal"><i class="fa fa-user-plus"></i>&nbsp;Add ALIV User Account</button>
                    
                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <?php if ( $this->GetAccounts['count'] == 0 ) : ?>

                        <div class="alert alert-warning border-warning">
                            There were no records available.
                        </div>

                    <?php else: ?>

                        <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm">
                            <thead class="thead-light font-weight-normal">
                                <tr>                  
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th class="text-left">Login</th>                  
                                    <th class="text-left">Role</th>                                                                    
                                    <th class="text-left">Email</th>                  
                                    <th class="text-left">Status</th>                                    
                                    <th class="text-left">Task</th>                                    
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach( $this->GetAccounts['data'] as $AccountSet ) : ?>

                                    <tr>
                                        <td>
                                            <div><?php echo $AccountSet['AdminLast'];  ?></div>                    
                                        </td>
                                        <td>
                                            <div><?php echo $AccountSet['AdminFirst']; ?></div>                    
                                        </td>

                                        <td>
                                            <div><?php echo $AccountSet['AdminNetworkID']; ?></div>                    
                                        </td>

                                        <td>
                                            <div><?php

                                                    if ( $AccountSet['AdminRole'] == 'A' ) :

                                                        echo 'Administrator'; 

                                                    elseif ( $AccountSet['AdminRole'] == 'O' ) :

                                                        echo 'Concierge - Order Processing'; 

                                                    elseif ( $AccountSet['AdminRole'] == 'D' ) : 

                                                        echo 'Concierge - Delivery'; 

                                                    endif;
                                                
                                                ?>
                                            </div>                        
                                        </td>

                                        <td>
                                            <div><?php echo $AccountSet['AdminEmail']; ?></div>                    
                                        </td>

                                        <td>
                                            <div><?php echo ( $AccountSet['AdminStatus'] == 'A' ) ? 'Active' : 'Inactive'; ?></div>                    
                                        </td>
                                    
                                        <td class="text-left">     
                                            <i class="fa fa-pencil text-warning" title="Update User Details" style="font-size: 18px" data-target="#UpdateAccount<?php echo $AccountSet['AdminID']?>" data-toggle="modal" ></i>
                                            <!-- &nbsp;
                                            <i class="fa fa-lock text-info" title="Reset Password" style="font-size: 18px" data-target="#ResetPassword<?php echo $AccountSet['AdminID']?>" data-toggle="modal"></i>                                                                     -->
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
                                          <option value="O">Concierge - Backend </option>
                                          <option value="D">Concierge - Delivery </option>                                          
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

<?php if ( $this->GetAccounts['count'] > 0 ) : foreach( $this->GetAccounts['data'] as $AccountSet ) : ?>

    <div class="modal fade animated" id="ResetPassword<?php echo $AccountSet['AdminID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="POST" action="<?php echo gpConfig['URLPATH']; ?>administrator/accounts">

                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-white">RESET <strong>ACCOUNT PASSWORD</strong></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">

                        <div class="form-body text-dark"> 
                        
                            <div class="alert alert-info border-info">
                                Reset the account password using the form below. The default password is <strong>123456</strong>
                            </div>

                            <div class="div mt-3 text-dark font-weight-bold">
                                New Password 
                            </div>

                            <div class="div mt-2 text-dark font-weight-normal">
                                <input name="Password[]" readonly type="password" value="12345678" required placeholder="New Password" class="form-control form-control-lg" />
                            </div>

                            <div class="div mt-3 text-dark font-weight-bold">
                                Confirm Password
                            </div>

                            <div class="div mt-2 text-dark font-weight-normal">
                                <input name="Password[]" readonly type="password" value="12345678" required placeholder="Confirm Password" class="form-control form-control-lg" />
                            </div>
    
                        </div>

                    </div>

                    <div class="modal-footer">                                 
                    <input type="hidden" value="<?php echo $AccountSet['AdminID']; ?>" name="AdminID" />                                                                                           
                        <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                        <button class="font-sm btn-lg btn-info font-weight-light" type="submit" name="btnResetPassword"><i class="fa fa-refresh"></i>  Reset Password</button>                                                                          
                    </div>

                </form>
                
            </div>

        </div>

    </div>

    <div class="modal fade animated" id="UpdateAccount<?php echo $AccountSet['AdminID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="POST" action="<?php echo gpConfig['URLPATH']; ?>administrator/accounts">

                    <div class="modal-header bg-warning">
                        <h4 class="modal-title text-white">UPDATE <strong>ACCOUNT</strong></h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">

                        <div class="form-body text-dark"> 
                        
                            <div class="alert alert-warning border-warning">
                                Update account details using the form below
                            </div>

                            <div class="row"> 

                                <div class="col-md-6"> 

                                    <div class="div mt-3 text-dark font-weight-bold">
                                        First Name
                                    </div>

                                    <div class="div mt-2 text-dark font-weight-normal">
                                        <input name="FirstName" autocomplete="off" type="text" required value="<?php echo $AccountSet['AdminFirst']; ?>" class="form-control form-control-lg" />
                                    </div>

                                </div>

                                <div class="col-md-6">            

                                    <div class="div mt-3 text-dark font-weight-bold">
                                        Last Name
                                    </div>

                                    <div class="div mt-2 text-dark font-weight-normal">

                                        <input name="LastName" autocomplete="off" type="text" required value="<?php echo $AccountSet['AdminLast']; ?>" class="form-control form-control-lg" />

                                    </div>

                                </div>

                                <div class="col-md-12">    

                                    <div class="mt-3 text-dark font-weight-bold">
                                        Email Address
                                    </div>

                                    <div class="div mt-2 text-dark font-weight-normal">

                                        <input name="EmailAddress" autocomplete="off"  type="email" required value="<?php echo $AccountSet['AdminEmail']; ?>" class="form-control form-control-lg" />
                                        <input name="EmailAddressOld" type="hidden" value="<?php echo $AccountSet['AdminEmail']; ?>" />

                                    </div>

                                </div>

                                <div class="col-md-6">    

                                    <div class=" mt-3 text-dark font-weight-bold">
                                        Role
                                    </div>

                                    <div class=" mt-2 text-dark font-weight-normal">

                                        <select name="Role" class="form-control form-control-lg custom-select">
                                            <option value="A" <?php echo ( ( $AccountSet['AdminRole'] == 'A' ) ? 'SELECTED' : NULL ); ?>>Administrator</option>
                                            <option value="O" <?php echo ( ( $AccountSet['AdminRole'] == 'O' ) ? 'SELECTED' : NULL ); ?>>Concierge - Backend</option>
                                            <option value="D" <?php echo ( ( $AccountSet['AdminRole'] == 'D' ) ? 'SELECTED' : NULL ); ?>>Concierge - Delivery</option>
                                        </select>

                                    </div>

                                </div>

                                <div class="col-md-6">    

                                    <div class=" mt-3 text-dark font-weight-bold">
                                        Network ID
                                    </div>

                                    <div class=" mt-2 text-dark font-weight-normal">

                                        <input name="LoginID" type="text" readonly value="<?php echo $AccountSet['AdminNetworkID']; ?>" class="form-control form-control-lg" />
                                        <input name="LoginIDOld" type="hidden" value="<?php echo $AccountSet['AdminNetworkID']; ?>" />

                                    </div>

                                </div>

                                 <div class="col-md-6">    

                                    <div class=" mt-3 text-dark font-weight-bold">
                                        Status
                                    </div>

                                    <div class=" mt-2 text-dark font-weight-normal">

                                        <select name="Status" class="form-control form-control-lg custom-select">
                                            <option value="A" <?php echo ( ( $AccountSet['AdminStatus'] == 'A' ) ? 'SELECTED' : NULL ); ?>>Active</option>
                                            <option value="2" <?php echo ( ( $AccountSet['AdminStatus'] == 'I' ) ? 'SELECTED' : NULL ); ?>>Inactive</option>
                                        </select>

                                    </div>

                                </div>

                            </div>
                            
                        </div>

                    </div>

                    <div class="modal-footer">    
                        <input type="hidden" value="<?php echo $AccountSet['AdminID']; ?>" name="AdminID" />                                                                               
                        <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                        <button class="font-sm btn-lg btn-warning font-weight-light" type="submit" name="btnUpdateAccount"><i class="fa fa-pencil"></i>  Update Account</button>                                                  
                        
                    </div>

                </form>
                
            </div>

        </div>

    </div>

<?php endforeach; endif; ?>

 
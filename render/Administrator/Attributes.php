<div class="container-fluid mt-4">

  <div class="animated fadeIn">

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-body"> 

                    <h3>ALIV <strong>DEVICE ATTRIBUTES</strong></h3>

                    <?php if ( !isset( $this->setMessage ) ) : ?>

                        <div class="alert alert-primary border-primary">
                            <b class="font-weight-normal">View all device attributes below.</b>
                        </div>                    

                    <?php else: ?>

                        <?php echo $this->setMessage; ?>

                    <?php endif; ?>

                    <button class="font-sm btn-dark btn-lg" type="button" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>administrator'"><i class="fa fa-desktop"></i>&nbsp;Dashboard</button>
                    <button class="font-sm btn-warning btn-lg" type="button" onclick="location.href='<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>devices'"><i class="fa fa-mobile-phone"></i>&nbsp;Device Catalog</button>
                    <button class="font-sm btn-success btn-lg" type="button" data-target="#AddAccount" data-toggle="modal"><i class="fa fa-cog"></i>&nbsp;Add Device Attribute(s)</button>
                    
                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <?php if ( $this->GetAttributes['count'] == 0 ) : ?>

                        <div class="alert alert-warning border-warning">
                            There were no device attributes available at this time.
                        </div>

                    <?php else: ?>

                        <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm">
                            <thead class="thead-light font-weight-normal">
                                <tr>                  
                                    <th>Make ( Brand ) </th>
                                    <th>Attribute Name</th>
                                    <th class="text-center">Device Assignments</th>                  
                                    <th class="text-left">Status</th>                                                                    
                                    <th class="text-left">Created</th>                                                      
                                    <th class="text-left">Task</th>                                    
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach( $this->GetAttributes['data'] as $AttrSet ) : ?>

                                    <tr>
                                        <td>
                                            <div><?php echo $AttrSet['MakeName'];  ?></div>                    
                                        </td>
                                        <td>
                                            <div><?php echo $AttrSet['AttributeName']; ?></div>                    
                                        </td>

                                        <td class="text-center">
                                            <div><?php echo $AttrSet['AttributeStatus']; ?></div>                    
                                        </td>

                                        <td>
                                            <div><?php echo ( $AttrSet['AttributeStatus'] == 'A' ) ? 'Active' : 'Inactive'; ?></div>                        
                                        </td>

                                        <td>
                                            <div><?php echo date( 'd-M-Y \a\t h:i a', strtotime( $AttrSet['AttributeCreated'] ) ); ?></div>                    
                                        </td>

                                        <td class="text-left">     
                                            <i class="fa fa-pencil text-warning" title="Update Attribute" style="font-size: 18px" data-target="#UpdateAttribute<?php echo $AttrSet['AttributeID']?>" data-toggle="modal" ></i>                                            
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

              <form method="POST" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>attributes">

                  <div class="modal-header bg-success">
                      <h5 class="modal-title text-white">ADD <strong>DEVICE ATTRIBUTES</strong></h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  
                  <div class="modal-body">

                      <div class="form-body text-dark"> 
                      
                          <div class="alert alert-success border-success">
                              Add Device Attributes using the form below. Please add each new attribute on a separate line.
                          </div>

                          <div class="row"> 

                              <div class="col-md-12"> 
                                    <strong>Select Make ( Brand )</strong>
                              </div>
                              <div class="col-md-12"> 

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <select name="MakeID" class="form-control custom-select">

                                      <?php foreach( $this->GetMakes['data'] as $MakeSet ) : ?>

                                            <option value="<?php echo $MakeSet['MakeID']; ?>"


                                            ><?php echo $MakeSet['MakeName']; ?></option>

                                     <?php endforeach; ?>

                                      </select>
                                  </div>

                              </div>
                              <div class="col-md-12 mt-4"> 

                                <div class=""> 
                                    <strong>Add Device Attributes</strong>
                                </div>

                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <textarea rows="7" name="Attributes" placeholder="Device Attributes" class="form-control"></textarea>
                                  </div>

                              </div>

                          </div>
                          
                      </div>

                  </div>

                  <div class="modal-footer">                                                                                   
                      <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                      <button class="font-sm btn-lg btn-success font-weight-light" type="submit" name="btnAddAttributes"><i class="fa fa-plus"></i>  Add Attribute(s)</button>                                                  
                      
                  </div>

              </form>
              
          </div>

      </div>

  </div>

</div>

<?php if ( $this->GetAttributes['count'] > 0 ) : foreach( $this->GetAttributes['data'] as $AttrSet ) : ?>

    <div class="modal fade animated" id="UpdateAttribute<?php echo $AttrSet['AttributeID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form method="POST" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>attributes">

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-white">UPDATE <strong>ATTRIBUTE DETAILS</strong></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">

                        <div class="form-body text-dark"> 
                        
                            <div class="alert alert-warning border-warning">
                                Enter the Updated Attribute Details using the form below.
                            </div>

                            <div class="div mt-3 text-dark font-weight-bold">
                                Attribute Name
                            </div>

                            <div class="div mt-2 text-dark font-weight-normal">
                                <input name="AttributeName"  type="text" value="<?php echo $AttrSet['AttributeName']; ?>" required placeholder="New Password" class="form-control form-control-lg" />
                                <input name="AttributeNameOld"  type="hidden" value="<?php echo $AttrSet['AttributeName']; ?>" />
                            </div>

                            <div class="div mt-3 text-dark font-weight-bold">
                                Attribute Description
                            </div>

                            <div class="div mt-2 text-dark font-weight-normal">
                                <textarea name="AttributeDescription"  rows="5" placeholder="Attribute Description" class="form-control"></textarea>
                            </div>
    
                            <div class="div mt-3 text-dark font-weight-bold">
                                Attribute Status
                            </div>

                            <div class="div mt-2 text-dark font-weight-normal">
                                <select name="AttributeStatus" class="form-control custom-select">
                                    <option value="A" <?php echo ( ( $AttrSet['AttributeStatus'] == 'A') ? 'SELECTED' : NULL ); ?>>Active</option>
                                    <option value="I" <?php echo ( ( $AttrSet['AttributeStatus'] == 'I') ? 'SELECTED' : NULL ); ?>>Inactive</option>
                                </select>
                            </div>
    
                        </div>

                    </div>

                    <div class="modal-footer">                                 
                        <input type="hidden" value="<?php echo $AttrSet['AttributeID']; ?>" name="AttributeID" />                                                                                           
                        <input type="hidden" value="<?php echo $AttrSet['MakeID']; ?>" name="MakeID" />                                                                                           
                        <button class="font-sm btn-lg btn-dark" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>                                                  
                        <button class="font-sm btn-lg btn-warning" type="submit" name="btnUpdateAttribute"><i class="fa fa-save"></i>  Save Changes</button>                                                                          
                    </div>

                </form>
                
            </div>

        </div>

    </div>


<?php endforeach; endif; ?>

 
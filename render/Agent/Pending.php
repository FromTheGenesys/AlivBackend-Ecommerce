<div class="container-fluid mt-4">

  <div class="animated fadeIn">

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-body"> 

                    <h3>PENDING <strong>ORDERS</strong></h3>

                    <?php if ( !isset( $this->setMessage ) ) : ?>

                        <div class="alert alert-primary border-primary">
                            <b class="font-weight-normal">View all order that have not been assigned for processing.</b>
                        </div>                    

                    <?php else: ?>

                        <?php echo $this->setMessage; ?>

                    <?php endif; ?>

                    <button class="font-sm btn-dark btn-lg" type="button" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>agent'"><i class="fa fa-desktop"></i>&nbsp;Dashboard</button>
                    
                </div>

            </div>

        </div>

    </div>

     <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-body"> 

                    <h4><strong>ORDERS</strong></h4>

                    <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm">
                        <thead class="thead-light font-weight-normal">
                            <tr>                  
                                <th>Order ID</th>
                                <th>Device</th>
                                <th class="text-left">Plan</th>                  
                                <th class="text-left">Accessory</th>                                                                    
                                <th class="text-left">Customer</th>                  
                                <th class="text-right">Order Total</th>                  
                                <th class="text-center">Card Auth</th>                  
                                <th class="text-left">Status</th>                                    
                                <th class="text-left">Task</th>                                    
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach( $this->GetPending['data'] as $PendingSet ) : ?>

                                <tr>
                                    <td>
                                        <div><?php echo $PendingSet['OrderID'];  ?></div>                    
                                    </td>
                                    <td>
                                        <div><?php echo $PendingSet['DeviceName']; ?></div>                    
                                    </td>

                                    <td>
                                        <div><?php echo $PendingSet['PlanName']; ?></div>                    
                                    </td>

                                    <td>
                                        <div><?php echo empty( $PendingSet['AccessoryName'] ) ? '<span class="text-danger"><strong>*** NONE ***</strong></span>' : $PendingSet['AccessoryName']; ?></div>                    
                                    </td>

                                    <td>
                                        <div>
                                            <?php echo $PendingSet['OrderCustLast'] .', '. $PendingSet['OrderCustFirst']; ?>                                
                                        </div>                    
                                    </td>

                                    <td class="text-right">
                                        <div><?php echo number_format( $PendingSet['OrderTotal'], 2 ); ?></div>                    
                                    </td>
                                    <td class="text-center">
                                        <div><?php echo $PendingSet['OrderCardAuth']; ?></div>                    
                                    </td>

                                    <td>
                                        <div><?php echo $this->LogicAgent->OrderStatus( $PendingSet['OrderStatus'] ); ?></div>                    
                                    </td>

                                   

                                    <td>
                                        <button class="btn-lg btn-warning font-sm" type="button" data-target="#Assignment<?php echo $PendingSet['OrderID']; ?>" data-toggle="modal"><i class="fa fa-user"></i> select order</button>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>

                    
                </div>

            </div>

        </div>

    </div>

  </div>

</div>


<?php if ( $this->GetPending['count'] > 0 ) :foreach( $this->GetPending['data'] as $PendingSet ) : ?>

  <div class="modal fade animated animate__animated animate__slideInLeft" id="Assignment<?php echo $PendingSet['OrderID']; ?>" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <form method="POST" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>pending">

                  <div class="modal-header bg-warning">
                      <h5 class="modal-title text-white">SELECT <strong>ORDER</strong></h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  
                  <div class="modal-body">

                      <div class="form-body text-dark"> 
                      
                          <div class="alert alert-warning border-warning">
                              click the accept assignment button to begin processing this order
                          </div>

                          <div class="row"> 

                              <div class="col-md-12 mt-3"> 
                                <strong>sms message</strong>
                              </div>

                              <div class="col-md-12"> 
                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <textarea name="sms" rows="4" placeholder="sms" class="form-control">this message is to inform you that the status of your aliv order #<?php echo $PendingSet['OrderID']; ?> has been updated to processing. thank you for choosing aliv. believe in best.</textarea>
                                  </div>

                              </div>

                              <div class="col-md-12 mt-3"> 
                                <strong>email message</strong>
                              </div>

                              <div class="col-md-12"> 
                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <textarea name="email" rows="4" placeholder="email" class="form-control">this message is to inform you that the status of your aliv order #<?php echo $this->GetOrder['data'][0]['OrderID']; ?> has been updated to processing. thank you for choosing aliv. believe in best.</textarea>
                                  </div>
                              </div>

                          </div>
                          
                      </div>

                  </div>

                  <div class="modal-footer">           
                      <input type="hidden" value="<?php echo $PendingSet['OrderID']; ?>" name="OrderID" />                                                                        
                      <button class="font-sm btn-lg btn-dark font-weight-light" type="button" data-dismiss="modal"><i class="fa fa-close"></i> cancel</button>                                                  
                      <button class="font-sm btn-lg btn-warning font-weight-light" type="submit" name="btnAccept"><i class="fa fa-save"></i>  accept assignment</button>                                                                        
                  </div>

              </form>
              
          </div>

      </div>

  </div>

<?php endforeach; endif; ?>

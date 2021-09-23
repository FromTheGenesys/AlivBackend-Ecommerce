<div class="container-fluid mt-4">

  <div class="animated fadeIn">

    <div class="row">

        <div class="col">

            <div class="card">

                <div class="card-body"> 

                    <h3>MY <strong>ORDERS</strong></h3>

                    <?php if ( !isset( $this->setMessage ) ) : ?>

                        <div class="alert alert-primary border-primary">
                            <b class="font-weight-normal">View all order that you have processed.</b>
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

                            <?php foreach( $this->MyOrders['data'] as $OrderSet ) : ?>

                                <tr>
                                    <td>
                                        <div><?php echo $OrderSet['OrderID'];  ?></div>                    
                                    </td>
                                    <td>
                                        <div><?php echo $OrderSet['DeviceName']; ?></div>                    
                                    </td>

                                    <td>
                                        <div><?php echo $OrderSet['PlanName']; ?></div>                    
                                    </td>

                                    <td>
                                        <div><?php echo empty( $OrderSet['AccessoryName'] ) ? '<span class="text-danger"><strong>*** NONE ***</strong></span>' : $OrderSet['AccessoryName']; ?></div>                    
                                    </td>

                                    <td>
                                        <div>
                                            <?php echo $OrderSet['OrderCustLast'] .', '. $OrderSet['OrderCustFirst']; ?>                                
                                        </div>                    
                                    </td>

                                    <td class="text-right">
                                        <div><?php echo number_format( $OrderSet['OrderTotal'], 2 ); ?></div>                    
                                    </td>
                                    <td class="text-center">
                                        <div><?php echo $OrderSet['OrderCardAuth']; ?></div>                    
                                    </td>

                                    <td>
                                        <div><?php echo $this->LogicAgent->OrderStatus( $OrderSet['OrderStatus'] ); ?></div>                    
                                    </td>

                                   

                                    <td>
                                        <button class="btn-lg btn-warning font-sm" type="button" onclick="location.href='<?php echo gpConfig['URLPATH']; ?>agent/order/<?php echo $OrderSet['OrderGUID']; ?>'"><i class="fa fa-user"></i> view order</button>
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
                                      <textarea name="sms" rows="4" placeholder="sms" class="form-control"></textarea>
                                  </div>

                              </div>

                              <div class="col-md-12 mt-3"> 
                                <strong>email message</strong>
                              </div>

                              <div class="col-md-12"> 
                                  <div class="div mt-2 text-dark font-weight-normal">
                                      <textarea name="email" rows="4" placeholder="email" class="form-control"></textarea>
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

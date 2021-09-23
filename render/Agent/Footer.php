
<div class="modal fadeIn animated" id="ChangeRole" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="POST" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">CHANGE <strong>OPERATOR ROLE</strong></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <div class="modal-body">

                    <div class="form-body text-dark"> 
                        
                        <div class="alert alert-primary border-primary">
                             Click the Confirm Role Change button to switch your current operator role from <strong>Customer Service Representative</strong> to <strong>Senior CSR</strong>.
                        </div>
                        
                    </div>

                </div>

                <div class="modal-footer">                                                                 
                    <button class="btn-lg btn-dark font-sm" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>                                                  
                    <button class="btn-lg btn-primary font-sm" type="submit" name="btnConfirmRoleChange"><i class="fa fa-check"></i> Confirm Role Change</button>                                                  
                </div>

            </form>
            
        </div>

    </div>

</div>

<div class="modal fadeIn animated" id="ChangeBranch" tabindex="-2" role="dialog" aria-labelledby="myCreateFolder" style="display: none;" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <form method="POST" action="<?php echo gpConfig['URLPATH'] . _ACCESS_; ?>">

                  <div class="modal-header bg-primary">
                      <h5 class="modal-title text-white">CHANGE <strong>OPERATOR BRANCH</strong></h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  
                  <div class="modal-body">

                      <div class="form-body text-dark"> 
                          
                          <div class="alert alert-primary border-primary">
                              To change the operator's branch, select an available option from the list below.  CLICK the Confirm Branch Change button to continue
                          </div>

                          <div>

                            <table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm">
                              <thead class="thead-light font-weight-normal">
                                <tr>
                                  <th><i class="fa fa-check text-success"></i></th>
                                  <th>Location</th>                                  
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                    foreach( explode( ',', $_SESSION['sessAcctLocations'] ) as $LocationSet ) :

                                        $timeblocks    =   explode( ',', $this->LogicGlobal->GetLocation( $LocationSet )['data'][0]['location_hours'] ); 

                                        if ( !empty( $this->LogicGlobal->GetLocation( $LocationSet )['data'][0]['location_hours'] ) ) : 

                                            foreach( $timeblocks as $timeBlock ) :

                                                list( $day, $start, $stop )   =  explode( '-', $timeBlock );

                                                if ( $day == date('w') ) :

                                                    $dayMatch   =   true;

                                                    if ( ( $start <= date('H:i:s') ) AND 
                                                        ( $stop >= date('H:i:s') ) ) :

                                                        $timeMatch   =   true;

                                                    endif;

                                                endif;
                                            
                                            endforeach;

                                            // day match if not found
                                            if ( !isset( $dayMatch ) ) 
                                            $dayMatch = false;

                                            // time match if not found
                                            if ( !isset( $timeMatch ) ) 
                                            $timeMatch = false;


                                            if ( ( $dayMatch == true ) AND ( $timeMatch == true ) ) : 

                                                echo '<tr>';
                                                echo '<td>';
                                                echo '<input type="radio" value="'. $LocationSet .'" name="LocationID" '. ( ( $LocationSet == $_SESSION['sessAcctLocation'] ) ? ' CHECKED ' : NULL )  .'  />';
                                                echo '</td>';
                                                echo '<td>';
                                                echo $this->LogicGlobal->GetLocation( $LocationSet )['data'][0]['LocationName'];
                                                echo '&nbsp;';                                          
                                                echo '</td>';
                                                echo '</tr>';

                                            endif;

                                        endif;
                                        
                                    endforeach;

                                ?>
                              </tbody>
                            </table>
                          </div>

                      </div>

                  </div>

                  <div class="modal-footer">                                                                 
                      <button class="btn-lg btn-dark font-sm" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>                                                  
                      <button class="btn-lg btn-primary font-sm" type="submit" name="btnConfirmBranchChange"><i class="fa fa-check"></i> Confirm Branch Change</button>                                                  
                  </div>

              </form>
              
          </div>

      </div>

  </div>



  </div>
  <footer class="app-footer bg-dark text-white font-sm" style="border: 1px solid #000;">
    <span>Copyright © <?php echo date('Y'); ?>. <a class="text-primary" ref="https://www.cashngobahamas.com/" target="_BLANK">Cash N' Go</a></span>
    <span class="ml-auto font-sm">Developed by <a class="text-primary " href="https://www.genesysnow.com/" target="_BLANK">Genesys Now. A Technology Company</a></span>
  </footer>

  <!-- Bootstrap and necessary plugins -->
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/jquery.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>js/inputmask.js"></script>  
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>js/ecommerce.js"></script>  

  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/popper.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/bootstrap.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/pace.min.js"></script>

  <!-- Plugins and scripts required by all views -->
  <!-- <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/Chart.min.js"></script> -->

  <!-- CoreUI Pro main scripts -->

  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>js/app.js"></script>

  <!-- Plugins and scripts required by this views -->
  <!-- <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/toastr.min.js"></script> -->
  <!-- <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/gauge.min.js"></script> -->
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/moment.min.js"></script>
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>vendors/js/daterangepicker.min.js"></script>

  <!-- Custom scripts required by this view -->
  <script src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>js/views/main.js"></script>

</body>
</html>
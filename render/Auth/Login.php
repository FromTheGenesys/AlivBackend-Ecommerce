<div class="row justify-content-center mt-3">
    
  <div class="col-lg-6">  
      
      <div class="card p-2 mt-2 opacity-3 bg-dark">

        <form method="POST" action="<?php echo gpConfig['URLPATH']; ?>auth/login">  

          <div class="card-body">

            <div class="text-center">
              <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/aliv-logo-white.png" class="img-fluid w-25 mb-3">
            </div>

            <?php if ( !isset( $this->setMessage ) ) : ?>

                <div class="alert bg-info border-info text-dark font-weight-normal mt-3">
                  Welcome to <strong>ALIV e-Commerce</strong> Back Office Portal. Please enter your <span class="font-weight-bold">Network ID</span> and <span class="font-weight-bold">Network Password</span> in the spaces provided below.
                </div>

            <?php else: ?>

                <?php echo $this->setMessage; ?>
                <!-- <div class="alert bg-<?php echo $this->setMessage[0]; ?> border-<?php echo $this->setMessage[0]; ?> font-weight-normal">
                    <?php echo $this->  etMessage[1]; ?>
                </div> -->

            <?php endif; ?>

            <div class="mb-3 input-group">
              <input type="text" required autocomplete="off" class="form-control form-control-lg" placeholder="Network ID" autofocus name="NetworkID" value="<?php echo isset( $_POST['btnLogin'] ) ? $_POST['NetworkID'] : NULL; ?>" />
            </div>

            <div class="mb-2 input-group">
              <input type="password" required class="form-control form-control-lg" placeholder="Network Password"  autocomplete="off" name="NetworkPassword" />
            </div>

            <div class="form-actions mt-3 mb-3">
              <button type="submit" class="font-lg btn-info btn-block btn-lg" name="btnLogin" ><i class="fa fa-lock"></i> Login</button>
            </div>

            <div class=" small mt-3 mb-1 text-white text-center">
              Powered by Genesys Now. A Technology Company.
              <br />
              Release: v<?php echo gpVersCfg['VERSION']; ?>
            </div>
                            
          </div>

        </form>

    </div>
    
</div>
    
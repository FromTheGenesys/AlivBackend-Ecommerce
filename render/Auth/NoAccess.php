<div class="row justify-content-center mt-3">
    
  <div class="col-lg-6">  
        
      <div class="text-center">
        <img src="<?php echo gpConfig['URLPATH'] . gpConfig['ASSETS']; ?>img/brand_logo.png" class="img-fluid w-50">
      </div>

      <div class="card bg-white p-2 mt-3">

      <form method="POST" action="<?php echo gpConfig['URLPATH']; ?>auth/logout">  

          <div class="card-body">

            <div class="alert bg-danger border-danger font-weight-normal text-left">
                You are attempting to access a page that is restricted. 
            </div>

            <div class="form-actions mt-3">            
              <?php if ( isset( $_SESSION['SessionIsStarted'] ) ) : ?>
                <button type="button" class="font-sm btn-dark btn-lg" onclick="location.href='<?php echo gpConfig['URLPATH'] . ( ( $_SESSION['sessAcctRole'] == '3') ? 'senior/' : 'csr/' ); ?>'" ><i class="fa fa-home"></i> Go Home</button>
              <?php else: ?>
                <button type="submit" class=" font-sm btn-dark btn-lg" name="btnLogin" ><i class="fa fa-home"></i> Go Home</button>
              <?php endif; ?>
            </div>
                            
          </div>

        </form>

    </div>
    
</div>
    
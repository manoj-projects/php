<?php
require_once("../resources/config.php");
include(TEMPLATE_FRONT . DS . "header.php");
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">
         
		 <?php   include(TEMPLATE_FRONT . DS . "side.php"); ?>
           
           

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                     <?php   include(TEMPLATE_FRONT . DS . "slide.php"); ?>
                    </div>

                </div>

                <div class="row">
<?php
             get_products_in_shop_page() ;
                      ?>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>
		<?php include(TEMPLATE_FRONT . DS . "footer.php");?>
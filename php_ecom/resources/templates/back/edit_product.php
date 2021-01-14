
 <?php update_products(); ?>
 



<div class="col-md-12">

<div class="row">
<h1 class="page-header">
  Edit Product
  <?php display_message(); ?>

</h1>
</div>
               


<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" class="form-control">
       
    </div>


    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="product_description" id="" cols="30" rows="10" class="form-control"></textarea>
    </div>



  



    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="publish" class="btn btn-primary btn-lg" value="Publish">
    </div>


     <!-- Product Categories-->
	   <div class="form-group">

   
        <label for="product-price">Product Price</label>
        <input type="number" name="product_price" class="form-control" size="60">

    </div>


    <div class="form-group">
         <label for="product-title">Product Quantity</label>
          <hr>
       <input type="number" name="product_quantity" class="form-control" size="60">
           
        </select>


</div>





    <!-- Product Brands-->




<!-- Product Tags -->

    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file">
      
    </div>



</aside><!--SIDEBAR-->


    
</form>



                



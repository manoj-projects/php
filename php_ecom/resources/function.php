<?php

$upload_directory = "uploads";

// helper functions


function last_id(){

global $connection;

return mysqli_insert_id($connection);


}

function set_message($msg){

if(!empty($msg)) {

$_SESSION['message'] = $msg;

} else {

$msg = "";


    }


}

function display_message() {

    if(isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }
}

function redirect($location){

return header("Location: $location ");


}

function query($sql)
{
	global $connection;
	
	return mysqli_query($connection,$sql);
}

function confirm($result)
{
	global $connection;
	if(!$result)
	{
	die("Query Failed" . mysqli_error($connection));	
	}
}

function escape_string($string)
{
	global $connection;
	
	return mysqli_real_escape_string($connection,$string);
}

function fetch_array($result)
{
	return mysqli_fetch_array($result);
}


/* **********************************Front End function ************************************** */

function get_categories(){


$query = query("SELECT * FROM categories");
confirm($query);

while($row = fetch_array($query)) {


$categories_links = <<<DELIMETER

<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>


DELIMETER;

echo $categories_links;

     }
}


function get_products_in_shop_page() 
{
	
	$query=query("SELECT * FROM products");
	     confirm($query);
  while($row=fetch_array($query))
  {	  

$product=<<<DELIMETER
  
	       <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="{$row["product_image"]}" alt="">
                            <div class="caption">
                                <h4 class="pull-right">{$row["product_price"]}</h4>
                                <h4><a href="product.html">{$row["product_title"]}</a>
                                </h4>
                                <p>{$row["product_description"]}</p>
                                <a class="btn btn-primary" href="../resources/cart.php?add={$row["product_id"]}">ADD TO CART</a>
						   </div>

                        </div>
                    </div>
DELIMETER;

echo $product;
  }   
                       
}


function get_products_in_cat_page() 
{
	
	$query=query("SELECT * FROM products WHERE product_category_id= ". escape_string($_GET['id']) . " ");
	     confirm($query);
  while($row=fetch_array($query))
  {	  

 $product=<<<DELIMETER
  
	        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3><a>{$row['product_title']}</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?id={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="../resources/item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;

echo $product;
  }   
                       
}


function login_user(){

if(isset($_POST['submit'])){

$username = escape_string($_POST['username']);
$password = escape_string($_POST['password']);

$query = query("SELECT * FROM register WHERE USER = '{$username}' AND PASS = '{$password }' ");
confirm($query);

if(mysqli_num_rows($query) == 0) {

set_message("Your Password or Username are wrong");
redirect("login.php");
} else {

$_SESSION['username'] = $username;
redirect("admin");

         }



    }



}

function send_message() {

    if(isset($_POST['submit'])){ 

        $to          = "manojprabhucivil@gmail.com";
        $from_name   =   $_POST['name'];
        $subject     =   $_POST['subject'];
        $email       =   $_POST['email'];
        $message     =   $_POST['message'];


        $headers = "From: {$from_name} {$email}";


        $result = mail($to, $subject, $message,$headers);

        if(!$result) {
               echo"not";
            
        } else {

           echo"sent";
        }




    }




}

/****************************************admin*****************************************/
function display_image($picture) {

global $upload_directory;

return $upload_directory  . DS . $picture;



}

function get_products_in_admin()
{
	
	$query=query("SELECT * FROM products");
	confirm($query);
	
	while($row=fetch_array($query))
	{
		$product_image = display_image($row['product_image']);
$products=<<<DELIMETER
		
		 <tr>
            <td>{$row["product_id"]}</td>
            <td>{$row["product_title"]}<br>
              <a href="index.php?edit_product&id={$row['product_id']}"><img width='100' src="{$row["product_image"]}" alt=""></a>
            </td>
			<td>{$row["product_category_id"]}</td>
            <td>{$row["product_price"]}</td>
            <td>{$row["product_quantity"]}</td>
			<td><a class="btn btn-danger" href="index.php?delete_product_id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
		
DELIMETER;
		
		echo $products;
		
	}
	
	
	
}


function add_products()
{
	if(isset($_POST["publish"]))
	{
		$title= escape_string($_POST["product_title"]);
		$desc= escape_string($_POST["product_description"]);
		$price= escape_string($_POST["product_price"]);
		$quantity= escape_string($_POST["product_quantity"]);
		$product_image          = escape_string($_FILES['file']['name']);
        $image_temp_location    = escape_string($_FILES['file']['tmp_name']);


		
		
		$query= query("INSERT INTO products(product_title,product_description,product_price,product_quantity,product_image) VALUES('$title','$desc','$price','$quantity','$product_image')");
		if(confirm($query))
		{
			set_message("insert sucessfully");
			redirect("index.php?products");
		}
		
	}
	
}
function update_products()
{
	if(isset($_POST["publish"]))
	{
		$title= escape_string($_POST["product_title"]);
		$desc= escape_string($_POST["product_description"]);
		$price= escape_string($_POST["product_price"]);
		$quantity= escape_string($_POST["product_quantity"]);
		$product_image          = escape_string($_FILES['file']['name']);
        $image_temp_location    = escape_string($_FILES['file']['tmp_name']);


		$query = "UPDATE products SET ";
$query .= "product_title            = '{$title}'        , ";
$query .= "product_price            = '{$price}'        , ";
$query .= "product_description      = '{$desc}'           , ";
$query .= "product_quantity         = '{$quantity}'     , ";
$query .= "product_image            = '{$product_image}'          ";
$query .= "WHERE product_id=" . escape_string($_GET['id']);
		
		$send_update_query = query($query);
confirm($send_update_query);
set_message("Product has been updated");
redirect("index.php?products");
	
	}
	
}
/************************************categories*********************************************/


function show_category_admin()
{
	
	$query = query("SELECT * FROM categories");
	confirm($query);
	
	while($row=fetch_array($query))
	{
$cat =<<<DELIMETER
		 <tr>
            <td>{$row["cat_id"]}</td>
            <td>{$row["cat_title"]}</td>
        </tr>
DELIMETER;
		echo $cat;
		
	}
}

function add_cat()
{
	if(isset($_POST["submit"]))
	{
		$cat_title = $_POST["cat_title"];
	$query=query("INSERT INTO categories(cat_title) values('{$cat_title}') ");
	if(confirm($query));
	{
		echo"Its work";
	}
	
	}
}

/**********************************slides**************************************************/
function get_active_slide(){
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);



    while($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

$slide_active = <<<DELIMETER


 <div class="item active">
    <img class="slide-image" src="http://placehold.it/800x300" alt="">
</div>


DELIMETER;

        echo $slide_active;


    }
}
function get_slides(){

    $query = query("SELECT * FROM slides");
    confirm($query);

    while($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

$slides = <<<DELIMETER
 <div class="item">
    <img class="slide-image" src="http://placehold.it/800x300" alt="">
</div>
DELIMETER;

        echo $slides;


    }


}

?>
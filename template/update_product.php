<?php

$page_title = "Update Product";
include_once "header.php";


echo "<div class='right-button-margin'>";
	echo "<a href='../index.php' class='btn btn-primary pull-right'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Products";
	echo "</a>";
echo "</div>";


$id = $_GET['id'] ?? die('ERROR: missing ID.');


include_once '..\App\Db.php';
include_once '..\App\Models\Products.php';


$database = new \App\Db();
$db = $database->getConnection();


$product = new \App\Models\Products($db);


$product->id = $id;


$product->readOne();


if($_POST){

	$product->name = $_POST['name'];
	$product->price = $_POST['price'];
	$product->description = $_POST['description'];
	$product->category_id = $_POST['category_id'];
	
	if($product->update()){
		echo "<div class=\"alert alert-success alert-dismissable\">";
			echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
			echo "Product was updated.";
    }
    else{
		echo "<div class=\"alert alert-danger alert-dismissable\">";
			echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
			echo "Unable to update product.";
    }
    echo "</div>";
}
?>
	
<form action='update_product.php?id=<?php echo $id; ?>' method='post'>
 
	<table class='table table-hover table-responsive table-bordered'>
	 
		<tr>
			<td>Name</td>
			<td><input type='text' name='name' value='<?php echo $product->name; ?>' class='form-control' required></td>
		</tr>
		 
		<tr>
			<td>Price</td>
			<td><input type='number' name='price' value='<?php echo $product->price; ?>' class='form-control' required></td>
		</tr>
		 
		<tr>
			<td>Description</td>
			<td><textarea name='description' class='form-control'><?php echo $product->description; ?></textarea></td>
		</tr>
		 
		<tr>
			<td>Category</td>
			<td>
				<?php

				include_once '..\App\Models\Categories.php';

				$category = new \App\Models\Categories($db);
				$stmt = $category->read();

				echo "<select class='form-control' name='category_id'>";
				
					echo "<option>Please select...</option>";
					while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row_category);

						if($product->category_id==$id){
							echo "<option value='$id' selected>";
						}else{
							echo "<option value='$id'>";
						}
						
						echo "$name</option>";
					}
				echo "</select>";
				?>
			</td>
		</tr>
		 
		<tr>
			<td></td>
			<td>
				<button type="submit" class="btn btn-primary">
					<span class='glyphicon glyphicon-edit'></span> Update
				</button>
			</td>
		</tr>
		 
	</table>
</form>
             
<?php
include_once "footer.php";
?>
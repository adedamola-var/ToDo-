<?php 

	include('config/db_connect.php');

	// write query for all pizzas
	$sql = 'SELECT comment,id,created_at FROM christmas ORDER BY created_at';

	// get the result set (set of rows)
	$result = mysqli_query($conn, $sql);

	// fetch the resulting rows as an array
	$merry_xmas = mysqli_fetch_all($result, MYSQLI_ASSOC); 

	// free the $result from memory (good practise)
	mysqli_free_result($result);

	// close connection
	mysqli_close($conn);


?>

<?php 

	include('config/db_connect.php');

	if(isset($_POST['delete'])){

		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

		$sql = "DELETE FROM christmas WHERE id = $id_to_delete";

		if(mysqli_query($conn, $sql)){
			header('Location: home1.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}

	// check GET request id param
	if(isset($_GET['id'])){
		
		// escape sql chars
		$id = mysqli_real_escape_string($conn, $_GET['id']);

		// make sql
		$sql = "SELECT * FROM christmas WHERE id = $id";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
		$trans = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

	}

?>


<?php 


include('config/db_connect.php');


$comment = '';
$errors = array('comment' => '');


if(isset($_POST['submit'])){ 

        // check comment
	if(empty($_POST['comment'])){
		$errors['comment'] = 'A comment is required';
	} else{
		$comment = $_POST['comment'];
		if(!preg_match('/^[0-9a-zA-Z\s]+$/', $comment)){
			$errors['comment'] = 'comment must be letters and spaces only';
		}
	}

	if(array_filter($errors)){
			echo 'errors in the form';
		}else{
            
			$comment = mysqli_real_escape_string($conn, $_POST['comment']);
			
            //create sql
            $sql = "INSERT INTO christmas(comment) VALUES('$comment')";

            //save to db and check;
            if(mysqli_query($conn, $sql)){
            	echo "comment submitted successfully";
            	//header('Location: index.php');

            }else {

            	//error
            	echo 'query error:' . mysqli_error($conn);
        }

            
		
		}

	} // end POST check POST check


?>

<body>
	<?php include('header.php'); ?>

	<!-- navbar -->
	<header>
		<nav class="nav-wrapper z-depth-0 transparent">
			<div class="container">
				<a href="#" class="brand-logo purple-text">To Do</a>
				<a href="#" class="sidenav-trigger" data-target="mobile-menu">
					<i class="material-icons purple-text">menu</i>
				</a>
				<ul class="right hide-on-med-and-down purple-text">
					<li><a href="#" class="tooltipped btn-floating btn-small purple darken-4" data-tooltip="Instagram">
						<i class="fab fa-instagram"></i>
					</a></li>
					<li><a href="#" class="tooltipped btn-floating btn-small purple darken-4" data-tooltip="Facebook">
						<i class="fab fa-facebook"></i>
					</a></li>
					<li><a href="#" class="tooltipped btn-floating btn-small purple darken-4"data-tooltip="Twitter">
						<i class="fab fa-twitter"></i>
					</a></li>
					<li><a href="#" class="tooltipped btn-floating btn-small purple darken-4"data-tooltip="snapchat">
						<i class="fab fa-snapchat"></i>
					</a></li>
					<li><a href="#" class="tooltipped btn-floating btn-small purple darken-4"data-tooltip="linkedIn">
						<i class="fab fa-linkedin"></i>
					</a></li>


				</ul>
				<ul class="sidenav white lighten-2" id="mobile-menu">
					<li><a href="#" class="purple-text">Products</a></li>
					<li><a href="#photo's" class="purple-text">About Us</a></li>
					<li><a href="#" class="purple-text">Contact</a></li>
				</ul>
			</div>
		</nav>
		<form class="" action="home1.php" method="POST">
		<div class="row hide-on-med-and-down">
			<div class="col l6 push-l2">
				<input class="search-icon purple-text" type="text" name="comment"placeholder="Enter a new task" value="<?php echo htmlspecialchars($comment) ?>">
				<div class="red-text"><?php echo $errors['comment']; ?></div>
				<div class="center section">
				<input type="submit" name="submit" value="Submit" class="btn brand purple z-depth-2">
			</div>
			</div>
		</div>
	</form>
     
     <form class="" action="home1.php" method="POST">
	 <div class="row hide-on-large-only">
			<div class="col s12 m12">
				<input class="search-icon purple-text" type="text" name="comment"placeholder="Enter a new task" value="<?php echo htmlspecialchars($comment) ?>">
				<div class="red-text"><?php echo $errors['comment']; ?></div>
				<div class="center section">
				<input type="submit" name="submit" value="Submit" class="btn brand purple z-depth-2">
			</div>
			</div>
		</div>
	</form>
	<div class="container">
		<div class="row">

			<?php foreach($merry_xmas as $merry): ?>

				<div class="col s12 m4 l8 push-l3">
					
							<h6 style="color: blue;">1.  Total number of task:  <?php echo htmlspecialchars($merry['id']); ?></h6>
							<h6 style="color:red;">2. <?php echo htmlspecialchars($merry['comment']); ?></h6>
							<h6 style="color: blue">3.  Created at:  <?php echo htmlspecialchars($merry['created_at']); ?></h6>
							
						</div>
						<div class="row">
							<div class="col">
						
							<!-- DELETE FORM -->
				<form action="home1.php" method="POST">
				<div class="row">
				<div class="col push-s5 push-l5">
				<input type="hidden" name="id_to_delete" value="<?php echo $merry['id']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0 red">
				
			</div>
		</div>
			</form>
						</div>
						
						</div>
			

			<?php endforeach; ?>

		</div>
	</div>


	</header>

	

	<!-- Compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

	<script>
		$(document).ready(function(){

			$('.sidenav').sidenav();
			$('.materialboxed').materialbox();
			$('.parallax').parallax();
			$('.tabs').tabs();
			$('.datepicker').datepicker({
				disableWeekends: true
			})
			$('.tooltipped').tooltip();
			$('.scrollspy').scrollSpy();
		});
	</script>
</body>
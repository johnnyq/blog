<?php

include("config.php");
include("check_login.php");
include("header.php");
include("nav.php");

$query = mysqli_query($db_conn,"SELECT * FROM users");

?>

<h1>Users</h1>

<hr>

<a href="add_user.php" class="btn btn-primary float-right mb-3">Add User</a>

<div class="table-responsive">

	<table class="table border">
		<thead class="thead-light">
			<tr>
				<th>Email</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			
			<?php 

			while($row = mysqli_fetch_array($query)){
			
			$user_id = $row['user_id'];
			$email = $row['user_email'];
			
			?>
			
			<tr>	
				<td>
					<a href="edit_user.php?user_id=<?php echo $user_id; ?>">
						<?php echo $email; ?>
					</a>
				</td>
			 	<td class="text-center">
				 	<a href="post.php?delete_user=<?php echo $user_id; ?>" class="btn btn-outline-secondary">Delete</a>
				 	</div>
			 	</td>
			</tr>
			
			<?php 
			
			} 

			?>
		
		</tbody>
	</table>

</div>

<?php 

include("footer.php");

?>
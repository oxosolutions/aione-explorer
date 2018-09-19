<?php 
$page_title="View Profile";
include('templates/html-start.php');
$userInfo = $user->getInfo();
$userDetails = $user->getDetails();
?>
<section class="view-profile mb-20">
	<div class="aione-table">
		<table class="wide"> 
	    	<tbody>
	    			<tr>
	    				<td>User ID</td>
	    				<td><?php echo $userInfo['user_id']; ?></td>
	    			</tr>	
	 				<tr>
	    				<td>Email</td>
	    				<td><?php echo $userInfo['email']; ?></td>
	    			</tr>	
	 				<tr>
	    				<td>Username</td>
	    				<td><?php echo $userInfo['username']; ?></td>
	    			</tr>	
	 				<tr>
	    				<td>Confirmed</td>
	    				<td><?php echo $userInfo['confirmed']; ?></td>
	    			</tr>	
	 				<tr>
	    				<td>Register Date</td>
	    				<td><?php echo $userInfo['register_date']; ?></td>
	    			</tr>	
	 				<tr>
	    				<td>User Role</td>
	    				<td><?php echo $userInfo['user_role']; ?></td>
	    			</tr>	
	 				<tr>
	    				<td>Last Login</td>
	    				<td><?php echo $userInfo['last_login']; ?></td>
	    			</tr>
	    			<tr>
	    				<td>First Name</td>
	    				<td><?php echo $userDetails['first_name']; ?></td>
	    			</tr>
	    			<tr>
	    				<td>Last Name</td>
	    				<td><?php echo $userDetails['last_name']; ?></td>
	    			</tr>
	    			<tr>
	    				<td>Address</td>
	    				<td><?php echo $userDetails['address']; ?></td>
	    			</tr>
	    			<tr>
	    				<td>Phone</td>
	    				<td><?php echo $userDetails['phone']; ?></td>
	    			</tr>	
	 				
	    		
	    	</tbody>
	    </table>
	</div>
   
</section>


<!-- .aione-row -->
<?php include('templates/html-end.php'); ?>
                              

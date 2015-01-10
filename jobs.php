<?php
/*
 * Template Name: Jobs
 * Description: Jobs Page
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';
?>

<body>
	<div class="row">
		<div class="col-md-6">
			<h1>For Members</h1>
			<p>Log in to search for jobs</p>
			<form>
				First Name 
		 		<input type="text" name="firstname">
		 		<br>
		 		<br>
		 		Last Name
		 		<input type="text" name="lastname">
		 		<br>
		 		<br>
				Birthday
		 		<input type="date" name="bday">
		 		<br>
		 		<br>
		 		<input type="submit" value="Submit">
		 	</form>
		</div>
		<div class="col-md-6">
			<h1>For Businesses</h1>
		</div>
	</div>		
</body>

<?php if (have_posts()){ ?>
	
		<?php while (have_posts()) : the_post()?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	
	<?php }else {
		echo 'Page Canvas For Page Builder'; 
	}?>

<?php get_footer();?>
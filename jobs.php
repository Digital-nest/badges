<?php
/*
 * Template Name: Jobs
 * Description: Jobs Page
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';
?>

<!--
<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
-->

<style>
	input[type="radio"] {
	-webkit-appearance: radio;
	}
	input[type="checkbox"] {
		-webkit-appearance: checkbox;
	}
	select::-ms-expand {
		display: inline;
	}

</style>

<section id="blog">
<input type="checkbox" name="test" value="test"> test <br>
	<div class="row">
		<div class="col-md-6">
			<h1>For Members</h1>
			<p>Log in below to review current job listings:</p>
			<br> 
			<form method="link" action="http://digitalnest.org/jobs/job-opportunities/">
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
			<p>
				Are you looking for inspired individuals with technical skills?
				If so, please fill out the project request form below.
			</p>
			<br>
			<form action ="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				Business:
				<input type="text" name="bname">
				<br>
				<br>
				Name:
				<input type="text" name="usrname">
				<br>
				<br>
				Phone Number:
				<input type="tel" name="usrtel">
				Email:
				<input type="email" name="usremail">
				<br>
				<br>
				Location:
				<input type="text" name ="location">
				<br>
				<br>
				Need:
				<input type="text" name="need">
				<br>
				<br>
				Description:
				<input type="text" name="description">
				<br>
				<br>
				Area of Expertise:
				<br>
				<?php
					$dn_categories = dn_get_categories();
					foreach ($dn_categories as $category):
				?>
				<input type="radio" name="categories" value="category">
				<?php echo $category->name ?>
				<br>
				<?php endforeach; ?>
				
				<br>
				Skills Needed:
				<br>
				<?php
				    $dn_skills = dn_get_skills();
					foreach ($dn_skills as $skill):
				?>					
				<input type="checkbox" name="skills" value="skill" style="border:5px;width:20px;height20px;"/>
				<?php echo $skill->name ?>
				<br>
				<?php endforeach; ?>
				<br>		
				Duration:
				<table>
					<?php
						for($i = 0; $i < 2; $i++):
					?>		
					<tr>
						<td>
							<select>
								<option value="month">Month</option>
								<option value="month">January</option>
								<option value="month">February</option>
								<option value="month">March</option>
								<option value="month">April</option>
								<option value="month">May</option>
								<option value="month">June</option>
								<option value="month">July</option>
								<option value="month">August</option>
								<option value="month">September</option>
								<option value="month">October</option>
								<option value="month">November</option>
								<option value="month">December</option>
							</select>
						</td>
						<td>
							<select>
								<option value="date">Date</option>
								<?php
									for($date = 1; $date <= 31; $date++):
								?>
								<option value="date">
									<?php echo $date ?>
								</option>
								<?php endfor; ?>  
							</select>
						</td>
						<td>
							<select>
								<option value="year">Year</option>
								<option value="year">2015</option>
								<option value="year">2016</option>
							</select>
						</td>
					</tr>
					<?php endfor; ?>
				</table>
					
				<br>
				<input type="submit" value="Submit">
				<input type="hidden" name="action" value="submit_job">
			</form>
			

		</div>
	</div>		
</section>

<?php if (have_posts()){ ?>
	
		<?php while (have_posts()) : the_post()?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	
	<?php }else {
		echo 'Page Canvas For Page Builder'; 
	}?>

<?php get_footer();?>
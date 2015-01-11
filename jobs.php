<?php
/*
 * Template Name: Jobs
 * Description: Jobs Page
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';
?>

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
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1>For Members</h1>
				<p>Log in below to review current job listings:</p>
				<br> 
				<form method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
					<div class="form-group">
						<label for="firstname">First Name</label>
				 		<input id="firstname" class="form-control" type="text" name="firstname">
				 	</div>
				 	<div class="form-group">
				 		<label for="lastname">Last Name</label>
				 		<input id="lastname" class="form-control" type="text" name="lastname">
				 	</div>
				 	<div class="form-group">
				 		<label for="bday">Birthday</label>
				 		<input id="bday" class="form-control" type="text" name="bday">
	                </div>
	                <div class="form-group">
	                	<input type="hidden" name="action" value="login_job">
	                	<input class="btn btn-default" type="submit" value="Submit">
	                </div>
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
					<div class="form-group">
						<label for="bname">Business:</label>
						<input class="form-control" id="bname" type="text" name="bname">
					</div>
					<div class="form-group">
						<label for="usrname">Name:</label>
						<input class="form-control" id="usrname" type="text" name="usrname">
					</div>
					<div class="form-group">
						<label for="usrtel">Phone Number:</label>
						<input class="form-control" id="usrtel" type="text" name="usrtel">
					</div>
					<div class="form-group">
						<label for="usremail">Email:</label>
						<input class="form-control" id="usremail" type="text" name="usremail">
					</div>
					<div class="form-group">
						<label for="location">Location:</label>
						<input class="form-control" id="location" type="text" name ="location">
					</div>
					<div class="form-group">
						<label for="need">Need:</label>
						<input class="form-control" id="need" type="text" name="need">
					</div>
					<div class="form-group">
						<label for="description">Description:</label>
						<input class="form-control" id="description" type="text" name="description">
					</div>
					<div class="form-group">
						<label for="category">Area of Expertise:</label>
						<?php
							$dn_categories = dn_get_categories();
							foreach ($dn_categories as $category):
						?>
						<div id="category" class="radio">
							<label for="category_<?php echo $category->id ?>"><?php echo $category->name ?></label>
							<input id="category_<?php echo $category->id ?>" type="radio" name="category" value="<?php echo $category->id ?>">	
						</div>
						<?php endforeach; ?>
					</div>
					<div class="form-group">
						<label for="skill-checkbox">Skills Needed:</label>
						<?php
						    $dn_skills = dn_get_skills();
							foreach ($dn_skills as $skill):
						?>
						<div id="skill-checkbox" class="checkbox">
							<label for="skill_<?php echo $skill->id ?>"><?php echo $skill->name ?></label>
							<input id="skill_<?php echo $skill->id ?>" type="checkbox" name="skill_<?php echo $skill->id ?>"/>
						</div>
						<?php endforeach; ?>
					</div>	
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
					<input class="btn btn-default" type="submit" value="Submit">
					<input type="hidden" name="action" value="submit_job">
				</form>
			</div>
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
<?php
/*
 * Template Name: Jobs for Members
 * Description: A Page Template with a Page Builder design.
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';

$id = $_GET['category'];

global $wpdb;

$category_name = dn_get_category_name($id);
$category_jobs = dn_get_category_jobs($id);
?>
<section id="blog">
<div class="container">

	<h1><?php echo dn_get_category_name($id);?></h1>
    <hr width="50%" align="left">
    
    
    <?php foreach ($category_jobs as $job): ?>
    
	<h3>...</h3>
	
	<h4>Contact Info</u>
    <hr width="20%" align="left">
    
     <div class="row">
       <div class="col-sm-6">
       <h4>Business:&nbsp;</h4>   
       <?php echo $job['business_name']?>
    </div>
       <div class="col-sm-6">
       <h4>Name:&nbsp;</h4>
       <?php echo $job['contact_name'] ?>
        </div>
    </div>
   
    <div class="row">
       <div class="col-sm-6">
       <h4>Email:&nbsp;</h4>
       <?php echo $job['contact_email']?>
    </div>   
    <div class="col-sm-6">
       <h4>Phone Number:&nbsp;</h4> 
       <?php echo $job['contact_phone']?>  
    </div>
    </div>
    
    <div class="row">
       <div class="col-sm-6">
       <h4>Duration of Employment:&nbsp;</h4>   
       <?php echo $job['duration']?>
    </div>
       <div class="col-sm-6">
       <h4>Paid:&nbsp;</h4>
       <?php if ($job['paid']){
                 echo 'Yes';
        	} else {
        	    echo 'No';
        	}
       ?>
        </div>
    </div>
        
    <h4>Description:&nbsp;</h4>   
    <?php echo $job['description']?>
    <h4>Need:&nbsp;</h4>
    <?php echo $job['need']?>  
    
    <h4>Skills Needed:&nbsp</h4>
    <ul>
    <?php foreach (dn_get_job_skills($id) as $skill): ?>
       <li><?php echo $skill['name']; ?>
    <?php endforeach ?>
    </ul> 
    <?php endforeach; ?>
</div>
</section>
<?php get_footer();?>
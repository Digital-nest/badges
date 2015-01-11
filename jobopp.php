<?php
/*
 * Template Name: Job Opportunities
 * Description: Job Opportunties subpage of Jobs
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';
?>

<section id="blog">
	<p>Click on the following area of expertise for job listings:</p>
	<br>
        <?php
		$dn_categories = dn_get_categories();
		foreach ($dn_categories as $category):
        ?>
        
	<a href="/jobs-for-members/?category=<?php echo $category->id ?>"><?php echo $category->name?></a>
        
	<br>
        <?php endforeach; ?>
</section>



<?php if (have_posts()){ ?>
	
		<?php while (have_posts()) : the_post()?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	
	<?php }else {
		echo 'Page Canvas For Page Builder'; 
	}?>

<?php get_footer();?>

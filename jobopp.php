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
	<!-- Update links -->
	<a href="digitalnest.org">Video Production</a>
	<br>
	<a href="digitalnest.org">App Development</a>
	<br>
	<a href="digitalnest.org">Web Design</a>
	<br>
</section>



<?php if (have_posts()){ ?>
	
		<?php while (have_posts()) : the_post()?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	
	<?php }else {
		echo 'Page Canvas For Page Builder'; 
	}?>

<?php get_footer();?>
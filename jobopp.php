<?php
/*
 * Template Name: Canvas
 * Description: A Page Template with a Page Builder design.
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';
?>

<section id="blog">
	<p>Click on the following area of expertise for job listings:<p>
	<br>
	<a href="">Video Production</a>
	<a href="">App Development</a>
	<a href="">Web Design</a>
</section>



<?php if (have_posts()){ ?>
	
		<?php while (have_posts()) : the_post()?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	
	<?php }else {
		echo 'Page Canvas For Page Builder'; 
	}?>

<?php get_footer();?>
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
	<div class="container">
	<h1>Job Opportunities</h1>
	<p>Click on the following area of expertise for job listings:</p>
	<ul>
        <?php foreach (dn_get_categories() as $category): ?>
    	<li>
			<a href="/jobs-for-members/?category=<?php echo $category->id ?>"><?php echo $category->name?></a>
		</li>
        <?php endforeach; ?>
    </ul>
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

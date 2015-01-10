<?php
/*
 * Template Name: Jobs-Management
 * Description: The template for the internal management page for jobs.
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';
?>

<h1>Manage Jobs</h1>

<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

    jQuery(document).ready(function($) {
        $.post(ajaxurl, {'action': 'submit_job'})
            .done(function(data) {
                console.log(data);
            });
    });
</script>

<?php

    $jobs = dn_get_all_jobs();

    foreach ($jobs as $job) {
        echo $job->business_name;
    }
?>

<div class="row">
    <div class="col-md-6">

    </div>
    <div class="col-md-6">

    </div>
</div>

<?php get_footer();?>
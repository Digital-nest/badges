<?php
/*
 * Template Name: Jobs-Management
 * Description: The template for the internal management page for jobs.
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';

$jobs = dn_get_unapproved_jobs();

?>

<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    console.log(ajaxurl)

    function submit_job() {
        //jQuery(document).ready(function($) {
        $.post(ajaxurl, {'action': 'submit_job'})
            .done(function(data) {
                console.log(data);
            });
        //});
    }

</script>

<section id="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Manage Jobs</h1>
                <label>
                <input type="checkbox">Label</label>
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Contact Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?php echo $job->business_name; ?></td>
                        <td><?php echo $job->name; ?></td>
                        <td><?php echo $job->email; ?></td>
                        <td><?php echo $job->phone; ?></td>
                        <td><?php echo $job->description; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                </table>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</section>

<?php get_footer();?>
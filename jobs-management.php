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
    jQuery(document).ready(function($) {
        
    });

</script>

<section id="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Manage Jobs</h1>
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Contact Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Duration</th>
                        <th>Category</th>
                        <th>Need</th>
                        <th>Skills</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr data-value="<?php echo $job['id']; ?>">
                        <td><?php echo $job['business_name']; ?></td>
                        <td><?php echo $job['contact_name']; ?></td>
                        <td><?php echo $job['contact_email']; ?></td>
                        <td><?php echo $job['contact_phone']; ?></td>
                        <td><?php echo $job['duration']; ?></td>
                        <td><?php echo $job['name']; ?></td>
                        <td><?php echo $job['need']; ?></td>
                        <td><?php echo $job['skills'][0]['name']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h3>Business Name</h3>
                <dl>
                    <li>contact name</li>
                    <li>contact email</li>
                    <li>contact phone</li>
                    <li>duration</li>
                    <li>need</li>
                    <li>category</li>
                    <li>skills</li>
                </dl>
                <h4>Description</h4>
                <p>
                    fjdkljfdslakfjskl
                </p>
                <form action="<?php echo admin_url('admin-ajax.php'); ?>">
                    <input type="hidden" name="action" value="approve_job">
                    <input type="submit" value="Approve">
                </form>
                <form action="<?php echo admin_url('admin-ajax.php'); ?>">
                    <input type="hidden" name="action" value="reject_job">
                    <input type="submit" value="Reject">
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer();?>
<?php
/*
 * Template Name: Jobs-Management
 * Description: The template for the internal management page for jobs.
 */
get_header('home');
global $smof_data;
$textdoimain = 'brizzz';

$jobs = dn_get_unapproved_jobs();

$id = $_GET['category'];
$category_name = dn_get_category_name($id);

?>

<?php echo 'Video Production' . 'dsjjfksdj' . $id ?>

<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

    var job_data = {
    <?php foreach ($jobs as $job): ?>
        "<?php echo $job['id']; ?>": {
            "business_name" : "<?php echo $job['business_name']; ?>",
            "contact_name" : "<?php echo $job['contact_name']; ?>",
            "contact_email" : "<?php echo $job['contact_email']; ?>",
            "contact_phone" : "<?php echo $job['contact_phone']; ?>",
            "duration" : "<?php echo $job['duration']; ?>",
            "description" : "<?php echo $job['description']; ?>",
            "category_name" : "<?php echo $job['name']; ?>",
            "needs" : "<?php echo $job['need']; ?>",
            "skills" : "<?php echo $job['skills'][0]['name']; ?>",
        },
    <?php endforeach; ?>
    };

    function show_detail(id) {
        var job = job_data[id];

        // clear all active rows
        jQuery("tr.warning").removeClass("warning");

        jQuery("#row-" + id).addClass("warning");
        jQuery("#detail-business-name").text(job["business_name"]);
        jQuery("#detail-contact-name").text(job["contact_name"]);
        jQuery("#detail-contact-email").text(job["contact_email"]);
        jQuery("#detail-contact-phone").text(job["contact_phone"]);
        jQuery("#detail-duration").text(job["duration"]);
        jQuery("#detail-need").text(job["need"]);
        jQuery("#detail-category").text(job["category_name"]);
        jQuery("#detail-skills").text(job["skills"]);
        jQuery("#detail-description").text(job["description"]);
    }

</script>

<section id="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h1>Details</h1>
                <h3 id="detail-business-name">Select a Job From the Table</h3>
                <dl class="dl-horizontal">
                    <dt>Contact Name</dt><dd id="detail-contact-name"></dd>
                    <dt>Contact Email</dt><dd id="detail-contact-email"></dd>
                    <dt>Contact Phone</dt><dd id="detail-contact-phone"></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Duration</dt><dd id="detail-duration"></dd>
                    <dt>Need</dt><dd id="detail-need"></dd>
                    <dt>Category</dt><dd id="detail-category"></dd>
                    <dt>Skills</dt><dd id="detail-skills"></dd>
                </dl>
                <h5>Description</h5>
                <p id="detail-description"></p>
                <form action="<?php echo admin_url('admin-ajax.php'); ?>">
                    <input type="hidden" name="action" value="approve_job">
                    <input type="submit" value="Approve">
                </form>
                <form action="<?php echo admin_url('admin-ajax.php'); ?>">
                    <input type="hidden" name="action" value="reject_job">
                    <input type="submit" value="Reject">
                </form>
            </div>
            <div class="col-md-8">
                <h1>Manage Jobs</h1>
                <table class="table">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Contact Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Duration</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr id="row-<?php echo $job['id']; ?>" onclick="show_detail(<?php echo $job['id']; ?>)">
                        <td><?php echo $job['business_name']; ?></td>
                        <td><?php echo $job['contact_name']; ?></td>
                        <td><?php echo $job['contact_email']; ?></td>
                        <td><?php echo $job['contact_phone']; ?></td>
                        <td><?php echo $job['duration']; ?></td>
                        <td><?php echo $job['name']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php get_footer();?>
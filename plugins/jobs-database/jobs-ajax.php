<?php

require_once 'jobs-common.php';

add_action('wp_ajax_submit_job', 'dn_ajax_submit_job');
add_action('wp_ajax_approve_job', 'dn_ajax_approve_job');
add_action('wp_ajax_reject_job', 'dn_ajax_reject_job');

/*
    dn_ajax_submit_job

    bname
    usrname
    usrtel
    usremail
    location
    need
    description

    Should take job and add it to the database.
    Should rate limit posts.
*/
function dn_ajax_submit_job() {
    global $wpdb;
    $job_table_name = dn_job_table_name();

    echo 'Submitting Job...';

    $wpdb->insert($job_table_name, array(
        'business_name' => $_POST['bname'],
        'location' => $_POST['location'],
        'category' => 1,
        'contact_name' => $_POST['usrname'],
        'contact_email' => $_POST['usremail'],
        'contact_phone' => $_POST['usrtel'],
        'description' => $_POST['description'],
        'duration' => 'dsfafsfdsa',
        'need' => $_POST['need'],
        'duration' => 'one month'
    ));

    //also needs to submit skills

    wp_redirect('/jobs/business-submission-acknowledgement?submitted=true');
    wp_die();
}

/*
    dn_ajax_approve_job

    Approves a job.
*/
function dn_ajax_approve_job() {
    global $wpdb;
    
    //$query = 

    echo 'Approval successful';
    wp_die();
}

/*
    dn_ajax_reject_job

    Rejects a job.
*/
function dn_ajax_reject_job() {
    global $wpdb;
    
    //$query = 

    echo 'Rejection successful';
    wp_die();
}
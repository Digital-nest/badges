<?php
/**
 * Plugin Name: Jobs Database
 * Plugin URI: http://nada
 * Description: A plugin to manage the jobs database.
 * Version: 1.0.0
 * Author: Name of the plugin author
 * Author URI: http://URI_Of_The_Plugin_Author
 * Text Domain: Optional. Plugin's text domain for localization. Example: mytextdomain
 * Domain Path: Optional. Plugin's relative directory path to .mo files. Example: /locale/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: A short license name. Example: GPL2
 */

add_action('wp_ajax_submit_job', 'dn_ajax_submit_job');
add_action('wp_ajax_approve_job', 'dn_ajax_approve_job');
add_action('wp_ajax_reject_job', 'dn_ajax_reject_job');
register_activation_hook( __FILE__, 'dn_create_database' );
register_activation_hook( __FILE__, 'dn_create_mock_data' );

function dn_job_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'dn_jobs';
}

function dn_job_skills_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'dn_job_skills';
}

function dn_category_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'dn_categories';
}

function dn_skill_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'dn_skills';
}

/*
    dn_create_database

    Creates database and adds mock data.
*/
function dn_create_database() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $job_table_name = dn_job_table_name();
    $category_table_name = dn_category_table_name();
    $skill_table_name = dn_skill_table_name();
    $job_skill_table_name = dn_job_skills_table_name();

    // Creates the category table
    $category_table_sql = "CREATE TABLE $category_table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      name varchar(128) NOT NULL,
      description text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    // Creates the main job listing table
    $job_table_sql = "CREATE TABLE $job_table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      business_name varchar(128) NOT NULL,
      location varchar(128) DEFAULT '' NOT NULL,
      contact_name varchar(128) DEFAULT '' NOT NULL,
      contact_email varchar(256) DEFAULT '' NOT NULL,
      contact_phone varchar(32) DEFAULT '' NOT NULL,
      duration varchar(128) DEFAULT 'duration placeholder' NOT NULL,
      category mediumint(9) NOT NULL REFERENCES $category_table_name(id),
      paid bool DEFAULT 0 NOT NULL,
      approved bool DEFAULT 0 NOT NULL,
      need text DEFAULT '' NOT NULL,
      description text DEFAULT '' NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    // Creates the skill table
    $skill_table_sql = "CREATE TABLE $skill_table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      name varchar(128) NOT NULL,
      description text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    // Creates the job <-> skill table
    $job_skill_table_sql = "CREATE TABLE $job_skill_table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      job_id mediumint(9) NOT NULL REFERENCES $job_table_name(id) ON DELETE CASCADE,
      skill_id mediumint(9) NOT NULL REFERENCES $skill_table_name(id) ON DELETE CASCADE,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $job_table_sql );
    dbDelta( $category_table_sql );
    dbDelta( $skill_table_sql );
    dbDelta( $job_skill_table_sql );
}

function dn_create_mock_data() {
    global $wpdb;
    $job_table_name = dn_job_table_name();
    $job_skill_table_name = dn_job_skills_table_name();

    foreach (range(0, 5) as $index) {
        $wpdb->insert($job_table_name, array(
            'business_name' => "Business $index",
            'location' => 'sample location',
            'category' => 1,
            'contact_name' => 'Herp Derp',
            'contact_email' => 'example@example.com',
            'contact_phone' => '1-123-456-7890',
            'need' => 'example need',
            'description' => "This is an example description for $index",
            'duration' => 'one month'
        ));
        $id = $wpdb->insert_id;

        // mock skills
        $wpdb->insert($job_skill_table_name, array(
            'job_id' => $id,
            'skill_id' => 1
        ));
        $wpdb->insert($job_skill_table_name, array(
            'job_id' => $id,
            'skill_id' => 2
        ));
    }
}

function dn_get_categories() {
    global $wpdb;
    $table_name = dn_category_table_name();

    $query = "SELECT * from $table_name";
    $results = $wpdb->get_results($query);

    return $results;
}

function dn_get_skills() {
    global $wpdb;
    $table_name = dn_skill_table_name();

    $query = "SELECT * from $table_name";
    $results = $wpdb->get_results($query);

    return $results;
}

function dn_get_job_skills($job_id) {
    global $wpdb;
    $skill_table_name = dn_skill_table_name();
    $job_skill_table_name = dn_job_skills_table_name();

    $query = "
        SELECT skill.id, skill.name
        FROM $job_skill_table_name AS job_skill
        JOIN $skill_table_name AS skill
        WHERE job_skill.job_id = $job_id
        AND job_skill.skill_id = skill.id
    ";
    $skills = $wpdb->get_results($query, ARRAY_A);
    return $skills;
}

function dn_get_all_jobs($approved) {
    global $wpdb;
    $job_table_name = dn_job_table_name();
    $category_table_name = dn_category_table_name();

    $approved_text = $approved ? 1 : 0;
    $query = "
        SELECT job.id,
               job.business_name, 
               job.contact_name,
               job.contact_phone,
               job.contact_email,
               job.duration,
               job.description,
               category.name
        FROM $job_table_name AS job
        JOIN $category_table_name AS category
        WHERE job.category = category.id
        AND job.approved = $approved_text
    ";
    $results = $wpdb->get_results($query, ARRAY_A);

    foreach ($results as $key => &$result) {
        $result['skills'] = dn_get_job_skills($result['id']);
    }

    return $results;
}

function dn_get_approved_jobs() {
    return dn_get_all_jobs(true);
}

function dn_get_unapproved_jobs() {
    return dn_get_all_jobs(false);
}

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
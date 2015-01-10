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
register_activation_hook( __FILE__, 'dn_create_database' );
register_activation_hook( __FILE__, 'dn_create_mock_data' );

function dn_job_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'job_requests';
}

function dn_category_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'job_categories';
}

function dn_skill_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'job_skills';
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

    // Creates the main job listing table
    $job_table_sql = "CREATE TABLE $job_table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      business_name varchar(128) NOT NULL,
      name varchar(128) NOT NULL,
      email varchar(256) DEFAULT '' NOT NULL,
      phone varchar(32) DEFAULT '' NOT NULL,
      approved bool DEFAULT 0 NOT NULL,
      description text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    // Creates the category table
    $category_table_sql = "CREATE TABLE $category_table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      name varchar(128) NOT NULL,
      description text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    // Creates the skill table
    $skill_table_sql = "CREATE TABLE $skill_table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      name varchar(128) NOT NULL,
      description text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $job_table_sql );
    dbDelta( $category_table_sql );
    dbDelta( $skill_table_sql );
}

function dn_create_mock_data() {
    global $wpdb;
    $table_name = dn_job_table_name();

    foreach (range(0, 1) as $index) {
        $wpdb->insert($table_name, array(
            'business_name' => "Business $index",
            'name' => 'Herp Derp',
            'email' => 'example@example.com',
            'phone' => '1-123-456-7890',
            'description' => "This is an example description for $index"
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

function dn_get_all_jobs() {
    global $wpdb;
    $table_name = dn_job_table_name();

    $query = "SELECT * from $table_name";
    $results = $wpdb->get_results($query);

    return $results;
}

function dn_get_approved_jobs() {
    global $wpdb;
    $table_name = dn_job_table_name();

    $query = "SELECT * from $table_name WHERE approved = 1";
    $results = $wpdb->get_results($query);

    return $results;
}

function dn_get_unapproved_jobs() {
    global $wpdb;
    $table_name = dn_job_table_name();

    $query = "SELECT * from $table_name where approved = 0";
    $results = $wpdb->get_results($query);

    return $results;
}

/*
    dn_ajax_submit_job

    Should take job and add it to the database.
*/
function dn_ajax_submit_job() {
    global $wpdb;
    
    echo 'Submitting Job...';
    wp_redirect('/jobs?submitted=true');
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
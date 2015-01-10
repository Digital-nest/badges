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

define('DN_TABLE_NAME', 'job_requests');

add_action('wp_ajax_submit_job', 'dn_ajax_submit_job');
register_activation_hook( __FILE__, 'dn_create_database' );
register_activation_hook( __FILE__, 'dn_create_mock_data' );

/*
    dn_create_database

    Creates database and adds mock data.
*/
function dn_create_database() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . DN_TABLE_NAME; 

    $sql = "CREATE TABLE $table_name (
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

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function dn_create_mock_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . DN_TABLE_NAME; 

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

function dn_get_all_jobs() {
    global $wpdb;
    $table_name = $wpdb->prefix . DN_TABLE_NAME;

    $query = "SELECT * from $table_name";

    $results = $wpdb->get_results($query);

    return $results;
}

function dn_get_approved_jobs() {

}

function dn_get_unapproved_jobs() {

}

/*
    dn_ajax_submit_job

    Should take job and add it to the database.
*/
function dn_ajax_submit_job() {
    global $wpdb;
    
    echo 'This is a test';
    wp_die();
}
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

require_once 'jobs-common.php';
require_once 'jobs-ajax.php';

register_activation_hook( __FILE__, 'dn_create_database' );
register_activation_hook( __FILE__, 'dn_create_mock_data' );

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

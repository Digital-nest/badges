<?php

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

function dn_get_category_name($id) {
    
    return $name;
}
<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  UltimatePlugin
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Clear Database stored data
$realEstatePosts = get_posts( array( 'post_type' => 'real_estate', 'numberposts' => -1 ) );

foreach( $realEstatePosts as $realEstate ) {
    wp_delete_post( $realEstate->ID, true );
}

// Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'real_estate'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );
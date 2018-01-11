<?php

namespace ucare;

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

include_once dirname( __FILE__ ) . '/plugin.php';


ucare();


if ( get_option( Options::NUKE ) == 'on' ) {

	\smartcat\mail\cleanup();


	// Trash all support tickets
	$query = new \WP_Query( array( 'post_type' => 'support_ticket' ) );

	foreach ( $query->posts as $post ) {
		wp_trash_post( $post->ID );
	}


	// Cleanup wp_options
	$options = new \ReflectionClass( Options::class );

	foreach ( $options->getConstants() as $option ) {
		delete_option( $option );
	}

	delete_option( 'ucare_version' );

	// Drop logs table
	global $wpdb;

	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}ucare_logs" );


}


// Cleanup capabilities and roles
remove_user_roles();
remove_role_capabilities();
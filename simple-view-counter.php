<?php
/*
Plugin Name: Simple View Counter
Plugin URI: 
Description: Add a very simplistic view counter to WordPress. Supports built-in post types, and custom post types 
Version: 0.6
Author: Ben Lobaugh
Author URI: http://ben.lobaugh.net
License: 
License URI: 
*/


// manage_posts_custom_column


if( !is_admin() ) {
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    add_action( 'wp', 'svc_inc_count' );
} else {
    // Add count column to post and custom post types
    add_filter( 'manage_posts_columns', 'svc_add_columns' );  
    add_action( 'manage_posts_custom_column', 'svc_view_columns', 10, 2 );
    
    // Add count column to pages
    add_filter( 'manage_pages_columns', 'svc_add_columns' );
    add_action( 'manage_pages_custom_column', 'svc_view_columns', 10, 2 );
    
    // Setup css for new column
    add_action('admin_head', 'svc_column_css');
}

function svc_inc_count( $content ) {
	global $post;
     //   die( var_dump( $post ) );
	$id = $post->ID;
      //  echo( $id );
       // die();
	//if( isset( $id ) ) {
          // return $post->ID;
		$count = get_post_meta( $id, '_svc_count', true );
		
		if( '' == $count )
			$count = 0;
		
		$count++;
                //echo $post->ID;
		//die( ( $post->ID ) );
		update_post_meta( $id, '_svc_count', $count );
	//}
	return $content;	
}

function svc_add_columns( $columns ) {
    $columns['svc_count'] = 'Views';
    return $columns;
}

function svc_view_columns( $column_name, $id ) {
    
    switch ( $column_name ) {
        case 'svc_count':
            $count = get_post_meta( $id, '_svc_count', true );
            if( '' == $count )
			$count = 0;
            echo $count;
    }
}

function svc_column_css() {
    ?>
<style type="text/css">
    .column-svc_count {
        width: 60px;
        text-align: center;
    }
</style>
    <?php
}
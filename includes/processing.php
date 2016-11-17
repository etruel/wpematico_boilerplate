<?php
/** 
 *  @package WPeMatico boilerplate
 *	functions to add filters and parsers on campaign running
**/
if ( !defined('ABSPATH') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

add_action('Wpematico_init_fetching', 'wpematico_boilerplate_init_fetching'); //hook to add actions and filter on init fetching
function wpematico_boilerplate_init_fetching($campaign) {  // chequea y agrega campos a campaign y graba en free
	if ($campaign['campaign_boilerplate']) {
		add_filter('wpematico_allow_insertpost', 'wpematico_boilerplate_process',5 ,2 );
	}
	//add_filter('wpematico_get_post_content', 'wpematico_boilerplate_get_content',5 ,2 );
}

function wpematico_boilerplate_process( $dev, $fetch, $args) {  // the fetch class
	global $item;
	trigger_error(__('** Doing boilerplate feature **', 'wpematico_boilerplate' ),E_USER_NOTICE);
	$campaign = $fetch->campaign;
	$item = $fetch->current_item;
	
/*	// Post Contents
	$title = $fetch->current_item['title'];
	$content= $fetch->current_item['content'];
	$post_excerpt = (isset($args['post_excerpt']) && !empty($args['post_excerpt']) ) ? $args['post_excerpt'] : null; 
	$post_type = (isset($fetch->current_item['customposttype']) && !empty($fetch->current_item['customposttype']) ) ? $fetch->current_item['customposttype'] : 'post';
	$timestamp = $fetch->current_item['date'];
	$date = ($timestamp) ? gmdate('Y-m-d H:i:s', $timestamp + (get_option('gmt_offset') * 3600)) : null;
	$categories = array(); //"[".implode("] [",$fetch->current_item['categories'])."]";
	foreach ( $fetch->current_item['categories'] as $category ) {
		$categories_names[] = get_term_by('id', $category, 'category')->name;	
		$categories_slugs[] = get_term_by('id', $category, 'category')->slug;	
    }
	$campaign_tags = implode(",",$fetch->current_item['campaign_tags']);
	$status = $fetch->current_item['posttype'];
	$post_format = $fetch->current_item['campaign_post_format'];
	$authorid = $fetch->current_item['author'];
	$allowpings = $fetch->current_item['allowpings'];
	$comment_status = (isset($fetch->current_item['commentstatus']) && !empty($fetch->current_item['commentstatus']) ) ? ( ($fetch->current_item['commentstatus']=="open")?'1':'0') : '1';
	$meta = $fetch->current_item['meta'];
	$images = $fetch->current_item['images'];
*/

	return $dev;  // true to insert post, false to skip post
}

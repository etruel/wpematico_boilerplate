<?php
/** 
 *  @package WPeMatico boilerplate
 *	functions to add metaboxes in campaign editing
**/
if ( !defined('ABSPATH') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

// Metabox campaigns 
add_action('add_meta_boxes', 'wpematico_boilerplate_metaboxes', 15, 0);
function wpematico_boilerplate_metaboxes( ) {  // chequea y agrega campos a campaign y graba en free
	global $pagenow, $post;
	if( !(($pagenow == 'post.php' || $pagenow == 'post-new.php') && $post->post_type=='wpematico' ) ) return false;
	add_meta_box( 'boilerplate-box', __('Boilerplate', 'wpematico_boilerplate' ), 'wpematico_boilerplate_box','wpematico','normal', 'default' );
	add_action('admin_print_styles', 'wpematico_boilerplate_styles',10,0);
	add_action('admin_print_scripts-post.php', 'wpematico_boilerplate_scripts');
	add_action('admin_print_scripts-post-new.php', 'wpematico_boilerplate_scripts'); 
}

function wpematico_boilerplate_styles() {
	global $post;
	if($post->post_type != 'wpematico') return $post->ID;
//	wp_enqueue_style('thickbox');
 		?>
<style type="text/css">
	#boilerplate {
		margin-left: 20px;
	}
	#boilerplate-box h2.hndle {
		background: #2ccbcb;
		color: maroon;
	}
</style>
	<?php
}
function wpematico_boilerplate_scripts() { // load javascript 
	global $post;
	if($post->post_type != 'wpematico') return $post_id;
	add_action('admin_head', 'wpematico_boilerplate_head_js');
}
		
function wpematico_boilerplate_head_js() { // load javascript 
	global $post, $campaign_data;
	?>
	<script type="text/javascript" language="javascript">
	jQuery(document).ready(function($){
		$('#campaign_boilerplate').click(function() {
			if ( true == $('#campaign_boilerplate').is(':checked')) {
				$('#boilerplate').fadeIn();
			} else {
				$('#boilerplate').fadeOut();
			}
		});
	});
	</script>
	<?php 
}

function wpematico_boilerplate_box( $post ) {
	global $post, $campaign_data;
	$campaign_boilerplate = $campaign_data['campaign_boilerplate'];
	?><p></p>
	<label><input class="checkbox" type="checkbox" <?php checked($campaign_boilerplate,true);?> name="campaign_boilerplate" value="1" id="campaign_boilerplate"/> <b><?php _e('Activate BoilerPlate Feature', 'wpematico_boilerplate' ); ?></b>
	</label><br />
	<?php _e('Activate this feature to ...', 'wpematico_boilerplate' ); ?>

<?php
}


// Saving campaigns (just check fields, saved in Free version
add_filter('pro_check_campaigndata', 'wpematico_boilerplate_check_campaigndata', 15, 2);
function wpematico_boilerplate_check_campaigndata( $campaign_data = array(), $post_data) {  // chequea y agrega campos a campaign y graba en free
	$cfg = get_option(WPeMatico :: OPTION_KEY);
	$pvetoemail	= (!isset($cfg['pvetoemail']) || empty($cfg['pvetoemail']) ) ? 'destiny.email.address@'.str_ireplace('www.', '', parse_url(get_option('siteurl'), PHP_URL_HOST)) : $cfg['pvetoemail'];
	$campaign_data['campaign_boilerplate']	= (!isset($post_data['campaign_boilerplate']) || empty($post_data['campaign_boilerplate'])) ? false: ($post_data['campaign_boilerplate']==1) ? true : false;

	return $campaign_data;
}

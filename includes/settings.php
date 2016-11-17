<?php
/** 
 *  @package WPeMatico boilerplate
 *	functions to add a tab with custom options in wpematico settings 
**/

if ( !defined('ABSPATH') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

add_action('admin_init', 'wpematico_boilerplate_help');
function wpematico_boilerplate_help(){
	if ( ( isset( $_GET['page'] ) && $_GET['page'] == 'wpematico_settings' ) && 
			( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'wpematico' ) &&
			( isset( $_GET['tab'] ) && $_GET['tab'] == 'boilerplate' ) ) {
		
		$screen = WP_Screen::get('wpematico_page_wpematico_settings ');
		
		$content = '<h3>' . __( 'Using Boilerplate for WPeMatico Campaigns.','wpematico_boilerplate' ) . '</h3>';
		$content.= '<p>' . __( 'This Add-on allows to use WPeMatico from a Wordpress website and to send the read posts from each campaign to an email account.','wpematico_boilerplate' ) . '</p>';
		$content.= '<p>' . __( 'Each campaign allows sending content to different email accounts.','wpematico_boilerplate' ) . '</p>';
		$content.= '<p>' . __( 'Therefore, it can post from a unique website with WPeMatico plugin to many different Wordpress websites.','wpematico_boilerplate' ) . '</p>';
//		$content.= '<p>' . __( '','wpematico_boilerplate' ) . '</p>';
		
		$screen->add_help_tab( array(
			'id'	=> 'boilerplate',
			'title'	=> __('Boilerplate', 'wpematico_boilerplate'),
			'content'=> $content,
//			'content'=> '<p>' . __( '.' ) . '</p>',
//			'callback'=> 'wpematico_boilerplate_commandshelp',
		) );
	}
}

add_filter('wpematico_more_options', 'wpematico_boilerplate_options',10 ,2);  
function wpematico_boilerplate_options($cfg, $options){
	$cfg['pvefromemail']	= (!isset($options['pvefromemail']) || empty($options['pvefromemail']) ) ? 'publisher.email.address@'.str_ireplace('www.', '', parse_url(get_option('siteurl'), PHP_URL_HOST)) : $options['pvefromemail'];
	$cfg['pvefromname']		= (!isset($options['pvefromname']) or empty($options['pvefromname']) ) ? 'WPeMatico Boilerplate' : $options['pvefromname'];
	$cfg['pvetoemail']		= (!isset($options['pvetoemail']) || empty($options['pvetoemail']) ) ? 'destiny.email.address@'.str_ireplace('www.', '', parse_url(get_option('siteurl'), PHP_URL_HOST)) : $options['pvetoemail'];
	return $cfg;
}

add_action( 'wpematico_settings_tab_boilerplate', 'wpematico_boilerplate_form' );
function wpematico_boilerplate_form(){
	$cfg = get_option(WPeMatico :: OPTION_KEY);
	$cfg = apply_filters('wpematico_check_options', $cfg);  
	$cfg['pvefromemail']	= (!isset($cfg['pvefromemail']) || empty($cfg['pvefromemail']) ) ? 'publisher.email.address@'.str_ireplace('www.', '', parse_url(get_option('siteurl'), PHP_URL_HOST)) : $cfg['pvefromemail'];
	$cfg['pvefromname']		= (!isset($cfg['pvefromname']) or empty($cfg['pvefromname']) ) ? 'WPeMatico Boilerplate' : $cfg['pvefromname'];
	$cfg['pvetoemail']		= (!isset($cfg['pvetoemail']) || empty($cfg['pvetoemail']) ) ? 'destiny.email.address@'.str_ireplace('www.', '', parse_url(get_option('siteurl'), PHP_URL_HOST)) : $cfg['pvetoemail'];
	?>
		<div id="poststuff" class="has-right-sidebar">
			<div id="side-info-column" class="inner-sidebar">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
				<div class="postbox">
				<h3 class="handle"><?php _e( 'About', 'wpematico_boilerplate' );?></h3>
				<div class="inside">
					<p id="left1" onmouseover="this.style.background =  '#555';" onmouseout="this.style.background =  '#FFF';" style="text-align:center; background-color: rgb(255, 255, 255); background-position: initial initial; background-repeat: initial initial; ">
						<a href="http://etruel.com" target="_Blank" title="Go to new etruel WebSite"><img style="background: transparent;border-radius: 15px;" src="http://etruel.com/wp-content/uploads/2016/03/etruelcom2016_250x120.png" title=""></a><br />
					WPeMatico <?php echo WPEMATICO_VERSION ; ?></p>
					<p><?php _e( 'Thanks for use and enjoy this plugin.', 'wpematico_boilerplate' );?></p>
					<p><?php _e( 'If you like it and can take a minute, I ask you to write a 5 star review on Wordpress.', 'wpematico_boilerplate' );?></p>
					<style type="text/css">#linkrate:before { content: "\2605\2605\2605\2605\2605";font-size: 18px;}
					#linkrate { font-size: 18px;}</style>
					<p style="text-align: center;">
						<a href="https://wordpress.org/support/view/plugin-reviews/wpematico?filter=5&rate=5#postform" id="linkrate" class="button" target="_Blank" title="Click here to rate plugin on Wordpress">  Rate</a>
					</p>
					<p></p>
				</div>
				</div>
				<?php //do_action('wpematico_wp_ratings'); ?>
				</div>
			</div>
			<div id="post-body">
				<div id="post-body-content">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div class="postbox inside">
							<h3><?php _e( 'WPeMatico Boilerplate Settings', 'wpematico_boilerplate' );?></h3>
							<div class="inside">
								<form method="post" action="">
									<p>
									<?php wp_nonce_field('wpematico-boilerplate'); ?>
									<p><b><?php _e('Default Sender Email:', 'wpematico_boilerplate' ); ?></b> <input name="pvefromemail" id="mailsndemail" type="text" value="<?php echo $cfg['pvefromemail'];?>" class="regular-text" /><span id="mailmsg"></span></p>
									<p><b><?php _e('Default Sender Name:', 'wpematico_boilerplate' ); ?></b> <input name="pvefromname" id="pvefromname" type="text" value="<?php echo $cfg['pvefromname'];?>" class="regular-text" /></p>

									<p><b><?php _e('Default Email Recipient:', 'wpematico_boilerplate' ); ?></b> <input name="pvetoemail" id="pvetoemail" type="text" value="<?php echo $cfg['pvetoemail'];?>" class="regular-text" /><span id="mailmsg2"></span></p>

									<p></p>
									<span id="saving">
										<input type="hidden" name="wpematico-action" value="save_boilerplate" />
										<?php submit_button( __( 'Save file', 'wpematico_boilerplate' ), 'primary', 'wpematico-save-boilerplate', false ); ?>
									</span>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
}


add_action( 'wpematico_save_boilerplate', 'wpematico_boilerplate_save' );
function wpematico_boilerplate_save() {
	if ( 'POST' === $_SERVER[ 'REQUEST_METHOD' ] ) {
		if ( get_magic_quotes_gpc() ) {
			$_POST = array_map( 'stripslashes_deep', $_POST );
		}
		# evaluation goes here
		check_admin_referer('wpematico-boilerplate');
		$errlev = error_reporting();
		error_reporting(E_ALL & ~E_NOTICE);  // desactivo los notice que aparecen con los _POST

		$cfg = get_option(WPeMatico :: OPTION_KEY);
		$cfg = array_merge($cfg, $_POST);
		$cfg = apply_filters('wpematico_check_options',$cfg);
				
		if( update_option( WPeMatico::OPTION_KEY, $cfg ) ) {
			?><div class="notice notice-success is-dismissible"><p> <?php _e( 'Settings saved.', 'wpematico_boilerplate' );?></p></div><?php
		}

		error_reporting($errlev);

	}
}

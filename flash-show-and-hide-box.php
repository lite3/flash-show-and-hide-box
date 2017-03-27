<?php
/**
 * @package flash-show-and-hide-box
 */
/*
Plugin Name: Flash Show And Hide Box
Plugin URI: https://www.litefeel.com/flash-show-and-hide-box/
Description: Flash Show And Hide Box lets we very convenient embed flash, and control it show and hide.
Version: 1.6
Author: litefeel
Author URI: https://www.litefeel.com/
License: GPLv2 or later
Text Domain: flash-show-and-hide-box
*/

/* options */
/* ------------------------------------------------------------ */
if(!class_exists('FlashShowAndHideBox')) {
class FlashShowAndHideBox {

	var $version = '1.4.2';
	
	function __construct() {
		add_action('init', array(&$this,'flash_init'));
	}
	
	function getDefalutOptions(){
		$options = array();
		$options['active_ubb'] = true;
		$options['load_js_at_front_page']	= true;
		$options['flash_hiding_state_text']	= __('Clike To Show Flash', 'flash-show-and-hide-box');
		$options['flash_showing_state_text']	= __('Clike To Hide Flash', 'flash-show-and-hide-box');
		return $options;
	}
	
	function getOptions() {
		$options = get_option('flashshowandhidebox_options');
		$ver_change = false;
		if(!is_array($options)) {
			$options = array();
		}
		$default = $this->getDefalutOptions();
		foreach ( $default as $key => $value) {
			if(!isset($options[$key])) {
				$options[$key] = $value;
				$ver_change = true;
			}
		}
		if ($ver_change) {
			update_option('flashshowandhidebox_options', $options);
		}
		return $options;
	}
	
	function flash_init(){
		load_plugin_textdomain( 'flash-show-and-hide-box' );
		
		$options = $this->getOptions();
		
		add_action('admin_menu', array($this, 'add'));
		
		if($options['active_ubb'] == true) {
			add_filter('the_content', array($this, 'replaceUBB'));
			add_filter('the_excerpt', array($this, 'replaceUBB'));
		}
		
		add_filter( 'plugin_action_links', array($this, 'plugin_action_links'), 10, 2 );
		add_action( 'wp_head', array(&$this, 'print_config') );
		add_action( 'template_redirect', array(&$this, 'load_staitc') );
	}
	
	function plugin_action_links( $links, $file ) {
		if ( $file != plugin_basename( __FILE__ )) return $links;

		$settings_link = '<a href="options-general.php?page=flash-show-and-hide-box/flash-show-and-hide-box.php">' . __( 'Settings', 'flash-show-and-hide-box' ) . '</a>';

		array_push( $links, $settings_link );

		return $links;
	}
	function print_config()
	{
		$options = get_option('commentsAvatarLazyload_options');
		if($options['load_js_at_front_page'] || !is_front_page()) {
			$swfurl = plugins_url('swf/expressInstall.swf', __FILE__);
			$iconurl = plugins_url('img/flash_icon.gif', __FILE__);
			$showing_state_text = isset($options['flash_showing_state_text']) ? 
									$options['flash_showing_state_text'] : '';
			$hiding_state_text = isset($options['flash_hiding_state_text']) ? 
									$options['flash_hiding_state_text'] : '';

			$output = "<script type='text/javascript'>\n" .
						"window.showFlashExpressInstallSWFURL = '$swfurl';\n" .
						"window.showFlashIconURL = '$iconurl';\n" .
						"window.showFlashShowingStateText = '$showing_state_text';\n" .
						"window.showFlashHidingStateText = '$hiding_state_text';\n" .
						"</script>\n";
			echo $output;
		}
	}
	function load_staitc(){
		$options = get_option('commentsAvatarLazyload_options');
		if($options['load_js_at_front_page'] || !is_front_page()) {
			wp_enqueue_script('showFlashLib',  plugins_url('js/showflash.js', __FILE__), array('jquery','swfobject'), $this->version);

		}
	}
	
	function replaceUBB($content) {
		$result = preg_replace('/\[flash=(\d+),(\d+)\]([^\[]+?)\[\/flash\]/i',
			'<script type="text/javascript">showFlashLib.createBox("$3",$1,$2);</script>',
			$content);
		return $result == NULL ? $content : $result;
	}

	function add() {
		if(isset($_POST['flashshowandhidebox_save'])) {
			$options = $this->getOptions();

			// load_js_at_front_page
			if(!$_POST['load_js_at_front_page']) {
				$options['load_js_at_front_page'] = (bool)false;
			} else {
				$options['load_js_at_front_page'] = (bool)true;
			}
			// active_ubb
			if(!$_POST['active_ubb']) {
				$options['active_ubb'] = (bool)false;
			} else {
				$options['active_ubb'] = (bool)true;
			}
			// flash_showing_state_text
			if(!$_POST['flash_showing_state_text']) {
				$options['flash_showing_state_text'] = '';
			} else {
				$options['flash_showing_state_text'] = (string)$_POST['flash_showing_state_text'];
			}
			// flash_hiding_state_text
			if(!$_POST['flash_hiding_state_text']) {
				$options['flash_hiding_state_text'] = '';
			} else {
				$options['flash_hiding_state_text'] = (string)$_POST['flash_hiding_state_text'];
			}
			
			update_option('flashshowandhidebox_options', $options);
		} else if(isset($_POST['flashshowandhidebox_reset'])) {
			$options = $this->getDefalutOptions();
			update_option('flashshowandhidebox_options', $options);
		}

		add_options_page('Flash Show And Hide Box Options', 'Flash Show And Hide Box Options', 'manage_options', __FILE__, array($this, 'display'));
	}

	function display() {
		$options = $this->getOptions();
?>

<div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2><?php _e('Flash Show And Hide Box Options', 'flash-show-and-hide-box'); ?></h2>

	<div id="poststuff" class="has-right-sidebar">
		<div class="inner-sidebar">
			<div id="donate" class="postbox" style="border:2px solid #080;">
				<h3 class="hndle" style="color:#080;cursor:default;"><?php _e('Donation', 'flash-show-and-hide-box'); ?></h3>
				<div class="inside">
					<p><?php _e('If you like this plugin, please donate to support development and maintenance!', 'flash-show-and-hide-box'); ?>
					<br /><br /><strong><a href="https://www.paypal.me/litefeel" target="_blank"><?php _e('Donate by paypal.me', 'flash-show-and-hide-box'); ?></a></strong><style>#donate form{display:none;}</style>
					</p>
				</div>
			</div>

			<div class="postbox">
				<h3 class="hndle" style="cursor:default;"><?php _e('About Author', 'flash-show-and-hide-box'); ?></h3>
				<div class="inside">
					<ul>
						<li><a href="https://www.litefeel.com/" target="_blank"><?php _e('Author Blog', 'flash-show-and-hide-box'); ?></a></li>
						<li><a href="https://www.litefeel.com/plugins/" target="_blank"><?php _e('More Plugins', 'flash-show-and-hide-box'); ?></a></li>
					</ul>
				</div>					
			</div>
		</div>

		<div id="post-body">
			<div id="post-body-content">

<form action="#" method="POST" enctype="multipart/form-data" name="flashshowandhidebox_form">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Flash displayed at home page', 'flash-show-and-hide-box'); ?></th>
					<td>
						<label>
							<input name="load_js_at_front_page" type="checkbox" <?php if($options['load_js_at_front_page']) echo 'checked="checked"'; ?> />
							 <?php _e('Flash will be displayed on the home page. If your Flash will not be displayed on the home page, do not choose this option.', 'flash-show-and-hide-box'); ?>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Active UBB code', 'flash-show-and-hide-box'); ?></th>
					<td>
						<label>
							<input name="active_ubb" type="checkbox" <?php if($options['active_ubb']) echo 'checked="checked"'; ?> />
							 <?php _e('Use UBB code embedded Flash will be displayed.', 'flash-show-and-hide-box'); ?>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('The Text when flash is showing', 'flash-show-and-hide-box'); ?></th>
					<td>
						<label>
							<input name="flash_showing_state_text" type="input" value="<?php echo $options['flash_showing_state_text']; ?>" style="width:400px;"/>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('The Text when flash is hiding', 'flash-show-and-hide-box'); ?></th>
					<td>
						<label>
							<input name="flash_hiding_state_text" type="input" value="<?php echo $options['flash_hiding_state_text']; ?>" style="width:400px;"/>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
		<input class="button-primary" type="submit" name="flashshowandhidebox_save" value="<?php _e('Update Options', 'flash-show-and-hide-box'); ?>" />
		<input class="button-primary" type="submit" name="flashshowandhidebox_reset" value="<?php _e('Reset Settings to Defaults', 'flash-show-and-hide-box'); ?>" />
		</p>
</form>
			</div>
		</div>
	</div>
</div>

<?php
	}
}

$flashShowAndHideBoxvar = new FlashShowAndHideBox();
}
?>

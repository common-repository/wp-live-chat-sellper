<?php
/*
Plugin Name: WP Live Chat Sellper
Plugin URI: https://sellper.net/wp-live-chat-sellper
Description: Wp Live Chat plugin enables you to add Live Sellper Chat script to your WordPress blog.
Version: 1.0
Author: Abel
Author URI: http://www.midlandwebcompany.com
License: GPLv2 or later
*/

/*  Copyright 2015  Midland Web Company  (email : info@midlandwebcompany.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('wplhc_PLUGIN_DIR',str_replace('\\','/',dirname(__FILE__)));

if ( !class_exists( 'livehelperchat' ) ) {
	
	class livehelperchat {

		function livehelperchat() {
		
			add_action( 'init', array( &$this, 'init' ) );
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
			add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
			add_action( 'wp_head', array( &$this, 'wp_head' ) );
			add_action( 'wp_footer', array( &$this, 'wp_footer' ) );
		
		}
		
	
		function init() {
			load_plugin_textdomain( 'wp-live-chat', false, dirname( plugin_basename ( __FILE__ ) ).'/lang' );
		}
	
		function admin_init() {
			register_setting( 'wp-live-chat', 'wplhc_insert_header', 'trim' );
			register_setting( 'wp-live-chat', 'wplhc_insert_footer', 'trim' );

			foreach (array('post','page') as $type) 
			{
				add_meta_box('wplhc_all_post_meta', 'Insert Script to &lt;head&gt;', 'wplhc_meta_setup', $type, 'normal', 'high');
			}
			
			add_action('save_post','wplhc_post_meta_save');
		}
	
		function admin_menu() {
			$page = add_submenu_page( 'options-general.php', 'WP live Chat', 'WP live Chat', 'manage_options', __FILE__, array( &$this, 'wplhc_options_panel' ) );
			}
	
		function wp_head() {
			$meta = get_option( 'wplhc_insert_header', '' );
				if ( $meta != '' ) {
					echo $meta, "\n";
				}

			$wplhc_post_meta = get_post_meta( get_the_ID(), '_inpost_head_script' , TRUE );
				if ( $wplhc_post_meta != '' ) {
					echo $wplhc_post_meta['synth_header_script'], "\n";
				}
			
		}
		   
				
		function wplhc_options_panel() { ?>
<div id="wplhc-wrap">
	<div class="wrap">
				<?php screen_icon(); ?>
					<h2>WP live Chat</h2>
					<hr />
					<div class="wplhc-wrap" style="width: auto;float: left;margin-right: 2rem;"><hr />
					
						<form name="dofollow" action="options.php" method="post">
						
							<?php settings_fields( 'wp-live-chat' ); ?>
                        	
							<h3 class="wplhc-labels" for="wplhc_insert_header">Paste your Live Sellper Chat script here:</h3>
                            <textarea rows="5" cols="57" id="insert_header" name="wplhc_insert_header"><?php echo esc_html( get_option( 'wplhc_insert_header' ) ); ?></textarea><br />
                            <h3 class="wplhc-labels footerlabel" for="wplhc_insert_footer">
							  <input class="button button-primary" type="submit" name="Submit" value="Save settings" /> 
						</h3>

						</form></div>
                        <div class="wplhc-sidebar" style="max-width: 270px;float: left;">
						<div class="wplhc-improve-site" style="padding: 1rem; background: rgba(0, 0, 0, .02);">
							<h2>Don't have your code?</h2>
							<p>No panic you can try it for free 14 days or purchase by going Here:</p>
							<p><a href="https://sellper.net" class="button" target="_blank">TRY IT &raquo;</a></p>
						</div>
				  </div>
					</div>
				</div>
				
							
				<?php
		}
	}

	
$WP_live_Helper_Chat = new livehelperchat();

}




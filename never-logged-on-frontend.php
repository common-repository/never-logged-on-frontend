<?php
/*
Plugin Name: Never Logged On Frontend
Description: When you activate the incognito mode, you will see the frontend as you were not logged in.
Author: Jose Mortellaro
Author URI: https://josemortellaro.com/
Text Domain: fnlof
Domain Path: /languages/
Version: 0.0.4
*/
/*  This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
defined( 'ABSPATH' ) || exit;
if( 
	!is_admin() 
	&& !function_exists('wp_parse_auth_cookie') 
	&& !defined( 'DOING_AJAX' ) 
	&& !defined( 'DOING_CRON' ) 
	&& !isset( $_REQUEST['eos_dp_preview'] )
	&& !isset( $_REQUEST['preview'] )
	&& !isset( $_REQUEST['customize_changeset_uuid'] )
	&& !isset( $_REQUEST['customize_theme'] )
	&& !isset( $_REQUEST['post'] )
	&& !isset( $_REQUEST['action'] )
	&& !isset( $_REQUEST['_locale'] )
	&& !isset( $_REQUEST['elementor-preview'] )
){
	$activation = !isset( $_COOKIE['fnlof_incognito'] ) ? true : $_COOKIE['fnlof_incognito'];
	if( $activation && 'false' !== $activation ){
		if( !function_exists( 'is_user_logged_in' ) ){
			function is_user_logged_in() {
				return false;
			}
		}
		function wp_parse_auth_cookie($cookie = '', $scheme = '') {
			return false;
		}
	}
}
if( is_admin() ){
	define( 'EOS_FNLOF_DIR',untrailingslashit( dirname( __FILE__ ) ) );
	define( 'EOS_FNLOF_URL',untrailingslashit( plugins_url( '', __FILE__ ) ) );
	require_once EOS_FNLOF_DIR.'/admin/nlof-admin.php';		
}
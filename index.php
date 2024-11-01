<?php
/*
Plugin Name: Website Speed Checker
Plugin URI:  http://seonorthmelbourne.com.au
Description: Check your website page speed with Google Page Insights, Use given script to increase web site performance and load time.
Version: 1.0
Author: Seo North Melbourne
Author URI: http://seonorthmelbourne.com.au
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_style('cl-chanimal-styles', plugin_dir_url( __FILE__ ) . 'css/plugin-styles.css' );
wp_enqueue_style('cl-popup-styles', plugin_dir_url( __FILE__ ) . 'css/popup.css' );

function snm_page_speed()
{
	include "page-sp.php";
}
add_action('admin_menu', 'add_page_speed_fun');

function add_page_speed_fun()
{
	add_menu_page('page_sp', 'Website Speed Checker','read','page_sp','', esc_url(plugin_dir_url( __FILE__ ). 'assets/launch.png'), __FILE__ );
	add_submenu_page('page_sp', 'Website Speed Checker', 'Page Speed', 'read', 'page_sp','snm_page_speed');
}

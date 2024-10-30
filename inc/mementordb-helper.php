<?php
/**
* Mementor Dashboard Helper Function & Hooks.
*
* @author Mementor
* @package Mementor Dashboard
* @version 1.0.0
*/

add_action( 'admin_menu', 'mementordb_register_redirect_menu_link', 220 );
function mementordb_register_redirect_menu_link(){
  include_once(ABSPATH.'wp-admin/includes/plugin.php');

  // Main menu
  add_menu_page(__('Main Menu', 'mementordb'), __('Main Menu', 'mementordb'), 'manage_options', 'menu_heading', '', 'dashicons-external', 1);

  // Support
  add_menu_page(__('Support', 'mementordb'), __('Support', 'mementordb'), 'manage_options', 'support_heading', '', 'dashicons-external', 2050);

  // Phone
  $mementordb_contact_number = get_option('mementordb-phone-number');
  if (isset($mementordb_contact_number) && !empty($mementordb_contact_number)) {
    add_menu_page($mementordb_contact_number, $mementordb_contact_number, 'manage_options', 'contact-number', 'mementordb_contact_number_menu_link', 'dashicons-phone', 2052);
  } else {
    add_menu_page('+47 561 23 010', '+47 561 23 010', 'manage_options', 'contact-number', 'mementordb_contact_number_menu_link_custom', 'dashicons-phone', 2052);
  }

  // Email
  $mementordb_email_address = get_option('mementordb-email-address');
  if (isset($mementordb_email_address) && !empty($mementordb_email_address)) {
    add_menu_page($mementordb_email_address, $mementordb_email_address, 'manage_options', 'email-address', 'mementordb_email_address_menu_link', 'dashicons-email-alt', 2054);
  } else {
    add_menu_page('post@mementor.no', 'post@mementor.no', 'manage_options', 'email-address', 'mementordb_email_address_menu_link_custom', 'dashicons-email-alt', 2054);
  }

  // Facebook
  $mementordb_facebook = get_option('mementordb-facebook');
  if (isset($mementordb_facebook) && !empty($mementordb_facebook)) {
    add_menu_page($mementordb_facebook, __('Chat on Facebook', 'mementordb'), 'manage_options', 'facebook', 'mementordb_facebook_menu_link', 'dashicons-facebook', 2065);
  }

  // Skype
  $ma_skype = get_option('mementordb-skype');
  if (isset($ma_skype) && !empty($ma_skype)) {
    add_menu_page($ma_skype, __('Chat on Skype', 'mementordb'), 'manage_options', 'skype', 'mementordb_skype_menu_link', 'dashicons-external', 2056);
  }

  // Slack
  $mementordb_slack = get_option('mementordb-slack');
  if (isset($mementordb_slack) && !empty($mementordb_slack)) {
    add_menu_page($mementordb_slack, __('Chat on Slack', 'mementordb'), 'manage_options', 'slack', 'mementordb_slack_menu_link', 'dashicons-external', 2058);
  }

  // Support
  $mementordb_support = get_option('mementordb-support');
  if (isset($mementordb_support) && !empty($mementordb_support)) {
    add_menu_page($mementordb_support, __('Visit our Website', 'mementordb'), 'manage_options', 'support', 'mementordb_support_menu_link_custom', 'dashicons-businessman', 2060);
  }

  // Clear Cache
  if (is_plugin_active('wp-rocket/wp-rocket.php')) {
    add_menu_page(__('Clear Cache', 'mementordb'), __('Clear Cache', 'mementordb'), 'manage_options', 'cache-heading', '', 'dashicons-external', 2072);
    add_menu_page(__('Clear Cache', 'mementordb'), __('Clear Cache', 'mementordb'), 'manage_options', 'wp-rocket', '', 'dashicons-external', 2075);
  }

  // Logout
  add_menu_page(__('Logout', 'mementordb'), __('Logout', 'mementordb'), 'manage_options', 'logout_heading', '', 'dashicons-external', 2098);
  add_menu_page(__('Log out', 'mementordb'), __('Log out', 'mementordb'), 'manage_options', 'logout_link', 'mementordb_logout_menu_link', 'dashicons-external', 2099);
}

//Added Output buffering to fix the headers issue.
ob_start();

function mementordb_contact_number_menu_link() {
  $contact_number = get_option('mementordb-contact-number');
  wp_redirect('tel:'.$contact_number, 301);
  exit;
}

function mementordb_contact_number_menu_link_custom() {
  wp_redirect('tel:+4756123010', 301);
	exit;
}

function mementordb_email_address_menu_link() {
  $email_address = get_option('mementordb-email-address');
  wp_redirect('mailto:'.$email_address, 301);
	exit;
}

function mementordb_email_address_menu_link_custom() {
  wp_redirect('mailto:post@mementor.no', 301);
	exit;
}

function mementordb_skype_menu_link() {
  $skype = get_option('mementordb-skype');
  wp_redirect('skype:'.$skype, 301);
	exit;
}

function mementordb_slack_menu_link() {
  $slack = get_option('mementordb-slack');
  wp_redirect($slack, 301);
	exit;
}

function mementordb_facebook_menu_link() {
  $facebook = get_option('mementordb-facebook');
  wp_redirect($facebook, 301);
	exit;
}

function mementordb_support_menu_link_custom() {
  $support = get_option('support');
  wp_redirect($support, 301);
	exit;
}

function mementordb_logout_menu_link() {
  $logout = get_site_url() .'/wp-login.php?action=logout';
  wp_redirect($logout, 301);
	exit;
}

<?php
/**
* Mementor Admin Class for add Menu & Setting Page
*
* @class    Mementordb_Admin
* @author   Mementor
* @package  Mementor Dashboard
* @version  1.0
*/
if (!defined('ABSPATH')) {
	exit;
}
if (!class_exists('Mementordb_Admin')) {

  class Mementordb_Admin {

    protected static $mementordb_admin_instance = null;

    public static function mementordb_admin_instance() {
      if (null == self::$mementordb_admin_instance) {
        self::$mementordb_admin_instance = new Mementordb_Admin();
      }
      return self::$mementordb_admin_instance;
    }

    public function __construct() {
      add_action('admin_menu', array($this, 'mementordb_admin_menu'), 200);
      add_action('admin_menu', array($this, 'mementordb_settings_menu'), 200);
      add_action('admin_head', array($this, 'mementordb_custom_js_code'));
      add_filter('admin_footer_text', array($this, 'mementordb_footer_text'), 11);
      add_filter('update_footer', array($this, 'mementordb_update_footer'), 9999);
      add_action('admin_menu', array($this, 'mementordb_remove_admin_sub_menu_item'), 999);
    }

    public function mementordb_admin_menu() {
      add_menu_page(__('Mementor Dashboard', 'mementordb'), __('Mementor', 'mementordb'), 'manage_options', 'mementor', null, null, 2000);
    }

    public function mementordb_settings_menu() {
      add_submenu_page('mementor', __('Mementor Dashboard', 'mementordb'),  __('Dashboard', 'mementordb') , 'manage_options', 'mementordb', array($this, 'mementordb_pretty_admin_page'));
    }

    public function mementordb_pretty_admin_page() {
      require_once(plugin_dir_path(__FILE__).'/view/mementordb-settings.php');
    }

    public function mementordb_custom_js_code() {
      if (!empty(get_option('mementordb-custom-js'))) {
        echo stripslashes(base64_decode(get_option('mementordb-custom-js')));
      }
    }

    public function mementordb_footer_text() {
      global $wp_version;
      return sprintf('%s %s %s | %s %s %s', '<i class="icon-wordpress"></i>', __('WordPress', 'mementordb'), $wp_version, '<i class="icon-versions"></i>', __('Mementor Dashboard', 'mementordb'), mementordb_main_instance()->mementordb_version);
    }

    public function mementordb_update_footer() {
      return '<a href="https://www.mementor.no/" target="_blank"><img src="'.MEMENTORDB_URL.'/assets/images/logo_element.png" alt=""></a>';
    }

    public function mementordb_remove_admin_sub_menu_item() {
      global $submenu;
      unset($submenu['mementor'][0]);
    }
  }
  function mementordb_admin_instance() {
    return Mementordb_Admin::mementordb_admin_instance();
  }
  mementordb_admin_instance();
}

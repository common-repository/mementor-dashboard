<?php
/**
* Plugin Name: Mementor Dashboard
* Plugin URI: https://www.mementor.no/
* Description: Mementor Dashboard is a modified skin for your WordPress Admin.
* Version: 1.0
* Author: Mementor
* Author URI: https://www.mementor.no/
* Text Domain: mementordb
* Domain Path: /i18n/languages/
* @author Mementor
* @package Mementor Dashboard
* @version 1.0
*/
if (!defined('ABSPATH')) {
  exit;
}
if (!class_exists('Mementordb_Main')) {
  class Mementordb_Main {

    public $mementordb_version = '1.0';
    protected static $mementordb_instance = null;
    public static function Mementordb_Main_instance() {
      if (null == self::$mementordb_instance) {
        self::$mementordb_instance = new Mementordb_Main();
      }
      return self::$mementordb_instance;
    }

    public function __construct() {
      $this->mementordb_language();
      $this->mementordb_constents();
      add_action('login_enqueue_scripts', array($this, 'mementordb_login_files'));
      add_action('admin_head', array($this, 'mementordb_admin_script_files'));
      $this->mementordb_includes();
  	}

    public function mementordb_language() {
      load_plugin_textdomain('mementordb', false, basename(dirname(__FILE__)).'/i18n/languages');
    }

    public function mementordb_constents() {
      if (!defined('MEMENTORDB')) {
        define('MEMENTORDB', true);
      }
      if (!defined('MEMENTORDB_URL')) {
        define('MEMENTORDB_URL', plugin_dir_url(__FILE__));
      }
      if (!defined('MEMENTORDB_DIR')) {
        define('MEMENTORDB_DIR', plugin_dir_path(__FILE__));
      }
    }

    public function mementordb_includes() {
      require_once(dirname(__FILE__).'/inc/mementordb-admin.php');
      require_once(dirname(__FILE__).'/inc/mementordb-login-form.php');
      require_once(dirname(__FILE__).'/inc/mementordb-wo-search-bar.php');
      require_once(dirname(__FILE__).'/inc/mementordb-helper.php');
    }

    public function mementordb_login_files() {
      wp_enqueue_style('mementordb-login', untrailingslashit(plugins_url('/', __FILE__)).'/assets/css/mementordb-login.min.css', false, $this->mementordb_version);
      wp_enqueue_style('mementordb-login-fonts', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false, false);
      wp_enqueue_script('mementordb-login-js', untrailingslashit(plugins_url('/', __FILE__)).'/assets/js/mementordb-login.min.js', array('jquery'), $this->mementordb_version, true);
    }

    public function mementordb_admin_script_files() {
      wp_enqueue_style('mementordb-style', untrailingslashit(plugins_url('/', __FILE__)).'/assets/css/mementordb-style.min.css', false, $this->mementordb_version);
      wp_enqueue_style('mementordb-admin', untrailingslashit(plugins_url('/', __FILE__)).'/assets/css/mementordb-admin.min.css', false, $this->mementordb_version);
      wp_enqueue_script('mementordb-admin-js', untrailingslashit(plugins_url('/', __FILE__)).'/assets/js/mementordb-admin.min.js', array('jquery'), $this->mementordb_version, true);
      wp_enqueue_script('mementordb-main', untrailingslashit(plugins_url('/', __FILE__)).'/assets/js/mementordb-main.min.js', false, $this->mementordb_version, true);
    }
  }

  function Mementordb_Main_instance() {
  	return Mementordb_Main::Mementordb_Main_instance();
  }
  Mementordb_Main_instance();
}

<?php
/**
* Mementor Dashboard Login Form Modification.
*
* @class   Mementordb_Login_Form
* @author  Mementor
* @package Mementor Dashboard
* @version 1.0
*/
if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Mementordb_Login_Form')) {

  class Mementordb_Login_Form {

    protected static $mementordb_login_form_instance = null;

    public static function mementordb_login_form_instance() {
      if (null == self::$mementordb_login_form_instance) {
        self::$mementordb_login_form_instance = new Mementordb_Login_Form();
      }
      return self::$mementordb_login_form_instance;
    }

    public function __construct() {
      add_action('init', array($this, 'mementordb_login_checked_remember_me'));
      add_action('login_head', array($this, 'mementordb_login_form_logo'));
      add_filter('login_headerurl', array($this, 'mementordb_logo_url_redirect'));
      add_filter('login_redirect', array($this, 'mementordb_login_user_redirect'), 10, 3);
      add_action('login_header', array($this, 'mementordb_login_header_wrapper'));
      add_action('login_footer', array($this, 'mementordb_login_footer_wrapper'));
      add_action('check_admin_referer', array($this, 'mementordb_logout_without_confirm'), 10, 2);
    }

    public function mementordb_login_form_logo() {
      $mementordb_form_logo = get_option('mementordb-form-logo');
      $mementordb_form_background = get_option('mementordb-form-background');
      $mementordb_custom_css = '';

      if ($mementordb_form_logo) {
        $mementordb_custom_css .= 'h1 a { background-image:url(' . esc_url($mementordb_form_logo) . ') !important; }';
      }

      if ($mementordb_form_background) {
        $mementordb_custom_css .= 'body.login { background-image:url(' . esc_url($mementordb_form_background) . ') !important; }';
      }

      if (isset($mementordb_custom_css) && !empty($mementordb_custom_css)) {
        echo '<style type = "text/css">'. $mementordb_custom_css .'</style>';
      }
    }

    public function mementordb_logo_url_redirect() {
      return home_url('/');
    }

    public function mementordb_login_user_redirect($redirect_to, $request, $user) {
      $mementordb_redirect_links = get_option('mementordb-form-redirect');
      $mementordb_user_roles = get_option('mementordb-user-role');
      if (isset($user->roles) && is_array($user->roles) && isset($mementordb_user_roles) && !empty($mementordb_user_roles) && !empty($mementordb_redirect_links[0])) {
        $mementordb_counter = 0;
        foreach($mementordb_user_roles as $mementordb_role) {
          if (in_array($mementordb_role, $user->roles)) {
            $mementordb_redirect = $mementordb_redirect_links[$mementordb_counter];
            break;
          }
          $mementordb_counter++;
        }
      } else {
        $mementordb_redirect = $redirect_to;
      }
      return  $mementordb_redirect;
    }

    public function mementordb_login_checked_remember_me() {
      add_filter('login_footer', array($this, 'mementordb_rememberme_checked'));
    }

    public function mementordb_rememberme_checked() {
      echo "<script>document.getElementById('rememberme').checked = true;</script>";
    }

    public function mementordb_login_header_wrapper() {
      echo '<div class="custom-login-form">';
    }

    public function mementordb_login_footer_wrapper() {
      echo '</div>';
    }

    public function mementordb_logout_without_confirm($action, $result) {
      if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '/wp-login.php';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
      }
    }
  }

  function mementordb_login_form_instance() {
    return Mementordb_Login_Form::mementordb_login_form_instance();
  }
  mementordb_login_form_instance();
  
}
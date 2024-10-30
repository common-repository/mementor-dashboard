<?php
/**
* Mementor Dashobard WooCommerce Admin Search Bar.
*
* @class   Mementordb_Woo_Admin_Bar
* @author  Mementor
* @package Mementor Dashboard
* @version 1.0
*/

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('Mementordb_Woo_Admin_Bar')) {

  class Mementordb_Woo_Admin_Bar {

    protected static $mementordb_woo_admin_bar_instance = null;

    public static function mementordb_woo_admin_bar_instance() {
      if (null == self::$mementordb_woo_admin_bar_instance) {
        self::$mementordb_woo_admin_bar_instance = new Mementordb_Woo_Admin_Bar();
      }
      return self::$mementordb_woo_admin_bar_instance;
    }

    public function __construct() {
      if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        add_action('admin_bar_menu', array($this, 'mementordb_product_admin_bar_form'));
        add_action('admin_bar_menu', array($this, 'mementordb_product_order_admin_bar_form'));
        if (is_admin()) {
          add_action('parse_request', array($this, 'mementordb_woocommerce_admin_product_search'));
          add_filter('get_search_query', array($this, 'mementordb_woocommerce_admin_product_search_label'));
        }
      }
      add_action('admin_bar_menu', array($this, 'mementordb_user_profile_info'), 999);
    }

    public function mementordb_product_admin_bar_form() {
      global $wp_admin_bar;
      $mementordb_search_query = '';
      if (isset($_GET['post_type']) == 'product') {
        $mementordb_search_query = $_GET['s'];
      }
      $wp_admin_bar->add_menu(array(
        'id' => 'mwsb_product_admin_bar_form',
        'parent' => 'top-secondary',
        'title' => '<form method="get" action="'.get_site_url().'/wp-admin/edit.php?post_type=product"><input name="s" type="text" value="'.esc_attr($mementordb_search_query).'"  placeholder="'.esc_attr__('Search Product', 'mementordb' ).'"/><input type="submit" value="'.esc_attr__('Search Products', 'mementordb' ).'"/><input name="post_type" value="product" type="hidden"></form>'
      ));
    }

    public function mementordb_product_order_admin_bar_form() {
      global $wp_admin_bar;
      $mementordb_search_query = '';
      if (isset($_GET['post_type']) == 'shop_order') {
        $mementordb_search_query = $_GET['s'];
      }
			$wp_nonce_url_ajax = wp_nonce_url(admin_url('admin-post.php?action=purge_cache&type=all'), 'purge_cache_all');
			$wp_nonce_url_ajax = str_replace("&amp;", "&", $wp_nonce_url_ajax);
      $wp_admin_bar->add_menu(array(
        'id' => 'mwsb_product_order_admin_bar_form',
        'parent' => 'top-secondary',
        'title' => '<form method="get" action="'.get_site_url().'/wp-admin/edit.php?post_type=shop_order"><input name="s" type="text" value="'.esc_attr($mementordb_search_query).'" placeholder="'.esc_attr__('Search Order', 'mementordb').'"/><input type="submit" value="'.esc_attr__('Search orders', 'mementordb').'"/><input name="post_type" value="shop_order" type="hidden"></form><script>var new_ajax_admin = "'.$wp_nonce_url_ajax.'";</script>'
      ));
    }

    public function mementordb_woocommerce_admin_product_search($wp) {
      global $pagenow, $wpdb;
      if ('edit.php' != $pagenow) return;
      if (!isset($wp->query_vars['s'])) return;
      if ($wp->query_vars['post_type']!='product') return;
      if ('#' == substr($wp->query_vars['s'], 0, 1)) :
        $mementordb_id = absint(substr($wp->query_vars['s'], 1));
      if (!$mementordb_id) return;
      unset($wp->query_vars['s']);
      $wp->query_vars['p'] = $mementordb_id;
      elseif ('SKU:' == strtoupper(substr($wp->query_vars['s'], 0, 4))) :
        $sku = trim(substr($wp->query_vars['s'], 4));
      if (!$sku) return;
      $prepared_statement = $wpdb->prepare('SELECT post_id FROM '.$wpdb->postmeta.' WHERE meta_key="_sku" AND meta_value LIKE "%'.$sku.'%";');
      $mementordb_ids = $wpdb->get_col($prepared_statement);
      if (!$mementordb_ids) return;
      unset($wp->query_vars['s']);
      $wp->query_vars['post__in'] = $mementordb_ids;
      $wp->query_vars['sku'] = $sku;
      endif;
    }

    public function mementordb_woocommerce_admin_product_search_label($query) {
      global $pagenow, $typenow, $wp;
      if ('edit.php' != $pagenow) return $query;
      if ($typenow != 'product') return $query;
      $s = get_query_var('s');
      if ($s) return $query;
      $sku = get_query_var('sku');
      if ($sku) {
        $post_type = get_post_type_object($wp->query_vars['post_type']);
        return sprintf(__( '[%s with SKU of %s]', 'mementordb'), $post_type->labels->singular_name, $sku);
      }
      $p = get_query_var('p');
      if ($p) {
        $post_type = get_post_type_object($wp->query_vars['post_type']);
        return sprintf(__( '[%s with ID of %d]', 'mementordb'), $post_type->labels->singular_name, $p);
      }
      return $query;
    }

    public function mementordb_user_profile_info($wp_admin_bar) {
      global $current_user;
      if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        $mementordb_billing_country = get_user_meta($current_user->ID, 'billing_country', true);
        $mementordb_billing_state = get_user_meta($current_user->ID, 'billing_state', true);
        if (!empty($mementordb_billing_country) && !empty($mementordb_billing_state)) {
          $mementordb_args = array(
            'id' => 'user-info',
            'title' => "<img alt='' src='".esc_url(get_avatar_url($current_user->ID))."' class='avatar avatar-64 photo' height='64' width='64' /><span class='display-name'>" . esc_html($current_user->display_name)."</span><span class='username'><i class='icon-pin'></i> ".esc_html($mementordb_billing_state).", ".esc_html($mementordb_billing_country)."</span>",
            'parent' => 'user-actions',
            'href' => ' https://install.mementor.no/wp-admin/profile.php',
            'meta' => array('class' => 'my-toolbar-page')
          );
        } else {
          $mementordb_args = array(
            'id' => 'user-info',
            'title' => "<img alt='' src='". esc_url(get_avatar_url($current_user->ID))."' class='avatar avatar-64 photo' height='64' width='64' /><span class='display-name'>". esc_html($current_user->display_name)."</span><span class='username'>".esc_html($current_user->user_email)."</span>",
            'parent' => 'user-actions',
            'href' => ' https://install.mementor.no/wp-admin/profile.php',
            'meta' => array('class' => 'my-toolbar-page')
          );
        }
      } else {
        $mementordb_args = array(
          'id' => 'user-info',
          'title' => "<img alt='' src='".esc_url(get_avatar_url($current_user->ID))."' class='avatar avatar-64 photo' height='64' width='64' /><span class='display-name'>".esc_html($current_user->display_name)."</span><span class='username'>".esc_html($current_user->user_email)."</span>",
          'parent' => 'user-actions',
          'href' => ' https://install.mementor.no/wp-admin/profile.php',
          'meta' => array('class' => 'my-toolbar-page')
        );
      }
      $wp_admin_bar->add_node($mementordb_args);
    }
  }

  function mementordb_woo_admin_bar_instance() {
    return Mementordb_Woo_Admin_Bar::mementordb_woo_admin_bar_instance();
  }
  mementordb_woo_admin_bar_instance();

}

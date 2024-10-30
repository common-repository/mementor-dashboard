<?php
/**
 * Mementor Admin Setting Page
 *
 * @author   Mementor
 * @package  Mementor Dashboard
 * @version  1.0
 */
if (!defined('ABSPATH')) {
  exit;
}
?>
<div class="mementor-wrap">
  <div class="mementor-wrap-container">
    <div class="mementor-content-wrap">
      <div class="mementor-settings-wrapper">
        <?php
					if (isset($_POST['mementordb-update-form-details']) || wp_verify_nonce(isset($_POST['mementordb-update-form-details']), 'mementordb-update-form-details')) {
            $mementordb_msg = false;
				    // Custom logo
				    if (isset($_POST['mementordb-form-logo'])) {
			        $mementordb_form_logo  = esc_url($_POST['mementordb-form-logo']);
			        update_option('mementordb-form-logo', $mementordb_form_logo);
			        $mementordb_msg = true;
				    }
				    // Custom background
				    if (isset($_POST['mementordb-form-background'])) {
			        $mementordb_form_bg  = esc_url($_POST['mementordb-form-background']);
			        update_option('mementordb-form-background', $mementordb_form_bg);
			        $mementordb_msg = true;
				    }
				    // Redirect url
				    if (isset($_POST['mementordb-form-redirect'])) {
			        $mementordb_form_redirect = mementordb_repeater_sanitize($_POST['mementordb-form-redirect'], 'mementordb-form-redirect');
			        update_option('mementordb-form-redirect', $mementordb_form_redirect);
			        $mementordb_msg = true;
				    }
				    // Redirect user role
				    if (isset($_POST['mementordb-user-role'])) {
              $mementordb_user_role = mementordb_repeater_sanitize($_POST['mementordb-user-role'], 'mementordb-user-role', 'text');
              update_option('mementordb-user-role', $mementordb_user_role);
              $mementordb_msg = true;
				    }
				    // Live chat script
				    if (isset($_POST['mementordb-custom-js'])) {
              $mementordb_custom_js = base64_encode($_POST['mementordb-custom-js']);
              update_option('mementordb-custom-js', $mementordb_custom_js);
              $mementordb_msg = true;
				    }
				    // Phone
				    if (isset($_POST['mementordb-phone-number'])) {
              $mementordb_phone_number = sanitize_text_field($_POST['mementordb-phone-number']);
              update_option('mementordb-phone-number', $mementordb_phone_number);
              $mementordb_msg = true;
				    }
				    // Email
				    if (isset($_POST['mementordb-email-address'])) {
              $mementordb_email = sanitize_email($_POST['mementordb-email-address']);
              update_option('mementordb-email-address', $mementordb_email);
              $mementordb_msg = true;
				    }
				    // Skype
				    if (isset($_POST['mementordb-skype'])) {
              $mementordb_skype = sanitize_text_field($_POST['mementordb-skype']);
              update_option('mementordb-skype', $mementordb_skype);
              $mementordb_msg = true;
				    }
				    // Slack
				    if (isset($_POST['mementordb-slack'])) {
              $mementordb_slack = sanitize_text_field($_POST['mementordb-slack']);
              update_option('mementordb-slack', $mementordb_slack);
              $mementordb_msg = true;
				    }
				    // Website
				    if (isset($_POST['mementordb-support'])) {
              $mementordb_support = esc_url($_POST['mementordb-support']);
              update_option('mementordb-support', $mementordb_support);
              $mementordb_msg = true;
				    }
				    // Facebook
				    if (isset($_POST['mementordb-facebook'])) {
              $mementordb_facebook = esc_url($_POST['mementordb-facebook']);
              update_option('mementordb-facebook', $mementordb_facebook);
              $mementordb_msg = true;
				    }
				    // Messages
				    if (isset($mementordb_msg) && !empty($mementordb_msg)) {
              echo '<div class="updated">'.esc_html__('Setting was updated successfully', 'mementordb').'</div>';
				    } else {
              echo '<div class="error">'.esc_html__('Setting was not successfully updated', 'mementordb').'</div>';
				    }
					}
        ?>
        <form method="post" id="mementor-login-form" class="myForms">
          <div class="form-wrap">
            <h4><?php _e( 'Settings', 'mementordb' ); ?></h4>
            <h2><?php _e( 'Login Form', 'mementordb' ); ?></h2>
            <?php
      				if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
      				} else {
        				wp_enqueue_style('thickbox');
        				wp_enqueue_script('media-upload');
        				wp_enqueue_script('thickbox');
      				}
            ?>
            <div class="image-wrapper form-field mementor_plugin_options">
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Custom Logo', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <?php if (get_option('mementordb-form-logo')) { ?>
                  <div class="upload-form">
                    <input type="text" value="<?php if (get_option('mementordb-form-logo')) echo get_option('mementordb-form-logo'); ?>" placeholder="No file selected" class="mementor_login_logo" id="mementor_login_logo" name="mementordb-form-logo" />
                    <button class="mementor_login_logo_setter button"><?php echo esc_html_e('Change', 'mementordb'); ?></button>
                    <button class="mementor_login_logo_remover button"><?php echo esc_html_e('Remove', 'mementordb'); ?></button>
                  </div>
                  <div class="mementor_login_logo_set"> <img src="<?php echo get_option('mementordb-form-logo'); ?>" alt="logo" /> </div>
                  <?php } else { ?>
                  <div class="upload-form">
                    <input type="text" value="<?php if (get_option('mementordb-form-logo')): echo get_option('mementordb-form-logo'); endif; ?>" class="mementor_login_logo" id="mementor_login_logo" name="mementordb-form-logo" placeholder="No file selected" />
                    <button class="mementor_login_logo_setter button"><?php echo esc_html_e( 'Choose File', 'mementordb' ); ?></button>
                    <button class="mementor_login_logo_remover button mementor_hidden"><?php echo esc_html_e( 'Remove', 'mementordb' ); ?></button>
                  </div>
                  <div class="mementor_login_logo_set mementor_hidden"> <img src="#" alt="logo" /> </div>
                  <?php } ?>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Form Background', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <?php if (get_option('mementordb-form-background')) { ?>
                    <div class="upload-form">
                      <input type="text" value="<?php if (get_option('mementordb-form-background')): echo get_option('mementordb-form-background'); endif; ?>" class="mementor_login_background" id="mementor_login_background" name="mementordb-form-background" placeholder="No file selected"/>
                      <button class="mementor_login_background_setter button"><?php echo esc_html_e('Change', 'mementordb'); ?></button>
                      <button class="mementor_login_background_remover button"><?php echo esc_html_e('Remove', 'mementordb'); ?></button>
                    </div>
                    <div class="mementor_login_background_set"> <img src="<?php echo get_option('mementordb-form-background'); ?>" alt="logo" /> </div>
                  <?php } else { ?>
                    <div class="upload-form">
                      <input type="text" value="<?php if (get_option('mementordb-form-background')) echo get_option('mementordb-form-background'); ?>" class="mementor_login_background" id="mementor_login_background" name="mementordb-form-background" placeholder="No file selected"/>
                      <button class="mementor_login_background_setter button"><?php echo esc_html_e('Choose File', 'mementordb'); ?></button>
                      <button class="mementor_login_background_remover button mementor_hidden"><?php echo esc_html_e('Remove', 'mementordb'); ?></button>
                    </div>
                    <div class="mementor_login_background_set mementor_hidden"> <img src="#" alt="logo" /> </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="mementor-form-redirect form-wrap" id="mementor-form-redirect">
              <h2><?php echo esc_html__('Login Redirect', 'mementordb'); ?></h2>
              <div id="myRepeatingFields">
                <?php
          				$form_redirect_links = get_option('mementordb-form-redirect');
          				$user_roles = get_option('mementordb-user-role');
          				if (isset($form_redirect_links) && !empty($form_redirect_links)) {
                    $counter = 0;
          					foreach ($form_redirect_links as $form_redirect_link) {
          						if (!empty($form_redirect_link)) {
                        ?>
                        <div class="entry input-group">
                          <div class="row">
                            <div class="col-sm-2">
                              <h2><?php echo esc_html__('User Role', 'mementordb'); ?></h2>
                            </div>
                            <div class="col-sm-10">
                              <select name="mementordb-user-role[]">
                                <?php wp_dropdown_roles($user_roles[$counter]); ?>
                              </select>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2">
                              <h2><?php echo esc_html__('User Role', 'mementordb'); ?></h2>
                            </div>
                            <div class="col-sm-10">
                              <div class="input-parent">
                                <input class="form-control" value="<?php echo $form_redirect_link; ?>" name="mementordb-form-redirect[]" type="text" placeholder="<?php echo esc_attr__('Placeholder Redirect Link', 'mementordb'); ?>" />
                              </div>
                            </div>
                            <span class="input-group-btn add-btn">
                              <button type="button" class="btn btn-lg btn-remove btn-danger"><span class="dashicons dashicons-minus"></span></button>
                            </span>
                          </div>
                        </div>
                        <?php
                      }
                      $counter++;
                    }
                  }
                ?>
                <div class="entry input-group col-xs-3">
                  <div class="row">
                    <div class="col-sm-2">
                      <h2><?php echo esc_html__('User Role', 'mementordb'); ?></h2>
                    </div>
                    <div class="col-sm-10">
                      <select name="mementordb-user-role[]">
                        <?php wp_dropdown_roles('editor'); ?>
                      </select>
                    </div>
                  </div>
                  <div class="input-parent">
                    <div class="row">
                      <div class="col-sm-2">
                        <h2><?php echo esc_html__('Redirect Link', 'mementordb'); ?></h2>
                      </div>
                      <div class="col-sm-10">
                        <input class="form-control" name="mementordb-form-redirect[]" type="text" placeholder="<?php echo esc_attr__('Placeholder Redirect Link', 'mementordb'); ?>" />
                      </div>
                    </div>
                    <span class="input-group-btn add-btn">
                      <button type="button" class="btn btn-success btn-lg btn-add"> <span class="dashicons dashicons-plus" aria-hidden="true"></span> </button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="mementor-custom-js form-wrap" id="custom-code">
              <h2><?php echo esc_html__('Admin Support Chat', 'mementordb'); ?></h2>
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Live Chat Code', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <textarea name="mementordb-custom-js" id="mementordb-custom-js" rows="5"><?php echo stripslashes(base64_decode(get_option('mementordb-custom-js'))); ?></textarea>
                </div>
              </div>
            </div>
            <div class="mementor-contact-details form-wrap" id="contact-details">
              <h2><?php echo esc_html__('Contact Details', 'mementordb'); ?></h2>
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Phone Number', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <input class="form-control" id="mementordb-phone-number" value="<?php echo (get_option('mementordb-phone-number')) ? get_option('mementordb-phone-number') : '+47 56 12 30 10'; ?>" name="mementordb-phone-number" type="text" placeholder="<?php echo esc_attr__('Phone Number', 'mementordb'); ?>" />
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Email Address', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <input class="form-control" id="mementordb-email-address" value="<?php echo (get_option('mementordb-email-address')) ? get_option('mementordb-email-address') : 'post@mementor.no'; ?>" name="mementordb-email-address" type="text" placeholder="<?php echo esc_attr__('Email Address', 'mementordb'); ?>" />
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Skype', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <input class="form-control" id="mementordb-skype" value="<?php echo get_option('mementordb-skype'); ?>" name="mementordb-skype" type="text" placeholder="<?php echo esc_attr__('Skype ID', 'mementordb'); ?>" />
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Slack', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <input class="form-control" id="mementordb-slack" value="<?php echo get_option('mementordb-slack'); ?>" name="mementordb-slack" type="text" placeholder="<?php echo esc_attr__('Slack', 'mementordb'); ?>" />
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Website', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <input class="form-control" id="mementordb-support" value="<?php echo get_option('mementordb-support'); ?>" name="mementordb-support" type="text" placeholder="<?php echo esc_attr__('Website', 'mementordb'); ?>" />
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <h2><?php echo esc_html__('Facebook', 'mementordb'); ?></h2>
                </div>
                <div class="col-sm-10">
                  <input class="form-control" id="mementordb-facebook" value="<?php echo get_option('mementordb-facebook'); ?>" name="mementordb-facebook" type="text" placeholder="<?php echo esc_attr__('Facebook', 'mementordb'); ?>" />
                </div>
              </div>
              <?php wp_nonce_field('mementordb-update-form-details', 'mementordb-update-form-details'); ?>
              <div class="form-button form-field">
                <input type="submit" name="mementordb-submit-form-details" id="submit-form-details" class="button button-primary" value="<?php echo esc_html__('Save Changes','mementordb');?>" />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
function mementordb_repeater_sanitize($mementordb_value, $mementordb_id, $mementordb_type = 'link') {
  $sanitized_value = array();
  if (!is_array($mementordb_value)) {
    return array();
  }
  foreach ($mementordb_value as $mementordb_key => $mementordb_subvalue) {
    $mementordb_sanitized_value[$mementordb_key] = $mementordb_subvalue;
    if (isset($mementordb_sanitized_value[$mementordb_key]) && $mementordb_type == 'text') {
      $mementordb_sanitized_value[$mementordb_key] = sanitize_text_field($mementordb_sanitized_value[$mementordb_key]);
    } else if (isset($mementordb_sanitized_value[$mementordb_key])) {
      $mementordb_sanitized_value[$mementordb_key] = esc_url_raw($mementordb_sanitized_value[$mementordb_key]);
    }
  }
  return $mementordb_sanitized_value;
}
?>

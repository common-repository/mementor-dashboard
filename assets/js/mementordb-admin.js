jQuery(function($) {
  $("#wp-admin-bar-user-info").prependTo("#adminmenuwrap");
  $("#wp-admin-bar-mwsb_product_admin_bar_form").appendTo("#wp-admin-bar-user-info");
  $("#wp-admin-bar-mwsb_product_order_admin_bar_form").appendTo("#wp-admin-bar-user-info");
  $("#wp-admin-bar-WPML_ALS").insertAfter("#toplevel_page_sitepress-multilingual-cms-menu-languages");
  $("#wp-admin-bar-WPML_ALS").wrap("<div id='admin-languages'><div class='admin-languages'><div id='admin-languages-inner'></div></div></div>");
  $("#wp-admin-bar-user-info .ab-item").append("<a href='/wp-admin/profile.php' class='profile-link'></a>");
  $('.toplevel_page_slack a').click(function() {
    $(this).attr('target', '_blank');
  });
  $('.toplevel_page_support a').click(function() {
    $(this).attr('target', '_blank');
  });
  $('.toplevel_page_facebook a').click(function() {
    $(this).attr('target', '_blank');
  });
  $("#toplevel_page_wp-rocket").click(function(e) {
    e.preventDefault();
    var loader = $(this).find(".wp-menu-name");
    loader.append("<span>...</span>");
    return $.ajax({
      type: "get",
      url: new_ajax_admin,
      error: function(xhr, error, thrown) {
        console.log(thrown);
        loader.find("span").addClass('error').text("Error").fadeOut('slow');
      },
      success: function(data) {
        console.log(data);
        loader.find("span").addClass('success').text("Clear").fadeOut('slow');
      }
    });
  });
});

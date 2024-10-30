jQuery(function($) {

  $(".mementor-settings-wrapper .nav-tab-wrapper a").click(function(event) {
    event.preventDefault();
    $(".mementor-settings-wrapper .nav-tab-wrapper a").removeClass("nav-tab-active");
    $(this).addClass("nav-tab-active");
    var tab = $(this).attr("href");
    $(".mementor-content-wrap .tab-content").not(tab).css("display", "none");
    $(tab).fadeIn();
  });

  $(document).ready(function($) {

    // Upload Form Logo
    $('.form-logo-upload').click(function(e) {
      e.preventDefault();
      var custom_uploader = wp.media({
        title: 'Custom Image',
        button: {
          text: 'Upload Image'
        },
        multiple: false
      }).on('select', function() {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        $('.form-logo').attr('src', attachment.url);
        $('.form-logo-url').val(attachment.url);
      }).open();
    });

    // Upload Form Background
    $('.form-background-upload').click(function(e) {
      e.preventDefault();
      var custom_uploader = wp.media({
        title: 'Custom Image',
        button: {
          text: 'Upload Image'
        },
        multiple: false
      }).on('select', function() {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        $('.form-background').attr('src', attachment.url);
        $('.form-background-url').val(attachment.url);
      }).open();
    });

    // Media library Init */
    if ($('.mementor_plugin_options .mementor_login_logo_setter').length > 0) {
      if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
        $('.mementor_plugin_options').on('click', '.mementor_login_logo_setter', function (e) {
          e.preventDefault();
          var button = $(this);
          var id = button.prev();
          wp.media.editor.send.attachment = function (props, attachment) {
            var mementor_img_url = attachment.url;
            id.val(mementor_img_url);
            button.parent().find('.mementor_login_logo_set img').attr('src', mementor_img_url);
            button.parent().find('.mementor_login_logo_set').removeClass('mementor_hidden');
            button.parent().find('.mementor_login_logo_set').slideDown();
            button.html('Change');
            button.parent().find('.mementor_login_logo_remover').removeClass('mementor_hidden');
            button.parent().find('.mementor_login_logo_remover').slideDown();
          };
          wp.media.editor.open(button);
          return false;
        });
      }
    }

    $(document).on('click', '.mementor_plugin_options .mementor_login_logo_remover', function (e) {
      e.preventDefault();
      $(this).parent().find('.mementor_login_logo_set').slideUp();
      $(this).parent().find('.mementor_login_logo').val(null);
      $(this).parent().find('.mementor_login_logo_setter');
      $(this).fadeOut();
    });

    if ($('.mementor_plugin_options .mementor_login_background_setter').length > 0) {
      if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
        $('.mementor_plugin_options').on('click', '.mementor_login_background_setter', function (e) {
          e.preventDefault();
          var button = jQuery(this);
          var id = button.prev();
          wp.media.editor.send.attachment = function (props, attachment) {
            var mementor_img_url = attachment.url;
            id.val(mementor_img_url);
            button.parent().find('.mementor_login_background_set img').attr('src', mementor_img_url);
            button.parent().find('.mementor_login_background_set').removeClass('mementor_hidden');
            button.parent().find('.mementor_login_background_set').slideDown();
            button.html('Change');
            button.parent().find('.mementor_login_background_remover').removeClass('mementor_hidden');
            button.parent().find('.mementor_login_background_remover').slideDown();
          };
          wp.media.editor.open(button);
          return false;
        });
      }
    }

    $(document).on('click', '.mementor_plugin_options .mementor_login_background_remover', function (e) {
      e.preventDefault();
      $(this).parent().find('.mementor_login_background_set').slideUp();
      $(this).parent().find('.mementor_login_background').val(null);
      $(this).parent().find('.mementor_login_background_setter');
      $(this).fadeOut();
    });

    // Repeater Field Js
		$(document).on('click', '.btn-add', function(e) {
			e.preventDefault();
			var controlForm = $('#myRepeatingFields:first'),
				currentEntry = $(this).parents('.entry:first'),
				newEntry = $(currentEntry.clone()).appendTo(controlForm);
      newEntry.find('input').val('');
      controlForm.find('.entry:not(:last) .btn-add')
        .removeClass('btn-add').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
				.html('<span class="dashicons dashicons-minus"></span>');
    }).on('click', '.btn-remove', function(e) {
			e.preventDefault();
			$(this).parents('.entry:first').remove();
			return false;
		});
  });

});

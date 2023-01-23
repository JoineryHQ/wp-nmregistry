jQuery(function($){
  // Hide "update profile" button if "wpua-add-existing" doesn't exist. It
  // only exists for people who have access to the image browser, who then
  // need the "update profile" button; those who don't have it will use the 
  // "Upload" button.
  if (!$('p#wpua-add-button-existing').length) {
    $('form.wpua-edit p.submit').hide();
  }
  
  // If there's a success message (e.g. "profile updated"), color it for better visibility.
  $('div.success p').addClass('wppb-success');
  
  // Alter the caption on current image
  $('p#wpua-preview-existing span.description').html('Current image');
  
  // Hide Upload button until File is selected.
  $('button#wpua-upload-existing').hide();
  $('input#wpua-file-existing').change(function(){
    $('button#wpua-upload-existing').fadeOut('fast').fadeIn('fast');    
  });
})

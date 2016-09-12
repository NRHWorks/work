(function ($) {
  
  $(document).ready(function() {

    $('#edit-field-developer-und').change( function() {

      var user_id = $(this).val();
      
      $('#edit-field-payment-time-und .form-type-checkbox').each( function() {
        if ($(this).children('label').html().indexOf(user_id + ']') !== -1) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });

    var user_id = $('#edit-field-developer-und').val();
    
    $('#edit-field-payment-time-und .form-type-checkbox').each( function() {
      if ($(this).children('label').html().indexOf(user_id + ']') !== -1) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });

  });
}(jQuery));

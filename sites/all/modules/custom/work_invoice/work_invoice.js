(function ($) {
  
  $(document).ready(function() {
    $('#edit-field-client-und').change( function() {

      var client_id = $(this).val();
      
      $('#edit-field-invoice-task-und .form-type-checkbox').each( function() {
        if ($(this).children('label').html().indexOf('@' + client_id) !== -1) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  });

}(jQuery));

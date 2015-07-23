function reset_height() {
  jQuery("#task-left").css('height', 'auto');    
  jQuery("#task-right").css('height', 'auto');    

  if (jQuery("#task-left").height() > jQuery('#task-right').height()) {
    jQuery("#task-right").height(jQuery("#task-left").height() + 20);
  } else {
    jQuery("#task-left").height(jQuery("#task-right").height());
  }
}

(function ($) {

  $(document).ready(function() {
    if ($("#task-left").height() > $('#task-right').height()) {
      $("#task-right").height($("#task-left").height() + 20);
    } else {
      $("#task-left").height($("#task-right").height());
    }

    $("ul.task a").click(function() {

      $('#task-right .right-wrapper').hide();
      $('#task-right #' + $(this).data('show') + '-wrapper').show();

      reset_height();

      $('#task-right li').removeClass('active');
      $(this).parent().addClass('active');
      
      $('#task-right li a').removeClass('active');
      $(this).addClass('active');

      if ($("#task-left").height() > $('#task-right').height()) {
        $("#task-right").height($("#task-left").height() + 20);
      } else {
        $("#task-left").height($("#task-right").height());
      }
    });

    $(".field-name-field-to-do input:checkbox").change(function() {
      if ($(this).attr('checked') == true) {
        $(this).parent().siblings('div').addClass('todo-done');
      } else {
        $(this).parent().siblings('div').removeClass('todo-done');
      }
 
      $.post('/tasks/update-todo/' + $(this).data('todo')); 
      
    });

    $('.datepicker').datepicker();

    $('input').focus( function () {
      if ($(this).val() == $(this).data('init')) {
        $(this).val('');
        $(this).removeClass('init');
        $(this).addClass('active');
      }
    });
    
    $('textarea').focus( function () {
      if ($(this).val() == $(this).data('init')) {
        $(this).val('');
        $(this).removeClass('init');
        $(this).addClass('active');
      }
    });
    
  });

}(jQuery));

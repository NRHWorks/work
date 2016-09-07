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
    schedule.assigned_to_me_toggle();

    $('.status-link').click(function() {
      $(this).parent().html('<img src="/sites/all/modules/custom/work_theme/images/loading.gif" style="width: 20px; height: auto;" />');
    });

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
      var thisCheckbox = $(this);
      $.post('/tasks/update-todo/' + $(this).data('todo'), function(d, status){
        if (status == 'success') {
          work_log.update_log_by_todo_eid(thisCheckbox.data('todo'));
        }
      });
      
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

    $('.browser_test i').click(function() {
      work_browser_test.icon_click(this);
    });

    $('tr.hover-color td').hover(function() {
      $('.col-' + $(this).data('col')).addClass('blue-hover');
    },
    function() {
      $('.col-' + $(this).data('col')).removeClass('blue-hover');
    });
  });

}(jQuery));

var work_browser_test =(function ($) {
  return {
    icon_click: function(clicked) {
      $.post('/work-browser-test/status/' + $(clicked).data('nid') + '/' + $(clicked).data('page') + '/' + $(clicked).data('browser') + '/' + $(clicked).data('resolution') + '/' + $(clicked).data('status'));

      if ($(clicked).data('status') == 'Passed') {
        $(clicked).parent().addClass('pass');
        $(clicked).parent().removeClass('in-progress');
        $(clicked).parent().removeClass('needs-tested');
        $(clicked).parent().html(' <i  class="icon-ok-1" data-nid="' + $(clicked).data('nid')  +  '" data-page="' + $(clicked).data('page')  +'" data-browser="' + $(clicked).data('browser')  +'" data-resolution="' + $(clicked).data('resolution')  + '" data-status="Needs Tested"> </i>');
      } 

      if ($(clicked).data('status') == 'Failed') {
        $(clicked).parent().addClass('fail');
        $(clicked).parent().removeClass('in-progress');
        $(clicked).parent().removeClass('needs-tested');
        $(clicked).parent().html(' <i  class="icon-cancel" data-nid="' + $(clicked).data('nid')  +  '" data-page="' + $(clicked).data('page')  +'" data-browser="' + $(clicked).data('browser')  +'" data-resolution="' + $(clicked).data('resolution')  + '" data-status="Needs Tested"> </i>');
      } 
      
      if ($(clicked).data('status') == 'Failed-Ticket') {
        $(clicked).parent().addClass('fail');
        $(clicked).parent().removeClass('in-progress');
        $(clicked).parent().removeClass('needs-tested');
        $(clicked).parent().html(' <i  class="icon-cancel" data-nid="' + $(clicked).data('nid')  +  '" data-page="' + $(clicked).data('page')  +'" data-browser="' + $(clicked).data('browser')  +'" data-resolution="' + $(clicked).data('resolution')  + '" data-status="Needs Tested"> </i>');
       
        window.open('http://work.nrhworks.com/tasks/add/' + $(clicked).data('nid') + '?task=Browser Test&browser=' + $(clicked).data('browser') + '&resolution=' + $(clicked).data('resolution') + '&page=' + $(clicked).data('page'));
      } 

      if ($(clicked).data('status') == 'Needs Tested') {
        $(clicked).parent().addClass('in-progress');
        $(clicked).parent().removeClass('pass');
        $(clicked).parent().removeClass('fail');
        $(clicked).parent().html(' <i style="color:green;" class="icon-ok-circled" data-nid="' + $(clicked).data('nid')  +  '" data-page="' + $(clicked).data('page')  +'" data-browser="' + $(clicked).data('browser')  +'" data-resolution="' + $(clicked).data('resolution')  + '" data-status="Passed"> </i><br /><i style="color:red;" class="icon-cancel-circled" data-nid="' + $(clicked).data('nid')  +  '" data-page="' + $(clicked).data('page')  +'" data-browser="' + $(clicked).data('browser')  +'" data-resolution="' + $(clicked).data('resolution')  + '" data-status="Failed"> </i> <br /><i style="color:blue;" class="icon-ticket" data-nid="' + $(clicked).data('nid')  +  '" data-page="' + $(clicked).data('page')  +'" data-browser="' + $(clicked).data('browser')  +'" data-resolution="' + $(clicked).data('resolution')  + '" data-status="Failed-Ticket"> </i>');
      } 

      $('.browser_test i').unbind('click');

      $('.browser_test i').click(function() {
        work_browser_test.icon_click(this);
      });
    }
  }
}(jQuery));

var work_log = (function ($) {
  return {
    update_log: function(nid){
      $.get("/work-log/ajax/get-log-by-nid/" + nid, function(data, status){
        $("#log-wrapper").html(data);
      });
    },
    update_log_by_todo_eid:function(eid) {
     $.get("/work-log/ajax/get-log-by-todo-eid/" + eid, function(data, status){
        $("#log-wrapper").html(data);
      });
    },
    update_log_comments: function(nid){
      $.get("/work-log/ajax/get-log-by-nid/" + nid, function(data, status){
        $("#log-wrapper").html(data);
      });
      $.get("/tasks/ajax/get-comments-by-nid/" + nid, function(data, status){
        $("#comments-container").html(data);
      });
    },
  }
}(jQuery));


var schedule = (function ($) {
  return {
    assigned_to_me_toggle: function(){
      if ($("input[name='assigned_to_me']").attr('checked')) {
        $("li.not-assigned-to-me").hide();
      }
      else {
        $("li.not-assigned-to-me").show();
      }
    }
  }
}(jQuery));

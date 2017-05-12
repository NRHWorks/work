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
    project.sprint_tabs_initialization();

    $('.status-link').click(function() {
      $(this).parent().html('<img src="/sites/all/modules/custom/work_theme/images/loading.gif" style="width: 20px; height: auto;" />');
    });

    if ($("#task-left").height() > $('#task-right').height()) {
      $("#task-right").height($("#task-left").height() + 20);
    } else {
      $("#task-left").height($("#task-right").height());
    }

    $("ul.task a").click(function() {

      $('#project-right .right-wrapper').hide();
      $('#project-right #' + $(this).data('show') + '-wrapper').show();

      reset_height();

      $('#project-right li').removeClass('active');
      $(this).parent().addClass('active');

      $('#project-right li a').removeClass('active');
      $(this).addClass('active');

      if ($("#project-left").height() > $('#project-right #' + $(this).data('show') + '-wrapper').height()) {
        $("#project-right").height($("#project-left").height() + 20);
      } else {
        $("#project-left").height($('#project-right #' + $(this).data('show') + '-wrapper').height());
        $("#project-right").height($('#project-right #' + $(this).data('show') + '-wrapper').height());
      }

      $('#story-right .right-wrapper').hide();
      $('#story-right #' + $(this).data('show') + '-wrapper').show();

      reset_height();

      $('#story-right li').removeClass('active');
      $(this).parent().addClass('active');

      $('#story-right li a').removeClass('active');
      $(this).addClass('active');

      if ($("#story-left").height() > $('#story-right #' + $(this).data('show') + '-wrapper').height()) {
        $("#story-right").height($("#story-left").height() + 20);
      } else {
        $("#story-left").height($('#story-right #' + $(this).data('show') + '-wrapper').height() + 100);
        $("#story-right").height($('#story-right #' + $(this).data('show') + '-wrapper').height() + 100);
      }
    });

    $(".field-name-field-to-do input:checkbox").change(function() {
      if ($(this).attr('checked') == true) {
        $(this).parent().siblings('div').addClass('todo-done');
      } else {
        $(this).parent().siblings('div').removeClass('todo-done');
      }
      var thisCheckbox = $(this);
      $.post('/stories/update-todo/' + $(this).data('todo'), function(d, status){
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

    var st = $.cookie("sprints_tabs");
    if (st !== undefined) {
      sprint.switch_tab(st);
    }

    var st = $.cookie("stories_tabs");
    if (st !== undefined) {
      story.switch_tab(st);
    }

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

        window.open('http://work.nrhworks.com/stories/add/' + $(clicked).data('nid') + '?task=Browser Test&browser=' + $(clicked).data('browser') + '&resolution=' + $(clicked).data('resolution') + '&page=' + $(clicked).data('page'));
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
      $.get("/stories/ajax/get-comments-by-nid/" + nid, function(data, status){
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



var project = (function ($) {
  return {
    sprint_tabs_initialization: function(){
      // var project_nid and sprint_tabs are set in node--project.tpl.php.

      // First check if this page is a project page.
      if (typeof(project_nid) == "undefined") {
        return;
      }

      // Put the elements in the correct tabs.
      $("#block-views-tasks-block-3").appendTo(".task-tab-content-0");
      $("#block-views-tasks-block-1").appendTo(".task-tab-content-0");
      $("#block-views-tasks-block-2").appendTo(".task-tab-content-0");
//      $("#block-views-sprint-backlog-block").appendTo(".task-tab-content-1");
//      $("#block-views-tasks-block-5").appendTo(".task-tab-content-1");
      $("#block-work-sprint-work-sprint-project-backlog").appendTo(".task-tab-content-1");
      $("#block-block-1").appendTo(".task-tab-content-2");

      // Show the proper tab.
      var tab_cookie = $.cookie("project_sprint_tabs");

      project.switch_to(sprint_tabs == 0 ? 0 : (tab_cookie == null? 1 : tab_cookie));
    },

    switch_to: function(index){
      $(".task-tab-content").removeClass("active");
      $(".task-tab-content-" + index).addClass("active");
      $(".task-tab").removeClass("active");
      $(".task-tab-" + index).addClass("active");
      $.cookie("project_sprint_tabs", index, { path : "/" });
    }
  }
}(jQuery));

var sprint = (function ($) {
  return {
    switch_tab: function(index) {
      $('.sprint-div').hide();
      $('#' + index).show();

      $('.tabs  a').removeClass('active');
      $('#' + index + '-link').addClass('active');
      $.cookie("sprints_tabs", index);

    }
  }
}(jQuery));


var story = (function ($) {
  return {
    switch_tab: function(index) {
      $('.stories-div').hide();
      $('#' + index).show();

      $('.tabs  a').removeClass('active');
      $('#' + index + '-link').addClass('active');
      $.cookie("stories_tabs", index);

    }
  }
}(jQuery));

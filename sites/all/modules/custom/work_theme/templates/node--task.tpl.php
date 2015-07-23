<?php
  // We hide the comments and links now so that we can render them later.
  hide($content['comments']);
  hide($content['links']);
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <div id="node-status-div">
    <?php 
      $terms = taxonomy_get_tree(2);

      foreach ($terms as $t) {
        if  ($t->tid != 8) {
          print "<a href='#' onclick='jQuery(\"#node-status-div\").hide(); jQuery(\"#node-status\").html(\"{$t->name}\"); jQuery.post(\"/tasks/update-status/{$node->nid}/{$t->tid}\")'>{$t->name}</a>\n";
        }
      } 
    ?>
  </div>

  <div id="task-left">
    <div class="row">
      <div class="half">
        <?php print render($content['field_due_date']); ?>
      </div>
      <div class="half">
        <?php print render($content['field_status']); ?>
      </div>
      <div class="clear"></div>
    </div>

    <?php print render($content['field_assigned_to']); ?><br />
    <?php print render($content['field_users']); ?> <br /> 

    <?php print render($content['body']); ?><br />
    <?php print render($content['field_to_do']); ?><br />
   
    <div class="field-label gray">Schedule:</div>
 
    <div id="schedule-wrapper">
    <?php print render($content['field_schedule']); ?>
    </div>

    <br />
    <a href="#" id="schedule-time" onclick="jQuery('#node-schedule-div').toggle(); return false;">Schedule Time</a>
    <div id="node-schedule-div">
      <form action="#" id="schedule-form" onsubmit="jQuery('#schedule-wrapper').load('/tasks/update-schedule/add', {data: jQuery('#schedule-form').serialize()}); jQuery('#node-schedule-div').hide(); return false;">
        <input type="text" id="schedule-date" class="datepicker init" value="mm/dd/yyyy" data-init="mm/dd/yyyy" name="date"/>
        <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
        <input type="checkbox" name="time[]" value="AM"/> AM
        <input type="checkbox" name="time[]" value="PM" /> PM
        <input type="checkbox" name="time[]" value="PM+" /> PM+
        <input type="submit" value="Schedule Time" />
      </form>
    </div>
    <br /><br />
    
    <div class="field-label gray">
      <div id="estimate-wrapper"><?php print render($content['field_estimate']); ?></div>
      Time:
    </div>

    <div id="time-wrapper">
      <?php print render($content['field_time']); ?>
    </div>
    <br />
    <a href="#" id="record-time" onclick="jQuery('#node-record-div').toggle(); return false;">Record Time</a>
    <div id="node-record-div">
      <form action="#" 
            id="record-form" 
            onsubmit="  jQuery('#time-wrapper').load('/tasks/update-time/add', {data: jQuery('#record-form').serialize()}); 
                        jQuery('#node-record-div').hide(); 
                        setTimeout(function() { jQuery('#estimate-wrapper').load('/tasks/estimate/<?php print $node->nid; ?>') }, 1000);
                        return false;">
        <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
        <input type="text" id="record-date" class="datepicker init" name="date" value="mm/dd/yyyy" size="12" data-init="mm/dd/yyyy" />
        <input type="text" id="record-hours" name="hours" value="hours" size="7" data-init="hours" class="init" /><br />
        <input type="text" id="record-description" name="description" value="description" size="50" data-init="description" class="init" />
        <input type="submit" value="Record Time"/>
      </form>
    </div>
    <div style="clear:both;" /></div>
    <br /><br />
  </div>

  <div id="task-right">
    <div class="tabs">
      <ul class="tabs primary task">
        <li class="active"><a href="#" data-show="comments" class="active">Comments</a></li>
        <li><a href="#" data-show="credentials">Credentials</a></li>
        <li><a href="#" data-show="assets">Assets</a></li>
        <li><a href="#" data-show="resources">Resources</a></li>
        <li><a href="#" data-show="log">Log</a></li>
      </ul>
    </div>

    <div id="comments-wrapper" class="right-wrapper">
      <?php print render($content['field_comments']); ?>
      <a href="#" id="add-comment" onclick="jQuery('#node-add-comment').toggle(); return false;">Add Comment</a>
      <div id="node-add-comment">
        <span style="font-size:16px; font-weight:bold;">Add Comment</span>
        <form action="#" 
              id="comment-form" 
              onsubmit="  jQuery('.field-name-field-comments').load('/tasks/update-comment/add', {data: jQuery('#comment-form').serialize()}); 
                          jQuery('#node-add-comment').hide(); 
                          reset_height();
                          return false;">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
          <input type="text" id="title" name="title" size="50" value="Subject" data-init="Subject" class="init" /><br /><br />
          <textarea id="description" name="description" class="init" cols="50" rows="10" data-init="Comment" />Comment</textarea>
          <input type="submit" value="Add Comment"/>
        </form>
      </div>

      <div style="clear:both"></div>
    </div>

    <div id="credentials-wrapper" class="right-wrapper">
      <?php print render($content['field_credentials']); ?>
    </div>

    <div id="assets-wrapper" class="right-wrapper">
      <?php print render($content['field_assets']); ?>
    </div>

    <div id="resources-wrapper" class="right-wrapper">
      <?php print render($content['field_resources']); ?>
    </div>

    <div style="clear:both"></div><br /><br />
  </div>
</div>

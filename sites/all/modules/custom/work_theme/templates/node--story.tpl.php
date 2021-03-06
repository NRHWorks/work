<?php
  global $user;

  // We hide the comments and links now so that we can render them later.
  hide($content['comments']);
  hide($content['links']);

?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?> style="position:relative">

  <div id="story-left">
    <div id="story-project">
      <strong>Project:</strong>
      <?php
        $project = node_load($node->field_project['und'][0]['nid']);
        print l($project->title, 'node/' . $project->nid);
      ?>
    </div>

    <div id="story-epic">
      <strong>Epic:</strong>
      <?php
        if (isset($node->field_epic['und'])) {
          $epic = taxonomy_term_load($node->field_epic['und'][0]['tid']);
          print $epic->name;
        }
        else {
          print "No Epic";
        }

      ?>
    </div>

    <br />

    <div id="story-theme">
      <strong>Theme:</strong>
      <?php
        if (isset($node->field_theme['und'])) {
          $theme = taxonomy_term_load($node->field_theme['und'][0]['tid']);
          print $theme->name;
        }
        else {
          print "No Theme";
        }

      ?>
    </div>

    <br />

    <div id="story-sprint">
      <strong>Sprint:</strong>
      <?php
        if (isset($node->field_sprint['und'])) {
          $sprint_title = db_query("SELECT title FROM node WHERE nid = :nid", array(":nid" => $node->field_sprint['und'][0]['nid']))->fetchField();
          print l($sprint_title, 'node/' . $node->field_sprint['und'][0]['nid']);
        }
        else {
          print "Not Assigned";
        }

      ?>
    </div>

    <br />

    <div class="row">
        <?php print render($content['field_due_date']); ?>
    </div>
    <br />

    <?php if (isset($node->field_estimate['und']) && ($node->field_estimate['und'][0]['value'] > 0)) : ?>
    <div class="row">
      <strong>Estimate:</strong> <?php print $node->field_estimate['und'][0]['value']; ?> hours<br /><br />
    </div>
    <?php endif; ?>

    <?php print render($content['body']); ?><br />
    <div class="row" id="priority-row">
        <?php print render($content['field_task_priority']); ?>
    </div>
    <div class="row" id="status-row">
        <?php print render($content['field_status']); ?>
    </div>

    <div class="field-label gray">Users:</div>
    <br />
    <div id="users-container">
      <div id="assigned-to-container"><?php print render($content['field_assigned_to']); ?></div><br />
      <div id="creator-container"><?php print render($content['field_creator']); ?></div><br />
      <div id="owner-container"><?php print render($content['field_owner']); ?></div><br />

      <?php /* ?>
      <div id="users-container"><?php print render($content['field_users']); ?></div><br />
      <?php */ ?>

      <?php global $user; if (in_array('administrator', $user->roles)) : ?>
        <div id="assign-to-container">
          <strong>Assign To: </strong>
            <?php
              if (isset($project->field_users['und']))
              foreach ($project->field_users['und'] as $u) :
                $project_user = user_load($u['uid']);

                if (!in_array($project_user->uid, array($node->field_assigned_to['und'][0]['uid']))) :
            ?>
                &nbsp;&nbsp;<a href="#" onclick="jQuery('#users-container').html('<img src=\'/sites/all/modules/custom/work_theme/images/loading.gif\' style=\'width: 20px; height: auto;\' />'); jQuery('#users-container').load('/stories/update-assigned/<?php print $node->nid; ?>/<?php print $project_user->uid; ?>');  return false;"><?php print $project_user->name; ?></a>
            <?php
                endif;
              endforeach;
            ?>
        </div>
        <br />
      <?php endif; ?>

      <?php global $user; if ($user->uid != $node->field_assigned_to['und'][0]['uid'] && !in_array('Client', $user->roles)) : ?>
        <div id="takeover-container"><a href="#" onclick="jQuery('#users-container').html('<img src=\'/sites/all/modules/custom/work_theme/images/loading.gif\' style=\'width: 20px; height: auto;\' />'); jQuery('#users-container').load('/stories/update-assigned/<?php print $node->nid; ?>/<?php print $user->uid; ?>');  return false;">Assign to Me</a></div><br />
      <?php endif; ?>
    </div>

    <div class="field-label gray">To Do:
      <div style="float:right;">
        <a href="#" onclick="jQuery('.todo-done').parent().toggle(); return false;">Toggle Complete</a>
      </div>
    </div>

    <div id="todo-wrapper">
      <?php print render($content['field_to_do']); ?><br />
    </div>

    <br />
    <a href="#" id="todo-add" onclick="jQuery('#node-todo-div').toggle(); return false;" class="form-link">Add Item</a>
    <div id="node-todo-div" class="hidden-form">
      <form action="#" id="todo-form" onsubmit="jQuery('#todo-wrapper').load('/stories/update-todo/add', {data: jQuery('#todo-form').serialize()}, function() {jQuery('#todo').val(''); jQuery('#node-todo-div').hide(); work_log.update_log(<?php print $node->nid;?>)}); return false;">
        <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
        <input type="text" id="todo" name="todo" size="50" placeholder="todo..."  /><br />
        <input type="submit" value="Add Item" />
      </form>
    </div>
    <br /><br />

    <div class="field-label gray">Schedule:</div>

    <div id="schedule-wrapper">
    <?php print render($content['field_schedule']); ?>
    </div>

    <br />
    <a href="#" id="schedule-time" onclick="jQuery('#node-schedule-div').toggle(); return false;" class="form-link">Schedule Time</a>
    <div id="node-schedule-div" class="hidden-form">
      <form action="#" id="schedule-form" onsubmit="
        jQuery('#schedule-wrapper').load('/stories/update-schedule/add', {data: jQuery('#schedule-form').serialize()}, function(){work_log.update_log(<?php print $node->nid;?>);}); jQuery('#node-schedule-div').hide(); return false;">
        <input type="text" id="schedule-date" class="datepicker init" placeholder="mm/dd/yyyy" name="date"/>
        <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
        <input type="checkbox" name="time[]" value="AM"/> AM
        <input type="checkbox" name="time[]" value="PM" /> PM
        <input type="checkbox" name="time[]" value="PM+" /> PM+
        <input type="submit" value="Schedule Time" />
      </form>
    </div>
    <br /><br />

    <?php if (!in_array('Client', $user->roles)) : ?>
      <div class="field-label gray">
        <div id="estimate-wrapper"><?php print render($content['field_estimate']); ?></div>
        Time:
      </div>

      <div id="time-wrapper">
        <?php print render($content['field_time']); ?>
      </div>
      <br />
      <a href="#" id="record-time" onclick="jQuery('#node-record-div').toggle(); return false;" class="form-link">Record Time</a>
      <div id="node-record-div" class="hidden-form">
        <form action="#"
              id="record-form"
              onsubmit="  jQuery('#time-wrapper').load('/stories/update-time/add', {data: jQuery('#record-form').serialize()}, function(){work_log.update_log(<?php print $node->nid;?>);});
                          jQuery('#node-record-div').hide();
                          setTimeout(function() { jQuery('#estimate-wrapper').load('/stories/estimate/<?php print $node->nid; ?>') }, 1000);
                          return false;">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
          <input type="text" id="record-date" class="datepicker init" name="date" placeholder="mm/dd/yyyy" size="12" />
          <input type="text" id="record-hours" name="hours" placeholder="hours" size="7" /><br />
          <input type="text" id="record-description" name="description" placeholder="description" size="50"  />
          <input type="submit" value="Record Time"/>
        </form>
      </div>
    <?php endif; ?>
    <div style="clear:both;" /></div>
    <br /><br />
  </div>
  <?php
    $credentials_count = 0;
    $assets_count = 0;
    $resources_count = 0;

    if (isset($node->field_credentials['und'])) { $credentials_count += count($node->field_credentials['und']); }
    if (isset($node->field_assets['und'])) { $assets_count += count($node->field_assets['und']); }
    if (isset($node->field_resources['und'])) { $resources_count += count($node->field_resources['und']); }

    if (isset($project->field_credentials['und'])) { $credentials_count += count($project->field_credentials['und']); }
    if (isset($project->field_assets['und'])) { $assets_count += count($project->field_assets['und']); }
    if (isset($project->field_resources['und'])) { $resources_count += count($project->field_resources['und']); }
  ?>

  <div id="story-right">
    <div class="tabs">
      <ul class="tabs primary task">
        <li class="active"><a href="#" data-show="comments" class="active">Comments</a></li>
        <li><a href="#" data-show="credentials">Credentials (<?php print $credentials_count; ?>)</a></li>
        <li><a href="#" id="assets-tab" data-show="assets">Assets (<?php print $assets_count; ?>)</a></li>
        <li><a href="#" data-show="resources">Resources (<?php print $resources_count; ?>)</a></li>
        <li><a href="#" data-show="log">Log</a></li>
      </ul>
    </div>

    <div id="comments-wrapper" class="right-wrapper">
      <div id="comments-container"><?php print render($content['field_comments']); ?></div>
      <a href="#" id="add-comment" onclick="jQuery('#node-add-comment').toggle(); return false;" class="form-link">Add Comment</a>
      <div id="node-add-comment" class="hidden-form">
        <form action="#"
              id="comment-form"
              onsubmit=" jQuery('#comments-container').load('/stories/update-comment/add', {data: jQuery('#comment-form').serialize()},function(){work_log.update_log(<?php print $node->nid;?>);});
                         jQuery('#node-add-comment').hide();
                         jQuery('#comment-form #description').val('');
                         reset_height();
                         return false;">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
          <span style="color:#555;">Reference To Do:</span>
          <select name="todo" style="margin-bottom: 10px;">
            <option>-- none --</option>
            <?php if (isset($node->field_to_do['und'])) foreach ($node->field_to_do['und'] as $todo_id) : ?>
              <option><?php print $todo_id['value']; ?></option>
            <?php endforeach; ?>
          </select>
          <!-- <input type="text" id="title" name="title" size="50" placeholder="Subject"  /><br /><br /> -->
          <textarea id="description" name="description" class="init" cols="50" rows="10" placeholder="Comment" /></textarea>
          <input type="submit" value="Add Comment"/>
        </form>
      </div>

      <div style="clear:both"></div>
    </div>

    <div id="credentials-wrapper" class="right-wrapper">
      <div id="credentials-container"><?php print render($content['field_credentials']); ?></div>
      --- Project Creds ---<br /><br />
      <?php $f = field_view_field('node', $project, 'field_credentials', array('label' => 'hidden')); print render($f); ?>

      <a href="#" id="add-credentials" onclick="jQuery('#node-add-credentials').toggle(); return false;" class="form-link">Add Credentials</a>
      <div id="node-add-credentials" class="hidden-form">
        <form action="#"
              id="credentials-form"
              onsubmit="  jQuery('#credentials-container').load('/stories/update-credentials/add', {data: jQuery('#credentials-form').serialize()},function(){work_log.update_log(<?php print $node->nid;?>);});
                          jQuery('#node-add-credentials').hide();
                          reset_height();
                          return false;">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />

          <input type="text" id="description" name="description"  size="50" placeholder="Description"  /><br /><br />
          <input type="text" id="path"        name="path"         size="50" placeholder="Path"         /><br /><br />
          <input type="text" id="username"    name="username"     size="50" placeholder="Username"     /><br /><br />
          <input type="text" id="password"    name="password"     size="50" placeholder="Password"     /><br /><br />

          <input type="submit" value="Add Credential"/>
        </form>
      </div>

      <div style="clear:both"></div>

    </div>

    <div id="assets-wrapper" class="right-wrapper">
      <?php print render($content['field_assets']); ?>
      --- Project Assets ---<br /><br />
      <?php $f = field_view_field('node', $project, 'field_assets', array('label' => 'hidden')); print render($f); ?>
      <a href="#" id="add-asset" onclick="jQuery('#node-add-asset').toggle(); return false;" class="form-link">Add Asset</a>
      <div id="node-add-asset" class="hidden-form">
        <form action="/stories/update-assets/add" id="asset-form" method="post" enctype="multipart/form-data">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />

          <input type="text" id="asset" name="asset" size="50" placeholder="Asset" data-init="Asset" class="init" /><br /><br />
          <input type="file" id="file" name="file" size="50" class="init" /><br /><br />

          <input type="submit" value="Add Asset"/>
        </form>
      </div>
    </div>

    <div id="resources-wrapper" class="right-wrapper">
      <div id="resources-container"><?php print render($content['field_resources']); ?></div>
      --- Project Resources ---<br /><br />
      <?php $f = field_view_field('node', $project, 'field_resources', array('label' => 'hidden')); print render($f); ?>
      <a href="#" id="add-resource" onclick="jQuery('#node-add-resource').toggle(); return false;" class="form-link">Add Resource</a>
      <div id="node-add-resource" class="hidden-form">
        <form action="#"
              id="resource-form"
              onsubmit="  jQuery('#resources-container').load('/stories/update-resources/add', {data: jQuery('#resource-form').serialize()},function(){work_log.update_log(<?php print $node->nid;?>);});
                          jQuery('#node-add-resource').hide();
                          reset_height();
                          return false;">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
          <input type="text" id="resource" name="resource" size="50" placeholder="Resource" data-init="Resource" class="init" /><br /><br />
          <input type="text" id="URL" name="url" size="50" placeholder="URL" data-init="URL" class="init" /><br /><br />
          <input type="submit" value="Add Comment"/>
        </form>
      </div>
    </div>

    <div id="log-wrapper" class="right-wrapper">
      <?php print work_log_view($node->nid);?>
    </div>

    <div style="clear:both"></div><br /><br />
  </div>

<!-- POPUP DIVS --->

<div id="node-status-div">
  <?php
    $terms = taxonomy_get_tree(2);

    foreach ($terms as $t) {
      if  ($t->tid != 8) {
        print "<a href='#'
                  onclick=' jQuery(\"#node-status-div\").hide();
                            jQuery(\"#node-status\").html(\"{$t->name}\");
                            jQuery.post(\"/stories/update-status/{$node->nid}/{$t->tid}\", function(){work_log.update_log({$node->nid});})'>
                  {$t->name}
               </a>\n";
      }
    }
  ?>
</div>

<div id="node-assign-to-div">
  <?php
    foreach ($node->field_users['und'] as $u) {
        $assign_user = user_load($u['uid']);

        print " <a  href='#'
                    onclick=' jQuery(\"#node-assign-to-div\").hide();
                              jQuery(\"#node-assigned-to\").html(\"{$assign_user->name}\");
                              jQuery.post(\"/stories/update-assigned/{$node->nid}/{$assign_user->uid}\", function(){work_log.update_log({$node->nid});})'>
                    {$assign_user->name}
                </a>\n";
    }
  ?>
</div>

<div id="node-users-div">
  <?php

    $result = db_query("SELECT uid, name FROM {users}");

    foreach ($result as $r) {
        print " <a  href='#'
                    onclick=' jQuery(\"#node-users-div\").hide();
                              jQuery(\"#users-container\").load(\"/stories/update-users/add/{$node->nid}/{$r->uid}\", function(){work_log.update_log({$node->nid});})'>
                    {$r->name}
                </a>\n";

    }
  ?>
</div>
</div>


<?php if (isset($_GET['assets'])) : ?>
<script>
  (function ($) {
    $(document).ready(function() {
      $('#assets-tab').click();
    });
  }(jQuery));
</script>
<?php endif; ?>

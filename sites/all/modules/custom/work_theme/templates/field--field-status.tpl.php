<?php
  $node = $element['#object'];
  $nid  = $node->nid;
?>
  <div class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
    <div class="field-items"<?php print $content_attributes; ?>>
      <div class="field-item"> <span id="node-status"><?php print render($items[0]); ?></span>
      <?php
         global $user;

         if (($user->uid == $node->field_assigned_to['und'][0]['uid']) || ($user->uid == 27)) {

            switch ($items[0]['#markup']) {
              case "Backlog" :
                ?>
                  <span class="status-link"> =>
                    <a href="#" onclick="jQuery('#status-row').load('/stories/status/<?php print $nid; ?>/queue', function() { work_log.update_log(<?php print $nid; ?>); }); ">Add to Queue</a>
                  </span>
                <?php
                break;

              case "In Queue" :
                ?>
                  <span class="status-link"> =>
                    <a href="#" onclick="jQuery('#status-row').load('/stories/status/<?php print $nid; ?>/review', function() { work_log.update_log(<?php print $nid; ?>); }); ">Review</a>
                  </span>
                <?php
                break;

              case 'Reviewed' :
                ?>
                  <span class="status-link"> =>
                    <a href="#" onclick="jQuery('#status-row').load('/stories/status/<?php print $nid; ?>/progress', function() { work_log.update_log(<?php print $nid; ?>); }); ">get started</a>
                  </span>
                <?php
                break;
              case 'In Progress' :
                ?>
                  <span class="status-link"> =>
                    <a href="#" onclick="jQuery('#feedback-comment').show(); ">request feedback</a> |
                    <a href="#" onclick="jQuery('#resolve-comment').show(); ">resolve</a>
                  </span>
                <?php
                break;

              case 'Feedback Requested' :
                ?>
                  <span class="status-link"> =>
                    <a href="#" onclick="jQuery('#give-feedback-comment').show(); ">give feedback</a>
                  </span>
                <?php
                break;

              case 'Resolved' :
                ?>
                  <span class="status-link"> =>
                    <a href="#" onclick="jQuery('#status-row').load('/stories/status/<?php print $nid; ?>/close', function() { work_log.update_log(<?php print $nid; ?>); });">accept work</a> |
                    <a href="#" onclick="jQuery('#reject-comment').show(); ">reject work</a>
                  </span>
                <?php
                break;

            }

          }
       ?>

      </div>
    </div>
  </div>
  <div id="reject-comment" style="display:none;" class="status-form hidden-form">
    <form action="#"
          id="reject-comment-form"
          onsubmit=" jQuery('#status-row').load('/stories/status/<?php print $nid; ?>/reject', {data: jQuery('#reject-comment-form').serialize()},function(){work_log.update_log_comments(<?php print $nid;?>);});
                     jQuery('#give-feedback-comment').hide();
                     return false;">
      <textarea id="status-text" name="status-text" class="init" cols="50" rows="10" placeholder="Why is the work being rejected?" /></textarea><br />
      <input type="submit" value="Reject!!!!!"/>
      <button type="button" value="Cancel" onclick="jQuery('.status-form').hide();" >Cancel</button>
    </form>
  </div>
  <div id="give-feedback-comment" style="display:none;" class="status-form hidden-form">
    <form action="#"
          id="give-feedback-comment-form"
          onsubmit=" jQuery('#status-row').load('/stories/status/<?php print $nid; ?>/give-feedback', {data: jQuery('#give-feedback-comment-form').serialize()},function(){work_log.update_log_comments(<?php print $nid;?>);});
                     jQuery('#give-feedback-comment').hide();
                     return false;">
      <textarea id="status-text" name="status-text" class="init" cols="50" rows="10" placeholder="Provide feedback..." /></textarea><br />
      <input type="submit" value="Give Feedback"/>
      <button type="button" value="Cancel" onclick="jQuery('.status-form').hide();" >Cancel</button>
    </form>
  </div>
  <div id="feedback-comment" style="display:none;" class="status-form hidden-form">
    <form action="#"
          id="feedback-comment-form"
          onsubmit=" jQuery('#status-row').load('/stories/status/<?php print $nid; ?>/feedback', {data: jQuery('#feedback-comment-form').serialize()},function(){work_log.update_log_comments(<?php print $nid;?>);});
                     jQuery('#feedback-comment').hide();
                     return false;">
      <textarea id="status-text" name="status-text" class="init" cols="50" rows="10" placeholder="Ask questions..." /></textarea><br />
      <input type="submit" value="Request Feedback"/>
      <button type="button" value="Cancel" onclick="jQuery('.status-form').hide();" >Cancel</button>
    </form>
  </div>
  <div id="resolve-comment" style="display:none;" class="status-form hidden-form">
    <form action="#"
          id="resolve-comment-form"
          onsubmit=" jQuery('#status-row').load('/stories/status/<?php print $nid; ?>/resolve', {data: jQuery('#resolve-comment-form').serialize()},function(){work_log.update_log_comments(<?php print $nid;?>);});
                     jQuery('#resolve-comment').hide();
                     return false;">
      <textarea id="status-text" name="status-text" class="init" cols="50" rows="10" placeholder="Add comments..." /></textarea><br />
      <input type="submit" value="Resolve Task"/>
      <button type="button" value="Cancel" onclick="jQuery('.status-form').hide();" >Cancel</button>
    </form>
  </div>


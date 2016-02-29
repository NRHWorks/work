<?php 
  global $user;
  $node = $element['#object']; 
  $nid  = $node->nid;
?>
  <div class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
    <div class="field-items"<?php print $content_attributes; ?>>
      <div class="field-item"> 
        <span id="node-priority"><?php print render($items[0]); ?></span> 
        <?php if (in_array('Client', $user->roles) || in_array('administrator', $user->roles)) : ?> => <a href="#" onclick="jQuery('#task-status-update').toggle(); return false;">update priority</a><?php endif; ?>
      </div>
    </div>
  </div>
  <div id="task-status-update">
    <?php
      $priority = taxonomy_get_tree(6);

      foreach ($priority as $p) :
    ?>
    
    <a href="#" onclick="jQuery('#priority-row').load('/tasks/priority/<?php print $nid; ?>/<?php print $p->tid; ?>'); jQuery('#task-status-update').hide(); return false;" ><?php print $p->name; ?></a> <?php print $p->description; ?><br /><br />

    <?php endforeach; ?>
  </div>

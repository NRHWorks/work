<?php
  // We hide the comments and links now so that we can render them later.
  hide($content['comments']);
  hide($content['links']);

?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?> style="position:relative">

  <div id="project-left">
    <div id="admins-container"><?php print render($content['field_admins']); ?></div><br />
    <div id="users-container"><?php print render($content['field_users']); ?></div><br />
    <div style="clear:both;" /></div>
    <br /><br />
  </div>

  <div id="project-right">
    <div class="tabs">
      <ul class="tabs primary task">
        <li class="active"><a href="#" data-show="contact">Contact Info</a></li>
      </ul>
    </div>

    <div id="contact-wrapper" class="right-wrapper">
      <div id="contact"><?php print render($content['field_contact_info']); ?></div><br />
      <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div><br /><br />
  </div>
</div>

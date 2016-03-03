<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if (!$label_hidden): ?>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
  <?php endif; ?>
  <div class="field-items"<?php print $content_attributes; ?>>
    <?php foreach ($items as $delta => $item): ?>
      <div class="field-item <?php print $delta % 2 ? 'odd' : 'even'; ?>"<?php print $item_attributes[$delta]; ?>>
<?php /* ?>
<a href="#" onclick="jQuery('#node-assign-to-div').toggle(); return false;"> <span id="node-assigned-to"><?php print $item['#title']; ?></span> </a>
<?php */ ?>
        <a href="#" onclick="return false;"> <span id="node-assigned-to"><?php print $item['#title']; ?></span> </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>

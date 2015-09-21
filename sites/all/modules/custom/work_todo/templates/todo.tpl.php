<style type="text/css">
  .todo-wrapper {
    clear: both;
    border-bottom: 1px solid #CCC;
    overflow: auto;
    padding: 10px 0px;
  }

  .todo-wrapper:last-child {
    border-bottom: 0px;
  }

  .todo-list-item {
    float: left;
    font-size: 18px;
  }
  
  .todo-list-item-sm {
    float: left;
    font-size: 14px;
  }

  .todo-actions {
    float: right;
  }

  #add-form {
    float:right;
    margin-top:-50px;
  }
</style>

<form action="todo/add" method="POST" id="add-form">
  <input type="text" name="todo" id="todo" size="60" autofocus />
  <input type="submit" value="To Do" />
</form>

<div class="todo-group">
<?php foreach ($data as $t) : ?>
  <?php if (($t->field_todo_status[LANGUAGE_NONE][0]['value'] == 0) && ($t->field_date[LANGUAGE_NONE][0]['value'] <= date('Y-m-d 24'))) : ?> 
    
    <div class="todo-wrapper">
      <div class="todo-list-item">
        <?php print $t->title; ?>
      </div>
      <div class="todo-actions">
        <a href="/todo/done/<?php print $t->nid; ?>">Done</a> | <a href="/todo/do-later/<?php print $t->nid; ?>">Do Later</a> | <a href="/todo/do-tomorrow/<?php print $t->nid; ?>">Do Tomorrow</a>
      </div>
    </div>

  <?php endif; ?>
<?php endforeach; ?>
</div>

<br /><br />
<h1>To Do: Tomorrow</h1>

<div class="todo-group">
<?php foreach ($data as $t) : ?>
  <?php if (($t->field_todo_status[LANGUAGE_NONE][0]['value'] == 0) && ($t->field_date[LANGUAGE_NONE][0]['value'] > date('Y-m-d 24'))) : ?> 
  
    <div class="todo-wrapper">
      <div class="todo-list-item-sm">
        <?php print $t->title; ?>
      </div>
      <div class="todo-actions">
        <a href="/todo/do-today/<?php print $t->nid; ?>">Do Today</a>
      </div>
    </div>

  <?php endif; ?>
<?php endforeach; ?>
</div>

<br /><br />
<h1>To Do: Done</h1>

<div class="todo-group">
<?php foreach ($data_done as $t) : ?>
  <?php if ($t->field_todo_status[LANGUAGE_NONE][0]['value'] == 1) : ?> 
    <div class="todo-wrapper">
      <div class="todo-list-item-sm">
        <strike><?php print $t->title; ?></strike>
      </div>
    </div>
  <?php endif; ?>
<?php endforeach; ?>
</div>

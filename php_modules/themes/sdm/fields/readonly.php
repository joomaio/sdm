<?php if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>"><?php echo $this->field->label ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<?php echo $this->field->value?>
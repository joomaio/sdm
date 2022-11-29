<?php if($this->field->showLabel): ?>
<label class="form-label"  for="<?php echo $this->field->name ?>"><?php echo $this->field->label ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<input name="<?php echo $this->field->name ?>" type="password" id="<?php echo $this->field->id ?>" <?php echo $this->field->required. ' '. $this->field->placeholder.' '. $this->field->autocomplete?>
    value="<?php echo $this->field->value?>" class="<?php echo $this->field->formClass?>" >

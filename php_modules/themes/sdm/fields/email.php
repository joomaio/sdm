<?php if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>" class="form-label"><?php echo $this->field->label ?></label>
<?php endif; ?>
<input name="<?php echo $this->field->name ?>" type="email" id="<?php echo $this->field->id ?>" <?php echo $this->field->required. ' '. $this->field->placeholder.' '. $this->field->autocomplete?>
    value="<?php echo $this->field->value?>" class="<?php echo $this->field->formClass?>">
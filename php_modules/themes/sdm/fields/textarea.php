<?php if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>"><?php echo $this->field->label ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<textarea name="<?php echo $this->field->name ?>" type="text" id="<?php echo $this->field->id ?>"  <?php echo $this->field->required. ' '. $this->field->placeholder.' '. $this->field->autocomplete?> 
    class="<?php echo $this->field->formClass?>"  ><?php echo $this->field->value?></textarea>
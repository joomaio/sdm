<?php if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>" class="form-label"><?php echo $this->field->label ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<?php $array = explode($this->field->separator, $this->field->value); 

$placeholder = explode($this->field->separator, $this->field->placeholder); 

foreach($placeholder as $i=>$plholder):
    $value = !isset($array[$i]) ? $array[$i] : '';
?>
<input name="<?php echo $this->field->name ?>[]" type="text" id="<?php echo $this->field->id. '_'. $i ?>"  <?php echo $this->field->required. ' '. $plholder.' '. $this->field->autocomplete?>
    value="<?php echo $value?>"   class="<?php echo $this->field->formClass?>" >
<?php 

endforeach;
<?php if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>"><?php echo $this->field->label ?></label>
<?php endif; ?>
<?php list($isBC, $year, $month, $day, $hour, $minute, $seconds) = explode($this->field->separator, $this->field->value); ?>
<br/>
<select name="<?php echo $this->field->name ?>[]" class="<?php echo $this->field->formClass?>">
    <option value="" <?php if('' == $isBC) echo 'selected="selected"'?>>AD</option>
    <option value="-" <?php if('-' == $isBC) echo 'selected="selected"'?>>BC</option>
</select>
<input name="<?php echo $this->field->name ?>[]" type="number" id="<?php echo $this->field->id ?>_year" <?php echo $this->field->required ?>
    value="<?php echo $year?>" class="<?php echo $this->field->formClass?>" min="0" max="9999" size="4" placeholder="YYYY"> - 
<input name="<?php echo $this->field->name ?>[]" type="number" id="<?php echo $this->field->id ?>_month" <?php echo $this->field->required ?>
    value="<?php echo $month?>" class="<?php echo $this->field->formClass?>" min="1" max="12" size="2" placeholder="MM"> - 
<input name="<?php echo $this->field->name ?>[]" type="number" id="<?php echo $this->field->id ?>_day" <?php echo $this->field->required ?>
    value="<?php echo $day?>" class="<?php echo $this->field->formClass?>" min="1" max="31" size="2" placeholder="DD">&nbsp;&nbsp;
<input name="<?php echo $this->field->name ?>[]" type="number" id="<?php echo $this->field->id ?>_hour" <?php echo $this->field->required ?>
    value="<?php echo $hour?>" class="<?php echo $this->field->formClass?>" min="0" max="24" size="2" placeholder="HH"> :
<input name="<?php echo $this->field->name ?>[]" type="number" id="<?php echo $this->field->id ?>_minute" <?php echo $this->field->required ?>
    value="<?php echo $minute?>" class="<?php echo $this->field->formClass?>" min="0" max="60" size="2" placeholder="MM">
<?php if($this->field->showSeconds): ?> : 
<input name="<?php echo $this->field->name ?>[]" type="number" id="<?php echo $this->field->id ?>_seconds" <?php echo $this->field->required ?>
    value="<?php echo $seconds?>" class="<?php echo $this->field->formClass?>" min="0" max="60" size="2" placeholder="SS">
<?php endif; ?>
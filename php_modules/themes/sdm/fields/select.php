<?php

if($this->field->emptyOption)
{
    array_unshift($this->field->options, ['text' => $this->field->emptyOption, 'value' => '' ]);
}

?>
<?php if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>" class="form-label"><?php echo $this->field->label  ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<select name="<?php echo $this->field->name ?>" id="<?php echo $this->field->id ?>" class=" <?php echo $this->field->formClass?>" <?php echo $this->field->required?> <?php echo $this->field->autocomplete;?>>
    <?php foreach( $this->field->options as $opt )
    {
        if(is_string($opt) || is_numeric($opt) )
        {
            $opt = ['text' => $opt, 'value' => $opt];
        }

        if(!is_object($opt))
        {
            $opt = (object) $opt;
        }

        echo '<option value="'. $opt->value. '" ';
        echo $opt->value == $this->field->value ? 'selected="selected" >' : '>';
        echo $opt->text;
        echo '</option>';
    } ?>
</select>
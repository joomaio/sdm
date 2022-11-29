<?php 
if($this->field->emptyOption)
{
    array_unshift($this->field->options, ['txt' => $this->field->emptyOption, 'value' => '' ]);
}

?>
<?php if($this->field->showLabel): ?>
<label class="form-label" for="<?php echo $this->field->name ?>"><?php echo $this->field->label  ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<fieldset>
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

        echo '<div class="form-check">';
        echo '<label class="form-check-label">';
        echo '<input type="radio" name="'. $this->field->name. '" value="'. $opt->value. '" class="form-check-input '. $this->field->formClass. '" ';
        echo $opt->value == $this->field->value ? 'checked="checked" >' : '>';
        echo '<span class="date-time-text format-i18n">'. $opt->text. '</span>';
        echo '</label><br>';
        echo '</div>';
    } ?>
</fieldset> 
<?php
$this->theme->add( $this->url.'assets/css/select2.min.css', '', 'select2-css');
$this->theme->add( $this->url.'assets/js/select2.full.min.js', '', 'bootstrap-select2', 'bottom');
if($this->field->emptyOption)
{
    array_unshift($this->field->options, ['text' => $this->field->emptyOption, 'value' => '' ]);
}

?>
<?php if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>" class="form-label"><?php echo $this->field->label  ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; 

?>
<div>
    <select name="<?php echo $this->field->name ?>" id="<?php echo $this->field->id ?>" class=" <?php echo $this->field->formClass?>" <?php echo $this->field->required?> <?php echo $this->field->autocomplete;?>>
        <?php foreach( $this->field->options as $opt )
        {
            if(is_string($opt) || is_numeric($opt) )
            {
                $opt = ['text' => $opt, 'value' => $opt];
            }
            if (is_array($opt['option']) && ($opt['option']))
            {
                echo '<optgroup label="'. $opt['text']. '"> ';
                foreach ($opt['option'] as $option)
                {
                    if(!is_object($option))
                    {
                        $option = (object) $option;
                    }
                    $value = $opt['value']. '-'. $option->value;
                    echo '<option value="'. $value. '" ';
                    echo $value == $this->field->value ? 'selected="selected" >' : '>';
                    echo $option->text;
                    echo '</option>';
                }
                echo '</optgroup>';
            } else {
                if(!is_object($opt))
                {
                    $opt = (object) $opt;
                }
                $value = $opt->value. '-0';
                echo '<option value="'. $value. '" ';
                echo $value == $this->field->value ? 'selected="selected" >' : '>';
                echo $opt->text;
                echo '</option>';
            }
            
        }
        ?>
        
    </select>
</div>
<?php
$js = <<<Javascript
$(document).ready(function() {
    $('#{$this->field->id}').select2();
  });
Javascript;

$this->theme->addInline('js', $js);
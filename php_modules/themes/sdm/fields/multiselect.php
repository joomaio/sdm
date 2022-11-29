<?php 
// $this->theme->add( $this->url. 'assets/css/select2.min.css', '', 'select2-css');
// $this->theme->add( $this->url. 'assets/css/select2_custom.css', '', 'select2-custom-css');
$this->theme->add( $this->url. 'assets/js/select2.full.min.js', '', 'bootstrap-select2');
if($this->field->emptyOption)
{
    array_unshift($options, ['text' => $this->field->emptyOption, 'value' => '' ]);
}
$this->field->placeholder ? preg_match_all('/\"(.*)\"/', $this->field->placeholder, $match) : $match = '' ;
is_array($match) ? $match = $match[1][0] : '';

$this->field->value = (array) $this->field->value;

?>
<?php if($this->field->showLabel): ?>
<label class="form-label" for="<?php echo $this->field->name ?>"><?php echo $this->field->label  ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<div>
    <select class="selectpicker d-block <?php echo $this->field->formClass?>" multiple name="<?php echo $this->field->name ?>[]" id="<?php echo $this->field->id ?>" <?php echo $this->field->required?> <?php echo $this->field->autocomplete;?>>
        <option></option>
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
            echo in_array( $opt->value, $this->field->value) ? 'selected="selected" >' : '>';
            echo $opt->text;
            echo '</option>';
        } ?>
    </select>
</div>
<?php
$js = <<<Javascript
$(document).ready(function() {
    $('#{$this->field->id}').select2({
        placeholder : '{$match}',
    });
  });
Javascript;

$this->theme->addInline('js', $js);
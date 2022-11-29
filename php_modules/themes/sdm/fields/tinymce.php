<?php use SPT\Theme;

static $tinyMCE;
if(!isset($tinyMCE))
{
    $this->theme->add( $this->url.'assets/tinymce/tinymce.min.js', '', 'tinymce');
}

$js = <<<Javascript
tinymce.init({
    selector: '#{$this->field->id}',
    plugins: [
        "advlist autolink lists link image charmap print preview anchor mediaadvanced",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools wordcount"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link mediaadvanced",
});
Javascript;

$this->theme->addInline('js', $js);

if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>" class="form-label"><?php echo $this->field->label ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<textarea rows="6" name="<?php echo $this->field->name ?>" id="<?php echo $this->field->id ?>"  <?php echo $this->field->required. ' '. $this->field->placeholder.' '. $this->field->autocomplete?>
    class="<?php echo $this->field->formClass?>" ><?php echo $this->field->value?></textarea>

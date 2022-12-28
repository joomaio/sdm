<?php use SPT\Theme;

static $sheetJs;
if(!isset($sheetJs))
{
    $this->theme->add($this->url . 'assets/sheetjs/css/xspreadsheet.css', '', 'sheetjs-xspreadsheet-css');
    $this->theme->add($this->url . 'assets/sheetjs/js/xspreadsheet.js', '', 'sheetjs-xspreadsheet-js', 'top');
    $this->theme->add($this->url . 'assets/sheetjs/dist/xlsx.full.min.js', '', 'sheetjs-xlsx-js', 'top');
    $this->theme->add($this->url . 'assets/sheetjs/js/xlsxspread.min.js', '', 'sheetjs-xlsxspread-js', 'top');
}

$js = <<<Javascript
var sheet_{$this->field->id} = x_spreadsheet(document.getElementById("sheet_{$this->field->id}"), {
    view : {
        height: () => $("#sheet_{$this->field->id}").height(),
        width: () => $("#sheet_{$this->field->id}").width()
    },
    showGrid: true,
});
var ab = $('#{$this->field->id}').val();
sheet_{$this->field->id}.loadData(stox(XLSX.read(ab, {type: 'base64'})));
$(document).ready(function(e) {
    $('#sheet_{$this->field->id} .x-spreadsheet-toolbar').css('width', 'auto');
    $(window).resize(function(){
        $('#sheet_{$this->field->id} .x-spreadsheet-toolbar').css('width', 'auto');
    });
    sheet_{$this->field->id}.change(function(data) {
        var file_content = XLSX.write(xtos(sheet_{$this->field->id}.getData()), {type: 'base64', bookType: 'csv'});
        $('#{$this->field->id}').val(file_content);
    });
});
function reRender_{$this->field->id}()
{
    $('#sheet_{$this->field->id} .x-spreadsheet-toolbar').css('width', 'auto');
    sheet_{$this->field->id}.reRender();
}

Javascript;

$this->theme->addInline('js', $js);

if($this->field->showLabel): ?>
<label for="<?php echo $this->field->name ?>" class="form-label"><?php echo $this->field->label ?><?php echo $this->field->required ? ' * ':''?></label>
<?php endif; ?>
<textarea name="<?php echo $this->field->name ?>" id="<?php echo $this->field->id ?>"  <?php echo $this->field->required. ' '. $this->field->placeholder.' '. $this->field->autocomplete?>
    class="d-none" ><?php echo $this->field->value?></textarea>
<div class="<?php echo $this->field->formClass?>" id="sheet_<?php echo $this->field->id ?>">
</div>
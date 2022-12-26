<?php
$this->theme->add( $this->url .'assets/css/select2.min.css', '', 'select2-css');
$this->theme->add( $this->url .'assets/css/select2_custom.css', '', 'select2-custom-css');
$this->theme->add( $this->url. 'assets/js/select2.full.min.js', '', 'bootstrap-select2');
$this->theme->add($this->url . 'assets/sheetjs/css/xspreadsheet.css', '', 'sheetjs-xspreadsheet-css');
$this->theme->add($this->url . 'assets/sheetjs/js/xspreadsheet.js', '', 'sheetjs-xspreadsheet-js', 'top');
$this->theme->add($this->url . 'assets/sheetjs/dist/xlsx.full.min.js', '', 'sheetjs-xlsx-js', 'top');
$this->theme->add($this->url . 'assets/sheetjs/js/xlsxspread.min.js', '', 'sheetjs-xlsxspread-js', 'top');
?>
<?php echo $this->render('notification'); ?>
<div class="container-fluid align-items-center row justify-content-center mx-auto pt-3">
    <form enctype="multipart/form-data" action="<?php echo $this->link_form . '/' . $this->id ?>" method="post" id="form_submit">
        <div class="row g-3">
            <div class="col-lg-8 col-sm-12">
                <input id="input_title" type="hidden" name="title">
                <div class="row">
                    <div class="mb-3 col-lg-12 col-sm-12 mx-auto">
                        <div class="fw-bold d-flex">
                            <span class="me-auto">Description:</span> 
                            <span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="editor" id="sheetToogle" value="sheetjs">
                                    <label class="form-check-label" for="sheetToogle">Sheet Editor</label>
                                </div>
                            </span>
                        </div>
                        <?php $this->field('description'); ?>
                        <div id="sheet_editor"></div>
                    </div>
                </div>
                
                <div class="d-flex g-3 flex-row align-items-end m-0 justify-content-center">
                    <?php $this->field('token'); ?>
                    <input class="form-control rounded-0 border border-1" type="hidden" name="_method" value="<?php echo $this->id ? 'PUT' : 'POST' ?>">
                    <div class="me-2">
                        <a href="<?php echo $this->link_list ?>">
                            <button type="button" class="btn btn-outline-secondary">Cancel</button>
                        </a>
                    </div>
                    <div class="me-2">
                        <input type="hidden" name="save_close" id="save_close">
                        <button type="submit" class="btn btn-outline-success btn_save_close">Save & Close</button>
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-outline-success">Apply</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="row">
                    <div class="mb-3 col-lg-12 col-sm-12 mx-auto">
                        <label class="form-label fw-bold">Note:</label>
                        <?php $this->field('note'); ?>
                    </div>
                </div>
                <div class="row pt-3" style="display: none">
                    <div class="mb-3 col-lg-12 col-sm-12 mx-auto">
                        <label class="form-label fw-bold">Tags:</label>
                        <?php $this->field('tags'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-lg-12 col-sm-12 mx-auto">
                        <label class="form-label fw-bold">Tags:</label>
                        <select class="js-example-tags" multiple id="select_tags">
                            <?php foreach ($this->data_tags as $item) : ?>
                                <option selected="selected" value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <label class="form-label fw-bold pt-3">Attachments:</label>
                <input name="files[]" type="file" multiple id="file" class="form-control">
                <div class="d-flex flex-wrap pt-4">
                    <?php foreach ($this->attachments as $item) :
                        $extension = @end(explode('.', $item['path']));
                        if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                            $path = file_exists(PUBLIC_PATH . $item['path']) ? $this->url . $item['path'] : $this->url . 'media/default/default_image.png';
                        }
                        elseif($extension == 'pdf')
                        {
                            $path = $this->url . 'media/default/default_pdf.png';
                        }
                        elseif(in_array($extension, ['doc', 'docx']))
                        {
                            $path = $this->url . 'media/default/default_doc.png';
                        } 
                        elseif(in_array($extension, ['xlsx', 'csv']))
                        {
                            $path = $this->url . 'media/default/default_excel.png';
                        }
                        else
                        {
                            $path = $this->url . 'media/default/default_file.png';
                        }
                        ?>
                        <div class="card border shadow-none d-flex flex-column me-2 justify-content-center" style="width: auto;">
                            <a href="<?php echo file_exists(PUBLIC_PATH. $item['path'] ) ? $this->url . $item['path'] : '' ?>" target="_blank" class="h-100 my-2 px-2 mx-auto" title="<?php echo $item['name']; ?>" style="">
                                <img style="height: 120px; max-width: 100%;" src="<?php echo $path ?>" alt="<?php echo $item['name']; ?>">
                            </a>
                            <div class="card-body d-flex">
                                <p class="card-text fw-bold m-0 me-2"><?php echo $item['name']; ?> </p>
                                <a data-id="<?php echo $item['id']?>" class="ms-auto me-2 button_download_item fs-4"><i class="fa-solid fa-download"></i></a>
                                <a data-id="<?php echo $item['id']?>" class="ms-auto button_delete_item fs-4"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                        <div class="d-block">
                            
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        
    </form>
</div>
<form class="hidden" method="POST" id="form_delete">
    <input type="hidden" value="<?php echo $this->token ?>" name="token">
    <input type="hidden" value="DELETE" name="_method">
</form>
<form class="hidden" method="POST" id="form_download">
    <input type="hidden" value="<?php echo $this->token ?>" name="token">
    <input type="hidden" value="POST" name="_method">
</form>
<style>
    span.select2 {
        width: 100% !important;
    }
</style>
<script>
    $('form').submit(function() {
        $('input#input_title').val($('input#title').val());
    });
    var sheet_editor = x_spreadsheet(document.getElementById("sheet_editor"));
    
    $(document).ready(function(e) {
        var ab = `<?php echo $this->data['description_sheetjs']; ?>`;
        sheet_editor.loadData(stox(XLSX.read(ab)));

        $('#form_submit').submit(function(e) {
            const file_content = XLSX.write(xtos(sheet_editor.getData()), {type: 'base64', bookType: 'csv'});
            $("#description").val(file_content);
        });

        $('#sheet_editor .x-spreadsheet-toolbar').css('width', 'auto');
        $('#sheet_editor .x-spreadsheet-sheet').css('width', 'auto');
        $('#sheet_editor .x-spreadsheet-bottombar').css('width', 'auto');
    });
</script>
<?php
$js = <<<Javascript
    var new_tags = [];
    $(".js-example-tags").select2({
        tags: true,
        createTag: newtag,
        matcher: matchCustom,
        ajax: {
            url: "{$this->link_tag}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data, params) {
                let items = [];
                if (data.data.length > 0) {
                    data.data.forEach(function(item) {
                        items.push({
                            id: item.id,
                            text: item.name
                        })
                    })
                }

                return {
                    results: items,
                    pagination: {
                        more: false
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search tags',
        minimumInputLength: 2,
    });

    function newtag(params, data) {
        var term = $.trim(params.term);
        if (term === '') {
            return null;
        }

        return {
            id: term,
            text: term,
            newTag: true // add additional parameters
        }
    }

    $('.js-example-tags').on('select2:select', function(e) {
        let tag = e.params.data;
        if (tag.newTag === true) {
            $.post("{$this->link_tag}", {
                    name: tag.text
                })
                .done(function(data) {
                    new_tags.push({
                        id: data.data.id,
                        text: data.data.name
                    })

                    setTags();
                });
        } else {
            setTags();
        }
    });

    $('.js-example-tags').on('select2:unselect', function(e) {
        setTags();
    });

    function matchCustom(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
            return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
            return null;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    function setTags() {
        let tmp_tags = $('#select_tags').val();
        if (tmp_tags.length > 0) {
            var items = [];

            if (new_tags.length > 0) {
                tmp_tags.forEach(function(item, key) {
                    let ck = false;
                    new_tags.forEach(function(item2, key2) {

                        if (item == item2.text)
                            ck = item2
                    })

                    if (ck === false)
                        items.push(item)
                    else
                        items.push(ck.id)
                })
            } else items = tmp_tags

            $('#tags').val(items.join(','))
        } else {
            $('#tags').val('')
        }
    }

    $(document).ready(function() {
        $("#description").attr('rows', 18);
        $(".btn_save_close").click(function() {
            $("#save_close").val(1);
        });
        $(".button_delete_item").click(function() {
            var id = $(this).data('id');
            var result = confirm("You are going to delete 1 file(s) attchament. Are you sure ?");
            if (result) {
                $('#form_delete').attr('action', '{$this->link_form_attachment}' + id);
                $('#form_delete').submit();
            }
            else
            {
                return false;
            }
        });
        $(".button_download_item").click(function() {
            var id = $(this).data('id');
            if (id) {
                $('#form_delete').attr('action', '{$this->link_form_download_attachment}' + id);
                $('#form_delete').submit();
            }
            else
            {
                return false;
            }
        });
    });
Javascript;

$this->theme->addInline('js', $js);
?>
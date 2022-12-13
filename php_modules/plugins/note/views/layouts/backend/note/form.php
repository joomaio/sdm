<div class="container-fluid align-items-center row justify-content-center mx-auto pt-3">
    <div class="card shadow-none p-0 col-lg-12">
        <div class="card-body">
            <?php echo $this->render('message'); ?>
            <form enctype="multipart/form-data" action="<?php echo $this->link_form . '/' . $this->id ?>" method="post">
                <div class="row g-3">
                    <div class="col-lg-8 col-sm-12">
                        <div class="row">
                            <div class="mb-3 col-lg-10 col-sm-12 mx-auto pt-3">
                                <label class="form-label fw-bold">Title:</label>
                                <?php $this->field('title'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-lg-10 col-sm-12 mx-auto">
                                <label class="form-label fw-bold">HTML Editor:</label>
                                <?php $this->field('html_editor'); ?>
                            </div>
                        </div>
                        <div class="row" style="display: none">
                            <div class="mb-3 col-lg-10 col-sm-12 mx-auto pt-3">
                                <label class="form-label fw-bold">Tags:</label>
                                <?php $this->field('tags'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-lg-10 col-sm-12 mx-auto pt-3">
                                <label class="form-label fw-bold">Tags:</label>
                                <select class="js-example-tags" multiple id="select_tags">
                                    <?php foreach ($this->data_tags as $item): ?>
                                        <option selected="selected" value="<?=$item['id']?>"><?=$item['name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <label class="form-label fw-bold pt-3">Attachments:</label>
                        <input name="files[]" type="file" multiple id="file" class="form-control">
                    </div>
                    
                </div>
                <div class="row g-3 align-items-cemultiplenter m-0">
                    <?php $this->field('token'); ?>
                    <input class="form-control rounded-0 border border-1" type="hidden" name="_method" value="<?php echo $this->id ? 'PUT' : 'POST' ?>">
                    <div class="col-xl-6 col-sm-6 text-end">
                        <a href="<?php echo $this->link_list ?>">
                            <button type="button" class="btn btn-outline-secondary">Cancel</button>
                        </a>
                    </div>
                    <div class="col-xl-3 col-sm-6 text-start ">
                        <button type="submit" class="btn btn-outline-success">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    span.select2{
        width: 100% !important;
    }
</style>

<script>
    var new_tags = [];
    $(".js-example-tags").select2({
        tags: true,
        createTag:newtag,
        matcher: matchCustom,
        ajax: {
            url: "<?=$this->link_tag?>",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (data, params) {
                let items = [];
                if (data.data.length > 0) {
                    data.data.forEach( function (item) {
                        items.push({id: item.id, text: item.name})
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

    function newtag(params, data){
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

    $('.js-example-tags').on('select2:select', function (e) {
        let tag = e.params.data;
        if (tag.newTag === true) {
             $.post( "<?=$this->link_tag?>", { name: tag.text})
                 .done(function( data ) {
                     new_tags.push({id:data.data.id, text: data.data.name})

                     setTags();
                 });
        } else {
            setTags();
        }
    });

    $('.js-example-tags').on('select2:unselect', function (e) {
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
        if (tmp_tags.length > 0){
            var items = [];

            if (new_tags.length > 0){
                tmp_tags.forEach( function (item, key) {
                    let ck = false;
                    new_tags.forEach(function (item2, key2) {

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
</script>

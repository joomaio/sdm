<form id="filter_form" class="row pe-0 pb-2" action="<?php echo $this->link_list ?>" method="POST">
    <div class="col-lg-11 col-sm-12">
        <div class="input-group input-group-navbar">
            <div class="pe-2">
                <div class="row">
                    <div class="col-auto">
                        <button data-id="" 
                            data-title="" 
                            data-url=""
                            type="button" 
                            class="align-middle btn border border-1 show_data" 
                            data-bs-placement="top" 
                            data-bs-toggle="modal" 
                            data-bs-target="#Popup_form_task">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="pe-2">
                <div class="row">
                    <div class="col-auto">
                        <button id="delete_selected" data-bs-placement="top" title="Delete Selected" data-bs-toggle="tooltip" class="btn border border-1" type="button">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-1 col-sm-12 text-end pe-0 pb-1 ">
        <div class="d-flex justify-content-end">
            <?php $this->field('limit');  ?>
        </div>
    </div>
</form>
<?php echo $this->render('backend.task.list.javascript'); ?>
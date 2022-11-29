<form id="filter_form" class="row pe-0 pb-2" action="<?php echo $this->link_list ?>" method="POST">
    <div class="col-lg-10 col-sm-12">
        <div class="input-group input-group-navbar">
            <div class="pe-2">
                <?php $this->field('status');  ?>
            </div>
            <div class="pe-2">
                <?php $this->field('sort');  ?>
            </div>
            <div class="pe-2">
                <?php $this->field('search');  ?>
            </div>
            <!-- <input type="text" name="search" class="form-control rounded-0 border border-1" placeholder="Search…" aria-label="Search"> -->
            <button type='Submit' data-bs-toggle="tooltip" title="Filter" class=" align-middle btn border border-1 ms-2" type="button">
                <i class="fa-solid fa-filter"></i>
            </button>
            <button data-bs-toggle="tooltip" title="Clear Filter" id="clear_filter" class="align-middle btn border border-1 ms-2" type="button">
                <i class="fa-solid fa-filter-circle-xmark"></i>
            </button>

        </div>
    </div>
    <div class="col-lg-2 col-sm-12 text-end pe-0 pb-1 ">
        <div class="d-flex justify-content-end">
            <?php $this->field('limit');  ?>
        </div>
    </div>
</form>
<?php echo $this->render('backend.transaction.list.javascript'); ?>
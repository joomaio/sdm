<div class="modal fade" id="exampleModalToggle" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered " style="max-width: 600px;">
        <div class="modal-content container px-5 pt-5">
            <?php echo $this->render('message'); ?>
            <form action="" method="post" id="form_request_list">
                <div class="row g-3 align-items-center">
                    <div class="row px-0">
                        <div class="mb-5 col-12 mx-auto pt-3">
                            <?php $this->field('title'); ?>
                        </div>
                    </div>
                    <div class="row pb-3 px-0">
                        <div class="col-3 d-flex align-items-center">
                            <label class="form-label fw-bold mb-0">Status</label>
                        </div>
                        <div class="col-9 d-flex">
                            <?php $this->field('status'); ?>
                        </div>
                    </div>
                    <div class="row px-0 mb-3">
                        <div class="col-3 d-flex align-items-center">
                            <label class="form-label fw-bold mb-0">Note</label>
                        </div>
                        <div class="col-9">
                            <?php $this->field('note'); ?>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center m-0">
                        <div class="modal-footer">
                            <?php $this->field('token'); ?>
                            <input class="form-control rounded-0 border border-1" id="request_list" type="hidden" name="_method" value="POST">
                            <div class="row">
                                <div class="col-6 text-end pe-0">
                                    <a href="<?php echo $this->link_list ?>">
                                        <button type="button" class="btn btn-outline-secondary fs-4">Cancel</button>
                                    </a>
                                </div>
                                <div class="col-6 text-end pe-0 ">
                                    <button type="submit" class="btn btn-outline-success fs-4">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
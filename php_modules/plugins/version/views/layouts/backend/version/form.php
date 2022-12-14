<div class="modal fade" id="exampleModalToggle" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered " style="max-width: 600px;">
        <div class="modal-content container px-5 pt-5">
            <?php echo $this->render('message'); ?>
            <form action="" method="post" id="form_version">
                <div class="row g-3 align-items-center">
                    <div class="row px-0">
                        <div class="mb-5 col-12 mx-auto pt-3">
                            <?php $this->field('name'); ?>
                        </div>
                    </div>
                    <div class="row px-0">
                        <div class="mb-3 col-12 mx-auto">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center">
                                    <label class="form-label fw-bold mb-0">Release Date</label>
                                </div>
                                <div class="col-9">
                                    <?php $this->field('release_date'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row px-0">
                        <div class="mb-3 col-12 mx-auto">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center">
                                    <label class="form-label fw-bold mb-0">Note</label>
                                </div>
                                <div class="col-9">
                                <?php $this->field('note'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center m-0">
                        <div class="modal-footer">
                            <?php $this->field('token'); ?>
                            <input class="form-control rounded-0 border border-1" id="version" type="hidden" name="_method" value="POST">
                            <div class="row">
                                <div class="col-6 text-end pe-0">
                                    <button type="button" class="btn btn-outline-secondary fs-4" data-bs-dismiss="modal">Cancel</button>
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
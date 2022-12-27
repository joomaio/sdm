<?php echo $this->render('notification'); ?>
<div class="modal fade" id="exampleModalToggle" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered " style="max-width: 600px;">
        <div class="modal-content container px-5 pt-5">
            <form action="" method="post" id="form_version">
                <div class="row g-3 align-items-center">
                    <div class="row">
                        <div class="mb-3 col-12 mx-auto pt-3">
                            <?php $this->field('name'); ?>
                        </div>
                    </div>
                    <div class="row">
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
                    <div class="row">
                        <div class="mb-3 col-12 mx-auto">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center">
                                    <label class="form-label fw-bold mb-0">Version</label>
                                </div>
                                <div class="col-9">
                                    <span id="version_number"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12 mx-auto">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center">
                                    <label class="form-label fw-bold mb-0">Description</label>
                                </div>
                                <div class="col-9">
                                <?php $this->field('description'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end mb-4">
                            <?php $this->field('token'); ?>
                            <input class="form-control rounded-0 border border-1" id="version" type="hidden" name="_method" value="POST">
                            <div class="me-2">
                                <button type="button" class="btn btn-outline-secondary fs-4" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-outline-success fs-4">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
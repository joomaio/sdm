<div class="modal fade" id="exampleModalToggle" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered " style="max-width: 600px;">
        <div class="modal-content container px-5 pt-5">
            <?php echo $this->render('message'); ?>
            <form action="" method="post" id="form_relate_note">
                <div class="row g-3 align-items-center">
                    <div class="row px-0">
                        <div class="mb-3 col-12 mx-auto">
                            <label class="form-label fw-bold">Note:</label>
                            <?php $this->field('note_id'); ?>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center m-0">
                        <div class="modal-footer">
                            <?php $this->field('token'); ?>
                            <input class="form-control rounded-0 border border-1" id="relate_note" type="hidden" name="_method" value="POST">
                            <div class="row">
                                <div class="col-6 text-end pe-0">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-6 text-end pe-0">
                                    <button type="submit" class="btn btn-outline-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
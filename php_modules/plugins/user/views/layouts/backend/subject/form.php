<div class="container-fluid align-items-center row justify-content-center mx-auto pt-3">
    <div class="card box-shadow col-lg-12 ">
        <div class="card-body">
            <?php echo $this->render('message');?>
            <form enctype="multipart/form-data" action="<?php echo  $this->link_form . '/' . $this->id ?>" method="POST">
                <div class="row g-3 align-items-center">
                    <div class="mb-3 col-lg-6 col-sm-12 mx-auto">
                        <label class="form-label fs-5 fw-bold pt-2">Name:</label>
                        <?php $this->field('sub_name'); ?>
                        <div class="d-flex mt-3">
                            <label class="col-form-label p-0 me-3 fw-bold fs-5">Active:</label>
                            <?php $this->field('sub_active'); ?>
                        </div>
                        <div class="row g-3 align-items-center  py-3 ">
                            <div class="col-xl-12 col-sm-7 text-start ">
                                <label class="col-form-label fw-bold">Select Topics:</label> <br>
                                <?php $this->field('topics'); ?>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <?php if ($this->data['sub_hdr_img_url']) { ?>
                                <img class="img-fluid my-3" name="sub hdr img" src="<? echo $this->data['sub_hdr_img_url']; ?>">
                            <?php } else { ?>
                                <div class="fw-bold mb-2 fs-5 text-center">No header picture</div>
                            <?php } ?>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="mb-3 col-lg-12 col-sm-12 mx-auto">
                                <label class="form-label w-100 fw-bold text-start fs-5"><?php echo $this->data['sub_hdr_img_url'] ? "Replace this picture (.jpg or .gif):" :  "Load header picture:" ?></label>
                                <input class="form-control mb-3" name="sub_hdr_img" type="file">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-xxl-12 col-md-12 mx-auto">
                                <label class="col-12 col-form-label fw-bold text-start">Subject Text:</label>
                                <div class="mb-3 border-end">
                                    <?php $this->field('sub_text'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-xxl-12 col-md-12 mx-auto">
                                <label class="col-12 col-form-label fw-bold text-start">Search Words (max 255 characters)</label>
                                <div class="mb-3 border-end">
                                    <?php $this->field('sub_search'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-xxl-12 col-md-12 mx-auto">
                                <label class="col-12 col-form-label fw-bold text-start">Resources</label>
                                <div class="mb-3 border-end">
                                    <?php $this->field('sub_resource'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-xxl-12 col-md-12 mx-auto">
                                <label class="col-12 col-form-label fw-bold text-start">Report citation</label>
                                <div class="mb-3 border-end">
                                    <?php $this->field('sub_citation'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <?php if ($this->data['sub_img_url']) { ?>
                                <img class="img-fluid my-3" name="sub hdr img" src="<? echo $this->data['sub_img_url']; ?>">
                            <?php } else { ?>
                                <div class="fw-bold mb-2 fs-5 text-center">No current menu picture</div>
                            <?php } ?>
                        </div>
                        <div class="row g-3 align-items-center  py-3 ">
                            <div class="col-xl-12 col-sm-7 text-start ">
                                <label class="col-form-label fw-bold"><? echo $this->data['sub_img_url'] ? "Replace This Menu Picture" : "Add New Menu Picture"; ?> (.jpg or .gif)</label> <br>
                                <input name="sub_img" class="form-control" type="file">Menu picture is 100 x 100 pixels
                            </div>
                        </div>

                    </div>
                </div>
                <?php
                $image_ct = 0;
                $this->subject_image = $this->subject_image ? $this->subject_image : [];
                for ($i = 0; $i < 7; $i++) {
                    $row = $this->subject_image[$i] ?  $this->subject_image[$i] : [];
                    $image_ct++;
                ?>
                        <div class="row">

                            <div class="col-xxl-6 col-md-12 py-3 mx-auto ">
                                <div class="row g-3 align-items-center py-3  border border-1">
                                    <div class="col-xl-6 col-sm-12 text-center">
                                        <?php if ($row['info_image_url']) { ?>
                                            <img name="subject_image_<? echo $row['info_image_url']; ?>" src="<? echo $row['info_image_url']; ?>" alt="<? echo $row['info_text']; ?>" border="1">
                                        <?php } else { ?>
                                            <label class="col-form-label fw-bold ">No picture</label>
                                        <?php } ?>

                                    </div>
                                    <div class="col-xl-6 col-sm-12 text-start m-0">
                                        <input type="hidden" name="info_id_<? echo $image_ct; ?>" value="<? echo $row['id'] ? $row['id'] : 'NEW'; ?>">
                                        <input name="info_image_<? echo $image_ct; ?>" type="hidden" value="<? echo $row['info_image']; ?>">
                                        <input name="info_sound_<? echo $image_ct; ?>" type="hidden" value="<? echo $row['info_sound']; ?>">

                                        <label class="col-form-label text-start fw-bold py-0">Text for picture <? echo $image_ct; ?>: &nbsp; </label>
                                        <input class="col-12 form-control rounded-0 border border-1" type="text" name="sub_txt_<? echo $image_ct; ?>" value="<? echo stripslashes($row['info_text']); ?>" size="50" maxlength="80">
                                        <label class="col-form-label text-start py-0 fw-bold"><?php echo $row['info_image_url'] ? "Replace this picture (.jpg or .gif)" : "Add new picture (.jpg or .gif)" ?></label>
                                        <input class="form-control" name="sub_image_<? echo $image_ct; ?>" type="file">
                                        <div class="mb-2 col-xxl-12 col-md-12 mx-auto">
                                            <?php if ($row['info_sound_url']) { ?>
                                                <embed src="<? echo $row['info_sound_url']; ?>" autostart=false width="0" height="0" id="sound_<? echo $image_ct; ?>" name="sound_<? echo $image_ct; ?>" enablejavascript="true"></embed>
                                            <?php } ?>

                                            <label class="col-form-label fw-bold col-12 text-start">Add sound file (.wav or .mp3)</label>
                                            <input class=" form-control" class="py-0" name="sub_sound_<? echo $image_ct; ?>" type="file">
                                        </div>
                                        <div class="col-3 mb-2 ">
                                            <label class="col-form-label text-start py-0 fw-bold">Sort Order</label>
                                            <input type="text" class="form-control" name="image_sort_<? echo $image_ct; ?>" value="<?php echo $row['sort_order'] ? $row['sort_order'] : "99" ?>" size="4">
                                        </div>
                                        <?php if ($row['id']) { ?>
                                            <input type="checkbox" name="del_img_<?php echo $i; ?>">
                                            <font color="red">Delete this Item</font>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }?>
                <div>
                    <div class="d-flex justify-content-center">
                        <input type="hidden" name="image_ct" value="<? echo $image_ct; ?>">
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-center  pt-3">
                        <span class="fs-6 fw-bold">Update Quick Facts Items</span>
                    </div>
                    <?php
                    $fact_ct_max = count($this->subject_fact) + 30;
                    if ($fact_ct_max > 49) {
                        $fact_ct_max = 49;
                    }
                    if ($this->subject_fact > 0) {
                        for ($fact_ct = 1; $fact_ct <= $fact_ct_max; $fact_ct++) {
                            # code...
                            $row = $this->subject_fact[$fact_ct] ? $this->subject_fact[$fact_ct] : [];
                    ?>
                            <div class="row">
                                <div class="col-xxl-6 col-sm-12 mx-auto">
                                    <div class="row align-items-center py-1">
                                        <input type="hidden" name="fact_id_<? echo $fact_ct; ?>" value="<? echo $row['id'] ? $row['id'] : 'NEW'; ?>">
                                        <div class="col-xl-2 col-sm-2">
                                            <input class="form-control rounded-0 border border-1" type="text" name="fact_sort_<? echo $fact_ct; ?>" value="<? echo $row['sort_order'] ? $row['sort_order'] : '99'; ?>" size="3" maxlength="3">
                                        </div>
                                        <div class="col-xl-4 col-sm-4">
                                            <input class="form-control rounded-0 border border-1" type="text" name="fact_name_<? echo $fact_ct; ?>" value="<? echo $row['name'] ? stripslashes($row['name']) : ''; ?>" size="30" maxlength="79">
                                        </div>
                                        <div class="col-xl-4 col-sm-4">
                                            <input class="form-control rounded-0 border border-1" type="text" name="fact_value_<? echo $fact_ct; ?>" value="<? echo $row['value'] ? stripslashes($row['value']) : ''; ?>" size="50" maxlength="249">
                                        </div>
                                        <div class="col-xl-2 col-sm-2">
                                            <input class="form-control rounded-0 border border-1" type="text" name="fact_s_link_<? echo $fact_ct; ?>" value="<? echo $row['s_link_id'] ? $row['s_link_id'] : '0'; ?>" size="5" maxlength="7">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <input type="hidden" name="fact_ct" value="<? echo $fact_ct; ?>">
                    <div class="row align-items-center py-3">
                        <div class="col-xl-6 col-sm-6 text-end">
                            <a href="<?php echo $this->link_list ?>">
                                <button type="button" class="btn btn-outline-secondary">Cancel</button>
                            </a>
                        </div>
                        <div class="col-xl-3 col-sm-6 text-start ">
                            <button type="submit" class="btn btn-outline-success">Save</button>
                        </div>
                    </div>
                    <?php $this->field('token'); ?>
                    <input type="hidden" name="_method" value="<?php echo !$this->id ? 'POST' : 'PUT' ?>">
                </div>
        </div>
    </div>
    </form>

</div>
</div>
<div class="main pt-3">
    <main class="content p-0">
        <div class="container-fluid p-0">
            <div class="row justify-content-center mx-auto">
                <div class="col-12">
                    <div class="card box-shadow col-lg-12 <?php echo $this->message ? '' : 'd-none' ?>">
						<div class="card-body fs-4">
						</div>
					</div>
                    <div class="card">
                        <div class="card-body">
                            <?php echo $this->render('message');?>
                            <div class="row align-items-center">
                                <?php echo $this->render('backend.subject.list.filter');?>
                            </div>
                            <table id="datatables-buttons" class="table table-striped border-top border-1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">#</th>
                                        <th>Name</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php while($this->list->hasRow()) $this->render('backend.subject.list.row'); ?> 
								</tbody>
                            </table>
                            <div class="row g-3 align-items-center">
								<?php echo $this->render('pagination'); ?>
							</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>


</div>
</div>



</body>

</html>
<div class="main border-bottom border-3 border-dark" style="min-height: 30vh;">
	<main class="content p-0 ">
		<div class="container-fluid p-0">
			<div class="row justify-content-center mx-auto">
				<div class="col-12 p-0">
					<div class="card border-0 shadow-none">
						<div class="card-body">
						<h2 class="pb-4 border-bottom"><i class="fa-solid fa-list-check pe-2"></i><?php echo $this->title_page_task ?></h2>
						<?php echo $this->render('message');?>
                        <div class="row align-items-center pt-3">
								<?php echo $this->render('backend.task.list.filter');?>
							</div>
							<div class="row align-items-center">
								<?php echo $this->render('backend.task.form');?>
							</div>
							<form action="<?php echo $this->link_list ?>" method="POST" id="formList">
								<input type="hidden" value="<?php echo $this->token ?>" name="token">
            					<input type="hidden" value="DELETE" name="_method">
								<table id="datatables-buttons" class="table table-striped border-top border-1" style="width:100%">
									<thead>
										<tr>
											<th width="10px">
												<input type="checkbox" id="select_all">
											</th>
											<th>Title</th>
											<th>Url</th>
											<th>Created At</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php while($this->list->hasRow()) $this->render('backend.task.list.row'); ?> 
									</tbody>
								<?php
								?>
								</table>
							</form>
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
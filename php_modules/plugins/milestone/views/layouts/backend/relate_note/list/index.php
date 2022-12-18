<div class="main " style="min-height: 30vh;" id="relate_note_link">
	<main class="content p-0 border-bottom border-3 border-dark">
		<div class="container-fluid p-0">
			<div class="row justify-content-center mx-auto">
				<div class="col-12 p-0">
					<div class="card border-0 shadow-none">
						<div class="card-body">
						<h2 class="pb-4 border-bottom"><i class="fa-solid fa-link pe-2"></i><?php echo $this->title_page_relate_note ?></h2>
						<?php echo $this->render('message');?>
                        <div class="row align-items-center pt-3">
								<?php echo $this->render('backend.relate_note.list.filter');?>
							</div>
							<div class="row align-items-center">
								<?php echo $this->render('backend.relate_note.form');?>
							</div>
							<form action="<?php echo $this->link_list ?>" method="POST" id="formListRelateNote">
								<input type="hidden" value="<?php echo $this->token ?>" name="token">
            					<input type="hidden" value="DELETE" name="_method">
								<table id="datatables-buttons" class="table table-striped border-top border-1" style="width:100%">
									<thead>
										<tr>
											<th width="10px">
												<input type="checkbox" id="select_all_relate_note">
											</th>
											<th>Title</th>
											<th>Description</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php while($this->list->hasRow()) $this->render('backend.relate_note.list.row'); ?> 
									</tbody>
								<?php
								?>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</main>
</div>

<div class="main">
	<main class="content p-0 ">
		<div class="container-fluid p-0">
			<div class="row justify-content-center mx-auto">
				<div class="col-12 pt-3">
					<div class="card">
						<div class="card-body">
						<?php echo $this->render('message');?>
                        <div class="row align-items-center">
								<?php echo $this->render('backend.user.list.filter');?>
							</div>
							<table id="datatables-buttons" class="table table-striped border-top border-1" style="width:100%">
								<thead>
									<tr>
										<th style="width: 40px;">#</th>
										<th>User Name</th>
										<th>Subscription Type</th>
										<th>Email</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>School Name</th>
										<th>Start Date</th>
										<th>Payment Date</th>
										<th>Expire Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php while($this->list->hasRow()) $this->render('backend.user.list.row'); ?> 
								</tbody>
							<?php
							?>
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
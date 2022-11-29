<?php

/**
 * SPT software - Layout html
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Display a layout
 * 
 */

if (!$this->total) return;

if ($this->totalPage > 5)
{
    $list_page = 0;
    if ($this->page > 1 && $this->page < 4)
    {
        $first = $this->page + 2;
    }
    elseif ($this->page == 1)
    {
        $first = 3;
    }
    else
    {
        $first = 0;
    }

    if ($this->page < $this->totalPage && $this->page > $this->totalPage - 3)
    {
        $last = [$this->page - 2, $this->totalPage];
    }
    elseif ($this->page == $this->totalPage)
    {
        $last = [$this->page - 2, $this->totalPage];
    }
    else
    {
        $last = [];
    }
    
    if ($this->page > 3 && $this->page < $this->totalPage - 2)
    {
        $mid = [$this->page - 2, $this->page + 2];
    }
    else
    {
        $mid = [];
    }
}
else
{
    $first = 0;
    $mid = [];
    $last = [];
    $list_page = $this->totalPage;
}
if ($this->totalPage > 4) {
    if ($this->page == 1) {
        $array = [1, 2, 3, 0, $this->totalPage];
    } elseif ($this->page == 2 && $this->totalPage > 5) {
        $array = [1, 2, 3, 4, 0, $this->totalPage];
    } elseif ($this->page == 2 && $this->totalPage == 5) {
        $array = [1, 2, 3, 4, $this->totalPage];
    } elseif ($this->page == 3 && $this->totalPage == 5) {
        $array = [1, 2, 3, 4, $this->totalPage];
    } elseif ($this->page == 3 && $this->totalPage > 5) {
        $array = [1, 2, 3, 4, 0, $this->totalPage];
    } elseif ($this->page == ($this->totalPage - 2)) {
        $array = [1, 0, $this->page - 1, $this->page, $this->totalPage];
    } elseif ($this->page == ($this->totalPage - 1)) {
        $array = [1, 0, $this->page - 1, $this->page, $this->totalPage];
    } elseif ($this->page == $this->totalPage) {
        $array = [1, 0, $this->page - 1, $this->page];
    } else {
        $array = [1, 0, $this->page - 1, $this->page, $this->page + 1, 0, $this->totalPage];
    }
} else {
    $array = range(1, $this->totalPage);
}

?>
<div class="col-sm-12 col-md-5 center-768 d-flex flex-column pl-0">
    <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing <?php echo $this->start + 1; ?> to
        <span id="number_entrie"><?php echo ($this->page) * $this->limit <= $this->total ? ($this->page) * $this->limit : $this->total; ?></span>
        of <span id="total_entrie"><?php echo $this->total; ?></span> entries
    </div>
    <div class="dataTables_info d-flex" >
		<span> Go to page: </span>
		<select onchange="location = this.value;" class="form-select form-select-sm ms-2 pe-2" style="width:70px;" aria-label="Default select example">
			<?php for ($i = 1; $i <= $this->totalPage; $i++) : ?>
			<option <?php if ($i == $this->page) : ?> selected <?php endif; ?> value="<?php echo $this->path_current. '?page='. $i ?>"><?php echo $i ?></option>
			<?php endfor;  ?>
		</select>
	</div>
</div>
<div class="col-sm-12 col-md-7 center-768 p-0">
    <div class="dataTables_paginate paging_simple_numbers ">
        <ul class="pagination d-flex justify-content-end mg-0">
            <li style="margin: 0;" class="page-item <?php echo ($this->page == 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $this->path_current . '?page=1' ?>">First</a>
            </li>
            <li style="margin: 0;" class="page-item <?php echo ($this->page == 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $this->path_current . '?page=' . ($this->page - 1); ?>">Previous</a>
            </li>
            <?php foreach ($array as $p) {
                $class = '';
                if (0 === $p) {
                    $class = 'disabled';
                } elseif ($this->page == $p) {
                    $class = 'active';
                }  ?>
                <li style="margin: 0;" class="page-item hide_576 <?php echo $class; ?>">
                    <a class="page-link " href="<?php echo $this->path_current . '?page=' . $p; ?>">
                        <?php echo 0 === $p ? '...' : $p ?>
                    </a>
                </li>
            <?php } ?>
            <li style="margin: 0;" class="page-item  <?php echo ($this->page == $this->totalPage) ? 'disabled' : ''  ?>">
                <a class="page-link" href="<?php echo $this->path_current . '?page=' . ($this->page + 1); ?>">Next</a>
            </li>
            <li style="margin: 0;" class="page-item  <?php echo ($this->page == $this->totalPage) ? 'disabled' : ''  ?>">
                <a class="page-link" href="<?php echo $this->path_current . '?page=' . $this->totalPage; ?>">Last</a>
            </li>
        </ul>
    </div>
</div>
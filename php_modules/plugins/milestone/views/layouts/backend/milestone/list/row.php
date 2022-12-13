<tr>
    <td>
        <input class="checkbox-item" type="checkbox" name="ids[]" value="<?php echo $this->item['id']; ?>">
    </td>
    <td>
        <a href="#" class="show_data" 
            data-id="<?php echo  $this->item['id'] ?>" 
            data-title="<?php echo  $this->item['title']  ?>" 
            data-status="<?php echo   $this->item['status'] ?>" 
            data-start_date="<?php echo   $this->item['start_date'] ? date('Y-m-d', strtotime($this->item['start_date'])) : '';  ?>" 
            data-note="<?php echo ($this->item['note']); ?>" 
            data-end_date="<?php echo   $this->item['end_date'] ? date('Y-m-d', strtotime($this->item['end_date'])) : '';  ?>" 
            data-bs-placement="top" 
            data-bs-toggle="modal" 
            data-bs-target="#exampleModalToggle"><?php echo  $this->item['title']  ?>
        </a>
    </td>
    <td><?php echo   $this->item['status'] ? 'Show' : 'Hide';  ?></td>
    <td><?php echo   $this->item['created_at'] ? date('m-d-Y', strtotime($this->item['created_at'])) : '';  ?></td>
    <td>
        <a href="#" 
            class="fs-4 me-1 show_data" 
            data-id="<?php echo  $this->item['id'] ?>" 
            data-title="<?php echo  $this->item['title']  ?>" 
            data-status="<?php echo   $this->item['status']?>"
            data-start_date="<?php echo   $this->item['start_date'] ? date('Y-m-d', strtotime($this->item['start_date'])) : '';  ?>" 
            data-note="<?php echo ($this->item['note']); ?>" data-end_date="<?php echo   $this->item['end_date'] ? date('Y-m-d', strtotime($this->item['end_date'])) : '';  ?>" 
            data-bs-placement="top" 
            data-bs-toggle="modal" 
            data-bs-target="#exampleModalToggle">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a data-id="<?php echo  $this->item['id'] ?>" style="color:#3b7ddd;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="delete fs-4 ps-1 border-0 bg-transparent button_delete_item"><i class="fa-solid fa-trash"></i></a>
    </td>
</tr>
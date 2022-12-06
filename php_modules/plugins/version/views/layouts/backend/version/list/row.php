<tr>
    <td>
        <input class="checkbox-item" type="checkbox" name="ids[]" value="<?php echo $this->item['id']; ?>">
    </td>
    <td><a href="<?php echo $this->link_form_detail . '/' . $this->item['id']; ?>"><?php echo  $this->item['name']  ?></a></td>
    <td><?php echo   $this->item['release_date'] ? date('m-d-Y', strtotime($this->item['release_date'])) : '';  ?></td>
    <td><?php echo   $this->item['created_at'] ? date('m-d-Y', strtotime($this->item['created_at'])) : '';  ?></td>
    <td>
        <a class="fs-4 me-1" href="<?php echo $this->link_form . '/' . $this->item['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
        <a class="fs-4 me-1" href="<?php echo $this->link_form . '-feedback/' . $this->item['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Go to feedback"><i class="fa-solid fa-message"></i></a>
        <a data-id="<?php echo  $this->item['id'] ?>" style="color:#3b7ddd;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="delete fs-4 border-0 bg-transparent button_delete_item"><i class="fa-solid fa-trash"></i></a>
    </td>
</tr>
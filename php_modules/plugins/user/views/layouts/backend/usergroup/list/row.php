<tr>
    <td>
        <input class="checkbox-item" type="checkbox" name="ids[]" value="<?php echo $this->item['id']; ?>">
    </td>
    <td><a href="<?php echo $this->link_form . '/' . $this->item['id']; ?>"><?php echo  $this->item['name']  ?></a></td>
    <td>
        <?php
            if ($this->item['access'] && count($this->item['access']) < 5){
                foreach($this->item['access'] as $item) 
                {
                    if ($item)
                    {
                        echo '<span class="badge bg-secondary me-1 fs-6">'.$item.'</span>';
                    }
                }
            } elseif(count($this->item['access']) >= 5) {
                echo '<span class="badge bg-secondary me-1 fs-6">Multiple Access</span>';
            }else{
                echo 'no group';
            }
            
        ?>
    </td>
    <td><?php echo   $this->item['status'] ? 'Active' : 'Inactive';  ?></td>
    <td>
        <a class="fs-4 me-1" href="<?php echo $this->link_form . '/' . $this->item['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
        <a data-id="<?php echo  $this->item['id'] ?>" style="color:#3b7ddd;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="delete fs-4 ps-1 border-0 bg-transparent button_delete_item"><i class="fa-solid fa-trash"></i></a>
    </td>
</tr>
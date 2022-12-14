<tr>
    <td>
        <input class="checkbox-item" type="checkbox" name="ids[]" value="<?php echo $this->item['id']; ?>">
    </td>
    <td>
        <a href="#"
            class="show_data"
            data-id="<?php echo  $this->item['id'] ?>" 
            data-name="<?php echo  $this->item['name']  ?>" 
            data-description="<?php echo  $this->item['description']  ?>" 
            data-release_date="<?php echo   $this->item['release_date'] ? date('Y-m-d', strtotime($this->item['release_date'])) : '';?>" 
            data-bs-placement="top" 
            data-bs-toggle="modal" 
            data-bs-target="#exampleModalToggle">
            <?php echo  $this->item['name']  ?>
        </a>
    </td>
    <td>
        <?php echo  strlen($this->item['description']) > 50 ? substr($this->item['description'], 0, 50) .'...' : $this->item['description'];  ?>
    </td>
    <td>
        <?php 
        if($this->get_log){
            foreach($this->get_log as $log)  {
                if($log['version_id'] == $this->item['id']){
                    echo '<span>'. '- ' . $log['log'] . '</span> <br>'; 
                }
            }
        }
        ?>
    </td>
    <td><?php echo   $this->item['release_date'] ? date('m-d-Y', strtotime($this->item['release_date'])) : '';  ?></td>
    <td><?php echo   $this->item['created_at'] ? date('m-d-Y', strtotime($this->item['created_at'])) : '';  ?></td>
    <td>
        <a href="#" 
            class="fs-4 me-1 show_data" 
            data-id="<?php echo  $this->item['id'] ?>" 
            data-name="<?php echo  $this->item['name']  ?>" 
            data-description="<?php echo  $this->item['description']  ?>" 
            data-release_date="<?php echo   $this->item['release_date'] ? date('Y-m-d', strtotime($this->item['release_date'])) : '';?>"
            data-bs-placement="top" 
            data-bs-toggle="modal" 
            data-bs-target="#exampleModalToggle">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a class="fs-4 me-1" href="<?php echo $this->link_form . '-feedback/' . $this->item['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Go to feedback"><i class="fa-solid fa-message"></i></a>
        <a data-id="<?php echo  $this->item['id'] ?>" style="color:#3b7ddd;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="delete fs-4 border-0 bg-transparent button_delete_item"><i class="fa-solid fa-trash"></i></a>
    </td>
</tr>
<tr>
    <td>
        <input class="checkbox-item" type="checkbox" name="ids[]" value="<?php echo $this->item['id']; ?>">
    </td>
    <td><a href="<?php echo $this->link_detail . '/' . $this->item['id']; ?>"><?php echo  $this->item['title']  ?></a></td>
    <td>
        <?php $description = $this->item['description'] ? $this->item['description'] : ''; ?>
        <?php echo  strlen(strip_tags($description)) > 50 ? substr(strip_tags($description), 0, 50) .'...' : $description;  ?>
    </td>
    <td><?php echo   $this->item['creator'] ?></td>
    <td>
        <a class="fs-4 me-1 show_data" 
            href="#"
            data-id="<?php echo  $this->item['id'] ?>" 
            data-title="<?php echo  $this->item['title']  ?>" 
            data-description="<?php echo ($this->item['description']); ?>" 
            data-bs-placement="top" 
            data-bs-toggle="modal" 
            data-bs-target="#exampleModalToggle">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    </td>
</tr>
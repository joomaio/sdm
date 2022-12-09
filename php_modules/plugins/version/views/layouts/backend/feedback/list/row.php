<tr>
    <td>
        <a href="<?php echo $this->link_form . '/' . $this->item['id']; ?>">
            <?php echo  $this->item['title']  ?>
        </a>
    </td>
    <td><?php echo   $this->item['tags'];?></td>
    <td><?php echo   $this->item['created_at'] ? date('m-d-Y', strtotime($this->item['created_at'])) : '';  ?></td>
</tr>
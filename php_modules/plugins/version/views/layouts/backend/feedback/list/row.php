<tr>
    <td>
        <a href="<?php echo $this->link_form . '/' . $this->item['id']; ?>">
            <?php echo  $this->item['title']  ?>
        </a>
    </td>
    <td><?= !empty($this->data_tags[$this->item['id']]) ? $this->data_tags[$this->item['id']] : '' ?></td>
    <td><?php echo   $this->item['created_at'] ? date('m-d-Y', strtotime($this->item['created_at'])) : '';  ?></td>
</tr>
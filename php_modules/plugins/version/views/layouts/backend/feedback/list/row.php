<tr>
    <td>
        <a href="<?php echo $this->link_form . '/' . $this->item['id']; ?>" target="_blank">
            <?php echo  $this->item['title']  ?><i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
        </a>
        <p class="p-0 m-0 text-muted"><?php echo $this->item['note']?></p>
    </td>
    <td><?= !empty($this->data_tags[$this->item['id']]) ? $this->data_tags[$this->item['id']] : '' ?></td>
</tr>
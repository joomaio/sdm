<tr>
    <td>
        <input class="checkbox-item-relate-note" type="checkbox" name="ids[]" value="<?php echo $this->item['id']; ?>">
    </td>
    <td>
        <a href="<?php echo $this->link_note. '/'. $this->item['note_id']; ?>"><?php echo  $this->item['title']  ?></a>
    </td>
    <td><?php echo   $this->item['description'] ?></td>
    <td>
        <a data-id="<?php echo  $this->item['id'] ?>" style="color:#3b7ddd;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="delete fs-4 ps-1 border-0 bg-transparent button_delete_item_relate_note"><i class="fa-solid fa-trash"></i></a>
    </td>
</tr>
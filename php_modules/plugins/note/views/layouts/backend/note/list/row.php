<tr>
    <td>
        <input class="checkbox-item" type="checkbox" name="ids[]" value="<?php echo $this->item['id']; ?>">
    </td>
    <td><a href="<?php echo $this->link_form . '/' . $this->item['id']; ?>"><?php echo  $this->item['title']  ?></a></td>
    <td><?= !empty($this->data_tags[$this->item['id']]) ? $this->data_tags[$this->item['id']] : '' ?></td>
</tr>

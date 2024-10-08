<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       x
 * @since      4.0.0
 *
 * @package    Etapes_Print
 * @subpackage Etapes_Print/admin/partials
 */

  defined( 'ABSPATH' ) || exit;
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
  <?php
      if (isset($_GET['upt'])) {
        $upt_id = $_GET['upt'];
        $print = $wpdb->get_row("SELECT * FROM $table_name WHERE id='$upt_id'");
        if ($print) {
      ?>
      <h2>EDIT</h2>
      <table class='wp-list-table widefat striped'>
        <thead>
          <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th>Position</th>
            <?php foreach ($fields as $key => $value) { ?>
              <th><?php echo $this->dataset->get_label_by_key($key); ?></th>
            <?php } ?>
            <th style="min-width: 130px!important">Actions</th>
          </tr>
        </thead>
        <tbody>
          <form action='' method='post'>
          <tr>
            <td><?php echo $print->id ?><input type='hidden' id='uptid' name='uptid' value='<?php echo $print->id ?>'></td>
            <td><input type="text" id="uptcode" name="uptcode" value='<?php echo $print->code ?>'></td>
            <td><input type="text" id="uptname" name="uptname" value='<?php echo $print->name ?>'></td>
            <td><input type="number" id="uptposition" name="uptposition" value='<?php echo $print->position ?>'></td>
            <?php foreach ($fields as $key => $value) { ?>
              <td><input type="<?php echo $value == 'number' ? 'number' : 'text' ?>" <?php echo $value == 'decimal' ? 'inputmode="numeric" pattern="[0-9]+(\.[0-9]+)?" title="This should be a number"' : '' ?> id="upt<?php echo $key ?>" name="upt<?php echo $key ?>" value="<?php echo $print->{$key} ?>"></td>
            <?php } ?>
            <td><button id='uptsubmit' name='uptsubmit' type='submit'>UPDATE</button> <a href='admin.php?page=<?php echo $page ?>'><button type='button'>CANCEL</button></a></td>
          </tr>
          </form>
        </tbody>
      </table>

    <?php } } ?>
  <br>
  <h2 style="text-transform:uppercase;"><?php echo htmlspecialchars($option); ?></h2>
  <div class="notice">
    <form action="" method="post" enctype="multipart/form-data">
      <h3>Import/Export des données :</h3>
      <button class="button-primary" type="submit" name="epexport" value="epexport" id="epexport">Exporter</button>
      
      <input type="file" name="csvfile" accept=".csv"/>
      <button class="button-secondary" id="epimport" name="epimport" value="epimport" type="submit">Importer</button>
    </form>
  </div>
  <table class="wp-list-table widefat striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Code</th>
        <th>Nom</th>
        <th>Position</th>
        <?php foreach ($fields as $key => $value) { ?>
          <th><?php echo $this->dataset->get_label_by_key($key); ?></th>
         <?php } ?>
        <th style="min-width: 125px!important">Actions</th>
      </tr>
    </thead>
    <tbody>
      <form action="" method="post">
        <tr>
          <td><input style="width: 30px;" type="text" value="#" disabled></td>
          <td><input type="text" id="newcode" name="newcode"></td>
          <td><input type="text" id="newname" name="newname"></td>
          <td><input type="number" id="newposition" name="newposition"></td>
          <?php foreach ($fields as $key => $value) { ?>
            <td><input type="<?php echo $value == 'string' ? 'text' : 'number' ?>" <?php echo $value == 'decimal' ? 'step="0.001"' : '' ?> id="new<?php echo $key ?>" name="new<?php echo $key ?>"></td>
          <?php } ?>
          <td><button id="newsubmit" name="newsubmit" type="submit">ADD</button></td>
        </tr>
      </form>
      <?php foreach ($results as $print) { ?>
        <tr>
          <td><?php echo $print->id ?></td>
          <td><?php echo $print->code ?></td>
          <td><?php echo $print->name ?></td>
          <td><?php echo $print->position ?></td>
          <?php foreach ($fields as $key => $value) { ?>
            <td><?php echo $print->{$key} ?></td>
          <?php } ?>
          <td><a href='admin.php?page=<?php echo $page ?>&upt=<?php echo $print->id ?>'><button type='button'>UPDATE</button></a> <a href='admin.php?page=<?php echo $page ?>&del=<?php echo $print->id ?>'><button type='button'>DELETE</button></a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
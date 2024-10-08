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
<h2><?php echo $my_table_name; ?></h2>
<form method="post">
    <table class="form-table">
        <tr>
            <th scope="row"><label for="code">Code</label></th>
            <td><input type="text" name="code" value="<?php echo esc_attr( $row['code'] ); ?>" class="regular-text" required></td>
        </tr>
        <?php foreach ( $options_data as $option => $data ) { 
          $option_name = $this->dataset->get_label_by_key($option);
          // asort($data);
        ?>
          <tr>
            <th scope="row"><label for="<?php echo $option; ?>"><?php echo $option_name; ?></label></th>
            <td>
              <select id="etapes_print_select_multiple" name="<?php echo 'etapes_print_' . $option . '_values[]' ?>" multiple="multiple">
                <?php foreach ($data as $key => $value) { ?>
                  <option value="<?php echo $key ?>" <?php echo ( in_array( $key, $currentData[$option] ) ? 'selected="selected"' : '' ) ?>><?php echo esc_html($value) ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
        <?php } if ($page == 'etapes-print-select-rule') { ?>
          <tr>
            <th scope="row"><label for="deny">Deny</label></th>
            <td>
              <select id="etapes_print_select_multiple" name="<?php echo 'deny[]' ?>" multiple="multiple">
                <?php foreach ($denyData as $value) { ?>
                  <option value="<?php echo $value['code'] ?>" <?php echo ( in_array( $value['code'], $denyList ) ? 'selected="selected"' : '' ) ?>><?php echo esc_html($value['code']) ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
        <? } ?>
    </table>
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer"></p>
</form>
</div>
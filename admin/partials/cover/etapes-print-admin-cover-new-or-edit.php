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
        <tr>
          <th scope="row"><label for="format">Format</label></th>
          <td>
            <select id="etapes_print_select_multiple" name="<?php echo 'etapes_print_format_values[]' ?>" multiple="multiple">
              <?php foreach ($formatList as $key => $value) { ?>
                <option value="<?php echo $key ?>" <?php echo ( in_array( $key, $currentData['format'] ) ? 'selected="selected"' : '' ) ?>><?php echo esc_html($value) ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="format">Format par défaut</label></th>
          <td>
            <select id="etapes_print_format_default_value" class="etapes_print_select_input" name="<?php echo 'etapes_print_format_default_value' ?>">
              <?php foreach ($currentData['format'] as $key) { ?>
                <option value="<?php echo $key ?>" <?php echo ($key === $row['default_format']) ? 'selected="selected"' : '' ?>><?php echo $this->dataset->get_label_by_key($key) ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="paper">Papier</label></th>
          <td>
            <select id="etapes_print_select_multiple" name="<?php echo 'etapes_print_paper_values[]' ?>" multiple="multiple">
              <?php foreach ($paperList as $key => $value) { ?>
                <option value="<?php echo $key ?>" <?php echo ( in_array( $key, $currentData['paper'] ) ? 'selected="selected"' : '' ) ?>><?php echo esc_html($value) ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="paper">Papier par défaut</label></th>
          <td>
            <select id="etapes_print_paper_default_value" class="etapes_print_select_input" name="<?php echo 'etapes_print_paper_default_value' ?>">
              <?php foreach ($currentData['paper'] as $key) { ?>
                <option value="<?php echo $key ?>" <?php echo ($value === $row['default_paper']) ? 'selected="selected"' : '' ?>><?php echo $this->dataset->get_label_by_key($key) ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
    </table>
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer"></p>
</form>
</div>
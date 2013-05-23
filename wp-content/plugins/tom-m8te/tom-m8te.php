<?php
/*
Plugin Name: Tom M8te
Plugin URI: http://wordpress.org/extend/plugins/tom-m8te/
Description: Tom-M8te provides useful functions that you can use in your plugins. Such as a nice function for adding social share links and database manipulation functions. 

Installation:

1) Install WordPress 3.4.2 or higher

2) Download the following file:

http://downloads.wordpress.org/plugin/tom-m8te.zip

3) Login to WordPress admin, click on Plugins / Add New / Upload, then upload the zip file you just downloaded.

4) Activate the plugin.

Version: 1.2.1
Author: TheOnlineHero - Tom Skroza
License: GPL2
*/
//  echo("<script language='javascript'>jQuery(window).keydown(function(e) {if (e.keyCode== 13 && e.ctrlKey) {alert('BOOO');}});</script>");

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

add_action('admin_menu', 'register_tom_m8te_page');

function register_tom_m8te_page() {
   add_menu_page('Tom M8te', 'Tom M8te', 'update_themes', 'tom-m8te/tom_m8te_docs.php', '',  '', 186);
}

function check_tom_m8te_version() {
  update_option("tom_m8te_version", "1.2");
}
check_tom_m8te_version();

function tom_add_social_share_links($url) {
  ?>
  <a title="Share On Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo($url); ?>"><img style="width: 30px;" src="<?php echo(get_option("siteurl")); ?>/wp-content/plugins/tom-m8te/images/facebook.jpg" style="width: 30px;" /></a>
  <a title="Share On Twitter" target="_blank" href="http://twitter.com/intent/tweet?url=<?php echo($url); ?>"><img style="width: 30px;" src="<?php echo(get_option("siteurl")); ?>/wp-content/plugins/tom-m8te/images/twitter.jpg" style="width: 30px;" /></a>
  <?php
}

function tom_get_query_string_value($name) {
  if (isset($_POST[$name])) {
    return $_POST[$name];
  } else if (isset($_GET[$name])) {
    return $_GET[$name];
  } else {
    return "";
  }
}

function tom_generate_datatable($table_name, $fields_array, $primary_key_name, $where_clause, $order_array = array(), $limit_clause = "", $page_name, $display_show = true, $display_edit = true, $display_delete = true) {
    
  if (!is_array($fields_array)) {
    echo("Fields Array, can only accept an array of field names.");
  } else {
    $results = tom_get_results($table_name, $fields_array, $where_clause, $order_array, $limit_clause);
    
    echo("<div class=\"postbox\" style=\"display: block; \"><div class=\"inside\">");
    if (count($results) > 0) { ?>
        <table class="data">
          <thead>
            <tr>
              <?php foreach($fields_array as $field_name) { ?>
                <th><?php echo(str_replace("_", " ", $field_name)); ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody> 
            <?php foreach($results as $result) { ?>
              <tr>
                <?php foreach($fields_array as $field_name) { ?>
                  <td><?php echo($result->$field_name); ?></td>
                <?php } ?>
                <?php if ($display_show) { ?>
                  <td><a href="<?php echo($page_name); ?>&action=show&id=<?php echo($result->$primary_key_name); ?>">Show</a></td>
                <?php }?>
                <?php if ($display_edit) { ?>
                  <td><a href="<?php echo($page_name); ?>&action=edit&id=<?php echo($result->$primary_key_name); ?>">Edit</a></td>
                <?php }?>
                <?php if ($display_delete) { ?>
                  <td><a class="delete" href="<?php echo($page_name); ?>&action=delete&id=<?php echo($result->$primary_key_name); ?>">Delete</a></td>
                <?php }?>                
              </tr>
            <?php } ?>

          </tbody>
        </table>
    <?php }
    echo("</div></div>"); 
  }

}

function tom_compress_content($content) {
  /* remove comments */
  $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
  /* remove tabs, spaces, newlines, etc. */
  return str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $content);
}


function tom_add_form_field($instance, $field_type, $field_label, $field_id, $field_name, $field_attributes = array(), $container_element, $container_attributes = array(), $value_options = array()) {
  $field_content = "";
  foreach ($field_attributes as $key => $value) {
    $field_content .= "$key='$value' ";
  }
  $container_content = "";
  foreach ($container_attributes as $key => $value) {
    $container_content .= "$key='$value' ";
  }
  
  $field_value = $instance->$field_name;
  if (tom_get_query_string_value($field_name) != "") {
    $field_value = tom_get_query_string_value($field_name);
  }

  echo("<$container_element $container_content><label for='$field_id'>$field_label</label>");
  if (preg_match("/text/i", $field_type)) {
    echo("<input type='text' id='$field_id' name='$field_name' value='$field_value' $field_content />");
  } else if (preg_match("/hidden/i", $field_type)) {
    echo("<input type='hidden' id='$field_id' name='$field_name' value='$field_value' />");
  } else if (preg_match("/select/i", $field_type)) {
    echo("<select id='$field_id' name='$field_name'>");
    foreach($value_options as $key => $option) {
      if ($field_value == $key) {
        echo("<option value='$key' selected>$option</option>");
      } else {
        echo("<option value='$key'>$option</option>");
      }
    } 
    echo("</select>");
  } else if (preg_match("/radio/i", $field_type)) {
    foreach($value_options as $key => $option) {
      if ($field_value == $key) {
        echo("<input type='radio' id='$field_id_$key' name='$field_name' value='$key' checked><label for='$field_id_$key'>$option</label></input>");
      } else {
        echo("<input type='radio' id='$field_id_$key' name='$field_name' value='$key'><label for='$field_id_$key'>$option</label></input>");
      }
    }
  } else if (preg_match("/checkbox/i", $field_type)) {
    foreach($value_options as $key => $option) {
      echo("<input type='hidden' name='$field_name' value=''></input>");
      if ($field_value == $key) {
        echo("<input type='checkbox' id='$field_id_$key' name='$field_name' value='$key' checked><label for='$field_id_$key'>$option</label></input>");
      } else {
        echo("<input type='checkbox' id='$field_id_$key' name='$field_name' value='$key'><label for='$field_id_$key'>$option</label></input>");
      }
    }
  }
  echo("</$container_element>");
}


function tom_create_option_if_not_exist($option_name) {
  if (!get_option($option_name)) {
    add_option($option_name);
  }
}

function tom_create_table($table_name, $fields_array_with_datatype, $primary_key_array) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix . $table_name;
  $fields_comma_separated = implode(",", $fields_array_with_datatype);
  $primary_key_comma_separated = implode(",", $primary_key_array);
  $primary_key_text = ", PRIMARY KEY  ($primary_key_comma_separated)";
  if (count($primary_key_array) > 1) {
    $primary_key_text = ", UNIQUE KEY ".$primary_key_array[0]." ($primary_key_comma_separated)";
  }
  
  $sql = "CREATE TABLE $table_name_prefix ($fields_comma_separated  $primary_key_text);";
  return dbDelta($sql);
}

function tom_add_fields_to_table($table_name, $fields_array_with_datatype) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix . $table_name;
  $fields_comma_separated = implode(",", $fields_array_with_datatype);
  $sql = "ALTER TABLE $table_name_prefix ADD $fields_comma_separated";
  return $wpdb->query($sql);
}

function tom_insert_record($table_name, $insert_array) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix.$table_name;
  return $wpdb->insert($table_name_prefix, $insert_array);
}

function tom_update_record_by_id($table_name, $update_array, $id_column_name, $id) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix.$table_name;
  return $wpdb->update($table_name_prefix, $update_array, array($id_column_name => $id));
}

function tom_update_record($table_name, $update_array, $where_array) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix.$table_name;
  return $wpdb->update($table_name_prefix, $update_array, $where_array);
}

function tom_delete_record_by_id($table_name, $id_column_name, $delete_id) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix.$table_name;
  return $wpdb->query($wpdb->prepare("DELETE FROM $table_name_prefix WHERE $id_column_name = %d", $delete_id));
}

function tom_delete_record($table_name, $where_sql) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix.$table_name;
  return $wpdb->query("DELETE FROM $table_name_prefix WHERE $where_sql");
}

function tom_get_results($table_name, $fields_array, $where_sql, $order_array = array(), $limit = "") {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix.$table_name;
  if ($fields_array == "*") {
    $fields_comma_separated = "*";
  } else {
    $fields_comma_separated = implode(",", $fields_array);
  }

  if (!empty($where_sql)) {
    $where_sql = "WHERE ".$where_sql;
  }
  $order_sql = "";
  if (!empty($order_array)) {
    $order_sql = "ORDER BY ".implode(",", $order_array);
  }
  $limit_sql = "";
  if ($limit != "") {
    $limit_sql = "LIMIT $limit";
  }
  $sql = "SELECT $fields_comma_separated FROM $table_name_prefix $where_sql $order_sql $limit_sql";
  //echo $sql;
  return $wpdb->get_results($sql);
}

function tom_get_row_by_id($table_name, $fields_array, $id_column_name, $id) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix.$table_name;
  $fields_comma_separated = implode(",", $fields_array);
  return $wpdb->get_row($wpdb->prepare("SELECT $fields_comma_separated FROM $table_name_prefix  WHERE $id_column_name = %d", $id));
}

function tom_get_row($table_name, $fields_array, $where_sql) {
  global $wpdb;
  $table_name_prefix = $wpdb->prefix.$table_name;
  $fields_comma_separated = implode(",", $fields_array);
  return $wpdb->get_row("SELECT $fields_comma_separated FROM $table_name_prefix WHERE $where_sql LIMIT 1");
}

?>
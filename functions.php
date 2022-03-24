<?php

function redwolf_files() {
    wp_enqueue_style('main_style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'redwolf_files');

function sports_bench_create_db() {
 global $wpdb;
 $charset_collate = $wpdb->get_charset_collate();
 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

 //* Create the teams table
 $table_name = $wpdb->prefix . 'sb_teams';
 $sql = "CREATE TABLE $table_name (
 team_id INTEGER NOT NULL AUTO_INCREMENT,
 team_name TEXT NOT NULL,
 team_city TEXT NOT NULL,
 team_state TEXT NOT NULL,
 team_stadium TEXT NOT NULL,
 PRIMARY KEY (team_id)
 ) $charset_collate;";
 dbDelta( $sql );
}
register_activation_hook( __FILE__, 'sports_bench_create_db' );

function sports_bench_team_admin_menu() {
 global $team_page;
 add_menu_page( __( 'Teams', 'sports-bench' ), __( 'Teams', 'sports-bench' ), 'edit_posts', 'add_data', 'sports_bench_teams_form_page_handler', 'dashicons-groups', 6 ) ;
}
add_action( 'admin_menu', 'sports_bench_team_admin_menu' );

function sports_bench_teams_form_page_handler() {
  global $wpdb;
  echo '<form method="POST" action="?page=add_data">
 <label>Team Name: </label><input type="text" name="team_name" /><br />
 <label>Team City: </label><input type="text" name="team_city" /><br />
 <label>Team State: </label><input type="text" name="team_state" /><br />
 <label>Team Stadium: </label><input type="text" name="team_stadium" /><br />
<input type="submit" value="submit" />
</form>';

  $default_row = $wpdb->get_row( "SELECT * FROM $table_name ORDER BY team_id DESC LIMIT 1" );
if ( $default_row != null ) {
 $id = $default_row->team_id + 1;
} else {
 $id = 1;
}
 $default = array(
 'team_id' => $id,
 'team_name' => '',
 'team_city' => '',
 'team_state' => '',
 'team_stadium' => '',
);
$item = shortcode_atts( $default, $_REQUEST );

 $wpdb->insert( $table_name, $item );
}
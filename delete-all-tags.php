<?php
/* 
 * Plugin Name:   Delete all tags
 * Version:       0.1
 * Plugin URI:    http://www.syscomes.com
 * Description:   Delete all tags
 * Author:        Jesse
 * Author URI:    http://www.syscomes.com
 */
add_action('admin_menu', 'delete_all_tags_menu_setup');
function delete_all_tags_menu_setup() {
   
   add_posts_page('Delete All Tags', 'Delete All Tags', 8, __FILE__, 'delete_all_tags');

 
}
function delete_all_tags(){
	global $wpdb;



if( $_POST['delete_all_tags'] == 'delete_all_tags' ){
	$zero='';
	if($_POST['zero'] == 'on')
		$zero=' AND c.count = 0';
	global $wpdb;
	$sql=<<<EOF
DELETE a,b,c
FROM
	{$wpdb->terms} AS a
	LEFT JOIN {$wpdb->term_taxonomy} AS c ON a.term_id = c.term_id
	LEFT JOIN {$wpdb->term_relationships} AS b ON b.term_taxonomy_id = c.term_taxonomy_id
WHERE (
	c.taxonomy = 'post_tag' {$zero}
	)
	
EOF;

	//check_admin_referer('empty_trash_update');
	$result=$wpdb->query($sql);
	
	
}
if($result){

	echo	'<div id="message" class="updated fade"><p>All tags are gone!</p></div>';
}else
if($result===0){

	echo	'<div id="message" class="updated fade"><p>em. You ain\'t tags to delete.</p></div>';
}
	echo    '<div class="wrap">';
	
	echo    '<h2>Delete all tags</h2>';
	echo	'<form method="post" action="'.$_SERVER['REQUEST_URI'] .'">';
	echo	'<p>Delete tags of zero posts:<input type="checkbox" name="zero"/></p>';
	echo	'<p><input type="submit" onclick="confirm(\'Do you really want to deleta all tags? Irrevocable Command! \')" name="submit" class="button" value="Delete all tags" /></p>';
	echo	'<p><input type="hidden" name="delete_all_tags" value="delete_all_tags" /></p>';
	echo  	'</form>';
	echo   '</div>';

}

?>

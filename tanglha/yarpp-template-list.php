<?php
/*
YARPP Template: List
Description: This template returns the related posts as a ordered list.
Author: qakcn
*/
?>

<h3>related posts</h3>

<?php
if (have_posts()) {
?>
<ol>
<?php
	while (have_posts()) {
		the_post();
		echo '<li><a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a> ('.get_the_score().')</li>';
	}
?>
</ol>
<?php
}else{
?>

<p>no related posts.</p>

<?php
}
?>

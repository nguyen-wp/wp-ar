<?php
/**
 * The template for displaying all single posts
 */
get_header(); 
?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
	$acf_tes = get_fields(get_the_ID());
	$acf_tes_image = $acf_tes['photo'] ? $acf_tes['photo'] : '';
	$acf_tes_author = $acf_tes['author'] ? $acf_tes['author'] : '';
	$acf_tes_company = $acf_tes['company'] ? $acf_tes['company'] : '';
	$acf_tes_position = $acf_tes['position'] ? $acf_tes['position'] : '';
	$acf_tes_rank = $acf_tes['rank'] ? (int)$acf_tes['rank'] : 0;
	$acf_tes_date = $acf_tes['date'] ? $acf_tes['date'] : '';
	$acf_tes_url = $acf_tes['url'] ? $acf_tes['url'] : '';
	$acf_tes_facebook = $acf_tes['facebook'] ? $acf_tes['facebook'] : '';
	$acf_tes_twitter = $acf_tes['twitter'] ? $acf_tes['twitter'] : '';
	$acf_tes_linkedin = $acf_tes['linkedin'] ? $acf_tes['linkedin'] : '';
	$acf_tes_instagram = $acf_tes['instagram'] ? $acf_tes['instagram'] : '';
	$acf_tes_youtube = $acf_tes['youtube'] ? $acf_tes['youtube'] : '';
	$acf_tes_whatsapp = $acf_tes['whatsapp'] ? $acf_tes['whatsapp'] : '';
	$acf_tes_tiktok = $acf_tes['tiktok'] ? $acf_tes['tiktok'] : '';
?>
<?php if($acf_tes_image) { ?>
	<div class="testimonial-image">
		<img src="<?php echo $acf_tes_image['url']; ?>" alt="<?php echo $acf_tes_image['alt']; ?>" />
	</div>
<?php } ?>
<?php if($acf_tes_author) { ?>
	<div class="testimonial-author">
		<strong><?php echo $acf_tes_author; ?></strong>
	</div>
<?php } ?>
<?php if($acf_tes_company) { ?>
	<div class="testimonial-company">
		<i>
			<?php echo $acf_tes_company; ?>
		</i>
	</div>
<?php } ?>
<?php if($acf_tes_rank) { ?>
	<div class="testimonial-rank">
		<?php if($acf_tes_rank > 0) { ?>
			<span class="rank rank-<?php echo $acf_tes_rank; ?>">
				<?php for($i = 1; $i <= $acf_tes_rank; $i++) { ?>
					<i class="fas fa-star"></i>
				<?php } ?>
			</span>
		<?php } ?>
	</div>
<?php } ?>
<div class="testimonial-content">
	<?php echo get_the_content(); ?>
</div>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
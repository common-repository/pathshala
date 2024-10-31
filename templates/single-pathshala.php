<?php
get_header();

if ( have_posts() ) :

	while ( have_posts() ) : the_post();
?>

    <article <?php post_class( 'pathshala-single-post' ); ?>>
        <h2 class="pathshala-event-title"><?php the_title(); ?></h2>
        <div class="pathshala-terms-wrap">
            <?php
            $categories = get_the_term_list( get_the_ID(), 'pathshala_category', '', ', ' );
            $tags = get_the_term_list( get_the_ID(), 'pathshala_tag', '', ', ' );
            if ( ! empty( $categories ) ) { ?>
            <div class="pathshala-category">
                <span><?php _e( 'Categories: '); ?></span>
                <?php echo $categories; ?>
            </div>
            <?php
            }

            if ( ! empty( $tags ) ) { ?>
            <div class="pathshala-tag">
                <span><?php _e( 'Tag: '); ?></span>
                <?php

                echo $tags;
                ?>
            </div>
            <?php } ?>

        </div>
        <div class="pathshala-content">
            <?php
                if ( has_post_thumbnail() ) {
                    echo get_the_post_thumbnail();
                }
            ?>
            <?php the_content(); ?>
        </div>
        
        <div class="pathshala-meta">
            <?php
            $course_attachment = get_post_meta( get_the_ID(), 'pathshala_course_attachment', true );

            if ( $course_attachment ) {
            ?>
                <div class="pathshala-attachment-wrap">
                    <div class="pathshala-attachment">
                        <strong><?php echo __( 'Attachment:', 'pathshala' ); ?></strong>
                        <a href="<?php echo $course_attachment; ?>" download> <?php echo wp_basename( $course_attachment ); ?></a>
                    </div>
                </div>
            <?php } ?>

            <?php
            $video = get_post_meta( get_the_ID(), 'course_video_url', true );
            if ( $video ) {
            ?>
                <div class="pathshala-video-wrap">
                    <div class="pathshala-video">
                       <strong>Video Link:</strong>
                        <a href="<?php echo $video; ?>" target="_blank"><?php echo $video;?></a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </article>

<?php
    endwhile;

else :

	get_template_part( 'no-results', 'index' );

endif;

get_footer();
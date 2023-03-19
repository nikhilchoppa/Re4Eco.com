<?php
    /* Require user to enter password */
    if( post_password_required() ) {
        echo '<p>' . esc_html__('This post is password protected. Enter the password to view any comments.', 'recycle') . '</p>';
        return;
    }

    /* Check if any comments are added */
    if( have_comments() ) {
        echo '<h4 id="comments" class="title">' . esc_html__('Comment on ', 'recycle') . '"' . get_the_title() . '"</h4>';

        /* List Comments */
        $commentlist_args = array(
            'avatar_size' => 72,
            'format' => 32,
            'callback' => 'orion_comments'
        );

        echo '<ol class="commentlist">';
            wp_list_comments($commentlist_args);
        echo '</ol>';

        /* Comments pagination */
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
            previous_comments_link();
            next_comments_link();
        }
    } else {
        if ( ! comments_open() ) {
            echo '<p class="no-comments">' . esc_html__( 'Comments are closed.', 'recycle') . '</p>';
        }
    }

    /* Comment form fields */
    $fields =  array(
        'author' => '<div class="col-md-4 col-md-pull-8 orioninner">
                        <input type="text" id="author" name="author" placeholder="'. esc_html__( 'Name', 'recycle').'">',
        'email'  => '
                        <input type="text" id="email" name="email" placeholder="'. esc_html__( 'E-mail', 'recycle').'">
                    ',
        'url' => '<input type="url" placeholder="Website"> </div>'
    );

    /* Comment form arguments */
    $args = array(
        'fields'       => apply_filters( 'comment_form_default_fields', $fields),
        'title_reply'  => '',
        'class_submit' => 'btn btn-c1 btn-flat btn-md pull-right'
    );

    /* If NOT logged in */
    $args_specific = array(
        'comment_field'        =>   '<div class="col-md-8 col-md-push-4 orioninner">
                                        <textarea id="message" placeholder="' . esc_html__("Write your comment here", 'recycle') . '" name="comment" rows="2"></textarea>                                   
                                    </div>',
        'logged_in_as'         => '<h6 class="title">' . esc_html__('Post comment', 'recycle') . '</h6>',
        'comment_notes_before' => '<h6 class="title">' . esc_html__('Leave comment', 'recycle') . '</h6>',
        'comment_notes_after'  => ''
    );

    /* If logged in */
    if ( is_user_logged_in() ) {
        $args_specific = array(
            'comment_field'        =>   '<div class="col-md-12 orioninner">
                                                <textarea id="message" placeholder="' . esc_html__("Comment", 'recycle') . '" name="comment" rows="3"></textarea>',
            'logged_in_as'         =>   '<h6 class="title">' . esc_html__('Leave a reply', 'recycle') . '</h6>',
            'comment_notes_before' =>   '<h6 class="title">' . esc_html__('Leave a reply', 'recycle') . '</h6><div id="comment-form"> <div class="col-md-12">',
            'comment_notes_after'  =>   '</div>'
        );
    }
    comment_form( array_merge($args, $args_specific) ); 
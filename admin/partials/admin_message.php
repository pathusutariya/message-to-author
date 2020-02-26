<div class="wrap">
    <h1 class="wp-heading-inline">Messages for: <?= wp_get_current_user()->display_name; ?> </h1>
    <hr/>
    <div class="m2a-messageshow">
        <table class="wp-list-table widefat fixed" border="1" cellpadding="5">
            <thead>
                <tr>
                    <th class="column-cb">ID</th>
                    <th>Post title</th>
                    <?php if ( current_user_can( 'moderate_comments' ) ): ?>
                        <th>Author <small>(Message To)</small></th>
                    <?php endif; ?>
                    <th>Sender <small>(Message From)</small></th>
                    <th>Subject</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
			<?php if ( empty( $messages ) ): ?>
                <tr>
                    <td colspan="6" align="center">No Message Found!</td>
                </tr>
			<?php
			else:
				$i = 1;
				foreach ( $messages as $print ):
					?>
                    <tr>
                        <th><?= $i ++; ?></th>
                        <td><strong class="capitlize"><?= get_post_type( $print->post_id ); ?></strong>: <a href="<?= get_the_permalink( $print->post_id ); ?>" target="_blank"><?php echo get_the_title( $print->post_id ); ?></a> &nbsp;[<?php edit_post_link( 'edit', '<small>', '</small>', $print->post_id ); ?>]</td>
						<?php if ( current_user_can( 'moderate_comments' ) ): ?>
                            <td><a href="<?php echo get_edit_user_link( $print->author_id ); ?>" target="_blank"><?php echo get_userdata( $print->author_id )->user_login; ?></a></td><?php endif; ?>
                        <td>
							<?php if ( is_numeric( $print->sender ) && $print->sender ): ?>
                                <a href="<?php echo get_edit_user_link( $print->sender ); ?>" target="_blank"><?= get_userdata( $print->sender )->user_login; ?></a>
							<?php elseif ( is_email( $print->sender ) ): ?>
                                <a href="mailto:<?php echo $print->sender; ?>" target="_blank"><?php echo $print->sender; ?></a>
							<?php else: ?>
								<?= $print->sender; ?>
							<?php endif; ?>
                        </td>
                        <td><?= $print->subject; ?></td>
                        <td class="message"><?= $print->message; ?></td>
                    </tr>
				<?php
				endforeach;
			endif;
			?>
            </tbody>
        </table>
    </div>
</div>
<h1>Show Author's Message</h1>
<form method="post" action="options.php">
    <div class="m2a-messageshow">
        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Post title</th>
                <th>Post Type</th>
                <?php if($user_type == 1): ?><th>Author</th><?php endif;?>
                <th>User</th>
                <th>Subject</th>
                <th>Message</th>
            </tr>
            <?php
            if (empty($messages)) {
                ?>
                <tr>
                    <td colspan="7" align="center">No Message Found!</td>
                </tr>
                <?php
            } else {
                $i = 1;
                foreach ($messages as $print) {
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><a href="<?php echo get_the_permalink($print->post_id); ?>" target="_blank"><?php echo get_the_title($print->post_id); ?></a> &nbsp;[<?php edit_post_link('edit', '<small>', '</small>', $print->post_id); ?>]</td>
                        <td><?php echo get_post_type($print->post_id); ?></td>
                        <?php if($user_type == 1): ?><td><a href="<?php echo get_edit_user_link($print->author_id); ?>" target="_blank"><?php echo get_userdata($print->author_id)->user_login; ?></a></td><?php endif; ?>
                        <td>
                            <?php if(is_numeric($print->user_id)): ?>
                                <a href="<?php echo get_edit_user_link($print->user_id); ?>" target="_blank"><?php echo get_userdata($print->user_id)->user_login; ?></a>
                            <?php elseif(filter_var($print->user_id, FILTER_VALIDATE_EMAIL) === true):?>
                                <a href="mailto:<?php echo$print->user_id; ?>" target="_blank"><?php echo $print->user_id; ?></a>
                            <?php else: ?>
                                <?php echo $print->user_id; ?>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $print->subject; ?></td>
                        <td><?php echo $print->message; ?></td>
                    </tr>
                <?php
                }
            }
            ?>
        </table>
    </div> 
</form>



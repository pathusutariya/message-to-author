# Message To Author
`Message to Author` is a WordPress plugin that allows users to message author of the post/CPT/page directly.

This can be helpful to set up catalogs to ask for inquiry, when handling multiple blog/magazine with multiple author. Post messages to author regarding any obligations of content.

Email to author about messages.

- All messages records in admin panel

- Author will see all messages/records belongs to him/her directly from users.

- Option to send message only for registered users.

- Can be used as an internal messaging system 

## Uses
Download this plugin and put it into your WordPress files into `/wp-content/plugins` and activate from your WordPress admin panel.

You can enable for all posts, or you can put message box anywhere on the website you can use Shortcode `[message2author]` for put anywhere or use PHP `<?php echo do_shortcode("[message2author]"); ?>` to embed in your code or template.

 

Multiple options available for UI of message-box 

1. `[message2author style="messagebox"]` for show message box

2. `[message2author style="popup"]` to display a button which pop a dialog box to send message.

3. The default behavior can be selected from admin's options.



## Technical Information

### Modify UI/Styling
To change styling and HTML,  the messages box will be available at `/public/partials/messagebox.php` and Popup will be editable from `/public/partials/popup.php` in plugin's directory.
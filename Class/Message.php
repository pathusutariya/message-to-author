<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<?php

/**
 * message class
 */
class M2a_message {

    private $post_id, $user_id, $message, $author_id, $db;

    function __construct() {
        //starting
        global $wpdb;
        $this->db = $wpdb;
    }

    public function setMessageData($post_id, $user_id = false, $message) {

        if ($user_id == false) {
            $user_id = $this->getCurruntUserID();
        }

        if ($user_id == $this->validateEmail($user_id)) {
            //this is non-registreted user settings
        } else {
            //this is registreted user settings
        }
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->message = $message;
        $this->setAuthorID($post_id);
    }

    //save data to database
    public function save() {
        //save data to database
    }

    //retrive all messages from database
    public function getMessage() {

        return $this->db->get_results("SELECT * FROM mta_m2a_message");

        /* if( user is admin ){
          //retrive all data from database and return in simple array
          //return fields are:

          }else{
          //retrive user's messages from database and return in simple array
          } */
    }

    private function getPostType($post_id) {
        
    }

    //author email
    public function sendAuthorMail() {
        // get all perameter and redesign message to email body
        $this->sendMail();
    }

    //send sender emai
    public function sendSenderMail() {
        // get all perameter and redesign message to email body
        $this->sendMail();
    }

    //setting author ID by post ID
    private function setAuthorID($post_id) {
        //get author id by postID
        //init to global var
    }

    //send email
    private function sendMail($to, $header, $subject) {
        //send Email
    }

    private function getCurruntUserID() {
        //return currunt user id
    }

    //email validation
    private function validateEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    private function getEmailID($user_id) {
        //return EmailID based on user_id
    }

}

?>
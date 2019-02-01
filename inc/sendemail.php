<?php

    // $to = "chuksgid@gmail.com";
    // $from = $_REQUEST['email'];
    // $name = $_REQUEST['name'];
    // $headers = "From: $from";
    // $subject = "You have a message from your BizPro";

    // $fields = array();
    // $fields{"Fname"}    = "First Name";
    // $fields{"Lname"}    = "Last Name";
    // $fields{"email"}    = "Email";
    // $fields{"sub"}    = "Subject";
    // $fields{"message"}   = "Message";
    

    // $body = "Here is the message you got:\n\n"; foreach($fields as $a => $b){   $body .= sprintf("%20s: %s\n",$b,$_REQUEST[$a]); }

    // $send = mail($to, $subject, $body, $headers);

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $Fname = strip_tags(trim($_POST["Fname"]));
				$Fname = str_replace(array("\r","\n"),array(" "," "),$Fname);
        $Lname = strip_tags(trim($_POST["Lname"]));
                $Lname = str_replace(array("\r","\n"),array(" "," "),$Lname);
        $name = $Fname . $Lname;
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST["sub"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR empty($subject) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        $recipient = "chuksgid@gmail.com";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }
?>
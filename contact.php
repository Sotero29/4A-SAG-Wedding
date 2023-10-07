<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

         

        
        $recipient = "example@example.com";

        $email_content = "Your Namez* $name\n";
        $email_content .= "Number*  $email\n\n";
        $email_content .= "Your Email* \n$message\n";
        $email_content .= "Your Message \n$message\n";

        $email_headers = "From: $name <$email>";

       
        if (mail($recipient,  $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            
            http_response_code(500);
            echo "Oops! Something went wrong ande we couldn't send your message.";
        }

    } else {
        
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
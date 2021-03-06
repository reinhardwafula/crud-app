<?php
function insertData($conn, $u_name, $u_email)
{   //the trim function is used to strip whitespace(and any other character) from the beginning and ending of a string.
    $u_name = trim(mysqli_real_escape_string($conn, htmlspecialchars($u_name)));
    $u_email = trim(mysqli_real_escape_string($conn, htmlspecialchars($u_email)));

    // IF NAME OR EMAIL IS EMPTY
    if (empty($u_name) || empty($u_email)) {
        return 'Please fill all required fields.';
    }
    //IF EMAIL IS NOT VALID
        //here we use filtervar() function to make sure that the external input we are getting is the correct input
    elseif (!filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email address.';
    } else {
        $check_email = mysqli_query($conn, "SELECT `email` FROM `users` WHERE `email` = '$u_email'");
        // IF THE EMAIL IS ALREADY IN USE
        if (mysqli_num_rows($check_email) > 0) {
            return 'This email is already registered. Please try another.';
        }

        // INSERTING THE USER DATA
        $query = mysqli_query($conn, "INSERT INTO `users`(`name`,`email`) VALUES('$u_name','$u_email')");
        // IF USER INSERTED
        if ($query) {
            return true;
        }
        return 'Opps something is going wrong!';
    }
}
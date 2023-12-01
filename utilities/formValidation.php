<?php
function is_empty($required_fields)
{
    $form_errors = array();

    foreach ($required_fields as $required_field) {
        if (!isset($_POST[$required_field]) || $_POST[$required_field] == NULL) {
            $form_errors[] = $required_field;
        }
    }

    return $form_errors;
}

function min_length($field_to_check_length)
{
    $form_errors = array();
    foreach ($field_to_check_length as $name_of_field => $min_length_required) {
        if (strlen(trim($_POST[$name_of_field])) < $min_length_required) {
            $form_errors[] = $name_of_field . " is not valid, it must be {$min_length_required} characters long";
        }
    }
    return $form_errors;
}

function check_email($data)
{
    $form_errors = array();
    $email = $data['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_errors[] = "Invalid email format";
    }

    return $form_errors;
}


function check_password_match($password, $confirm_password)
{
    $form_errors = array();
    if ($_POST[$password] !== $_POST[$confirm_password]) {
        $form_errors[] = "Password and Confirm Password do not match";
    }
    return $form_errors;
}

function show_errors($form_err_array)
{
    $errors = ""; // Initialize the $errors variable
    $errors .= "<ul class='text-red-800 mt-2 pl-10 space-y-1 list-disc list-inside'>";
    foreach ($form_err_array as $err) {
        $errors .= "<li>". $err ."</li>";
    }
    $errors .= "</ul>";
    return $errors;
}
?>
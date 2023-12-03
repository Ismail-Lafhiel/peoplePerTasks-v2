<?php
include_once("../resources/session.php");
include_once("../resources/db.php");
include_once('../utilities/formValidation.php');
if (isset($_POST['submit'])) {
    // array that store errors
    $form_errors = array();
    $required_fields = array("email", "new_password", "confirm_password");
    //call is_empty to check if the fields are empty
    $form_errors = array_merge($form_errors, is_empty($required_fields));
    //check the minimum length
    $field_to_check_length = array('new_password' => 8, "confirm_password" => 8);
    // call min_length function
    $form_errors = array_merge($form_errors, min_length($field_to_check_length));
    // email validation / merge the return data into form_errors array
    $form_errors = array_merge($form_errors, check_email($_POST));
    if (empty($form_errors)) {
        // collect data from form
        $email = $_POST['email'];
        $password1 = $_POST['new_password'];
        $password2 = $_POST['confirm_password'];

        // check if the pass1 and pass2 are the same
        $form_errors = array_merge($form_errors, check_password_match("new_password", "confirm_password"));

        //prepare the statement
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $res = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $res[$row['email']] = $row['email'];
        }

        if (mysqli_num_rows($result) == 1) {
            $hashed_password = password_hash($password1, PASSWORD_BCRYPT);
            $sqlUpdate = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
            $stmt = mysqli_prepare($conn, $sqlUpdate);
            mysqli_stmt_execute($stmt);

            $successMessage = "<div class='p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 text-center' role='alert'>
                                <span class='font-medium'>Success alert!</span> Password Reset Successfully.
                            </div>";
        } else {
            $errorMessage = "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 text-center' role='alert'>
                     <span class='font-medium'>Danger alert!</span> The email adress provided does not exist
                  </div>";
        }
    } else {
        $errorMessage = "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 text-center' role='alert'>
                    <span class='font-medium'>" . count($form_errors) . " errors in this form</span>
                </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "Reset Password";
include_once('components/head.php');
$home_hover = "class='block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500'";
?>

<body>
    <?php include_once('components/header.php') ?>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"
                    alt="logo">
                PeoplePerTasks
            </a>
            <div
                class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
                <?php
                if (isset($successMessage)) {
                    echo $successMessage;
                } else if (isset($errorMessage)) {
                    echo $errorMessage;
                }
                if (!empty($form_errors))
                    echo show_errors($form_errors);
                ?>
                <h2
                    class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white mt-5">
                    Change Password
                </h2>
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                            email</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New
                            Password</label>
                        <input type="password" name="new_password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                    </div>
                    <div>
                        <label for="confirm-password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                            password</label>
                        <input type="password" name="confirm_password" id="confirm-password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="newsletter" aria-describedby="newsletter" type="checkbox"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                required="">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="newsletter" class="font-light text-gray-500 dark:text-gray-300">I accept the <a
                                    class="font-medium text-blue-600 hover:underline dark:text-blue-500" href="#">Terms
                                    and Conditions</a></label>
                        </div>
                    </div>
                    <button type="submit" name="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Reset
                        passwod</button>
                </form>
            </div>
        </div>
    </section>
    <?php include_once('components/footer.php') ?>
    <?php include_once('components/darkmood.php') ?>
</body>

</html>
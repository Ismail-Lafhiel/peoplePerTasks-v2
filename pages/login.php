<?php
include_once("../resources/session.php");
include_once("../resources/db.php");
include_once('../utilities/formValidation.php');
if (isset($_POST['login'])) {
    // array that store errors
    $form_errors = array();
    $required_fields = array("email", "password");
    //call is_empty to check if the fields are empty
    $form_errors = array_merge($form_errors, is_empty($required_fields));
    //check the minimum length
    $field_to_check_length = array('password' => 8);
    // call min_length function
    $form_errors = array_merge($form_errors, min_length($field_to_check_length));
    // email validation / merge the return data into form_errors array
    $form_errors = array_merge($form_errors, check_email($_POST));
    if (empty($form_errors)) {
        // collect data from form
        $email = $_POST['email'];
        $password = $_POST['password'];
        //prepare the statement
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION['username'] = $_SESSION['first_name'] . " " . $_SESSION['last_name'];

                $successMessage = "<div class='p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-green-800 dark:text-green-400 text-center' role='alert'>
                        <span class='font-medium'>success alert!</span> You logged in
                    </div>";
                // header("Location: index.php");
            } else {
                $errorMessage = "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-green-800 dark:text-red-400 text-center' role='alert'>
                        <span class='font-medium'>Danger alert!</span> Invalid password
                    </div>";
            }
        } else {
            $errorMessage = "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-red-800 dark:text-red-400 text-center' role='alert'>
                        <span class='font-medium'>Danger alert!</span> Invalid email
                    </div>";
        }

    } else {
        $errorMessage = "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-red-800 dark:text-red-400 text-center' role='alert'>
                    <span class='font-medium'>" . count($form_errors) . " errors in this form</span>
                </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "Sign in";
include_once('components/head.php');
?>

<body>
    <?php require_once('components/header.php') ?>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"
                    alt="logo">
                PeoplePerTasks
            </a>
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <?php
                if (isset($successMessage)) {
                    echo $successMessage;
                }
                if (isset($errorMessage)) {
                    echo $errorMessage;
                }
                if (!empty($form_errors))
                    echo show_errors($form_errors);
                ?>
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Sign in to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                email</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com" required="">
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="">
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="remember" name="remember" aria-describedby="remember" type="checkbox"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                                </div>
                            </div>
                            <a href="reset_password.php"
                                class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Forgot
                                password?</a>
                        </div>
                        <button type="submit" name="login"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Signin
                        </button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Don't have an account yet? <a href="signup.php"
                                class="font-medium text-blue-600 hover:underline dark:text-blue-500">Sign up</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include_once('components/footer.php') ?>
    <?php include_once('components/darkmood.php') ?>
</body>

</html>
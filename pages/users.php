<?php
include_once("../resources/session.php");
if($_SESSION["user_type"] == "admin"){
    require_once(__DIR__ . "/../resources/db.php");
    // ----------------------------- add user --------------------------//
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $user_type = $_POST["user_type"];
        $ville_id = $_POST["ville_id"];

        $imgNewName = null;

        if (isset($_FILES["user_avatar"]) && $_FILES["user_avatar"]["error"] === 0) {
            $imgName = $_FILES["user_avatar"]["name"];
            $imgTmpName = $_FILES["user_avatar"]["tmp_name"];
            $imgSize = $_FILES["user_avatar"]["size"];
            $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
            $imgActualExt = strtolower($imgExt);
            $allowed = array("jpg", "jpeg", "png");

            if (in_array($imgActualExt, $allowed)) {
                if ($imgSize < 125000) {
                    $imgNewName = uniqid("", true) . "." . $imgActualExt;
                    $imgDestination = '../images/uploads/' . $imgNewName;
                    if (move_uploaded_file($imgTmpName, $imgDestination)) {
                        // Image uploaded successfully
                    } else {
                        $err = "Error uploading the image";
                    }
                } else {
                    $err = "Image size is too large";
                }
            } else {
                $err = "Invalid file type. Allowed types: jpg, jpeg, png";
            }
        } else {
            $err = "Error uploading the image";
        }

        if (!isset($err)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO `users` (first_name, last_name, email, password, user_type, img_path, ville_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        } else {
            exit();
        }

        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "ssssssi", $first_name, $last_name, $email, $hashed_password, $user_type, $imgDestination, $ville_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "New user created successfully";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
    //-------------------------- delete user --------------------------------//
    if (isset($_GET["delete_user"])) {
        $user_id = $_GET["delete_user"];
        $query = "DELETE FROM `users` WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // ------------------ update user -----------------------------------//
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_POST["user_id"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $user_type = $_POST["user_type"];
        $ville_id = $_POST["ville_id"];

        $imgNewName = null;

        if (isset($_FILES["user_avatar"]) && $_FILES["user_avatar"]["error"] === 0) {
            $imgName = $_FILES["user_avatar"]["name"];
            $imgTmpName = $_FILES["user_avatar"]["tmp_name"];
            $imgSize = $_FILES["user_avatar"]["size"];

            $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
            $imgActualExt = strtolower($imgExt);
            $allowed = array("jpg", "jpeg", "png");

            if (in_array($imgActualExt, $allowed)) {
                if ($imgSize < 125000) {
                    $imgNewName = uniqid("", true) . "." . $imgActualExt;
                    $imgDestination = '../images/uploads/' . $imgNewName;
                    if (move_uploaded_file($imgTmpName, $imgDestination)) {
                        // Image uploaded successfully
                    } else {
                        $err = "Error uploading the image";
                    }
                } else {
                    $err = "Image size is too large";
                }
            } else {
                $err = "Invalid file type. Allowed types: jpg, jpeg, png";
            }
        } else {
            $err = "Error uploading the image";
        }

        $query = "UPDATE `users` SET first_name='$first_name', last_name='$last_name', email='$email', user_type='$user_type', img_path = '$imgNewName', ville_id = '$ville_id' WHERE id=$user_id";

        if (mysqli_query($conn, $query)) {
            echo "User updated successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        exit; // Add exit after header to stop further execution
    }
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['edit_user'])) {
            $user_id = $_GET["edit_user"];

            $query = "SELECT * FROM `users` WHERE id=$user_id"; // Add WHERE clause to select specific user

            $result = mysqli_query($conn, $query);

            if ($row = mysqli_fetch_assoc($result)) {
                $userData = $row; // Store user data directly, no need for an array
            } else {
                echo "User not found";
            }
        }

    }
    // ----------------------------------------- show users-----------------------------------------//
    $query = "SELECT * FROM `users`";
    $result = mysqli_query($conn, $query);

    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $users[$row['id']] = $row;
    }
    // get villes info:
    $sql = "SELECT * FROM villes";
    $result = mysqli_query($conn, $sql);

    $villes = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $villes[$row['id']] = $row;
    }
    mysqli_close($conn);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <?php
    $title = "Users";
    include("components/adminHead.php");
    ?>

    <body class="dark:bg-gray-900">

        <?php
        $users_hover = "class='flex items-center p-2 text-white rounded-lg bg-orange-600 dark:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 group'";
        include("components/adminSideBar.php");
        ?>

        <main class=" mt-14 p-12 ml-0  smXl:ml-64  ">

            <div class="relative overflow-x-auto  sm:rounded-lg">


                <!-- Modal toggle -->
                <button data-modal-target="add-modal" data-modal-toggle="add-modal"
                    class="mb-7 mr-5 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="inline mr-1" style="fill: #FFF"
                        viewBox="0 0 448 512">
                        <path
                            d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                    </svg>
                    Add User
                </button>


                <!-- add modal -->
                <div id="add-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Add New User
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-toggle="add-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form class="p-4 md:p-5" method="POST"
                                enctype="multipart/form-data">
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="first-name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                                            Name</label>
                                        <input type="text" name="first_name" id="first-name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="first name" required="">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="last-name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                            Name</label>
                                        <input type="text" name="last_name" id="last-name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="last name" required="">
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="email" name="email" id="email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="email" required="">
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="password"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                        <input type="password" name="password" id="password"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="******" required="">
                                    </div>
                                    <div>
                                        <label for="countries"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select your
                                            country</label>
                                        <select id="countries" name="ville_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option>--select your city--</option>
                                            <?php foreach ($villes as $id => $ville) {
                                                echo "<option value='" . $id . "'>" . $ville['ville'] . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="countries"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select user
                                            type</label>
                                        <select id="countries" name="user_type"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value='#'>--select a type--</option>
                                            <option value='admin'>admin</option>
                                            <option value='client'>client</option>
                                            <option value='freelancer'>freelancer</option>

                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                            for="user_avatar">Upload file</label>
                                        <input
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            aria-describedby="user_avatar_help" id="user_avatar" name="user_avatar"
                                            type="file">
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">A
                                            profile picture is useful to confirm your are logged into your account</div>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Add User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- edit modal -->
                <div id="edit-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    edit User
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-toggle="edit-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form class="p-4 md:p-5" method="POST" enctype="multipart/form-data">
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <input type="hidden" name="user_id" id="user_id" value=<?php echo $userData['id'] ?>>
                                        <div class="col-span-2">
                                            <label for="first-name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                                                Name</label>
                                            <input type="text" name="first_name" id="first-name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="first name" required="">
                                        </div>
                                        <div class="col-span-2">
                                            <label for="last-name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                                Name</label>
                                            <input type="text" name="last_name" id="last-name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="last name" required="">
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="email"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="email" required="">
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="password"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                            <input type="password" name="password" id="password"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="******" required="">
                                        </div>
                                        <div>
                                            <label for="countries"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select your
                                                country</label>
                                            <select id="countries" name="ville_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option>--select your city--</option>
                                            <?php foreach ($villes as $id => $ville) {
                                            echo "<option value='" . $id . "'>" . $ville['ville'] . "</option>";
                                        } ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="countries"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select user
                                            type</label>
                                        <select id="countries" name="user_type"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value='#'>--select a type--</option>
                                            <option value='admin'>admin</option>
                                            <option value='client'>client</option>
                                            <option value='freelancer'>freelancer</option>

                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                            for="user_avatar">Upload file</label>
                                        <input
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            aria-describedby="user_avatar_help" id="user_avatar" name="user_avatar"
                                            type="file">
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">A
                                            profile picture is useful to confirm your are logged into your account</div>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    edit User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- delete modal  -->
                <div id="delete-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="delete-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                    Are you sure you want to delete this user?
                                </h3>
                                <form>
                                    <input type="hidden" name="user_id" id="user-id"
                                    value=<?php echo $userData['id'] ?>>
                                        <div class="col-span-2 mt-3">
                                            <button data-modal-hide="delete-modal" type="submit"
                                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-full text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                                Yes, I'm sure
                                            </button>
                                            <button data-modal-hide="delete-modal" type="button"
                                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-full border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                                                cancel
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="w-full shadow-md text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-search" type="checkbox"
                                            class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    id
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Created At
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Updated At
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-13" type="checkbox"
                                            class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-13" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">
                                            <?php echo $user['id'] ?>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    <?php if (isset($user['img_path'])) {
                                        echo "<img class='w-10 h-10 rounded-full' src=" . $user['img_path'] . " alt='" . $user['first_name'] . " " . $user["last_name"] . "'>";
                                    } else {
                                        echo "<img class='w-10 h-10 rounded-full' src='../images/avatar.jpg' alt='avatar'>";
                                    }
                                    ?>

                                    <div class="inline ps-3">
                                        <?php echo $user['first_name'] . " " . $user["last_name"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $user["email"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $user["user_type"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $user["created_at"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $user["updated_at"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <a id="edit-user-link" href="users.php?edit_user=<?php echo $user['id'] ?>"
                                        class="mb-7 mr-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        Edit
                                    </a>
                                    <a id="delete-user-link" href="users.php?delete_user=<?php echo $user['id'] ?> "
                                        class="mb-7 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>

        <script src="../../js/dashboard.js"></script>
        <?php include_once('components/darkmood.php') ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <script>
            // Get the delete link
            const deleteLink = document.getElementById('delete-user-link');
            // Get the modal
            const deleteModal = document.getElementById('delete-modal');
            // Get the delete link
            const editLink = document.getElementById('edit-user-link');
            // Get the modal
            const editModal = document.getElementById('edit-modal');

            // Function to show the modal
            function showDeleteModal() {
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }
            function showEditModal() {
                editModal.classList.remove('hidden');
                editModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            // Add event listener to the delete link
            deleteLink.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default behavior of the link
                showDeleteModal(); // Show the modal
            });
            editLink.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default behavior of the link
                showEditModal(); // Show the modal
            });
        </script>
    </body>

    </html>
<?php }else{
    header("Location: dashboard.php");
}  ?>

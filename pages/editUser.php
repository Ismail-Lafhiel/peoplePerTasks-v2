<?php
include_once("../resources/session.php");
require_once("./controllers/userController.php");
if ($_SESSION["user_type"] == "admin") {
    $villes = array();
    getVilles($conn);
    $villes = array_merge($villes, getVilles($conn));
    if (isset($_GET['edit_id'])) {
        $userData = array();
        $edit_id = $_GET['edit_id'];
        getUserForEdit($conn, $edit_id);
        $userData = array_merge($userData, getUserForEdit($conn, $edit_id));
    }
    if (isset($_POST['user_id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['user_type']) && isset($_FILES['user_avatar']) && isset($_POST['ville_id'])) {
        updateUser($conn, $_POST['user_id'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['user_type'], $_FILES['user_avatar'], $_POST['ville_id']);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $title = "edit user";
    include("components/adminHead.php");
    ?>

    <body class="dark:bg-gray-900">
        <?php
        include("components/adminSideBar.php");
        ?>
        <main class=" mt-14 p-12 ml-0  smXl:ml-64">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-900">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit User
                    </h3>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="POST" enctype="multipart/form-data">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <input type="hidden" name="user_id" id="user_id" value=<?php if (isset($userData['id']))
                            echo $userData['id'] ?>>
                            <div class="col-span-2">
                                <label for="first-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                                    Name</label>
                                <input type="text" name="first_name" id="first-name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="first name" value="<?php echo $userData['first_name'] ?>">
                        </div>
                        <div class="col-span-2">
                            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                Name</label>
                            <input type="text" name="last_name" id="last-name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="last name" required="" value="<?php echo $userData['first_name'] ?>">
                        </div>
                        <div class="col-span-2">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="email" required="" value="<?php echo $userData['email'] ?>">
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
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="countries"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select user
                                type</label>
                            <select id="countries" name="user_type" value="<?php echo $userData['user_type'] ?>"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value='#' disabled>--select a type--</option>
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
                                aria-describedby="user_avatar_help" id="user_avatar" name="user_avatar" type="file">
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">A
                                profile picture is useful to confirm your are logged into your account</div>
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        edit User
                    </button>
                    <a href="users.php"
                        class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        Go back
                    </a>
                </form>
            </div>
        </main>

        <script src="../../js/dashboard.js"></script>
        <?php include_once('components/darkmood.php') ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
    </body>

    </html>

<?php } else {
    header("Location: dashboard.php");
} ?>
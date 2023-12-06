<?php
include_once("../resources/session.php");
require_once("controllers/userController.php");
if ($_SESSION["user_type"] == "admin") {
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['user_type']) && isset($_FILES['user_avatar']) && isset($_POST['ville_id'])) {
        createUser($conn, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['user_type'], $_FILES['user_avatar'], $_POST['ville_id']);
    }
    $users = array();
    getUsers($conn);
    $villes = array();
    getVilles($conn);
    $villes = array_merge($villes, getVilles($conn));
    $users = array_merge($users, getUsers($conn));
    
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        deleteUser($conn, $delete_id);
        
    }
    mysqli_close($conn);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <?php
    $title = "users";
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
                            <form class="p-4 md:p-5" method="POST" enctype="multipart/form-data">
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
                <?php
                //  var_dump($users);
                 ?>
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
                            <th colspan="2" class="px-6 py-3">
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
                                <td class="px-2 py-4">
                                    <?php if (isset($user['img_path'])) {
                                        echo "<img class='w-10 h-10 rounded-full' src=" . $user['img_path'] . " alt='" . $user['first_name'] . " " . $user["last_name"] . "'>";
                                    } else {
                                        echo "<img class='w-10 h-10 rounded-full' src='../images/avatar.jpg' alt='avatar'>";
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?php echo $user['first_name'] . " " . $user["last_name"] ?>
                                </td>
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
                                    <a href="editUser.php?edit_id=<?php echo $user['id'] ?>"
                                        class="mb-7 mr-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        Edit
                                    </a>
                                    <a href="users.php?delete_id=<?php echo $user['id'] ?>"
                                        onclick="return confirm('Are you sure you want to delete this user?')"
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
    </body>

    </html>
<?php } else {
    header("Location: dashboard.php");
} ?>
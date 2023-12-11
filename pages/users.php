<?php
include_once("../resources/session.php");
require_once("controllers/userController.php");
if ($_SESSION["user_type"] == "admin") {
    $users = array();
    $villes = getVilles($conn);
    $users = getUsers($conn);

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
        $users_hover = "class='flex items-center p-2 text-white rounded-lg bg-blue-600 dark:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 group'";
        include("components/adminSideBar.php");
        ?>
        <main class=" mt-14 p-12 ml-0  smXl:ml-64  ">
            <div class="mb-10 w-96">
                <div class="flex">
                    <div class="relative w-full">
                        <input type="search" id="search-bar"
                            class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                            placeholder="Search by name" required>
                        <button
                            class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto  sm:rounded-lg">
                <table class="w-full shadow-md text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                    <tbody id="search-result">
                        <?php foreach ($users as $user): ?>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-13" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#search-bar").keyup(function () {
                    var input = $("#search-bar").val();
                    //   alert(input)
                    $.ajax({
                        method: "POST",
                        url: "searchusers.php",
                        data: { input: input },
                        success: function (res) {
                            $("#search-result").html(res).show();
                        },
                    });
                });
            });
        </script>
    </body>

    </html>
<?php } else {
    header("Location: dashboard.php");
} ?>
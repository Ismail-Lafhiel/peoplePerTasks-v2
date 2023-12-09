<?php
include_once("../resources/session.php");
require_once("./controllers/freelancerController.php");
// require_once("./controllers/userController.php");
if ($_SESSION["user_type"] == "admin") {
    $users = getUsers($conn);
    // Show freelancers
    $freelancers = getFreelancers($conn);
    // delete freelancer
    if (isset($_GET['delete_freelancer']))
        deleteFreelancer($conn, $_GET['delete_freelancer']);
    mysqli_close($conn);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php $title = "Freelancers";
    include("components/adminHead.php"); ?>

    <body class="dark:bg-gray-900">
        <?php
        $freelancers_hover = "class='flex items-center p-2 text-white rounded-lg bg-blue-600 dark:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 group'";
        include("components/adminSideBar.php");
        ?>
        <main class=" mt-14 p-12 ml-0  smXl:ml-64  ">
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
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                skills
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Created at
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Updated at
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($freelancers as $freelancer): ?>
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
                                            <?php echo $freelancer['id'] ?>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo $freelancer['first_name'] . " " . $freelancer['last_name'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <?php echo $freelancer['skill'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $freelancer["created_at"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $freelancer["updated_at"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="editFreelancer.php?edit_freelancer=<?php echo $freelancer['id'] ?>"
                                        class="mb-7 mr-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        Edit
                                    </a>
                                    <a href="freelancers.php?delete_freelancer=<?php echo $freelancer['id'] ?>"
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
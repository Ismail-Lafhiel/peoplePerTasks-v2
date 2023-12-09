<?php
include_once("../resources/session.php");
require_once("./users.php");
if ($_SESSION["user_type"] == "admin") {
    require_once(__DIR__ . "/../resources/db.php");
    // Add testimonial
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $comment = htmlspecialchars($_POST["comment"]); // Protect against XSS
        $user_id = $_POST["user_id"];

        $query = "INSERT INTO `testimonials` (comment, user_id) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "si", $comment, $user_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "New testimonial created successfully";
                exit;
            } else {
                echo "Error: " . mysqli_error($conn); // Display error message
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Unable to prepare the statement";
        }
    }

    // Delete testimonial
    if (isset($_GET["delete_testimonial"])) {
        $testimonial_id = $_GET["delete_testimonial"];
        $query = "DELETE FROM `testimonials` WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $testimonial_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Show testimonials
    $query = "SELECT testemonials.id, testemonials.comment, ... ... testemonials.created_at, testemonials.updated_at, users.first_name, users.last_name, users.img_path
      FROM testemonials 
      INNER JOIN users ON testemonials.user_id = users.id ORDER BY testemonials.id DESC";

    $result = mysqli_query($conn, $query);

    $testimonials = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Sanitize user input to prevent XSS
        $sanitizedRow = array_map('htmlspecialchars', $row);
        $testimonials[$sanitizedRow['id']] = $sanitizedRow;
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php $title = "Testemonials";
    include("components/adminHead.php"); ?>

    <body class="dark:bg-gray-900">

        <?php
        $testemonials_hover = "class='flex items-center p-2 text-white rounded-lg bg-blue-600 dark:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 group'";
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
                    Add Testemonial
                </button>
                <button data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                    class="mb-7 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="inline mr-1" style="fill: #FFF"
                        viewBox="0 0 448 512">
                        <path
                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                    </svg>
                    Delete Testemonial
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
                                    Add New Category
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
                            <form class="p-4 md:p-5" method="POST">
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="comment"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment</label>
                                        <input type="text" name="comment" id="comment"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="writea a comment" required="">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="user_id"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Writter</label>
                                        <select name="user_id" id="user_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="#"> --select an option-- </option>
                                            <?php foreach ($users as $id => $user) {
                                                echo "<option value='" . $id . "'>" . $user['first_name'] . " " . $user['last_name'] . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Add Testemonial
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
                                    Are you sure you want to delete this testemonial?
                                </h3>
                                <form class="p-4 md:p-5" method="POST">
                                    <input type="hidden" name="testemonial_id" id="testemonial_id" value=<?php echo $testemonialData['id'] ?>>
                                    <div class="col-span-2 mt-3">
                                        <button data-modal-hide="delete-modal" type="submit"
                                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
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
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                comment
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Written By
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Created at
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Updated at
                            </th>
                            <th scope="col" class="px-6 py-3">
                                actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testemonials as $testemonial): ?>
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
                                            <?php echo $testemonial["id"] ?>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo $testemonial["comment"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $testemonial["first_name"] . " " . $testemonial["last_name"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $testemonial["created_at"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $testemonial["updated_at"] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <!-- <a id="edit-testemonial-link"
                                        href="testemonials.php?edit_testemonial=
                                        <?php // echo $testemonial['id'] ?>"
                                        class="mb-7 mr-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        Edit
                                    </a> -->
                                    <a id="delete-testemonial-link"
                                        href="testemonials.php?delete_testemonial=<?php echo $testemonial['id'] ?> "
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
            const deleteLink = document.getElementById('delete-testemonial-link');
            // Get the modal
            const deleteModal = document.getElementById('delete-modal');
            // Get the delete link
            // const editLink = document.getElementById('edit-testemonial-link');
            // Get the modal
            // const editModal = document.getElementById('edit-modal');

            // Function to show the modal
            function showDeleteModal() {
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }
            // function showEditModal() {
            //     editModal.classList.remove('hidden');
            //     editModal.setAttribute('aria-hidden', 'false');
            //     document.body.style.overflow = 'hidden';
            // }

            // Add event listener to the delete link
            deleteLink.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default behavior of the link
                showDeleteModal(); // Show the modal
            });
            // editLink.addEventListener('click', function (event) {
            // event.preventDefault(); // Prevent the default behavior of the link
            // showEditModal(); // Show the modal
            // });
        </script>
    </body>

    </html>
<?php } else{
    header("Location: dashboard.php");
} ?>
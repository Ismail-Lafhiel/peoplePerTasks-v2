<?php
include_once("../resources/session.php");
//------------------------------- add project ---------------------------- //
if ($_SESSION["user_type"] == "admin" || $_SESSION["user_type"] == "client") {
    require_once(__DIR__ . "/../resources/db.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $project_title = $_POST["project_title"];
        $project_description = $_POST["project_description"];
        $category_id = $_POST["category_id"];
        $user_id = $_POST["user_id"];
        $query = "INSERT INTO `projects` (title, description, category_id, user_id) VALUES (?,?,?, ?)";

        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "ssii", $project_title, $project_description, $category_id, $user_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "New project created successfully";
                header("Location: ../projects.php");
                exit;
            } else {
                echo "Error: Unable to execute the query";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Unable to prepare the statement";
        }
    }
    // ----------------------------- delete project ------------------------------------- //
    if (isset($_GET["delete_project"])) {
        $project_id = $_GET["delete_project"];
        $query = "DELETE FROM `projects` WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $project_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // ----------------------------- update project ------------------------------------- //
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $project_id = $_POST["project_id"];
        $project_title = $_POST["project_title"];
        $project_description = $_POST["project_description"];
        $category_id = $_POST["category_id"];
        $user_id = $_POST["user_id"];

        $query = "UPDATE `projects` SET title=?, description=?, user_id = ?, category_id = ? WHERE id=?";

        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "ssiii", $project_title, $project_description, $user_id, $project_id, $category_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "User updated successfully";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

    }
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['edit_project'])) {
            $project_id = $_GET["edit_project"];

            $query = "SELECT * FROM `projects` WHERE id=$project_id"; // Add WHERE clause to select specific project

            $result = mysqli_query($conn, $query);

            if ($row = mysqli_fetch_assoc($result)) {
                $projectData = $row; // Store user data directly, no need for an array
            } else {
                echo "User not found";
            }
        }

    }
    // ----------------------------- show project ------------------------------------- //
    $query = "SELECT projects.id, projects.title, projects.created_at, projects.updated_at, categories.name, users.first_name, users.last_name 
          FROM projects 
          INNER JOIN categories ON projects.category_id = categories.id 
          INNER JOIN users ON projects.user_id = users.id";

    $result = mysqli_query($conn, $query);

    $projects = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $projects[$row['id']] = $row;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $title = "Projects";
    include("components/adminHead.php")
?>

    <body class="dark:bg-gray-900">

        <?php
        $projects_hover = "class='flex items-center p-2 text-white rounded-lg bg-orange-600 dark:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 group'";
        include("components/adminSideBar.php");
        ?>

        <main class=" mt-14 p-12 ml-0  smXl:ml-64">

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
                    Add Project
                </button>
                <button data-modal-target="edit-modal" data-modal-toggle="edit-modal"
                    class="mb-7 mr-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="inline mr-1" style="fill: #FFF"
                        viewBox="0 0 512 512">
                        <path
                            d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z" />
                    </svg>
                    Edit Project
                </button>
                <button data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                    class="mb-7 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="inline mr-1" style="fill: #FFF"
                        viewBox="0 0 448 512">
                        <path
                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                    </svg>
                    Delete Project
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
                                    Add New Project
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
                                <div class="grid gap-4 mb-4">
                                    <div>
                                        <label for="project_title"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
                                            title</label>
                                        <input type="text" name="project_title" id="project_title"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                                            placeholder="Prject title" required="">
                                    </div>
                                    <div>
                                        <label for="categories"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
                                            category</label>

                                        <Select name="category_id" id="categories"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                                            <option value="#"> --select an option-- </option>
                                            <?php
                                            foreach ($categories as $id => $category) {
                                                echo "<option value='" . $id . "'>" . $category['name'] . "</option>";
                                            }
                                            ?>
                                        </Select>
                                    </div>
                                    <div>
                                        <label for="users"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                                            owner</label>

                                        <Select name="user_id" id="users"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                                            <option value="#"> --select an option-- </option>
                                            <?php
                                            foreach ($users as $id => $user) {
                                                echo "<option value='" . $id . "'>" . $user['first_name'] . " " . $user['last_name'] . "</option>";
                                            }
                                            ?>
                                        </Select>
                                    </div>

                                    <div>
                                        <label for="project_description"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
                                            Description</label>
                                        <textarea id="project_description" name="project_description" rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                                            placeholder="Write Project Description here"></textarea>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Add Project
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- edit modal  -->
                <div id="edit-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-gray-100 rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Edit Project
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
                            <form class="p-4 md:p-5" method="POST">
                                <div class="grid gap-4 mb-4">

                                    <div>
                                        <label for="project_id"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
                                            ID</label>
                                        <input type="text" name="project_id" id="project_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                                            placeholder="project id" required="">
                                    </div>
                                    <div>
                                        <label for="project_title"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
                                            title</label>
                                        <input type="text" name="project_title" id="project_title"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                                            placeholder="Prject title" required="">
                                    </div>
                                    <div>
                                        <label for="categories"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
                                            category</label>

                                        <Select name="category_id" id="categories"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                                            <option value="#"> --select an option-- </option>
                                            <?php
                                            foreach ($categories as $id => $category) {
                                                echo "<option value='" . $id . "'>" . $category['name'] . "</option>";
                                            }
                                            ?>
                                        </Select>
                                    </div>
                                    <div>
                                        <label for="users"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                                            owner</label>

                                        <Select name="user_id" id="users"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                                            <option value="#"> --select an option-- </option>
                                            <?php
                                            foreach ($users as $id => $user) {
                                                echo "<option value='" . $id . "'>" . $user['first_name'] . " " . $user['last_name'] . "</option>";
                                            }
                                            ?>
                                        </Select>
                                    </div>

                                    <div>
                                        <label for="project_description"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
                                            Description</label>
                                        <textarea id="project_description" name="project_description" rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                                            placeholder="Write Project Description here"></textarea>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Edit Project
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
                                    Are you sure you want to delete this project?
                                </h3>
                                <form class="p-4 md:p-5" method="POST">
                                    <div class="col-span-2">
                                        <label for="project_id"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
                                            ID</label>
                                        <input type="number" name="project_id" id="project_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="project id" required="">
                                    </div>
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
                <!-- table of data -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                                    Project name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Owner
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Created at
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Updated at
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $project): ?>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $project["id"] ?>
                                    </th>
                                    <td class="px-6 py-4 max-w-xs max-h-1 overflow-hidden">
                                        <?php echo $project["title"] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project['name'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project['first_name'] . " " . $project['last_name'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project['created_at'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project['updated_at'] ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>


                </div>
            </div>

        </main>

        <script src="../../js/dashboard.js"></script>
        <script src="../../js/theme.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
    </body>

    </html>
<?php } ?>
<?php
// require_once("Categories_CRUD/showCategories.php");
// require_once("User_CRUD/showUsers.php");
// require_once("Project_CRUD/showProjects.php");
?>
<?php
include_once("../resources/session.php");
require_once("./controllers/projectController.php");
require_once("./controllers/categoryController.php");
require_once("./controllers/userController.php");
//------------------------------- add project ---------------------------- //
if ($_SESSION["user_type"] == "admin" || $_SESSION["user_type"] == "client") {
    if (isset($_POST['project_title']) && isset($_POST['category_id']) && isset($_POST['user_id']) && isset($_POST['project_description']) && isset($_FILES['project_img'])) {
        add_project($conn, $_POST['project_title'], $_POST['project_description'], $_FILES['project_img'], $_POST['category_id'], $_POST['user_id']);
    }
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        delete_project($conn, $delete_id);

    }
    $projects = show_projects($conn);
    $users = getUsers($conn);
    $categories= getCategories($conn);
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
                            <form class="p-4 md:p-5" method="POST" enctype="multipart/form-data" >
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
                                                echo "<option value='" . $id . "'>" . $category['category_name'] . "</option>";
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
                                                echo "<option value='" . $id . "'>" . $user['first_name']. " ". $user['last_name'] . "</option>";
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
                                    <div class="col-span-2">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                            for="project_img">Upload file</label>
                                        <input
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            aria-describedby="project_img_help" id="project_img" name="project_img"
                                            type="file">
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="project_img_help">A
                                            project picture is useful to specify the project type</div>
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
                                <th colspan="2" class="px-6 py-3">
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
                                <th scope="col" class="px-6 py-3">
                                    Actions
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

                                        <?php if (isset($project['img_path'])) {
                                            echo "<img class='w-10 h-10 rounded-full' src='../images/uploads/'". $project['img_path']." alt = 'project image'  >";
                                        } else {
                                            echo "<img class='w-10 h-10 rounded-full' src='../images/project-image.jpg' alt='project-image'>";
                                        }
                                        ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project["title"] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project['category_name'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project['username'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project['created_at'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $project['updated_at'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="editProject.php?edit_id=<?php echo $project['id'] ?>"
                                            class="mb-7 mr-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                            Edit
                                        </a>
                                        <a href="projects.php?delete_id=<?php echo $project['id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this project?')"
                                            class="mb-7 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>


                </div>
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
<?php
include_once("../resources/session.php");
require_once("./controllers/categoryController.php");
require_once("./controllers/userController.php");
require_once("./controllers/projectController.php");
if ($_SESSION["user_type"] == "admin" || $_SESSION["user_type"] == "client") {
    if (isset($_GET['edit_id'])) {
        $projectData = array();
        $edit_id = $_GET['edit_id'];
        get_project_for_edit($conn, $edit_id);
        $projectData = array_merge($projectData, get_project_for_edit($conn, $edit_id));
        $users = getUsers($conn);
        $categories = getCategories($conn);
    }
    if (isset($_POST['project_id'], $_POST['project_title'], $_POST['project_description'], $_FILES['project_img'], $_POST['category_id'], $_POST['user_id'])) {
        update_project($conn, $_POST['project_id'], $_POST['project_title'], $_POST['project_description'], $_FILES['project_img'], $_POST['category_id'], $_POST['user_id']);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <?php
    $title = "edit project";
    include("components/adminHead.php");
    ?>

    <body class="dark:bg-gray-900">
        <?php
        include("components/adminSideBar.php");
        ?>
        <main class=" mt-14 p-12 ml-0  smXl:ml-64">
            <!-- Modal content -->
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-gray-100 rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Project
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="edit-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <?php var_dump($projectData) ?>
                    <form class="p-4 md:p-5" method="POST" enctype="multipart/form-data">
                        <div class="grid gap-4 mb-4">
                            <input type="hidden" name="project_id" id="project_id">
                            <div>
                                <label for="project_title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
                                    title</label>
                                <input type="text" name="project_title" id="project_title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                                    placeholder="Prject title" required="" value="<?php echo $projectData['title'] ?>">
                            </div>
                            <div>
                                <label for="categories"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
                                    category</label>

                                <Select name="category_id" id="categories"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                                    <option value="#" disabled> --select an option-- </option>
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
                                    placeholder="Write Project Description here"><?php echo $projectData['description'] ?></textarea>
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="project_img">Upload file</label>
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    aria-describedby="project_img_help" id="project_img" name="project_img" type="file">
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="project_img_help">A
                                    project picture is useful to specify the project type</div>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Edit Project
                        </button>
                        <a href="projects.php"
                            class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Go Back
                        </a>
                    </form>
                </div>
            </div>
        </main>

        <script src="../js/dashboard.js"></script>
        <script src="../js/mood.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
    </body>

    </html>

<?php } else {
    header("Location: dashboard.php");
} ?>
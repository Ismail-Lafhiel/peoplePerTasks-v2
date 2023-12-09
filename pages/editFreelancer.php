<?php
include_once("../resources/session.php");
require_once("./controllers/freelancerController.php");
if ($_SESSION["user_type"] == "admin") {
    if (isset($_POST['freelancer_id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['skills']))
        updateFreelancer($conn, $_POST['freelancer_id'], $_POST['first_name'] , $_POST['last_name'], htmlspecialchars($_POST["skills"]));
    if (isset($_GET['edit_freelancer'])) {
        $freelancerData = get_freelancer_for_edit($conn, $_GET['edit_freelancer']);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $title = "edit freelancer";
    include("components/adminHead.php");
    ?>

    <body class="dark:bg-gray-900">
        <?php
        include("components/header.php");
        ?>
        <main class=" mt-14 p-12 ml-0  smXl:ml-64">
            <?PHP var_dump($freelancerData) ?>
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-900">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Freelancer
                    </h3>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="POST">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <input type="hidden" name="freelancer_id" id="freelancer_id">
                        <div class="col-span-2">
                            <label for="first-name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                                Name</label>
                            <input type="text" name="first_name" id="first-name" value="<?php echo $freelancerData['first_name'] ?>"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="first name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                Name</label>
                            <input type="text" name="last_name" id="last-name" value="<?php echo $freelancerData['last_name'] ?>"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="last name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="last-name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Competences</label>
                            <textarea id="skills" name="skills" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write your competences here..."><?php echo $freelancerData['skill'] ?></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Edit Freelancer
                    </button>
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
<?php
require_once(__DIR__ . "/../resources/db.php");

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $sql = "SELECT * from users where first_name LIKE '$input%'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="w-4 p-4">
                <div class="flex items-center">
                    <input id="checkbox-table-search-13" type="checkbox"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-table-search-13" class="sr-only">checkbox</label>
                </div>
            </td>
            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                <div class="pl-3">
                    <div class="text-base font-semibold">
                        <?php echo $row['id'] ?>
                    </div>
                </div>
            </th>
            <td class="px-2 py-4">
                <?php if (isset($row['img_path'])) {
                    echo "<img class='w-10 h-10 rounded-full' src=" . $row['img_path'] . " alt='" . $row['first_name'] . " " . $row["last_name"] . "'>";
                } else {
                    echo "<img class='w-10 h-10 rounded-full' src='../images/avatar.jpg' alt='avatar'>";
                }
                ?>

            </td>
            <td>
                <?php echo $row['first_name'] . " " . $row["last_name"] ?>
            </td>
            </td>
            <td class="px-6 py-4">
                <?php echo $row["email"] ?>
            </td>
            <td class="px-6 py-4">
                <?php echo $row["user_type"] ?>
            </td>
            <td class="px-6 py-4">
                <?php echo $row["created_at"] ?>
            </td>
            <td class="px-6 py-4">
                <?php echo $row["updated_at"] ?>
            </td>
            <td class="px-6 py-4">
                <a href="editUser.php?edit_id=<?php echo $row['id'] ?>"
                    class="mb-7 mr-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Edit
                </a>
                <a href="users.php?delete_id=<?php echo $row['id'] ?>"
                    onclick="return confirm('Are you sure you want to delete this user?')"
                    class="mb-7 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    Delete
                </a>
            </td>
        </tr>
        <?php
    }
}

?>
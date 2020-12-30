<?php declare(strict_types = 1);

    require "classes/DatabaseClass.php";
    require "config/database.php";
    require "helpers/helpers.php";

    $db = new \App\Database($dsn, $username, $password, $options);

    if (isset($_POST['submit'])) {
        if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
    }

    /*
    * Remove member
    */
    if(isset($_POST['submit']) && $_POST['action'] === 'remove_member') {


        $sql = "DELETE FROM employees WHERE id = :id";
        $db->delete($sql, ['id' => $_POST['id']]);

        $delete_pivot_sql = "DELETE FROM project_employee WHERE employee_id = :id";
        $db->delete($delete_pivot_sql, ['id' => $_POST['id']]);
        
    }

    $employees = $db->fetchAll("SELECT * FROM employees");
?>

<?php include "templates/header.php"; ?>

    <?php if(isset($_POST) && isset($_POST['action'])) : ?>
        <div class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-full mt-4">
            <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                <path
                    fill="currentColor"
                    d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z"
                    ></path>
            </svg>
            <span class="text-green-800">Team member was removed successfully</span>
        </div>
    <?php endif; ?>

    <div class="my-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
            Team
        </h1>

        <a href="/create.php?q=employee" class="px-6 py-2 text-white bg-green-400 text-sm rounded-sm hover:bg-green-500">Add</a>
    </div>


    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Delete</span>
                            </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach($employees as $employee) : ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo escape($employee['firstname']); ?> 
                                                    <?php echo escape($employee['lastname']); ?> 
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo escape($employee['email']); ?> 
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php echo escape($employee['position']); ?> 
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="edit.php?q=employees&id=<?php echo escape($employee["id"]); ?>" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="submit" form="remove_member_<?php echo escape($employee["id"]); ?>" class="text-red-600 hover:text-red-900">Delete</a>
                                        <form class="hidden" method="POST" id="remove_member_<?php echo escape($employee["id"]); ?>">
                                            <input type="text" class="hidden" name="action" value="remove_member">
                                            <input type="text" class="hidden" name="id" value="<?php echo escape($employee["id"]); ?>">
                                            <input type="text" class="hidden" name="submit">
                                            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php include "templates/footer.php"; ?>
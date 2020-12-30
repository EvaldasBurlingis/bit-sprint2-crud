<?php declare(strict_types = 1);

    require "classes/DatabaseClass.php";
    require "config/database.php";
    require "helpers/helpers.php";

    $db = new \App\Database($dsn, $username, $password, $options);
    $error = false;

    if (isset($_POST['submit'])) {
        if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
    }

    /*
    * Remove member from project
    */
    if(isset($_POST['submit']) && $_POST['action'] === 'remove_member') {

        $remove_from_project = array(
            'uid' => $_POST['uid'],
            'pid' => $_POST['pid']
        );

        $sql = ("DELETE FROM project_employee WHERE employee_id = :uid AND project_id = :pid");

        $db->delete($sql, $remove_from_project);
        
    }

    /*
    * Add member to project
    */
    if(isset($_POST['submit']) && $_POST['action'] === 'add_member') {

        $add_to_project = array(
            'uid' => $_POST['uid'],
            'pid' => $_POST['pid']
        );

        $get_single_sql = "SELECT * from project_employee pe WHERE pe.employee_id = :uid AND pe.project_id = :pid";
        $is_already_in_db = $db->fetchSingle($get_single_sql, $add_to_project);

        if (!$is_already_in_db) {
            $sql = "INSERT INTO project_employee (project_id, employee_id) VALUES (:pid, :uid)";
            $db->insert($sql, $add_to_project);
        } else{
            $error = true;
        }

    }

    /*
    * Remove project
    */
    if(isset($_POST['submit']) && $_POST['action'] === 'remove_project') {


        $sql = ("DELETE FROM projects WHERE id = :id");

        $db->delete($sql, ['id' => $_POST['id']]);
        
    }

    $projects = $db->fetchAll("SELECT * FROM projects");
    $all_employees = $db->fetchAll("SELECT * FROM employees");
    $employees = $db->fetchAll("SELECT
                                    pe.project_id,
                                    pe.employee_id,
                                    e.id,
                                    e.firstname,
                                    e.lastname,
                                    e.email,
                                    e.position
                                FROM
                                    project_employee pe
                                LEFT JOIN employees e
                                    ON e.id = pe.employee_id");

?>

<?php include "templates/header.php"; ?>
    <div>
        <?php if(isset($_POST) && isset($_POST['action']) && !$error) : ?>
            <div class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-full mt-4">
                <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                    <path
                        fill="currentColor"
                        d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z"
                        ></path>
                </svg>
                <?php if($_POST['action'] === 'remove_member') : ?>
                    <span class="text-green-800">Team member removed from the project successfully</span>
                <?php endif; ?>
                <?php if($_POST['action'] === 'remove_project') : ?>
                    <span class="text-green-800">Project removed successfully</span>
                <?php endif; ?>
                <?php if($_POST['action'] === 'add_member') : ?>
                    <span class="text-green-800">Member was added to project successfully</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_POST) && isset($_POST['action']) && $error) : ?>
            <div class="bg-yellow-100 px-6 py-4 my-4 rounded-md text-lg flex items-center w-full mt-4">
                <svg
                    viewBox="0 0 24 24"
                    class="text-yellow-600 w-5 h-5 sm:w-5 sm:h-5 mr-3"
                    >
                    <path
                        fill="currentColor"
                        d="M23.119,20,13.772,2.15h0a2,2,0,0,0-3.543,0L.881,20a2,2,0,0,0,1.772,2.928H21.347A2,2,0,0,0,23.119,20ZM11,8.423a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Zm1.05,11.51h-.028a1.528,1.528,0,0,1-1.522-1.47,1.476,1.476,0,0,1,1.448-1.53h.028A1.527,1.527,0,0,1,13.5,18.4,1.475,1.475,0,0,1,12.05,19.933Z"
                        ></path>
                </svg>
                <span class="text-yellow-800">This member is already working with this project</span>
            </div>
        <?php endif; ?>

        <div class="my-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Projects
            </h1>

            <a href="/create.php?q=project" class="px-6 py-2 text-white bg-green-400 text-sm rounded-sm hover:bg-green-500">Add</a>
        </div>

        <?php foreach($projects as $project) : ?>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6 flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Project Information
                    </h3>
                    <div>
                        <a href="edit.php?q=projects&id=<?php echo escape($project["id"]); ?>" class="text-green-600 hover:text-green-900 mr-6">Edit</a>
                        <button type="submit" form="remove_project_<?php echo escape($project["id"]); ?>" class="text-red-600 hover:text-red-900">Delete</a>
                        <form class="hidden" method="POST" id="remove_project_<?php echo escape($project["id"]); ?>">
                            <input type="text" class="hidden" name="action" value="remove_project">
                            <input type="text" class="hidden" name="id" value="<?php echo escape($project["id"]); ?>">
                            <input type="text" class="hidden" name="submit">
                            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                        </form>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Project title
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <?php echo escape($project['title']) ?>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Customer
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <?php echo escape($project['customer']) ?>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Budget
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <?php echo escape($project['budget']) ?>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Description
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <?php echo escape($project['description']) ?>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Assigned team members
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 flex justify-between items-start">
                                <div class="flex">
                                    <?php foreach($employees as $employee) : ?>
                                        <?php if($employee['project_id'] === $project['id']) : ?>
                                            <div class="mr-12 p-3 relative hover-trigger">
                                                <form method="POST" class="hidden" id="remove_member_form<?php echo escape($employee['id']) . escape($project['id']); ?>">
                                                    <input type="text" class="hidden" name="action" value="remove_member">
                                                    <input type="text" class="hidden" name="uid" value="<?php echo escape($employee['id']); ?>">
                                                    <input type="text" class="hidden" name="pid" value="<?php echo escape($project['id']); ?>">
                                                    <input type="text" class="hidden" name="submit">
                                                    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                                                </form>
                                                <button
                                                    form="remove_member_form<?php echo escape($employee['id']) . escape($project['id']); ?>"  
                                                    type="submit"
                                                    class="text-red-500 absolute top-0 right-0 hover-target">
                                                    <svg 
                                                        class="w-4 h-4" 
                                                        fill="currentColor" 
                                                        viewBox="0 0 20 20" 
                                                        xmlns="http://www.w3.org/2000/svg">
                                                            <path 
                                                                fill-rule="evenodd" 
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" 
                                                                clip-rule="evenodd">
                                                            </path>
                                                    </svg>
                                                </button>
                                                <div class="text-xs font-medium text-indigo-600">
                                                    <?php echo escape($employee['position']); ?> 
                                                </div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo escape($employee['firstname']); ?> 
                                                    <?php echo escape($employee['lastname']); ?> 
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo escape($employee['email']); ?> 
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <div class="relative" x-data="{ open: false }">

                                    <button class="text-gray-900 text-sm px-4 py-1 rounded-md" @click="open = !open">
                                        <svg class="w-6 h-6" 
                                            fill="currentColor" 
                                            viewBox="0 0 20 20" 
                                            xmlns="http://www.w3.org/2000/svg">
                                                <path 
                                                    d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z">
                                                </path>
                                        </svg>
                                    </button>

                                    <div class="px-4 py-2 bg-white shadow-2xl absolute top-0 right-16 rounded-md" x-show="open" @click.away="open = false">
                                        <form method="POST" class="flex items-center">
                                            <input type="text" name="submit" class="hidden" />
                                            <input type="text" name="action" value="add_member" class="hidden" />
                                            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                                            <input type="text" class="hidden" name="pid" value="<?php echo escape($project['id']); ?>">
                                            <select 
                                                name="uid"
                                                class="mr-2 block w-64 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <?php foreach($all_employees as $e) : ?>
                                                    <option value="<?php echo $e['id'] ;?>" >
                                                        <?php echo escape($e['firstname']) . ' ' . escape($e['lastname']) . ' -- ' . escape($e['position']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button 
                                                type="submit" 
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Add
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        <?php endforeach; ?> 

    </div>
<?php include "templates/footer.php"; ?>
<?php declare(strict_types = 1);


    require "classes/DatabaseClass.php";
    require "config/database.php";
    require "helpers/helpers.php";

    $db = new \App\Database($dsn, $username, $password, $options);
 
    if (isset($_POST['submit'])) {
        if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
    }

    /**
     * Create employee
     */
    if(isset($_POST['submit']) && isset($_GET['q']) && $_GET['q'] === 'employee') {

        $new_employee = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "position"  => $_POST['position']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            "employees",
            implode(", ", array_keys($new_employee)),
            ":" . implode(", :", array_keys($new_employee))
        );

        $db->insert($sql, $new_employee);
    }

    /**
     * Create project
     */
    if(isset($_POST['submit']) && isset($_GET['q']) && $_GET['q'] === 'project') {  

        $new_project = array(
            "title"       => $_POST['title'],
            "customer"    => $_POST['customer'],
            "budget"      => $_POST['budget'],
            "description" => $_POST['description']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            "projects",
            implode(", ", array_keys($new_project)),
            ":" . implode(", :", array_keys($new_project))
        );

        $db->insert($sql, $new_project);
    }

?>

<?php include "templates/header.php"; ?>

<!-- Save notification -->
<?php if($_POST['submit']) :?>
    <div class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-full">
        <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
            <path
                fill="currentColor"
                d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z"
                ></path>
        </svg>
        <span class="text-green-800"><?php echo $_GET['q'] === 'employee' ? 'Employee has been saved.' : 'Project has been saved.'; ?></span>
    </div>
<?php endif; ?>

<div class="mt-10 sm:mt-0 pt-8">
  <div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
      <div class="px-4 sm:px-0">
        <?php if($_GET['q'] === 'employee') : ?>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Employee information</h3>
            <p class="mt-1 text-sm text-gray-600">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit quos optio ad ducimus maiores totam molestiae dolor, atque veniam officia.
            </p>
        <?php endif; ?>
        <?php if($_GET['q'] === 'project') : ?>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Project information</h3>
            <p class="mt-1 text-sm text-gray-600">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit quos optio ad ducimus maiores totam molestiae dolor, atque veniam officia.
            </p>
        <?php endif; ?>
      </div>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-2">

      <?php if($_GET['q'] === 'project') : ?>
        <form method="POST">
            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="border border-gray-300 shadow-sm rounded-md mt-1 px-4 py-1 focus:border-indigo-500">
                </div>

                <div class="col-span-2">
                    <label for="customer" class="block text-sm font-medium text-gray-700">Customer</label>
                    <input type="text" name="customer" id="customer" class="border border-gray-300 shadow-sm rounded-md mt-1 px-4 py-1 focus:border-indigo-500">
                </div>

                <div class="col-span-2">
                    <label for="budget" class="block text-sm font-medium text-gray-700">Budget</label>
                    <input type="text" name="budget" id="budget" class="border border-gray-300 shadow-sm rounded-md mt-1 px-4 py-1 focus:border-indigo-500">
                </div>

                <div class="col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="10" class="w-full border border-gray-300 shadow-sm rounded-md mt-1 px-4 py-1 focus:border-indigo-500"></textarea>
                </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <input type="submit" name="submit" value="Save" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
            </div>
            </div>
        </form>
      <?php endif; ?>

      <?php if($_GET['q'] === 'employee') : ?>
        <form method="POST">
            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="firstname" class="block text-sm font-medium text-gray-700">First name</label>
                    <input type="text" name="firstname" id="firstname" autocomplete="given-name" class="border border-gray-300 shadow-sm rounded-md mt-1 px-4 py-1 focus:border-indigo-500">
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Last name</label>
                    <input type="text" name="lastname" id="lastname" autocomplete="family-name" class="border border-gray-300 shadow-sm rounded-md mt-1 px-4 py-1 focus:border-indigo-500">
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input type="email" name="email" id="email" autocomplete="email" class="border border-gray-300 shadow-sm rounded-md mt-1 px-4 py-1 focus:border-indigo-500">
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <select id="position" name="position" autocomplete="position" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Account Coordinator">Account Coordinator</option>
                        <option value="UX / UI Designer">UX / UI Designer</option>
                        <option value="Copywriter ">Copywriter </option>
                        <option value="Team Lead">Team Lead</option>
                        <option value="Developer">Developer</option>
                        <option value="QA">QA</option>
                        <option value="Customer service manager">Customer service manager</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <input type="submit" name="submit" value="Save" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
            </div>
            </div>
        </form>
      <?php endif; ?>

    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>
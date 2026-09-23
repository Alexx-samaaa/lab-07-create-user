<?php
include 'initialize.php';

$limit = 5;

$countResult = pg_query(
    $connection,
    "SELECT COUNT(*) AS total FROM users"
);

$countData = pg_fetch_assoc($countResult);
$totalUsers = (int) $countData['total'];

$totalPages = max(1, ceil($totalUsers / $limit));

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;

$query = "SELECT id, firstname, lastname, username
          FROM users
          ORDER BY id DESC
          LIMIT $1 OFFSET $2";

$result = pg_query_params(
    $connection,
    $query,
    [$limit, $offset]
);

$alertMessage = $_SESSION['alert_message'] ?? '';
$alertType = $_SESSION['alert_type'] ?? '';

unset($_SESSION['alert_message']);
unset($_SESSION['alert_type']);
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>User Records - Lab 07</title>

<script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="bg-pink-50 min-h-screen">

<div class="flex min-h-screen">


<!-- Sidebar -->
<aside class="w-80 bg-white border-r border-pink-100 flex flex-col">

    <div class="px-7 py-8 border-b border-pink-100">

        <p class="text-pink-500 text-sm font-semibold">
            LAB 07
        </p>

        <h1 class="text-2xl font-bold text-pink-700 mt-1">
            User Manager
        </h1>

        <p class="text-sm text-gray-400 mt-2">
            User Management System
        </p>

    </div>

    <nav class="flex-1 px-5 py-7">

        <p class="text-xs font-semibold text-gray-400 uppercase px-3 mb-4">
            Menu
        </p>

        <a href="dashboard.php"
           class="flex items-center px-5 py-4 gap-4 rounded-xl text-gray-600 hover:bg-pink-50 hover:text-pink-700 font-medium mb-3">
            Dashboard
        </a>

        <a href="user_add.php"
           class="flex items-center px-5 py-4 gap-4 rounded-xl text-gray-600 hover:bg-pink-50 hover:text-pink-700 font-medium mb-3">
            Create User
        </a>

        <a href="user_records.php"
           class="flex items-center px-5 py-4 gap-4 rounded-xl bg-pink-100 text-pink-700 font-semibold">
            User Records
        </a>

    </nav>

    <div class="px-7 py-6 border-t border-pink-100">

        <p class="text-xs text-gray-400">
            CC 6 416
        </p>

        <p class="text-sm text-gray-500 mt-1">
            Application Development
        </p>

    </div>

</aside>

<!-- Main Content -->
<main class="flex-1 p-10">

    <div class="max-w-7xl mx-auto">

        <div class="mb-8">

            <p class="text-sm text-pink-500 font-semibold">
                LAB 07
            </p>

            <h2 class="text-3xl font-bold text-gray-800 mt-1">
                User Records
            </h2>

            <p class="text-gray-500 mt-2">
                View all users created in the system.
            </p>

        </div>

        <?php if ($alertMessage): ?>

            <div class="mb-6 px-5 py-4 rounded-xl
                <?php echo $alertType === 'success'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-red-100 text-red-700'; ?>">

                <?php echo htmlspecialchars($alertMessage); ?>

            </div>

        <?php endif; ?>

        <div class="bg-white rounded-2xl border border-pink-100 overflow-hidden">

            <div class="px-7 py-6 border-b border-pink-100 flex items-center justify-between">

                <div>

                    <h3 class="text-xl font-bold text-gray-800">
                        Registered Users
                    </h3>

                    <p class="text-sm text-gray-400 mt-1">
                        Total users: <?php echo $totalUsers; ?>
                    </p>

                </div>

                <a href="user_add.php"
                   class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-3 rounded-xl font-semibold">
                    Add User
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-pink-50">

                        <tr>

                            <th class="px-7 py-4 text-sm font-semibold text-gray-600">
                                ID
                            </th>

                            <th class="px-7 py-4 text-sm font-semibold text-gray-600">
                                Name
                            </th>

                            <th class="px-7 py-4 text-sm font-semibold text-gray-600">
                                Username
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if (pg_num_rows($result) > 0): ?>

                        <?php while ($user = pg_fetch_assoc($result)): ?>

                            <tr class="border-t border-gray-100">

                                <td class="px-7 py-5 text-gray-600">
                                    <?php echo $user['id']; ?>
                                </td>

                                <td class="px-7 py-5 font-medium text-gray-800">

                                    <?php
                                    echo htmlspecialchars(
                                        $user['firstname'] . " " . $user['lastname']
                                    );
                                    ?>

                                </td>

                                <td class="px-7 py-5 text-gray-600">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="3"
                                class="px-7 py-12 text-center text-gray-400">

                                No users have been created yet.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            <div class="px-7 py-5 border-t border-gray-100 flex items-center justify-between">

                <p class="text-sm text-gray-500">
                    Page <?php echo $page; ?> of <?php echo $totalPages; ?>
                </p>

                <div class="flex gap-2">

                    <?php if ($page > 1): ?>

                        <a href="user_records.php?page=<?php echo $page - 1; ?>"
                           class="px-4 py-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">
                            Previous
                        </a>

                    <?php endif; ?>

                    <?php if ($page < $totalPages): ?>

                        <a href="user_records.php?page=<?php echo $page + 1; ?>"
                           class="px-4 py-2 rounded-lg bg-pink-600 text-white hover:bg-pink-700">
                            Next
                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</main>


</div>

</body>
</html>

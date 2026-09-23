<?php
include 'initialize.php';

$userCountResult = pg_query($connection, "SELECT COUNT(*) AS total FROM users");
$userCountData = pg_fetch_assoc($userCountResult);
$totalUsers = $userCountData['total'];

$recentUsersResult = pg_query(
    $connection,
    "SELECT id, firstname, lastname, username
     FROM users
     ORDER BY id DESC
     LIMIT 5"
);
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lab 07</title>


<script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="bg-pink-50 min-h-screen">

<div class="flex min-h-screen">


<!-- Sidebar -->
<aside class="w-80 bg-white border-r border-pink-100 flex flex-col">

    <div class="px-7 py-8 border-b border-pink-100">
        <p class="text-pink-500 text-sm font-semibold">LAB 07</p>
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
           class="flex items-center px-5 py-4 gap-4 rounded-xl bg-pink-100 text-pink-700 font-semibold mb-3">
            Dashboard
        </a>

        <a href="user_add.php"
           class="flex items-center px-5 py-4 gap-4 rounded-xl text-gray-600 hover:bg-pink-50 hover:text-pink-700 font-medium mb-3">
            Create User
        </a>

        <a href="user_records.php"
           class="flex items-center px-5 py-4 gap-4 rounded-xl text-gray-600 hover:bg-pink-50 hover:text-pink-700 font-medium">
            User Records
        </a>

    </nav>

    <div class="px-7 py-6 border-t border-pink-100">
        <p class="text-xs text-gray-400">CC 6 416</p>
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
                Dashboard
            </h2>

            <p class="text-gray-500 mt-2">
                Manage and view your registered users.
            </p>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-2xl border border-pink-100 p-7 mb-8">
            <p class="text-sm text-gray-500">
                Total Users
            </p>

            <p class="text-4xl font-bold text-pink-700 mt-2">
                <?php echo $totalUsers; ?>
            </p>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-2xl border border-pink-100 overflow-hidden">

            <div class="px-7 py-6 border-b border-pink-100 flex items-center justify-between">

                <div>
                    <h3 class="text-xl font-bold text-gray-800">
                        Recent Users
                    </h3>

                    <p class="text-sm text-gray-400 mt-1">
                        Recently created user accounts
                    </p>
                </div>

                <a href="user_add.php"
                   class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-3 rounded-xl font-semibold">
                    Create User
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

                    <?php if (pg_num_rows($recentUsersResult) > 0): ?>

                        <?php while ($user = pg_fetch_assoc($recentUsersResult)): ?>

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
                                class="px-7 py-10 text-center text-gray-400">
                                No users have been created yet.
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>

</div>

</body>
</html>

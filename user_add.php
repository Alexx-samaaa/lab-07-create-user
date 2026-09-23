<?php
include 'initialize.php';

$alertMessages = [
    'fields' => 'Please complete all fields.',
    'mismatch' => 'Passwords do not match.',
    'exists' => 'Username already exists.',
    'failed' => 'Failed to create user.'
];

$errorCode = $_GET['error'] ?? '';

$alertMessage = $alertMessages[$errorCode] ?? '';
$alertType = $alertMessage ? 'error' : '';
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - Lab 07</title>

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
           class="flex items-center px-5 py-4 gap-4 rounded-xl text-gray-600 hover:bg-pink-50 hover:text-pink-700 font-medium mb-3">
            Dashboard
        </a>

        <a href="user_add.php"
           class="flex items-center px-5 py-4 gap-4 rounded-xl bg-pink-100 text-pink-700 font-semibold mb-3">
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

    <div class="max-w-4xl mx-auto">

        <div class="mb-8">
            <p class="text-sm text-pink-500 font-semibold">
                LAB 07
            </p>

            <h2 class="text-3xl font-bold text-gray-800 mt-1">
                Create User
            </h2>

            <p class="text-gray-500 mt-2">
                Add a new user to the system.
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

        <div class="bg-white rounded-2xl border border-pink-100 p-8">

            <form action="user_add_data.php"
                  method="POST"
                  onsubmit="return validateForm();">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            First Name
                        </label>

                        <input
                            type="text"
                            name="firstname"
                            id="firstname"
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300"
                        >

                        <p id="firstnameError" class="text-red-500 text-sm mt-1 hidden">
                            Please enter your first name.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="lastname"
                            id="lastname"
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300"
                        >

                        <p id="lastnameError" class="text-red-500 text-sm mt-1 hidden">
                            Please enter your last name.
                        </p>
                    </div>

                </div>

                <div class="mt-6">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        id="username"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300"
                    >

                    <p id="usernameError" class="text-red-500 text-sm mt-1 hidden">
                        Please enter a username.
                    </p>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300"
                        >

                        <p id="passwordError" class="text-red-500 text-sm mt-1 hidden"></p>

                    </div>

                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirm Password
                        </label>

                        <input
                            type="password"
                            name="confirm_password"
                            id="confirm_password"
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300"
                        >

                        <p id="confirmPasswordError" class="text-red-500 text-sm mt-1 hidden"></p>

                    </div>

                </div>

                <div class="flex gap-4 mt-8">

                    <a href="dashboard.php"
                       class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl bg-pink-600 text-white font-semibold hover:bg-pink-700">
                        Add User
                    </button>

                </div>

            </form>

        </div>

    </div>

</main>

</div>


<script>

function validateForm() {

    let valid = true;

    const firstname = document.getElementById("firstname");
    const lastname = document.getElementById("lastname");
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");

    const firstnameError = document.getElementById("firstnameError");
    const lastnameError = document.getElementById("lastnameError");
    const usernameError = document.getElementById("usernameError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");


    // Hide previous errors
    firstnameError.classList.add("hidden");
    lastnameError.classList.add("hidden");
    usernameError.classList.add("hidden");
    passwordError.classList.add("hidden");
    confirmPasswordError.classList.add("hidden");


    // Check empty fields
    if (firstname.value.trim() === "") {
        firstnameError.textContent = "Please enter your first name.";
        firstnameError.classList.remove("hidden");
        valid = false;
    }

    if (lastname.value.trim() === "") {
        lastnameError.textContent = "Please enter your last name.";
        lastnameError.classList.remove("hidden");
        valid = false;
    }

    if (username.value.trim() === "") {
        usernameError.textContent = "Please enter a username.";
        usernameError.classList.remove("hidden");
        valid = false;
    }

    if (password.value === "") {
        passwordError.textContent = "Please enter a password.";
        passwordError.classList.remove("hidden");
        valid = false;
    } else if (password.value.length < 8) {
        passwordError.textContent = "Password must be at least 8 characters.";
        passwordError.classList.remove("hidden");
        valid = false;
    }

    if (confirmPassword.value === "") {
        confirmPasswordError.textContent = "Please confirm your password.";
        confirmPasswordError.classList.remove("hidden");
        valid = false;
    } else if (password.value !== confirmPassword.value) {
        confirmPasswordError.textContent = "Passwords do not match.";
        confirmPasswordError.classList.remove("hidden");
        valid = false;
    }


    // Stop if there are errors
    if (!valid) {
        return false;
    }


    // Ask for confirmation only when everything is valid
    return confirm("Are you sure you want to add this user?");
}

</script>

</body>
</html>

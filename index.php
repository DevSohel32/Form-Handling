<?php
if (isset($_POST["submit"])) {

    // ===== Input Data Sanitization =====
    $firstName = dataValidation($_POST["firstName"]);
    $lastName = dataValidation($_POST["lastName"]);
    $email = dataValidation($_POST["email"]);
    $password = dataValidation($_POST["password"]);
    $confirmPassword = dataValidation($_POST["confirmPassword"]);
    $role = $_POST["role"];
    $avatarName = $_FILES['avatar']['name'];
    $avatarSize = $_FILES['avatar']['size'];
    $avatarTemp = $_FILES['avatar']['tmp_name'];
    $avatarType = $_FILES['avatar']['type'];

    // ===== Field Validations =====
    if (empty($firstName)) {
        $errors['firstName'] = "⚠️ Please enter your first name.";
    } else {
        $data['firstName'] = $firstName;
    }

    if (empty($lastName)) {
        $errors['lastName'] = "⚠️ Please enter your last name.";
    } else {
        $data['lastName'] = $lastName;
    }

    if (empty($email)) {
        $errors['email'] = "📧 Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "❌ Please enter a valid email address.";
    } else {
        $data['email'] = $email;
    }

    if (empty($password)) {
        $errors['password'] = "🔒 Please set your password.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "⚠️ Password must be at least 6 characters long.";
    } else {
        $data['password'] = $password;
    }

    if (empty($confirmPassword)) {
        $errors['confirmPassword'] = "🔁 Please confirm your password.";
    } elseif ($confirmPassword !== $password) {
        $errors['confirmPassword'] = "❌ Passwords do not match.";
    } else {
        $data['confirmPassword'] = $confirmPassword;
    }if(empty($role)){ 
        $errors ['role'] = '⚠️ Please select your role';

    }else{
        $data['role'] = $role;
    }

    // ===== Avatar Validation =====
    $avatarActualExt = strtolower(pathinfo($avatarName, PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "svg", "webp"];

    if (empty($avatarName)) {
        $errors['avatarName'] = "🖼️ Please select a profile image.";
    } elseif (!in_array($avatarActualExt, $allowed)) {
        $errors['avatarName'] = "🚫 Invalid file type! Only JPG, JPEG, PNG, SVG, or WEBP are allowed.";
    } elseif ($avatarSize > 2000000) { // 2MB limit
        $errors['avatarName'] = "⚠️ File size too large. Maximum allowed size is 2MB.";
    } else {
        $data['avatarName'] = $avatarName;
    }

    if(empty($errors)){
     echo "<p style='color:green; font-weight:bold;'>✅ Registration successful! Welcome aboard 🎉</p>";
    }

}
function dataValidation($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Colorful Tailwind Form</title>

    <!-- ✅ Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-pink-100 to-purple-200">
    <form
        class="backdrop-blur-lg bg-white/70 p-8 rounded-2xl shadow-2xl max-w-md w-full border border-white/50 transition duration-500 hover:shadow-blue-300/50"
        method="post" enctype="multipart/form-data">

        <h2
            class="text-3xl font-bold text-center mb-8 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">
            Registration Form
        </h2>

        <div class="grid md:grid-cols-2 md:gap-6">
            <!-- First Name -->
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="firstName" id="floating_firstName"
                    class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-blue-500 focus:ring-0 focus:outline-none peer transition-all duration-300"
                    placeholder=" " value="<?= $data["firstName"] ?? '' ?>" />
                <p class="text-red-500 text-sm mt-1"><?= $errors['firstName'] ?? '' ?></p>
                <label for="floating_first_name"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:text-blue-600 peer-focus:-translate-y-6 peer-focus:scale-75">
                    First name
                </label>
            </div>

            <!-- Last Name -->
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="lastName" id="floating_last_name"
                    class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-pink-500 focus:ring-0 focus:outline-none peer transition-all duration-300"
                    placeholder=" " value="<?= $data['lastName'] ?? '' ?>" />
                <p class="text-red-500 text-sm mt-1"><?= $errors["lastName"] ?? '' ?></p>
                <label for="floating_last_name"
                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:text-pink-600 peer-focus:-translate-y-6 peer-focus:scale-75">
                    Last name
                </label>
            </div>
        </div>

        <!-- Email -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="email" name="email" id="floating_email"
                class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-purple-500 focus:ring-0 focus:outline-none peer transition-all duration-300"
                placeholder=" " value="<?= $data["email"] ?? '' ?> " />
            <p class="text-red-500 text-sm mt-1"> <?= $errors["email"] ?? '' ?> </p>
            <label for="floating_email"
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:text-purple-600 peer-focus:-translate-y-6 peer-focus:scale-75">
                Email address
            </label>
        </div>

        <!-- Password -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="password" name="password" id="floating_password"
                class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-green-500 focus:ring-0 focus:outline-none peer transition-all duration-300"
                placeholder=" " />
            <p class="text-red-500 text-sm mt-1"><?= $errors['password'] ?? '' ?></p>
            <label for="floating_password"
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:text-green-600 peer-focus:-translate-y-6 peer-focus:scale-75">
                Password
            </label>
        </div>

        <!-- Confirm Password -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="password" name="confirmPassword" id="floating_repeat_password"
                class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:border-orange-500 focus:ring-0 focus:outline-none peer transition-all duration-300"
                placeholder=" " />
            <p class="text-red-500 text-sm mt-1"><?= $errors['confirmPassword'] ?? '' ?></p>
            <label for="floating_repeat_password"
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:text-orange-600 peer-focus:-translate-y-6 peer-focus:scale-75">
                Confirm password
            </label>
        </div>

        <!-- File Upload -->
        <div class="relative z-0 w-full mb-6 group">
            <label class="block mb-2 text-sm font-medium text-gray-900" for="user_avatar">
                Upload file
            </label>
            <input name="avatar" id="user_avatar" type="file"
                class="block w-full p-3 text-sm text-gray-700 border border-gray-300 rounded-lg  focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-300" />
                 <p class="text-red-500 text-sm mt-1"><?= $errors['avatarName'] ?? '' ?></p>
        </div>

        <!-- Role Select -->
        <div class="mb-8">
            <select id="countries" name="role"
                class="block w-full p-3 text-sm text-gray-700 border border-gray-300 rounded-lg bg-gradient-to-r from-blue-50 to-purple-50 focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-300">
                <option selected disabled>Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Student">Student</option>
                <option value="Manager">Manager</option>
            </select>
            <p class="text-red-500 text-sm mt-1"><?= $errors['role'] ?? '' ?></p>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3 text-white font-semibold rounded-lg bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 shadow-lg shadow-purple-300/50 hover:opacity-90 hover:scale-[1.02] focus:ring-4 focus:ring-purple-300 transition-all duration-500"
            name="submit">
            Submit
        </button>
    </form>
</body>

</html>

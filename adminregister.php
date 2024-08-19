<?php 
session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
        $email = $_POST['email'];
        
        

		if(!empty($user_name) && !empty($password) && !empty($email) && !is_numeric($user_name))
		{

			//save to database
			$user_id = random_num(20);
			$query = "insert into admin (user_id,user_name,password,email) values ('$user_id','$user_name','$password','$email')";

			mysqli_query($con, $query);

			header("Location: adminlogin.php");
			die;
		}else
		{
			echo "Please enter some valid information!";
		}
	}
        // Fetch the most recent logo from the database
$query = "SELECT logo_name FROM logo ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $logo_name = $row['logo_name'];
} else {
    // Default logo if none is found in the database
    $logo_name = 'default_logo.png';  // You should have a default logo in the 'uploads' folder
}

// Define the path to the logo
$logo_path = "img/" . $logo_name;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register - Secular Citizens BD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-gradient-to-t from-neutral-500 to-stone-900 p-4">
        <div class="container mx-auto flex justify-center text-center">
        <div>
                <a href="#" class="text-white font-bold text-2xl"><img src="<?php echo htmlspecialchars($logo_path); ?>" class="w-56 h-50"><p class="text-sm font-light text-green-500 ml-6">Be secular, Be free...</p></a>
            </div>
        </div>
    </nav>

    <div class="bg-stone-900 text-white py-2">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Contact Number -->
            
            <!-- Social Media Links -->
            
        </div>
    </div>

        <!-- Registration Section -->
        <section class="py-16">
            <div class="container mx-auto">
                <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold text-center mb-4 font-zendots">Admin Register</h2>
                    <form method="post">
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                            <input type="text" id="user_name" name="user_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your username">
                        </div>
                        <div class="mb-6 relative">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline pr-10" placeholder="Enter your password">
                    <span class="absolute inset-y-0 right-0 pr-3 mt-6 flex items-center cursor-pointer">
                        <i class="fas fa-eye text-black" id="togglePassword"></i>
                    </span>
                </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your email">
                        </div>
                        <div class="flex items-center justify-center">
                            <button type="submit" class="bg-stone-900 hover:bg-neutral-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
                        </div>
                    </form>
                    <p class="text-center text-gray-600 text-sm mt-4">Already have an account? <a href="adminlogin.php" class="text-stone-900 font-bold hover:text-stone-700">Login</a></p>
                </div>
            </div>
        </section>

    <!-- Footer -->
    <footer class="bg-stone-950 text-white py-4">
        <div class="container mx-auto text-center">
            &copy; 2024 Secular Citizens Bangladesh. All Rights Reserved.
        </div>
    </footer>
    <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the eye / eye-slash icon
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>

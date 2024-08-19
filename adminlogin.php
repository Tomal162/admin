<?php 

session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//read from database
			$query = "select * from admin where user_name = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: index.php");
						die;
					}
				}
			}
			
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
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
    <title>Admin Login - Secular Citizens BD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-gradient-to-t from-neutral-500 to-stone-900 p-4">
        <div class="container mx-auto flex justify-center text-center">
        <div>
                <a href="#" class="text-white font-bold text-2xl"><img src="<?php echo htmlspecialchars($logo_path); ?>" class="w-56 h-50"><p class="text-sm font-light text-white ml-6">Be secular, Be free...</p></a>
            </div>
        </div>
    </nav>

    <div class="bg-stone-900 text-white py-2">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Contact Number -->
            
            <!-- Social Media Links -->
            
        </div>
    </div>

    <!-- Login Section -->
<section class="py-16">
    <div class="container mx-auto">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-center mb-4 font-zendots">Admin Login</h2>
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
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-stone-900 hover:bg-neutral-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Login</button>
                    <a href="#" class="inline-block align-baseline font-bold text-sm text-stone-900 hover:text-stone-700">Forgot Password?</a>
                </div>
            </form>
            <p class="text-center text-gray-600 text-sm mt-4">Don't have an account? <a href="adminregister.php" class="text-stone-900 font-bold hover:text-stone-700">Register</a></p>
        </div>
    </div>
</section>
    <!-- Footer -->
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

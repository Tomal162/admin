<?php

include("connection.php");

//Update Logo
$uploadOk = 1; 
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['image'])) {
    // Directory where the logo will be uploaded
    $target_dir = "img/";
    
    // Make sure the directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Additional checks...
    // Check file size (optional, e.g., limit to 500KB)
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats (optional)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Attempt to upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // If file upload is successful, continue with saving the filename in the database...
            $logo_name = basename($_FILES["image"]["name"]);

            // Update or insert into the database...
            $query = "insert into logo (logo_name) values ('$logo_name')";
            if (mysqli_query($con, $query)) {
                header("Location: home.php");
                die;
            } else {
                echo "Error updating logo: " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
 //Update recent slogan

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
        if (isset($_POST['slogan_body']) && !empty($_POST['slogan_body'])) {
            $slogan_body = $_POST['slogan_body'];

			//save to database
			$query = "insert into slogan (slogan_body) values ('$slogan_body')";

			mysqli_query($con, $query);

			header("Location: home.php");
			die;
		}else
		{
			echo "Please enter some valid slogan!";
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


// Query to check if there are any unread messages
$query = "SELECT COUNT(*) as unread_count FROM emails WHERE is_read = FALSE";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$unread_count = $row['unread_count'];

//Update three images

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['image_1']) && isset($_FILES['image_2']) && isset($_FILES['image_3'])) {
    $target_dir = "img/";

    // Create the directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $uploadOk = 1;
    $images = [];

    function uploadImage($imageKey, &$uploadOk, &$images, $target_dir) {
        $target_file = $target_dir . basename($_FILES[$imageKey]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size (optional, e.g., limit to 500KB)
        if ($_FILES[$imageKey]["size"] > 500000) {
            echo "Sorry, your file " . basename($_FILES[$imageKey]["name"]) . " is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed for " . basename($_FILES[$imageKey]["name"]) . ".";
            $uploadOk = 0;
        }

        // Attempt to upload the file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES[$imageKey]["tmp_name"], $target_file)) {
                $images[$imageKey] = basename($_FILES[$imageKey]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file " . basename($_FILES[$imageKey]["name"]) . ".";
                $uploadOk = 0;
            }
        }
    }

    // Upload each image
    uploadImage('image_1', $uploadOk, $images, $target_dir);
    uploadImage('image_2', $uploadOk, $images, $target_dir);
    uploadImage('image_3', $uploadOk, $images, $target_dir);

    // Save filenames to the database if all uploads were successful
    if ($uploadOk == 1) {
        $img_1 = $images['image_1'];
        $img_2 = $images['image_2'];
        $img_3 = $images['image_3'];

        $query = "insert into image (img_1, img_2, img_3) values('$img_1', '$img_2', '$img_3')";
        if (mysqli_query($con, $query)) {
            header("Location: home.php");
            die;
        } else {
            echo "Error updating images: " . mysqli_error($con);
        }
    }
}

//Update generic image

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['g_image'])) {
    // Directory where the generic image will be uploaded
    $target_dir = "img/";
    
    // Make sure the directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($_FILES["g_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size (optional, e.g., limit to 500KB)
    if ($_FILES["g_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats (optional)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Attempt to upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["g_image"]["tmp_name"], $target_file)) {
            // If file upload is successful, continue with saving the filename in the database
            $img_name = basename($_FILES["g_image"]["name"]);

            // Insert into the database
            $query = "insert into generic_image (img_name) values ('$img_name')";
            if (mysqli_query($con, $query)) {
                header("Location: home.php"); // Redirect to a success page or the admin panel
                exit;
            } else {
                echo "Error inserting image: " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

//Update Organization Description

if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
        if (isset($_POST['des_body']) && !empty($_POST['des_body'])) {
            $des_body = $_POST['des_body'];

			//save to database
			$query = "insert into description (des_body) values ('$des_body')";

			mysqli_query($con, $query);

			header("Location: home.php");
			die;
		}else
		{
			echo "Please enter some valid description!";
		}
	}

    //Update Board Members

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['image_name'])) {
        
            // Directory where the image will be uploaded
            $target_dir = "img/";
            
            // Make sure the directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
    
            // Path to save the uploaded file
            $target_file = $target_dir . basename($_FILES["image_name"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
            // Check file size (optional, e.g., limit to 500KB)
            if ($_FILES["image_name"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
    
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
    
            // Attempt to upload the file
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["image_name"]["tmp_name"], $target_file)) {
                    // Prepare data for insertion
                    $image_name = basename($_FILES["image_name"]["name"]);
                    $name = mysqli_real_escape_string($con, $_POST['name']);
                    $designation = mysqli_real_escape_string($con, $_POST['designation']);
                    
                    // Insert data into the database
                    $query = "insert into board_members (image_name, name, designation) values ('$image_name', '$name', '$designation')";
    
                    if (mysqli_query($con, $query)) {
                        header("Location: home.php"); // Redirect to prevent form resubmission
                        exit;
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    

    //Delete Board Member

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['member_id'])) {
        // Ensure you have a connection to the database
        include("connection.php");
    
        // Get the member ID
        $member_id = mysqli_real_escape_string($con, $_POST['member_id']);
    
        // Query to delete the board member
        $query = "DELETE FROM board_members WHERE id = '$member_id'";
    
        if (mysqli_query($con, $query)) {
            // Redirect or show a success message
            header("Location: home.php"); // Or any other relevant page
            exit;
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
//Update Hotlines
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        // Retrieve the hotline data from the form
        $call_1 = mysqli_real_escape_string($con, $_POST['contact_1']);
        $call_2 = mysqli_real_escape_string($con, $_POST['contact_2']);
        $call_3 = mysqli_real_escape_string($con, $_POST['contact_3']);
    
        // Insert or update the hotlines in the database
        $query = "insert into hotline (call_1, call_2, call_3) values ('$call_1', '$call_2', '$call_3')";
    
        if (mysqli_query($con, $query)) {
            header("Location: home.php");
            // Redirect or show success message
        } else {
            echo "Error: " . mysqli_error($con);
        }
    
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="dist/css/style.css">
    <title>Dashboard</title>
</head>
<body class="text-gray-800 font-inter">
    
    <!-- start: Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full bg-stone-900 p-4 z-50 sidebar-menu transition-transform">
        <div>
            <a href="#" class="text-white font-bold text-2xl"><img src="<?php echo htmlspecialchars($logo_path); ?>" class="w-30 h-26"><p class="text-sm font-light text-white ml-12">Be secular, Be free...</p></a>
        </div>
        <ul class="mt-4">
            <li class="mb-1 group active">
                <a href="index.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800">
                    <i class="ri-home-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 sidebar-dropdown-toggle">
                    <i class="ri-instance-line mr-3 text-lg"></i>
                    <span class="text-sm">Pages</span>
                    <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="home.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Home</a>
                    </li> 
                    <li class="mb-4">
                        <a href="gettoknowus.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Get to know us</a>
                    </li> 
                    <li class="mb-4">
                        <a href="resourcehub.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Resource hub</a>
                    </li> 
                    <li class="mb-4">
                        <a href="events.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Events</a>
                    </li> 
                    <li class="mb-4">
                        <a href="discourse.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Discourse</a>
                    </li> 
                    <li class="mb-4">
                        <a href="reachout.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Reach out</a>
                    </li> 
                </ul>
            </li>
            <li class="mb-1 group">
                <a href="social.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800">
                    <i class="ri-heart-3-line mr-3 text-lg"></i>
                    <span class="text-sm">Social Links</span>
                </a>
            </li>
            <li class="mb-1 group">
    <a href="inbox.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800">
        <?php if ($unread_count > 0): ?>
            <!-- Unread Mail Icon -->
            <i class="ri-mail-unread-line mr-3 text-lg text-red-500"></i>
        <?php else: ?>
            <!-- Read Mail Icon -->
            <i class="ri-mail-line mr-3 text-lg"></i>
        <?php endif; ?>
        <span class="text-sm">Inbox<?php if ($unread_count > 0) echo " ($unread_count)"; ?></span>
    </a>
</li>
        </ul>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
    <!-- end: Sidebar -->
    
    <!-- start: Main Content -->
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
            <button type="button" class="text-lg text-gray-600 sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>
            <ul class="flex items-center text-sm ml-4">
                <li class="mr-2">
                    <a href="#" class="text-gray-400 hover:text-gray-600 font-medium">Home</a>
                </li>
            </ul>
            <ul class="ml-auto flex items-center">
                <li class="mr-1 dropdown">
                    <button type="button" class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                        <i class="ri-search-line"></i>
                    </button>
                    <div class="dropdown-menu shadow-md shadow-black/5 z-30 hidden max-w-xs w-full bg-white rounded-md border border-gray-100">
                        <form action="" class="p-4 border-b border-b-gray-100">
                            <div class="relative w-full">
                                <input type="text" class="py-2 pr-4 pl-10 bg-gray-50 w-full outline-none border border-gray-100 rounded-md text-sm focus:border-blue-500" placeholder="Search...">
                                <i class="ri-search-line absolute top-1/2 left-4 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </form>
                        <div class="mt-3 mb-2">
                            <div class="text-[13px] font-medium text-gray-400 ml-4 mb-2">Recently</div>
                            <ul class="max-h-64 overflow-y-auto">
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">Create landing page</div>
                                            <div class="text-[11px] text-gray-400">$345</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">Create landing page</div>
                                            <div class="text-[11px] text-gray-400">$345</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">Create landing page</div>
                                            <div class="text-[11px] text-gray-400">$345</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">Create landing page</div>
                                            <div class="text-[11px] text-gray-400">$345</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">Create landing page</div>
                                            <div class="text-[11px] text-gray-400">$345</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">Create landing page</div>
                                            <div class="text-[11px] text-gray-400">$345</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">Create landing page</div>
                                            <div class="text-[11px] text-gray-400">$345</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">Create landing page</div>
                                            <div class="text-[11px] text-gray-400">$345</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <button type="button" class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                        <i class="ri-notification-3-line"></i>
                    </button>
                    <div class="dropdown-menu shadow-md shadow-black/5 z-30 hidden max-w-xs w-full bg-white rounded-md border border-gray-100">
                        <div class="flex items-center px-4 pt-4 border-b border-b-gray-100 notification-tab">
                            <button type="button" data-tab="notification" data-tab-page="notifications" class="text-gray-400 font-medium text-[13px] hover:text-gray-600 border-b-2 border-b-transparent mr-4 pb-1 active">Notifications</button>
                            <button type="button" data-tab="notification" data-tab-page="messages" class="text-gray-400 font-medium text-[13px] hover:text-gray-600 border-b-2 border-b-transparent mr-4 pb-1">Messages</button>
                        </div>
                        <div class="my-2">
                            <ul class="max-h-64 overflow-y-auto" data-tab-for="notification" data-page="notifications">
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">New order</div>
                                            <div class="text-[11px] text-gray-400">from a user</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">New order</div>
                                            <div class="text-[11px] text-gray-400">from a user</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">New order</div>
                                            <div class="text-[11px] text-gray-400">from a user</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">New order</div>
                                            <div class="text-[11px] text-gray-400">from a user</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">New order</div>
                                            <div class="text-[11px] text-gray-400">from a user</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <ul class="max-h-64 overflow-y-auto hidden" data-tab-for="notification" data-page="messages">
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">John Doe</div>
                                            <div class="text-[11px] text-gray-400">Hello there!</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">John Doe</div>
                                            <div class="text-[11px] text-gray-400">Hello there!</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">John Doe</div>
                                            <div class="text-[11px] text-gray-400">Hello there!</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">John Doe</div>
                                            <div class="text-[11px] text-gray-400">Hello there!</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                                        <div class="ml-2">
                                            <div class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">John Doe</div>
                                            <div class="text-[11px] text-gray-400">Hello there!</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="dropdown ml-3">
                    <button type="button" class="dropdown-toggle text-gray-400 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                        <i class="ri-user-3-line"></i>
                    </button>
                    <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                        <li>
                            <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                        </li>
                        <li>
                            <a href="" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Update Logo -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Update Logo</h2>
            <form method="post" enctype="multipart/form-data" onsubmit="showNotification(event, 'logo-notification')">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Select Image</label>
                    <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload</button>
            </form>
            <div id="logo-notification" class="hidden bg-green-500 text-white p-2 mt-4 rounded">Updated Successfully</div>
</div>
<!-- Update Slogan -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Update Slogan</h2>
    <form method="post" enctype="multipart/form-data" onsubmit="showNotification(event, 'slogan-notification')">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Slogan Body</label>
            <input type="text" name="slogan_body" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
    </form>
    <div id="slogan-notification" class="hidden bg-green-500 text-white p-2 mt-4 rounded">Updated Successfully</div>
</div>
        
            <!-- Update Images -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Update Images</h2>
                <form method="post" enctype="multipart/form-data" onsubmit="showNotification(event, 'images-notification')">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Select Image</label>
                        <input type="file" name="image_1" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Select Image</label>
                        <input type="file" name="image_2" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Select Image</label>
                        <input type="file" name="image_3" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload</button>
                </form>
                <div id="images-notification" class="hidden bg-green-500 text-white p-2 mt-4 rounded">Updated Successfully</div>
            </div>
            

            

             <!-- Update Generic Image -->
             <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Update Generic Image</h2>
                <form method="post" enctype="multipart/form-data" onsubmit="showNotification(event, 'generic-image-notification')">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Select Image</label>
                        <input type="file" name="g_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Upload</button>
                </form>
                <div id="generic-image-notification" class="hidden bg-green-500 text-white p-2 mt-4 rounded">Updated Successfully</div>
            </div>

            <!-- Update Description of Organization -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Update Description of Organization</h2>
                <form method="post" onsubmit="showNotification(event, 'description-notification')">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="des_body" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
                </form>
                <div id="description-notification" class="hidden bg-green-500 text-white p-2 mt-4 rounded">Updated Successfully</div>
            </div>

           <!-- Update Board Members -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Update Board Members</h2>
    <div class="mb-4">
        <form method="post" enctype="multipart/form-data" onsubmit="showNotification(event, 'members-notification')">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Select Image</label>
                <input type="file" name="image_name" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Designation</label>
            <input type="text" name="designation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
        </form>
    </div>
    <div id="members-notification" class="hidden bg-green-500 text-white p-2 mt-4 rounded">Updated Successfully</div>
</div>
<!-- Delete Board Members -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Delete Board Members</h2>
    <form method="post" onsubmit="showNotification(event, 'delete-notification')">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Member ID</label>
            <input type="text" name="member_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">Delete</button>
    </form>
    <div id="delete-notification" class="hidden bg-red-500 text-white p-2 mt-4 rounded">Deleted Successfully</div>
</div>
            <!-- Update Hotlines -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Update Hotlines</h2>
                <form method="post" onsubmit="showNotification(event, 'hotlines-notification')">
                    <div class="mb-4 flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700">Hotline 1</label>
                            

                                <input type="text" name="contact_1" class="mt-1 block w-3/4 px-3 py-2 border border-l-1 border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter contact number">
                            
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded-md hover:bg-blue-700">Update</button>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700">Hotline 2</label>
                            
                                
                                <input type="text" name="contact_2" class="mt-1 block w-3/4 px-3 py-2 border border-l-1 border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter contact number">
                            
                            
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700">Hotline 3</label>
                            
                                
                                <input type="text" name="contact_3" class="mt-1 block w-3/4 px-3 py-2 border border-l-1 border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter contact number">
                            
                            
                        </div>
                    </div>
                </form>
                <div id="hotlines-notification" class="hidden bg-green-500 text-white p-2 mt-4 rounded">Updated Successfully</div>
            </div>
        
    </main>
    <!-- end: Main Content -->

    <script>
        function showNotification(event, notificationId) {
        event.preventDefault();  // Prevent the default form submission

        const notification = document.getElementById(notificationId);
        notification.classList.remove('hidden');

        // Hide the notification after 2 seconds
        setTimeout(() => {
            notification.classList.add('hidden');
            // Submit the form after showing the notification
            event.target.submit();  // Programmatically submit the form
        }, 2000);
    }
        </script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="dist/js/script.js"></script>

</body>
</html>

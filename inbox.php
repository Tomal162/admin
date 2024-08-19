<?php 
session_start();

	include("connection.php");

    // Query to check if there are any unread messages
$query = "SELECT COUNT(*) as unread_count FROM emails WHERE is_read = FALSE";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$unread_count = $row['unread_count'];

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    // Update the message to mark it as read
    $query = "UPDATE emails SET is_read = TRUE WHERE id = $message_id";
    if (mysqli_query($con, $query)) {
        echo "Message marked as read.";
    } else {
        echo "Error: " . mysqli_error($con);
    }
} 

//Delete Messages

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    
    
    $id = intval($_POST['id']); // Get the ID and sanitize it

    if ($id > 0) {
        $query = "DELETE FROM emails WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
} 
// Fetch the first five messages
$query = "SELECT * FROM emails ORDER BY id ASC LIMIT 5";
$result = mysqli_query($con, $query);
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get the offset from the GET request
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Fetch the next set of messages
$query = "SELECT * FROM emails ORDER BY id ASC LIMIT 5 OFFSET $offset";
$result = mysqli_query($con, $query);
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);


	
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


//Deleting message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    include('db_connect.php'); // Assuming you have a file for database connection
    
    $id = intval($_POST['id']); // Get the ID and sanitize it

    if ($id > 0) {
        $query = "DELETE FROM emails WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Invalid ID";
    }
} else {
    echo "Invalid request";
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
        <a href="#" class="pb-4">
        <div>
                <a href="#" class="text-white font-bold text-2xl"><img src="<?php echo htmlspecialchars($logo_path); ?>" class="w-30 h-26"><p class="text-sm font-light text-white ml-12">Be secular, Be free...</p></a>
            </div>
        </a>
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
                    <a href="#" class="text-gray-400 hover:text-gray-600 font-medium">Inbox</a>
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
                            <a href="adminlogout.php" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
           

            <!-- Messages -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Messages</h2>
                <div id="message-container" class="max-w-5xl mx-auto">
        <?php foreach ($messages as $message): ?>
            <article class="mb-6 p-6 bg-white border border-gray-300 shadow-sm rounded-lg">
                <h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($message['first_name'] . ' ' . $message['last_name']); ?></h2>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($message['phone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($message['email']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($message['address']); ?></p>
                <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                <p class="text-sm text-gray-500"><strong>Received At:</strong> <?php echo htmlspecialchars($message['created_at']); ?></p>
                <button class="delete-message px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700" 
                        data-id="<?php echo $message['id']; ?>">Delete</button>
            
            </article>
        <?php endforeach; ?>
    </div>
    <div class="flex justify-center mt-6">
        <button id="load-more" class="px-4 py-2 bg-black text-white rounded hover:bg-neutral-500">Load More</button>
    </div>
            
    </main>
    <!-- end: Main Content -->
    <script>
        let offset = 5;

        document.getElementById('load-more').addEventListener('click', function () {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `load_more_messages.php?offset=${offset}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('message-container').innerHTML += xhr.responseText;
                    offset += 5;
                }
            };
            xhr.send();
        });
    </script>

    <script>document.querySelectorAll('.delete-message').forEach(button => {
    button.addEventListener('click', function() {
        const messageId = this.getAttribute('data-id'); // Get the ID from data-id attribute
        
        if (confirm('Are you sure you want to delete this message?')) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'inbox.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Message deleted successfully!');
                    location.reload(); // Refresh the page to reflect changes
                } else {
                    alert('Error deleting message');
                }
            };
            xhr.send(`id=${messageId}`); // Send the ID to the server
        }
    });
});</script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="dist/js/script.js"></script>
</body>
</html>
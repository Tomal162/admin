<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

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

    <!-- start: Main -->
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
            <button type="button" class="text-lg text-gray-600 sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>
            <ul class="flex items-center text-sm ml-4">
                <li class="mr-2">
                    <a href="#" class="text-gray-400 hover:text-gray-600 font-medium">Dashboard</a>
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
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                    <div class="flex justify-between mb-6">
                        <div>
                            <div class="text-2xl font-semibold mb-1">10</div>
                            <div class="text-sm font-medium text-gray-400">Reach</div>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-full bg-gray-100 rounded-full h-4">
                            <div class="h-full bg-blue-500 rounded-full p-1" style="width: 60%;">
                                <div class="w-2 h-2 rounded-full bg-white ml-auto"></div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-600 ml-4">60%</span>
                    </div>
                </div>
                <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                    <div class="flex justify-between mb-4">
                        <div>
                            <div class="flex items-center mb-1">
                                <div class="text-2xl font-semibold">324</div>
                                <div class="p-1 rounded bg-emerald-500/10 text-emerald-500 text-[12px] font-semibold leading-none ml-2">+30%</div>
                            </div>
                            <div class="text-sm font-medium text-gray-400">Visitors</div>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <img src="img/p1.jpg" alt="" class="w-8 h-8 rounded-full object-cover block">
                        <img src="img/p6.jpg" alt="" class="w-8 h-8 rounded-full object-cover block -ml-3">
                        <img src="img/p3.jpg" alt="" class="w-8 h-8 rounded-full object-cover block -ml-3">
                        <img src="img/p4.jpg" alt="" class="w-8 h-8 rounded-full object-cover block -ml-3">
                        <img src="img/p5.jpg" alt="" class="w-8 h-8 rounded-full object-cover block -ml-3">
                        <span class="text-lg font-medium text-gray-600 ml-4">...</span>
                    </div>
                </div>
                <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                    <div class="flex justify-between mb-6">
                        <div>
                            <div class="text-2xl font-semibold mb-1"><span class="text-base font-normal text-gray-400 align-top"></span>2,345</div>
                            <div class="text-sm font-medium text-gray-400">Emails</div>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
                    <div class="flex justify-between mb-4 items-start">
                        <div class="font-medium">Board Members</div>
                        <div class="dropdown">
                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[540px]" data-tab-for="order" data-page="active">
                            <thead>
                                <tr>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">Name</th>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Department</th>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Job Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">John Doe</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Advisory</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Chairman</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Jane Lee</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Administrative</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Administrative Officer</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Alexa Smith</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Communications & IT</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Communications Officer</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Christian Tello</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Programme Management</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Programme Director</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Robert Smith</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Human Resource</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Chief HR Officer</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Joey Almond</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Finance</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Finance Manager</span>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                       
                    </div>
                </div>
                <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
                    <div class="flex justify-between mb-4 items-start">
                        <div class="font-medium">Organization Staffs</div>
                        <div class="dropdown">
                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <form action="" class="flex items-center mb-4">
                        <div class="relative w-full mr-2">
                            <input type="text" class="py-2 pr-4 pl-10 bg-gray-50 w-full outline-none border border-gray-100 rounded-md text-sm focus:border-blue-500" placeholder="Search...">
                            <i class="ri-search-line absolute top-1/2 left-4 -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <select class="text-sm py-2 pl-4 pr-10 bg-gray-50 border border-gray-100 rounded-md focus:border-blue-500 outline-none appearance-none bg-select-arrow bg-no-repeat bg-[length:16px_16px] bg-[right_16px_center]">
                            <option value="">All</option>
                        </select>
                    </form>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[540px]">
                            <thead>
                                <tr>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">Name</th>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Department</th>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Job Title</th>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Lily Wood</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Adminitrative</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Assistant Manager</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="dropdown">
                                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i class="ri-more-2-fill"></i></button>
                                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Avery John</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Administrative</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Coordinator</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="dropdown">
                                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i class="ri-more-2-fill"></i></button>
                                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Tomas Gray</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Communications & IT</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Community Organizer</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="dropdown">
                                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i class="ri-more-2-fill"></i></button>
                                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Everett Rose</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Human Resource</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Recruiter</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="dropdown">
                                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i class="ri-more-2-fill"></i></button>
                                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Pamela Red</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Finance</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-400">Coordinator</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="dropdown">
                                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600 text-sm w-6 h-6 rounded flex items-center justify-center bg-gray-50"><i class="ri-more-2-fill"></i></button>
                                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md lg:col-span-2">
                    <div class="flex justify-between mb-4 items-start">
                        <div class="font-medium">Programme Statistics</div>
                        <div class="dropdown">
                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div class="rounded-md border border-dashed border-gray-200 p-4">
                            <div class="flex items-center mb-0.5">
                                <div class="text-xl font-semibold">10</div>
                                
                            </div>
                            <span class="text-gray-400 text-sm">Active</span>
                        </div>
                        <div class="rounded-md border border-dashed border-gray-200 p-4">
                            <div class="flex items-center mb-0.5">
                                <div class="text-xl font-semibold">50</div>
                                
                            </div>
                            <span class="text-gray-400 text-sm">Completed</span>
                        </div>
                        <div class="rounded-md border border-dashed border-gray-200 p-4">
                            <div class="flex items-center mb-0.5">
                                <div class="text-xl font-semibold">4</div>
                                
                            </div>
                            <span class="text-gray-400 text-sm">Canceled</span>
                        </div>
                    </div>
                    <div>
                        <canvas id="order-chart"></canvas>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 shadow-md shadow-black/5 col-span-2 p-6 rounded-md">
                    <div class="flex justify-between mb-4 items-start">
                        <div class="font-medium">Programmes</div>
                        <div class="dropdown">
                            <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[460px]">
                            <thead>
                                <tr>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">Title</th>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Location</th>
                                    <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 1</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Chattogram</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 2</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Barishal</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 3</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Sylhet</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-blue-500/10 text-blue-500 font-medium text-[12px] leading-none">Active</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 4</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Dhaka</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 5</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Narayanganj</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 6</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Jessore</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-blue-500/10 text-blue-500 font-medium text-[12px] leading-none">Active</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 7</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Bandarban</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 8</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Rajshahi</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none">Canceled</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <div class="flex items-center">
                                            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                            <a href="#" class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">Programme 9</a>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="text-[13px] font-medium text-gray-600">Rangpur</span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-b-gray-50">
                                        <span class="inline-block p-1 rounded bg-blue-500/10 text-blue-500 font-medium text-[12px] leading-none">Active</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- end: Main -->

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="dist/js/script.js"></script>
    
</body>
</html>


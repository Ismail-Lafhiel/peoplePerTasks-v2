<?php
include_once("../resources/session.php");
$no_hover = "class='flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group'";
?>
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button" id="sidebar-toggle-button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg smXl:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>

                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>

                <a href="../pages/index.php" class="flex ml-2 md:mr-24  items-center">
                    <img src="../../images/logo.webp" class="h-8 mr-6" alt="peoplepertask Logo">
                    <span class="font-inter font-semibold dark:text-white">PeaplePerTask</span>
                </a>
            </div>

            <div class="flex items-center">
                <div class="flex relative items-center ml-3">
                    <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 w-10"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-10 h-10 rounded-full" src="../../images/avatar.jpg" alt="user photo">
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">
                                <?php echo $_SESSION['username']; ?>
                            </span>
                            <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">
                                <?php echo $_SESSION['email']; ?>
                            </span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="../pages/dashboard.php"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                            </li>
                            <li>
                                <a href="../pages/logout.php"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                                    out</a>
                            </li>
                        </ul>
                    </div>
                    <button aria-label="theme toggle" id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 ml-5 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 dark:text-gray-200" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full  bg-white border-r border-gray-200 smXl:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <?php if($_SESSION["user_type"] == "admin"){ ?>
            <li>
                <a href="../pages/dashboard.php" <?php if (isset($dashboard_hover))
                    echo $dashboard_hover;
                else {
                    echo $no_hover;
                }
                ?>>
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 6.27737C2 6.0311 2.12534 5.80007 2.33638 5.65735L7.53638 2.14078C7.81395 1.95307 8.18605 1.95307 8.46362 2.14078L13.6636 5.65735C13.8747 5.80007 14 6.0311 14 6.27737V12.8588C14 13.4891 13.4627 14 12.8 14H3.2C2.53726 14 2 13.4891 2 12.8588V6.27737Z"
                            stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span class="ml-3 font-inter">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../pages/users.php" <?php if (isset($users_hover))
                    echo $users_hover;
                else {
                    echo $no_hover;
                }
                ?>>
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2.15845 13C3.04205 11.5262 4.97863 10.5175 7.99996 10.5175C11.0213 10.5175 12.9579 11.5262 13.8415 13M10.4 5.4C10.4 6.72548 9.32545 7.8 7.99996 7.8C6.67448 7.8 5.59996 6.72548 5.59996 5.4C5.59996 4.07452 6.67448 3 7.99996 3C9.32545 3 10.4 4.07452 10.4 5.4Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <span class="ml-3 font-inter">Users</span>
                </a>
            </li>

            <li>
                <a href="../pages/freelancers.php" <?php if (isset($freelancers_hover))
                    echo $freelancers_hover;
                else {
                    echo $no_hover;
                }
                ?>>
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2.15845 13C3.04205 11.5262 4.97863 10.5175 7.99996 10.5175C11.0213 10.5175 12.9579 11.5262 13.8415 13M10.4 5.4C10.4 6.72548 9.32545 7.8 7.99996 7.8C6.67448 7.8 5.59996 6.72548 5.59996 5.4C5.59996 4.07452 6.67448 3 7.99996 3C9.32545 3 10.4 4.07452 10.4 5.4Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>

                    <span class="flex-1 ml-3 whitespace-nowrap font-inter">Freelancers</span>
                </a>
            </li>

            <li>
                <a href="../pages/projects.php" <?php if (isset($projects_hover))
                    echo $projects_hover;
                else {
                    echo $no_hover;
                }
                ?>>

                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-gray-400 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 9.5H5L6 10.55H10L11 9.5H14M3.5 14C2.67157 14 2 13.3284 2 12.5V3.5C2 2.67157 2.67157 2 3.5 2H12.5C13.3284 2 14 2.67157 14 3.5V12.5C14 13.3284 13.3284 14 12.5 14H3.5Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <span class="flex-1 ml-3 whitespace-nowrap font-inter">Projects</span>
                </a>
            </li>

            <li>
                <a href="../pages/categories.php" <?php if (isset($categories_hover))
                    echo $categories_hover;
                else {
                    echo $no_hover;
                }
                ?>>
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.4003 4.19996L1.60068 4.19978L1.59985 4.2M14.4003 4.19996L14.3999 13.0773C14.3999 13.9183 13.7052 14.6 12.8483 14.6H3.15137C2.29449 14.6 1.59985 13.9183 1.59985 13.0773V4.2M14.4003 4.19996L11.8342 1.63431C11.6841 1.48429 11.4807 1.4 11.2685 1.4H4.73122C4.51905 1.4 4.31557 1.48428 4.16554 1.63431L1.59985 4.2M10.3999 6.6C10.3999 7.92548 9.32534 9 7.99985 9C6.67437 9 5.59985 7.92548 5.59985 6.6"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>



                    <span class="flex-1 ml-3 whitespace-nowrap font-inter">Categories</span>
                </a>
            </li>
            <li>
                <a href="../pages/testemonials.php" <?php if (isset($testemonials_hover))
                    echo $testemonials_hover;
                else {
                    echo $no_hover;
                }
                ?>>
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.4003 4.19996L1.60068 4.19978L1.59985 4.2M14.4003 4.19996L14.3999 13.0773C14.3999 13.9183 13.7052 14.6 12.8483 14.6H3.15137C2.29449 14.6 1.59985 13.9183 1.59985 13.0773V4.2M14.4003 4.19996L11.8342 1.63431C11.6841 1.48429 11.4807 1.4 11.2685 1.4H4.73122C4.51905 1.4 4.31557 1.48428 4.16554 1.63431L1.59985 4.2M10.3999 6.6C10.3999 7.92548 9.32534 9 7.99985 9C6.67437 9 5.59985 7.92548 5.59985 6.6"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>



                    <span class="flex-1 ml-3 whitespace-nowrap font-inter">Testemonials</span>
                </a>
            </li>
            <li>
                <a href="../pages/logout.php"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap font-inter">Sign Out</span>
                </a>
            </li>
            <?php }else if($_SESSION["user_type"] == "freelancer"){ ?>
                <li>
                <a href="../pages/dashboard.php" <?php if (isset($dashboard_hover))
                    echo $dashboard_hover;
                else {
                    echo $no_hover;
                }
                ?>>
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 6.27737C2 6.0311 2.12534 5.80007 2.33638 5.65735L7.53638 2.14078C7.81395 1.95307 8.18605 1.95307 8.46362 2.14078L13.6636 5.65735C13.8747 5.80007 14 6.0311 14 6.27737V12.8588C14 13.4891 13.4627 14 12.8 14H3.2C2.53726 14 2 13.4891 2 12.8588V6.27737Z"
                            stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span class="ml-3 font-inter">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../pages/logout.php"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap font-inter">Sign Out</span>
                </a>
            </li>
            <?php }else{ ?>
                <li>
                <a href="../pages/dashboard.php" <?php if (isset($dashboard_hover))
                    echo $dashboard_hover;
                else {
                    echo $no_hover;
                }
                ?>>
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 6.27737C2 6.0311 2.12534 5.80007 2.33638 5.65735L7.53638 2.14078C7.81395 1.95307 8.18605 1.95307 8.46362 2.14078L13.6636 5.65735C13.8747 5.80007 14 6.0311 14 6.27737V12.8588C14 13.4891 13.4627 14 12.8 14H3.2C2.53726 14 2 13.4891 2 12.8588V6.27737Z"
                            stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span class="ml-3 font-inter">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../pages/projects.php" <?php if (isset($projects_hover))
                    echo $projects_hover;
                else {
                    echo $no_hover;
                }
                ?>>

                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-gray-400 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white"
                        width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 9.5H5L6 10.55H10L11 9.5H14M3.5 14C2.67157 14 2 13.3284 2 12.5V3.5C2 2.67157 2.67157 2 3.5 2H12.5C13.3284 2 14 2.67157 14 3.5V12.5C14 13.3284 13.3284 14 12.5 14H3.5Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <span class="flex-1 ml-3 whitespace-nowrap font-inter">Projects</span>
                </a>
            </li>
            <li>
                <a href="../pages/logout.php"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap font-inter">Sign Out</span>
                </a>
            </li>
            <?php } ?>

        </ul>
    </div>
</aside>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
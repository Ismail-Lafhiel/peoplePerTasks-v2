<!DOCTYPE html>
<html lang="en">
<?php
$title = "edit profile";
include("components/head.php");
?>
<style>
    :root {
        --main-color: #4a76a8;
    }

    .bg-main-color {
        background-color: var(--main-color);
    }

    .text-main-color {
        color: var(--main-color);
    }

    .border-main-color {
        border-color: var(--main-color);
    }
</style>
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

<body>
    <?php include("components/header.php");
    ?>
    <div class="bg-gray-100 dark:bg-gray-900 py-20">
        <div class="container mx-auto my-5 p-5">
            <div class="md:flex no-wrap md:-mx-2 ">
                <!-- Left Side -->
                <div class="w-full md:w-3/12 md:mx-2">
                    <!-- Profile Card -->
                    <div class="bg-white p-3 border-t-4 border-blue-400 dark:bg-gray-900">
                        <div class="image overflow-hidden">
                            <img class="h-auto w-full mx-auto rounded-full" src="../images/client2.jpg" alt="">
                        </div>
                        <h1 class="text-gray-900 font-bold text-xl leading-8 my-1 dark:text-gray-100">Jane Doe</h1>
                        <h3 class="text-gray-600 font-lg text-semibold leading-6 dark:text-gray-100">Owner at Her
                            Company Inc.</h3>
                        <p class="text-sm text-gray-500 hover:text-gray-600 leading-6 dark:text-gray-100">Lorem ipsum
                            dolor sit amet
                            consectetur adipisicing elit.
                            Reprehenderit, eligendi dolorum sequi illum qui unde aspernatur non deserunt</p>
                        <ul
                            class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm dark:bg-gray-900">
                            <li class="flex items-center py-3">
                                <span class="dark:text-gray-100">Status</span>
                                <span class="ml-auto"><span
                                        class="bg-blue-500 py-1 px-2 rounded text-white text-sm">Active</span></span>
                            </li>
                            <li class="flex items-center py-3">
                                <span class="dark:text-gray-100">Member since</span>
                                <span class="ml-auto dark:text-gray-100">Nov 07, 2016</span>
                            </li>
                        </ul>
                    </div>
                    <!-- End of profile card -->
                    <div class="my-4"></div>
                </div>
                <!-- Right Side -->
                <div class="w-full md:w-9/12 mx-2 h-64 dark:bg-gray-900">
                    <!-- Profile tab -->
                    <!-- About Section -->
                    <div class="bg-white p-3 shadow-sm rounded-sm dark:bg-gray-900">
                        <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                            <span clas="text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                    <path
                                        d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z" />
                                </svg>
                            </span>
                            <span class="tracking-wide dark:text-white dark:text-semibold">About</span>
                        </div>
                        <div class="text-gray-700">
                            <div class="grid md:grid-cols-2 text-sm">
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold dark:text-white">First Name</div>
                                    <div class="px-4 py-2 dark:text-gray-200">Jane</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold dark:text-white">Last Name</div>
                                    <div class="px-4 py-2 dark:text-gray-200">Doe</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold dark:text-white">Current Address</div>
                                    <div class="px-4 py-2 dark:text-gray-200">Beech Creek, PA, Pennsylvania</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold text-white">Email.</div>
                                    <div class="px-4 py-2">
                                        <a class="text-blue-800 dark:text-blue-600">jane@example.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button
                            class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4 dark:text-blue-600">
                            Edit Information</button>
                    </div>
                    <!-- End of about section -->

                    <div class="my-4"></div>

                    <!-- Experience and education -->
                    <div class="bg-white p-3 shadow-sm rounded-sm dark:bg-gray-900">

                        <div class="grid grid-cols-2 dark:bg-gray-900">
                            <div>
                                <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                    <span clas="text-blue-500">
                                        <svg viewBox="0 0 24 24" fill="none"
                                            class="h-5 stroke-white" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M6 1C4.34315 1 3 2.34315 3 4V20C3 21.6569 4.34315 23 6 23H18C19.6569 23 21 21.6569 21 20V8.82843C21 8.03278 20.6839 7.26972 20.1213 6.70711L15.2929 1.87868C14.7303 1.31607 13.9672 1 13.1716 1H6ZM5 4C5 3.44772 5.44772 3 6 3H12V8C12 9.10457 12.8954 10 14 10H19V20C19 20.5523 18.5523 21 18 21H6C5.44772 21 5 20.5523 5 20V4ZM18.5858 8L14 3.41421V8H18.5858Z"
                                                fill="#0F0F0F" />
                                        </svg>
                                    </span>
                                    <span class="tracking-wide dark:text-white">Experience</span>
                                </div>
                                <ul class="list-inside space-y-2">
                                    <li>
                                        <div class="text-blue-600">Owner at Her Company Inc.</div>
                                        <div class="text-gray-500 text-xs dark:text-gray-100">March 2020 - Now</div>
                                    </li>
                                    <li>
                                        <div class="text-blue-600">Owner at Her Company Inc.</div>
                                        <div class="text-gray-500 text-xs dark:text-gray-100">March 2020 - Now</div>
                                    </li>
                                    <li>
                                        <div class="text-blue-600">Owner at Her Company Inc.</div>
                                        <div class="text-gray-500 text-xs dark:text-gray-100">March 2020 - Now</div>
                                    </li>
                                    <li>
                                        <div class="text-blue-600">Owner at Her Company Inc.</div>
                                        <div class="text-gray-500 text-xs dark:text-gray-100">March 2020 - Now</div>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                    <span clas="text-blue-500">
                                        <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path fill="#fff" d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path fill="#fff"
                                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                        </svg>
                                    </span>
                                    <span class="tracking-wide dark:text-white">Education</span>
                                </div>
                                <ul class="list-inside space-y-2">
                                    <li>
                                        <div class="text-blue-600">Masters Degree in Oxford</div>
                                        <div class="text-gray-500 text-xs dark:text-gray-100">March 2020 - Now</div>
                                    </li>
                                    <li>
                                        <div class="text-blue-600">Bachelors Deblue in LPU</div>
                                        <div class="text-gray-500 text-xs dark:text-gray-100">March 2020 - Now</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End of Experience and education grid -->
                    </div>
                    <!-- End of profile tab -->
                </div>
            </div>
        </div>
    </div>
    <?php include_once('components/footer.php') ?>
    <?php include_once('components/darkmood.php') ?>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>

</html>
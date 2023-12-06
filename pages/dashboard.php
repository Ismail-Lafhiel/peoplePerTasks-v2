<?php
include_once("../resources/session.php");
if (isset($_SESSION["username"])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <?php
    $title = "Dashboard";
    include_once('components/adminHead.php');
    ?>

    <body class="dark:bg-gray-900">
        <?php
        $dashboard_hover = "class='flex items-center p-2 text-white rounded-lg bg-blue-600 dark:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 group'";
        include_once("components/adminSideBar.php");
        ?>
        <main class=" mt-14 p-12 ml-0 smXl:ml-64  dark:border-gray-700">
            <div class="cards flex flex-wrap justify-center tablet:justify-between gap-6 mb-12 ">
                <div
                    class="bg-white dark:bg-gray-800 card border border-[#D9D9DE] dark:border-gray-700 w-full max-w-[30rem]   tablet:max-w-[20rem] p-5 rounded-xl">
                    <div class="icon_container mb-9">
                        <span class="h-9 w-9 bg-[#CAFFF2] rounded-full flex justify-center
                    items-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.5 5.83333L10 1.66667L2.5 5.83333V14.1667L10 18.3333L17.5 14.1667V5.83333ZM10 12.7778C11.5943 12.7778 12.8868 11.5341 12.8868 10C12.8868 8.46588 11.5943 7.22222 10 7.22222C8.40569 7.22222 7.11325 8.46588 7.11325 10C7.11325 11.5341 8.40569 12.7778 10 12.7778Z"
                                    stroke="#00373E" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                    <div class="data_container flex justify-between">
                        <div class="left">
                            <p class="font-bold dark:text-gray-200 text-lg font-inter">32</p>
                            <p class="font-medium text-[#7F7D83] font-inter">Offer Posted</p>
                        </div>

                        <div
                            class="right pr-2 pl-2 bg-green-100 w-fit rounded-lg flex items-center border border-green-300">
                            <span class="text-green-800 font-inter text-xl">+5.6%</span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 card border border-[#D9D9DE] dark:border-gray-700 w-full max-w-[30rem]  tablet:max-w-[20rem] p-5 rounded-xl">
                    <div class="icon_container mb-9">
                        <span class="h-9 w-9 bg-[#FFD58F] rounded-full flex justify-center
                    items-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.5 5.83333L10 1.66667L2.5 5.83333V14.1667L10 18.3333L17.5 14.1667V5.83333ZM10 12.7778C11.5943 12.7778 12.8868 11.5341 12.8868 10C12.8868 8.46588 11.5943 7.22222 10 7.22222C8.40569 7.22222 7.11325 8.46588 7.11325 10C7.11325 11.5341 8.40569 12.7778 10 12.7778Z"
                                    stroke="#B27104" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>


                    <div class="data_container flex justify-between">
                        <div class="left">
                            <p class="font-bold dark:text-gray-200  text-lg font-inter">60</p>
                            <p class="font-medium text-[#7F7D83] font-inter">Active Freelancers</p>
                        </div>

                        <div class="right pr-2 pl-2 bg-red-100 w-fit rounded-lg flex items-center border border-red-300">
                            <span class="text-red-800 font-inter text-xl">-1.16%</span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 card border border-[#D9D9DE] dark:border-gray-700 w-full max-w-[30rem]  tablet:max-w-[20rem] p-5 rounded-xl">
                    <div class="icon_container mb-9">
                        <span class="h-9 w-9 bg-[#EBF1FD] rounded-full flex justify-center
                    items-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.5 5.83333L10 1.66667L2.5 5.83333V14.1667L10 18.3333L17.5 14.1667V5.83333ZM10 12.7778C11.5943 12.7778 12.8868 11.5341 12.8868 10C12.8868 8.46588 11.5943 7.22222 10 7.22222C8.40569 7.22222 7.11325 8.46588 7.11325 10C7.11325 11.5341 8.40569 12.7778 10 12.7778Z"
                                    stroke="#2080F6" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>


                    <div class="data_container flex justify-between">
                        <div class="left">
                            <p class="font-bold dark:text-gray-200  text-lg font-inter">325</p>
                            <p class="font-medium text-[#7F7D83] font-inter">Active Jobs</p>
                        </div>

                        <div
                            class="right pr-2 pl-2 bg-green-100 w-fit rounded-lg flex items-center border border-green-300">
                            <span class="text-green-800 font-inter text-xl">+10.05%</span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 card border border-[#D9D9DE] dark:border-gray-700 w-full max-w-[30rem]  tablet:max-w-[20rem] p-5 rounded-xl">
                    <div class="icon_container mb-9">
                        <span class="h-9 w-9  rounded-full flex justify-center
                    items-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.5 5.83333L10 1.66667L2.5 5.83333V14.1667L10 18.3333L17.5 14.1667V5.83333ZM10 12.7778C11.5943 12.7778 12.8868 11.5341 12.8868 10C12.8868 8.46588 11.5943 7.22222 10 7.22222C8.40569 7.22222 7.11325 8.46588 7.11325 10C7.11325 11.5341 8.40569 12.7778 10 12.7778Z"
                                    stroke="#802c98" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>


                    <div class="data_container  flex justify-between">
                        <div class="left">
                            <p class="font-bold dark:text-gray-200  text-lg font-inter">500</p>
                            <p class="font-medium text-[#7F7D83] font-inter">Job Delivered</p>
                        </div>

                        <div
                            class="right pr-2 pl-2 bg-green-100 w-fit rounded-lg flex items-center border border-green-300">
                            <span class="text-green-800 font-inter text-xl">+9.3%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white  dark:bg-gray-800 border border-[#D9D9DE] dark:border-gray-700 rounded-xl p-8 mb-12 ">
                <span class="text-[#00373E] dark:text-gray-200  font-inter font-semibold text-lg block mb-5">Popular
                    Categories of Jobs </span>
                <div class="h-[32rem] w-auto">
                    <canvas id="myChart"></canvas>
                </div>
            </div>

            <div class="flex flex-col gap-8">
                <div
                    class="flex-1  w-full  bg-white border dark:bg-gray-800 border-[#D9D9DE] dark:border-gray-700 rounded-xl  p-4 md:p-6">
                    <span class="text-[#00373E] dark:text-gray-200  font-inter font-semibold text-lg block mb-5">Income By
                        Countries</span>

                    <div class="h-[32rem] w-full">
                        <canvas id="bar-chart"></canvas>
                    </div>
                </div>

                <div
                    class="w-fit  bg-white border dark:bg-gray-800 border-[#D9D9DE] dark:border-gray-700 rounded-xl  p-4 md:p-6">
                    <span class="text-[#00373E] dark:text-gray-200  font-inter font-semibold text-lg block mb-5">Popular
                        locations of
                        Freelancers</span>
                    <div class="py-6" id="pie-chart"></div>
                </div>


            </div>

        </main>

        <script src="../js/dashboard.js"></script>
        <script src="../js/mood.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
    </body>
<?php
} else {
    header("Location: login.php");
}
?>
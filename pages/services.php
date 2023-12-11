<!DOCTYPE html>
<html lang="en">

<?php
require_once("./controllers/projectController.php");
$projects = show_projects($conn);
$title = "Services";
include_once('components/head.php');
$services_hover = "class='block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500'";
?>

<body>
  <?php include_once('components/header.php') ?>
  <div class="dark:bg-gray-900">
    <div>
      <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-24">
          <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">
            Find Freelance Jobs
          </h1>

        </div>
        <section aria-labelledby="products-heading" class="pb-24 pt-6">
          <form>
            <div class="flex">
              <button id="dropdown-button" data-dropdown-toggle="dropdown"
                class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                type="button">All categories <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
                </svg></button>
              <div id="dropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                  <li>
                    <button type="button"
                      class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mockups</button>
                  </li>
                  <li>
                    <button type="button"
                      class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Templates</button>
                  </li>
                  <li>
                    <button type="button"
                      class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Design</button>
                  </li>
                  <li>
                    <button type="button"
                      class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Logos</button>
                  </li>
                </ul>
              </div>
              <div class="relative w-full">
                <input type="search" id="search-bar"
                  class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                  placeholder="Search Mockups, Logos, Design Templates..." required>
                <button
                  class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                  </svg>
                  <span class="sr-only">Search</span>
                </button>
              </div>
            </div>
          </form>
          <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            <!-- services grid -->
            <div class="lg:col-span-3">
              <section class="text-gray-600 body-font">
                <div class="container px-5 py-24 mx-auto">
                  <div class="flex flex-wrap -m-4">
                    <?php foreach ($projects as $project): ?>
                      <div
                        class="lg:w-1/4 md:w-1/2 p-4 w-full ring-1 rounded-lg ring-gray-300 dark:ring-gray-700 bg-white dark:bg-gray-900">
                        <h3
                          class="text-gray-900 font-bold text-lg p-2 lg:p-4 lg:text-xl tracking-widest title-font mb-1 dark:text-white">
                          <a href="projects.php">
                            <?php echo $project['title'] ?>
                          </a>
                        </h3>
                        <p class="text-sm text-gray-400 pl-2 lg:pl-4">
                          Fixed-price - Posted
                          <?php echo $project['days'] ?> days ago
                        </p>
                        <ul class="pl-2 py-4 lg:pt-4 lg:py-6 flex gap-20">
                          <li>
                            <p class="inline-block mr-2 text-black font-semibold dark:text-white">
                              Posted By
                            </p>
                            <span class="text-sm pt-1 dark:text-gray-400">
                              <?php echo $project['username'] ?>
                            </span>
                          </li>
                        </ul>
                        <p class="text-gray-400 truncate pl-2 lg:pl-4">
                          <?php echo $project['description'] ?>
                        </p>
                        <div>
                          <ul class="pl-2 py-4 lg:pt-4 lg:py-10 flex gap-5">
                            <?php foreach ($project['tags'] as $tag): ?>
                              <li class="bg-blue-300 text-blue-600 rounded-3xl py-1.5 px-3 text-xs font-semibold">
                                <?php echo $tag; ?>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                          <div class="pl-2 py-4 lg:pt-4 lg:py-10">
                            <a href="project.php"
                              class="bg-blue-600 text-white rounded-3xl py-2 px-4 text-sm font-semibold">See more</a>
                            <?php if ($_SESSION['user_type'] == "freelancer") { ?>
                              <a href="offer.php"
                                class="bg-gray-200 text-blue-600 rounded-3xl py-2 px-4 text-sm font-semibold">Apply Now</a>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </section>
              <div class="flex">
                <!-- Previous Button -->
                <a href="#"
                  class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                  Previous
                </a>

                <!-- Next Button -->
                <a href="#"
                  class="flex items-center justify-center px-4 h-10 ml-3 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                  Next
                </a>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
  <?php include_once('components/footer.php') ?>
  <?php include_once('components/darkmood.php') ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
</body>

</html>
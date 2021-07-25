 <x-app-layout>
   <div class="filter flex space-x-6">
      <div class="w-1/3">
         <select name="category" id="category" class="w-full rounded-xl px-4 py-2 border-none">
            <option value="category-one">Category One</option>
            <option value="category-twp">Category Two</option>
            <option value="category-three">Category Three</option>
            <option value="category-four">Category Four</option>
         </select>
      </div>
      <div class="w-1/3">
         <select name="other-filters" id="other-filters" class="w-full rounded-xl px-4 py-2 border-none">
            <option value="filter-one">Filter One</option>
            <option value="filter-twp">Filter Two</option>
            <option value="filter-three">Filter Three</option>
            <option value="filter-four">Filter Four</option>
         </select>
      </div>
      <div class="w-2/3 relative">
         <div class="absolute top-0 flex items-center h-full ml-2">
            <svg class="w-4 text-gray-700 " class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
         </div>
         <input type="search" placeholder="Find an idea" class="w-full rounded-xl bg-white pl-8 border-none placeholder-gray-900">
      </div>
   </div>
   <div class="ideas-container space-y-6 my-6 ">
      <div class="idea-container bg-white rounded-xl flex hover:shadow-md transition duration-150 ease-in cursor-pointer">
         <div class="border-r border-gray-100 px-5 py-8">
            <div class="text-center">
               <div class="semibold text-2xl">12</div>
               <div class="text-gray-500">Votes</div>
               <div class="mt-8">
                  <button class="button w-20 bg-gray-200 font-bold text-xxs uppercase rounded-xl px-4 py-3 border-gray-200 hover:border-gray-400 transition duration-150 ease-in">Vote</button>
               </div>
            </div>
         </div>
         <div class="flex px-2 py-6">
            <a href="" class="flex-none">
               <img src=" https://source.unsplash.com/200x200/?face&crop=face&v=1" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
            <div class="mx-4">
               <h4 class="text-xl font-semibold">
                  <a href="#" class="hover:underline">A random title can go here</a>
               </h4>
               <div class="text-gray-600 mt-3 line-clamp-3">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur natus officiis rerum minus repellendus perferendis, at, veniam illo eveniet quo saepe dolor amet excepturi obcaecati praesentium possimus quia architecto impedit!
                  Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta impedit nulla debitis quae modi nihil optio earum quos, laboriosam repudiandae, quibusdam beatae obcaecati illum cumque, molestias perspiciatis minus veritatis officia!
               </div>
               <div class="flex items-center justify-between mt-6">
                  <div class="flex items-center text-xs font-semibold space-x-2 text-gray-400">
                     <div>10 hours ago</div>
                     <div>&bull;</div>
                     <div>Category 1</div>
                     <div>&bull;</div>
                     <div class="text-gray-900">Comments</div>
                  </div>
                  <div class="flex items-center  font-semibold space-x-2  ">
                     <div class="bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">
                     Open</div>
                     <button class="relative bg-gray-100 hover:bg-gray-200 rounded-full h-7 transition duration-150 ease-in py-2 px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                        <ul class="absolute w-44 font-semibold bg-white shadow-lg rounded-xl py-3 text-left ml-8">
                           <li><a href="#" class="hover:bg-gray-100 transition duration-150 ease-in px-5 py-3 block">Spam</a></li>
                           <li><a href="#" class="hover:bg-gray-100 transition duration-150 ease-in px-5 py-3 block">Delete</a></li>
                        </ul>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="idea-container bg-white rounded-xl flex hover:shadow-md transition duration-150 ease-in cursor-pointer">
         <div class="border-r border-gray-100 px-5 py-8">
            <div class="text-center">
               <div class="semibold text-2xl">32</div>
               <div class="text-gray-500">Votes</div>
               <div class="mt-8">
                  <button class="button w-20 bg-gray-200 font-bold text-xxs uppercase rounded-xl px-4 py-3 border-gray-200 hover:border-gray-400 transition duration-150 ease-in">Vote</button>
               </div>
            </div>
         </div>
         <div class="flex px-2 py-6">
            <a href="" class="flex-none">
               <img src=" https://source.unsplash.com/200x200/?face&crop=face&v=1" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
            <div class="mx-4">
               <h4 class="text-xl font-semibold">
                  <a href="#" class="hover:underline">A random title can go here</a>
               </h4>
               <div class="text-gray-600 mt-3 line-clamp-3">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur natus officiis rerum minus repellendus perferendis, at, veniam illo eveniet quo saepe dolor amet excepturi obcaecati praesentium possimus quia architecto impedit!
                  Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta impedit nulla debitis quae modi nihil optio earum quos, laboriosam repudiandae, quibusdam beatae obcaecati illum cumque, molestias perspiciatis minus veritatis officia!
               </div>
               <div class="flex items-center justify-between mt-6">
                  <div class="flex items-center text-xs font-semibold space-x-2 text-gray-400">
                     <div>10 hours ago</div>
                     <div>&bull;</div>
                     <div>Category 1</div>
                     <div>&bull;</div>
                     <div class="text-gray-900">Comments</div>
                  </div>
                  <div class="flex items-center font-semibold space-x-2  ">
                     <div class="bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">
                     Open</div>
                     <button class="relative bg-gray-100 hover:bg-gray-200 rounded-full h-7 transition duration-150 ease-in py-2 px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                        <ul class="absolute w-44 font-semibold bg-white shadow-lg rounded-xl py-3 text-left ml-8">
                           <li><a href="#" class="hover:bg-gray-100 transition duration-150 ease-in px-5 py-3 block">Spam</a></li>
                           <li><a href="#" class="hover:bg-gray-100 transition duration-150 ease-in px-5 py-3 block">Delete</a></li>
                        </ul>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>
  </x-app-layout>
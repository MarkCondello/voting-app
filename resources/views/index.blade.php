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
  </x-app-layout>
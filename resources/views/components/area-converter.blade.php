<style>
/* Custom Scrollbar */
.custom-scroll::-webkit-scrollbar {
  width: 6px;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background-color: #05ede3;
  border-radius: 3px;
}
.custom-scroll::-webkit-scrollbar-track {
  background: #f0f0f0;
}

/* Enhanced Unit Item Styles */
.unit-item {
  padding: 10px 14px;
  font-size: 15px;
  color: #1f2937;
  background-color: #ffffff;
  border: 1px solid transparent;
  border-radius: 6px;
  margin-bottom: 6px;
  cursor: pointer;
  user-select: none;
  transition: all 0.25s ease-in-out;
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Hover effect */
.unit-item:hover {
  background-color: #e0fdfa; /* subtle teal bg */
  color: #0d9488;
  border-color: #a7f3d0; /* light teal border */
  transform: scale(1.02);
  box-shadow: 0 1px 4px rgba(13, 148, 136, 0.2);
}

/* Selected item */
.unit-item.bg-teal-200 {
  background-color: #05ede3 !important;
  color: #ffffff !important;
  font-weight: 600;
  border-color: #05ede3;
  box-shadow: 0 0 0 2px #05ede3;
}
</style>



<!-- Area Converter Modal UI -->
<div id="areaConverterModal" class="fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center hidden" role="dialog" aria-modal="true">
  <div id="areaConverterContent" class="transform scale-95 transition-all duration-300 ease-in-out bg-white w-full max-w-2xl mx-4 p-8 rounded-2xl shadow-2xl relative border-t-8 border-[#05ede3]">
    
    <button id="closeAreaConverterBtn" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">&times;</button>

    <h2 class="text-xl font-bold text-gray-800 mb-4">
      🏗️ Area Converter
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
      <div>
        <label for="areaValue" class="block text-sm font-semibold text-gray-700 mb-1">📊 Enter Value</label>
        <input id="areaValue" type="number" min="0" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" autofocus/>
      </div>

 <!-- From Unit -->
<div>
  <label class="block text-sm font-semibold text-gray-700 mb-1">📤 From Unit</label>
  <div id="fromUnitWrapper" class="w-full border rounded-md px-3 py-2 overflow-y-auto max-h-40 focus:outline-none focus:ring-2 focus:ring-teal-400 hover:bg-gray-100 cursor-pointer custom-scroll space-y-1">
    <!-- Units will be populated here -->
  </div>
</div>

<!-- To Unit -->
<div>
  <label class="block text-sm font-semibold text-gray-700 mb-1">📥 To Unit</label>
  <div id="toUnitWrapper" class="w-full border rounded-md px-3 py-2 overflow-y-auto max-h-40 focus:outline-none focus:ring-2 focus:ring-teal-400 hover:bg-gray-100 cursor-pointer custom-scroll space-y-1">
    <!-- Units will be populated here -->
  </div>
</div>

    <!-- Result Output -->
<!-- Full width Result Output -->
<div id="conversionResult" class="md:col-span-3 mt-8 text-center bg-customPrimary text-white py-4 px-6 rounded-lg shadow-inner w-full">
  <p class='text-sm text-gray-300 mb-2'>0 Bigha =</p>
  <div class='text-3xl font-bold text-orange-400 mt-1'>0 Cent</div>
  <span class="text-yellow-300"></span>
  <p id="unitNote" class="text-sm text-teal-700 mt-4 text-center">
    💡1 Bigha = 20.1614 Biswa in <strong class="text-teal-700">Uttar Pradesh</strong>
  </p>
</div>
    <!-- <span class="text-xs text-gray-400 text-center w-full">
        *This tool is for informational puproses only.
      </span> -->
  </div>
</div>
 <!-- Home Budget Calculator Modal -->
  <div id="calculatorModal"
    class="hidden fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8 relative border-t-8 border-[#05ede3]">
      
      <!-- Close Button -->
      <button id="closeCalculatorBtn"
        class="absolute top-4 right-5 text-black hover:text-red-500 text-3xl font-bold">
        &times;
      </button>

      <!-- Header -->
      <div class="text-center mb-6">
        <p class="text-2xl font-extrabold text-black mb-1">Home Buying Budget Calculator</p>
        <p class="text-sm text-gray-500">Get an estimate of how much home you can afford</p>
      </div>

      <!-- Form Fields -->
      <div class="space-y-6">

        <!-- Savings -->
        <div>
        <div class="flex justify-between items-center mb-1">
            <label class="text-sm font-semibold text-black">Savings for buying home</label>
            <div class="text-sm bg-green-50 text-green-600 font-bold rounded px-3 py-1">₹
            <input type="number" id="savings" min="0" step="10000" value="2800000"
                class="bg-transparent text-right w-24 outline-none" />
            </div>
        </div>
        
        <input type="range" id="savings-slider" min="0" max="20000000" step="100000" value="2800000"
            class="mt-4 w-full accent-[#05ede3]">
        
        <div class="mt-1 text-sm text-[#05ede3] font-medium hidden">₹<span id="savings-value">28,00,000</span></div>
        </div>


        <!-- EMI -->
<!-- EMI -->
<div>
  <div class="flex justify-between items-center mb-1">
    <label class="text-sm font-semibold text-black">EMI you can afford</label>
    <div class="text-sm bg-green-50 text-green-600 font-bold rounded px-3 py-1">₹
      <input type="number" id="emi" min="1000" step="100" value="30000"
        class="bg-transparent text-right w-24 outline-none" />
    </div>
  </div>

  <input type="range" id="emi-slider" min="1000" max="1000000" step="1000" value="30000"
    class="mt-4 w-full accent-[#05ede3]">

  <div class="mt-1 text-sm text-[#05ede3] font-medium hidden">₹<span id="emi-value">30,000</span></div>
</div>


        <!-- Tenure -->
<!-- Tenure -->
<div>
  <div class="flex justify-between items-center mb-1">
    <label class="text-sm font-semibold text-black">Preferred loan tenure (Years)</label>
    <div class="text-sm bg-green-50 text-green-600 font-bold rounded px-3 py-1">
      <input type="number" id="tenure" min="1" max="30" value="10"
        class="bg-transparent text-right w-16 outline-none" /> Yrs
    </div>
  </div>

  <input type="range" id="tenure-slider" min="1" max="30" step="1" value="10"
    class="mt-4 w-full accent-[#05ede3]">

  <div class="mt-1 text-sm text-[#05ede3] font-medium hidden"><span id="tenure-value">10</span> Years</div>
</div>


      </div>

      <!-- Result -->
      <div class="mt-8 text-center bg-black text-white py-4 px-6 rounded-lg shadow-inner">
        <p class="text-lg font-semibold">Estimated Home Budget</p>
        <p id="budget-range" class="text-3xl font-bold text-orange-400 mt-1">0</p>
        <p id="budget-words" class="text-xs mt-2 text-gray-200 italic min-h-[35px] sm:min-h-0"></p>
        <p class="text-xs mt-1 text-gray-300">*Based on average interest rate of 9.75%</p>
      </div>
</div>
</div>
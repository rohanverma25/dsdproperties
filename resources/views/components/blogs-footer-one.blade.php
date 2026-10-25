   <!-- Disclaimer-->
         <p class="rounded p-3 kc-disc-bg mb-5 mt-5 bg-[#F8F8FF] leading-[1.0]"><small>Disclaimer: The information on this website is shared for general awareness about property and real estate, collected from various reports and news sources. While we strive to provide accurate and updated details, we do not guarantee the completeness, accuracy, or reliability of the content. We are not responsible for any financial, legal, or property-related decisions made based on this information. For accurate details, please verify with the concerned authorities before proceeding.</small></p>
         
         
        <div class="max-w-xxl mx-auto bg-white border rounded-2xl shadow-sm p-6 flex flex-col sm:flex-row items-start gap-4">
        <!-- <img src="{{asset('author/Aarav.png')}}" alt="Author" class="w-16 h-16 rounded-full object-cover"> -->
        <!-- Content -->
        <div class="flex-1">
            <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">
                {{$author['name']}} <span class="text-gray-500 text-sm font-normal">, AUTHOR</span>
            </h3>
            </div>
            <!-- Bio -->
            <p class="text-gray-700 mt-2 text-sm leading-relaxed">
              {{$author['description'];}}
            <!-- Aarav is a real estate analyst with 7+ years of experience in property research. He provides data-driven insights to help buyers and investors make smart decisions. -->
            </p>
        </div>
</div>
<div class="max-w-xxl mx-auto bg-white border rounded-2xl shadow-sm p-6 flex flex-col gap-4 mt-6">
  <form action="#" method="POST" id="comment_form" name="comment_form" class="space-y-4">
    
    <!-- Comment Textarea -->
    <textarea 
      name="comment" 
      rows="4" 
      placeholder="Your comment*"
      class="w-full border rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
       min="3" max="200"  required></textarea>

    <!-- Name, Email & Button -->
    <div class="flex flex-col sm:flex-row gap-3">
      <input 
        type="text" 
        name="name" 
        placeholder="Name*"
        class="flex-1 border rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        required>

      <input 
        type="email" 
        name="email" 
        placeholder="Email id*"
        class="flex-1 border rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        required>

      <button 
        type="submit" 
        class="bg-customPrimary text-white font-medium rounded-lg px-5 py-3 hover:bg-blue-700 transition">
        Post a comment
      </button>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const comment_form = document.getElementById("comment_form");
        comment_form.addEventListener("submit", function (e) {
            e.preventDefault();
            alert("Thank you for your comment. Your submission has been received and is currently under review.");
            this.reset();
        });
    });
        </script>
  </form>
  </div>

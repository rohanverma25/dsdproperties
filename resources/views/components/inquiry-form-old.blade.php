<div class="bg-card rounded-xl card-shadow p-6"style="background-color: var(--color-light-teal);">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-2">Let's Talk Solutions</h2>
        <p class="text-sm">
            Provide your details, and our property specialist will connect with you within 24 hours
        </p>
    </div>
    
    <div id="ebook-form-container">
        <form id="ebook-form" method="POST" action="{{ route('inquiry.submit') }}" class="space-y-4">
            @csrf
            <div>
                <input type="text" name="full_name" placeholder="Full Name*" required
                       class="w-full px-4 py-3 border rounded-lg form-input">
            </div>
            <div>
                <input type="tel" name="phone_number" placeholder="Phone Number*" required
                       class="w-full px-4 py-3 border rounded-lg form-input">
            </div>
            <div>
                <input type="email" name="email" placeholder="Email*" required
                       class="w-full px-4 py-3 border rounded-lg form-input">
            </div>
            <!-- <div>
                <select name="property_type" class="w-full px-4 py-3 border rounded-lg form-input">
                    <option value="">Property Type (Optional)</option>
                    <option value="residential">Residential</option>
                    <option value="commercial">Commercial</option>
                    <option value="plot">Plot/Land</option>
                    <option value="investment">Investment Property</option>
                </select>
            </div> -->
            <div>
                <textarea name="message" placeholder="Your Message*" rows="3"
                          class="w-full px-4 py-3 border rounded-lg form-input" required></textarea>
            </div>
            <button type="submit"
                    class="w-full bg-accent hover:bg-orange-700 bg-orange-600 text-white py-3 rounded-lg font-semibold transition">
                Consult with a Property Expert
            </button>
            <p class="text-xs mt-2" style="color: var(--text-tertiary);">
                This site is protected by reCAPTCHA and the Google
                <a href="https://policies.google.com/privacy" class="underline">Privacy Policy</a> and
                <a href="https://policies.google.com/terms" class="underline">Terms of Service</a> apply.
            </p>
        </form>
    </div>
    
    <!-- Hidden success message -->
    <div id="success-message" class="hidden text-center p-6">
        <div class="text-green-500 text-5xl mb-4">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 class="text-3xl font-bold mb-2">Thank You!</h2>
        <p class="mb-4">One of our property experts will connect with you shortly.</p>
        <button id="reset-form" class="text-accent hover:underline">
            Submit another inquiry
        </button>
    </div>
    
    <!-- Loading indicator -->
<div id="loading-indicator" class="hidden text-center p-6">
    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2" style="border-top-color: #011f4b; border-bottom-color: #011f4b;"></div>
    <p class="mt-2 text-gray-900 font-medium">Submitting your inquiry...</p>
</div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("ebook-form");
    const formContainer = document.getElementById("ebook-form-container");
    const successMessage = document.getElementById("success-message");
    const loadingIndicator = document.getElementById("loading-indicator");
    const resetButton = document.getElementById("reset-form");
    
    // Reset form when reset button is clicked
    resetButton.addEventListener("click", function() {
        form.reset();
        successMessage.classList.add("hidden");
        formContainer.classList.remove("hidden");
    });
    
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        
        // Clear all previous errors
        form.querySelectorAll(".error-message").forEach(el => el.remove());
        
        const nameInput = form.full_name;
        const phoneInput = form.phone_number;
        const emailInput = form.email;
        const name = nameInput.value.trim();
        const phone = phoneInput.value.trim();
        const email = emailInput.value.trim();
        let hasError = false;
        
        // Helper: Show error message
        const showError = (input, message) => {
            const error = document.createElement("div");
            error.className = "error-message text-red-500 text-sm mt-1";
            error.textContent = message;
            input.insertAdjacentElement("afterend", error);
            hasError = true;
            input.classList.add("border-red-500");
        };
        
        // Helper: Remove error styling
        const removeErrorStyling = (input) => {
            input.classList.remove("border-red-500");
        };
        
        // Name validation
        if (!name) {
            showError(nameInput, "Name Field is required.");
        } else if (name.length < 2) {
            showError(nameInput, "Name must be at least 2 characters.");
        } else {
            removeErrorStyling(nameInput);
        }
        
        // Phone validation
        if (!phone) {
            showError(phoneInput, "Phone Field is required.");
        } else if (!/^\d{10,}$/.test(phone.replace(/\s/g, ''))) {
            showError(phoneInput, "Phone must be at least 10 digits.");
        } else {
            removeErrorStyling(phoneInput);
        }
        
        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            showError(emailInput, "Email Field is required.");
        } else if (!emailPattern.test(email)) {
            showError(emailInput, "Please enter a valid email.");
        } else {
            removeErrorStyling(emailInput);
        }
        
        if (hasError) return;
        
        // Show loading indicator
        formContainer.classList.add("hidden");
        loadingIndicator.classList.remove("hidden");
        
        // Submit via AJAX
   const formData = new FormData(form);

        // Add current page URL
        formData.append("page_url", window.location.href);

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                "Accept": "application/json"
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            loadingIndicator.classList.add("hidden");
            
            if (data.success) {
                successMessage.classList.remove("hidden");
                // Track conversion if analytics is available
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'conversion', {
                        'send_to': 'AW-CONVERSION_ID/CONVERSION_LABEL',
                        'event_category': 'form',
                        'event_label': 'property_inquiry'
                    });
                }
            } else {
                // Show server validation errors if any
                if (data.errors) {
                    formContainer.classList.remove("hidden");
                    Object.entries(data.errors).forEach(([field, messages]) => {
                        const input = form[field];
                        if (input) {
                            showError(input, messages[0]);
                        }
                    });
                } else {
                    alert("There was an error. Please try again.");
                    formContainer.classList.remove("hidden");
                }
            }
        })
        .catch(error => {
            console.error("Submission failed:", error);
            loadingIndicator.classList.add("hidden");
            formContainer.classList.remove("hidden");
            alert("Submission failed. Please check your connection and try again.");
        });
    });
});
</script>
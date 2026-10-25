<style>
/* WhatsApp Button Styles - Separate File */
/* This file contains only styles for the WhatsApp button to avoid conflicts */

/* WhatsApp Button Base Styles */
.whatsapp-btn-container .whatsapp-button {
    background-color: #3b82f6;
    color: #f9fafb;
    font-weight: 600;
    padding: 0.75rem 1.25rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    border: none;
    text-decoration: none;
    position: relative;
    overflow: hidden;
    z-index: 10;
    border-radius: 0.5rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.whatsapp-btn-container .whatsapp-button:hover {
    background: linear-gradient(to right, #3b82f6, #14b8a6);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
}

.whatsapp-btn-container .whatsapp-button:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.whatsapp-btn-container .whatsapp-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}

.whatsapp-btn-container .whatsapp-button:hover::before {
    transform: translateX(0);
}

/* Floating Button Styles */
.whatsapp-btn-container .whatsapp-button.floating {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    padding: 0;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
}

.whatsapp-btn-container .whatsapp-button.floating span {
    display: none;
}

.whatsapp-btn-container .whatsapp-button.floating svg {
    margin: 0;
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .whatsapp-btn-container .whatsapp-button {
        background-color: #3b82f6;
        color: #f9fafb;
    }
    
    .whatsapp-btn-container .whatsapp-button:hover {
        background: linear-gradient(to right, #3b82f6, #14b8a6);
    }
}

/* Explicit Dark Mode Class */
.dark .whatsapp-btn-container .whatsapp-button {
    background-color: #3b82f6;
    color: #f9fafb;
}

.dark .whatsapp-btn-container .whatsapp-button:hover {
    background: linear-gradient(to right, #3b82f6, #14b8a6);
}

/* Light Mode Class */
.light .whatsapp-btn-container .whatsapp-button {
    background-color: #3b82f6;
    color: white;
}

.light .whatsapp-btn-container .whatsapp-button:hover {
    background: linear-gradient(to right, #3b82f6, #14b8a6);
}
</style>

@props([
    'phone' => '918595002933',
    'url' => request()->getRequestUri()
])

@php
    $encodedMessage = urlencode("Hello, I have a query about your services." . PHP_EOL . "Page: " . $url);
    $whatsappUrl = "https://wa.me/{$phone}?text={$encodedMessage}";
@endphp

<div class="whatsapp-btn-container">
    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
       class="whatsapp-button {{ $attributes['class'] ?? '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
             class="w-5 h-5 mr-2" aria-hidden="true">
            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
        </svg>
        <span>{{ $slot ?? 'WhatsApp Us' }}</span>
    </a>
</div>
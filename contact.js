// Check for form submission status
window.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    
    if (status === 'success') {
        showMessage('Thank you! Your message has been sent successfully. I will get back to you soon!', 'success');
        // Clear URL parameters
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (status === 'error') {
        showMessage('Oops! There was an error sending your message. Please try again or email me directly.', 'error');
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (status === 'validation_error') {
        showMessage('Please fill in all required fields correctly.', 'error');
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `form-message ${type}`;
    messageDiv.textContent = message;
    
    const form = document.querySelector('.contact-form-container');
    if (form) {
        form.insertBefore(messageDiv, form.firstChild);
        
        // Auto-remove message after 5 seconds
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
}
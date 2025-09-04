// This file can contain general, site-wide functions like setting the date.

// Set minimum date to today
function setMinDate() {
    const today = new Date().toISOString().split('T')[0];
    const dateField = document.getElementById('dateField');
    if (dateField) {
        dateField.setAttribute('min', today);
        dateField.value = today;
    }
}

// Add event listeners when the DOM is fully loaded.
document.addEventListener('DOMContentLoaded', function() {
    setMinDate();
    
    // Add event listeners to clear errors on user input for search form
    const fromField = document.getElementById('fromField');
    const toField = document.getElementById('toField');

    if (fromField) {
        fromField.addEventListener('input', clearAllErrors);
    }
    if (toField) {
        toField.addEventListener('input', clearAllErrors);
    }
});
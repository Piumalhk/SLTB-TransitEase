let allLocations = [];

// Load all locations on page load from a separate source or hardcoded list
async function loadAllLocations() {
    try {
        // In a real application, this would be an AJAX call to a PHP script:
        // const response = await fetch('/bus-reservation-system/public/get_locations.php');
        // const result = await response.json();
        
        // Placeholder for testing
        const result = {
            status: 'success',
            data: ['Colombo', 'Kandy', 'Galle', 'Jaffna', 'Anuradhapura', 'Matara', 'Kurunegala', 'Ratnapura']
        };

        if (result.status === 'success') {
            allLocations = result.data;
            console.log('Locations loaded:', allLocations.length);
        } else {
            console.error('Error loading locations:', result.message);
        }
    } catch (error) {
        console.error('Error fetching locations:', error);
    }
}

// Show suggestions based on input
function showSuggestions(input, suggestionsId) {
    const value = input.value.toLowerCase();
    const suggestionsDiv = document.getElementById(suggestionsId);
    
    if (value.length === 0) {
        suggestionsDiv.style.display = 'none';
        return;
    }
    
    if (allLocations.length === 0) {
        suggestionsDiv.innerHTML = '<div class="suggestion-item">Loading locations...</div>';
        suggestionsDiv.style.display = 'block';
        return;
    }
    
    const filteredLocations = allLocations.filter(location => 
        location.toLowerCase().startsWith(value)
    );
    
    if (filteredLocations.length === 0) {
        suggestionsDiv.innerHTML = '<div class="suggestion-item">No matching locations found</div>';
        suggestionsDiv.style.display = 'block';
        return;
    }
    
    let html = '';
    filteredLocations.slice(0, 10).forEach(location => {
        html += `<div class="suggestion-item" onmousedown="selectLocation('${location}', '${input.id}', '${suggestionsId}')">${location}</div>`;
    });
    
    suggestionsDiv.innerHTML = html;
    suggestionsDiv.style.display = 'block';
}

// Select a location from suggestions
function selectLocation(location, inputId, suggestionsId) {
    document.getElementById(inputId).value = location;
    document.getElementById(suggestionsId).style.display = 'none';
    clearAllErrors();
}

// Hide suggestions with delay to allow for click
function hideSuggestions(suggestionsId) {
    setTimeout(() => {
        document.getElementById(suggestionsId).style.display = 'none';
    }, 200);
}

// Clear all error messages
function clearAllErrors() {
    const errorDivs = document.querySelectorAll('.error-message');
    errorDivs.forEach(el => el.remove());
}

// Show error message
function showError(fieldId, message) {
    clearAllErrors();
    const field = document.getElementById(fieldId);
    const fieldContainer = field.parentNode;
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    fieldContainer.style.position = 'relative';
    fieldContainer.appendChild(errorDiv);
    
    setTimeout(() => {
        if (errorDiv.parentNode) {
            errorDiv.remove();
        }
    }, 8000);
}
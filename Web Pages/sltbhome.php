<?php
// sltbhome.php - Converted from sltbhome.html
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase</title>
    <link rel="stylesheet" href="sltbhome.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<style>
.suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ccc;
    border-top: none;
    border-radius: 0 0 4px 4px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1002;
    display: none;
    width: 70%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.suggestion-item {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
}

.suggestion-item:hover {
    background-color: #f0f0f0;
}

.suggestion-item:last-child {
    border-bottom: none;
}

.error-message {
    color: #dc3545;
    font-size: 11px;
    font-weight: bold;
    margin-top: 2px;
    display: none;
    text-align: right;
    width: 250px;
    position: absolute;
    top: 35px;
    right: -130px;
    background: #f8d7da;
    padding: 8px;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
    z-index: 1001;
    box-shadow: 0 2px 5px rgba(220,53,69,0.2);
    word-wrap: break-word;
    line-height: 1.3;
}
</style>

</head>
<body>
    <div class="header">
        <div class="header-main" >
            <form >
                <div class="language">
                <select name="language" id="language">
                  <option value="volvo">Sinhala</option>
                  <option value="saab">English</option>
                </select>
            </div>
              </form>        <img src="nee.png" alt="Logo" width="100" style="position: absolute;  right: 80%; transform: translateX(-50%);">
        <button class="admin-button" style="position: absolute;  left: 87.5%; transform: translateX(-50%);" onclick="window.location.href='adminlogin.php'">ADMIN LOGIN</button>
        <img src="kisspng-computer-icons-login-management-user-5ae155f3386149.6695613615247170432309-removebg-preview.png" alt="Ad Logo" width="100">
    </div>
    </div>
     <nav class="navbar" >
            <div class="logo">
                <img src="Bus-logo-temokate-on-transparent-background-PNG-removebg-preview.png" alt="Bus Logo">
                <div class="logo-text">SLTB-Transit<span>Ease</span></div>
            </div>            <ul class="nav-links" style="font-size:20px;">
                <li><a href="sltbhome.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="#">Schedule</a></li>
                <li><a href="sltbhotline.php">Hotline</a></li>
            </ul>
        </nav>
        
    <div class="container">
 
    
        <div class="rect1" >
            <div class="rect2" style="background-color:#11276B;height: 30%;">
                <div class="rout"><p style="color: rgb(255, 255, 255);font-family: calibri";><B>HIGWAY ROUT SELECTION</B></p></div>
                
            </div>            <div class="rect3" style=" height: 80%;border-radius: 0px 0px 20px 20px;">                <form id="busSearchForm" method="get" action="routslect.php" onsubmit="return validateForm()">
                    <div class="search">                <div class="rect4" style="width: 25%; position: relative;">
                    <input type="text" id="fromField" name="from" placeholder="FROM" required 
                           style="height: 30px; width: 50%; padding: 8px; border: 0px solid #ccc; border-radius: 4px; margin-bottom: 40px;"
                           autocomplete="off" onkeyup="showSuggestions(this, 'fromSuggestions')" 
                           onblur="hideSuggestions('fromSuggestions')" onfocus="showSuggestions(this, 'fromSuggestions')">
                    <div id="fromSuggestions" class="suggestions"></div>
                </div>                        
                <div class="rect4" style="width: 25%; position: relative;">
                    <input type="text" id="toField" name="to" placeholder="TO" required 
                           style="height: 30px; width: 50%; padding: 8px; border: 0px solid #ccc; border-radius: 4px; margin-bottom: 40px;"
                           autocomplete="off" onkeyup="showSuggestions(this, 'toSuggestions')" 
                           onblur="hideSuggestions('toSuggestions')" onfocus="showSuggestions(this, 'toSuggestions')">
                    <div id="toSuggestions" class="suggestions"></div>
                </div>
                <div class="rect4" style= "width: 25%; margin-top:0px; ">
                    <input type="date" id="dateField" name="date" required style="height: 45px; width: 50%;">
                </div>
            
                <div class="rect4" style="width: 25%; margin-top:0px;">
                    <button type="submit" class="bus-button" style="position: absolute;  left: 87.5%; transform: translateX(-50%);height: 40px ; width:150px ;">SEARCH BUSES</button>
                </div>
            </div>
                </form>
            </div>
            
        </div>
        <div class="back-image">

            <div class="feedback" style="width: 33%;">
                <img src="feedback.png" class="feedbacke_image">
                <p class="F"><button class="f-button"><b>FEEDBACK</b></button> </p>
             </div>            <div class="cancel" style="width: 33%">
                    <img src="cancel.png" class="feedbacke_image">
                    <p class="F"><button class="f-button" onclick="window.location.href='sltbhotline.php'"><b>BOOKING CANCEL</b></button></p>
            </div>            <div class="news" style="width: 33%">
                    <img src="news.png" class="feedbacke_image">
                    <p class="F"><button class="f-button" onclick="window.location.href='sltbnews.php'"><b>NEWS</b></button> </p>
            </div>
        </div>
<div style="width: 99%;height: 180px;position: absolute;top: 830px;display: flex;flex-direction: row;">
  
            <div class="card1" style="width: 50%;background-color:#ffff;display: flex;align-items: center;justify-content: center;height: 260px; opacity: 80%;">
                <img src="visa.png" class="payimage">
              
            </div>
            
            

            <div class="card2" style="width: 50%;background-color: #ffff;display: flex;align-items: center;justify-content: center;height: 260px;opacity: 80%;">
            <img src="master.png" class="payimage1">
            
            </div>
            <p class="credit" style="color: red; margin-top: 5PX;">CREDIT/DEBIT CARD</p>
        
</div>
        <div class="payment">
         <p class="Multiple">Multiple Payment Options</p>
        </div>
    </div>
    </div>
    

    <footer class="footer" >
        <div class="footer-column">
            <div class="social-media">
            <ul>
                <li><a href="#"><img src="Images/socialmedea.png" ></a width:100;></li>
              
            </ul>
        </div>
        </div>
        <div class="footer-column">
            <div class="list">
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">T&C</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
        </div>
        <div class="footer-column">
            <div class="logo">
                <img src="Bus-logo-temokate-on-transparent-background-PNG-removebg-preview.png" alt="Bus Logo">
                <div class="logo-text">SLTB-Transit<span>Ease</span></div>
            </div>
            <div class="apex"><p>Team Apex<br>teamapex@gmail.com</p></div>
            
          
          </div>
        <div class="footer-column">
            <div class="footer-sltb">
            <img src="nee.png" alt="SLTB Logo" width="100" >
        </div>
        <div class="new">
            <p><b>Sri Lanka Transport Board</b>
            <br>No. 200, Kirula Road, Colombo 5
            <br>+94(0)11 7706000|+94(0)11 25811120-4
            <br>=94(0)11 2589683|info@sltb.lk</p>
        </div>
        </div>    </footer>      <script>        
        let allLocations = [];
        
        // Load all locations on page load
        async function loadAllLocations() {
            try {
                const response = await fetch('get_locations.php');
                const result = await response.json();
                
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
                html += `<div class="suggestion-item" onclick="selectLocation('${location}', '${input.id}', '${suggestionsId}')">${location}</div>`;
            });
            
            suggestionsDiv.innerHTML = html;
            suggestionsDiv.style.display = 'block';
        }
          // Select a location from suggestions
        function selectLocation(location, inputId, suggestionsId) {
            document.getElementById(inputId).value = location;
            document.getElementById(suggestionsId).style.display = 'none';
            // Clear any error messages when user selects a valid location
            clearAllErrors();
        }
        
        // Hide suggestions with delay to allow for click
        function hideSuggestions(suggestionsId) {
            setTimeout(() => {
                document.getElementById(suggestionsId).style.display = 'none';
            }, 200);
        }        // Validate form - check if locations exist and are different
        async function validateForm() {
            const from = document.getElementById('fromField').value.trim();
            const to = document.getElementById('toField').value.trim();
            
            // Clear any previous error messages
            clearAllErrors();
            
            if (from === '' || to === '') {
                showError('fromField', 'Please enter both FROM and TO locations');
                return false;
            }
            
            if (from === to) {
                showError('fromField', 'FROM and TO locations must be different');
                return false;
            }
            
            // Show loading message while validating
            const submitButton = document.querySelector('.bus-button');
            const originalText = submitButton.textContent;
            submitButton.textContent = 'VALIDATING...';
            submitButton.disabled = true;
            
            // Check if locations exist in database and if route is available
            try {
                const response = await fetch(`validate_route.php?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}`);
                const result = await response.json();
                
                // Reset button state
                submitButton.textContent = originalText;
                submitButton.disabled = false;
                
                if (result.status === 'error') {
                    // If route doesn't exist, check what destinations are available from the 'from' location
                    if (result.message.includes('No routes available')) {
                        try {
                            const destResponse = await fetch(`get_destinations.php?from=${encodeURIComponent(from)}`);
                            const destResult = await destResponse.json();
                            
                            if (destResult.status === 'success' && destResult.data.length > 0) {
                                const availableDestinations = destResult.data.slice(0, 5).join(', ');
                                showError('fromField', `No routes from ${from} to ${to}. Available destinations from ${from}: ${availableDestinations}`);
                            } else {
                                showError('fromField', `No routes available from ${from}. Please try a different starting location.`);
                            }
                        } catch (destError) {
                            showError('fromField', result.message);
                        }
                    } else {
                        showError('fromField', result.message);
                    }
                    return false;
                }
                
                return true;
            } catch (error) {
                // Reset button state on error
                submitButton.textContent = originalText;
                submitButton.disabled = false;
                showError('fromField', 'Error validating route. Please check your connection and try again.');
                return false;
            }
        }
        
        // Clear all error messages
        function clearAllErrors() {
            document.querySelectorAll('.error-message').forEach(el => el.remove());
        }
          // Show error message with right alignment
        function showError(fieldId, message) {
            // Clear any existing errors first
            clearAllErrors();
            
            const field = document.getElementById(fieldId);
            const fieldContainer = field.parentNode;
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            
            // Position the error message relative to the field container
            fieldContainer.style.position = 'relative';
            fieldContainer.appendChild(errorDiv);
            
            // Auto-hide error message after 8 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.remove();
                }
            }, 8000);
        }
        
        // Set minimum date to today
        function setMinDate() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('dateField').setAttribute('min', today);
            document.getElementById('dateField').value = today;
        }
         // Load locations when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadAllLocations();
            setMinDate();
            
            // Add input event listeners to clear errors when user types
            document.getElementById('fromField').addEventListener('input', clearAllErrors);
            document.getElementById('toField').addEventListener('input', clearAllErrors);
        });
          // Handle form submission with proper validation
        document.getElementById('busSearchForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const isValid = await validateForm();
                if (isValid) {
                    // Clear any errors before submitting
                    clearAllErrors();
                    this.submit();
                }
            } catch (error) {
                console.error('Form submission error:', error);
                showError('fromField', 'An error occurred. Please try again.');
            }
        });
    </script>
</body>
</html>


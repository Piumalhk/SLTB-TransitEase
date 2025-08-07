<?php
// payment.php - Converted from payment.html
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase</title>
    <link rel="stylesheet" href="payment.css">
    <link rel="stylesheet" href="payment.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            font-family: calibri;
        }
        .form-group input {
            padding: 8px;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #11276B;
            box-shadow: 0 0 5px rgba(17, 39, 107, 0.3);
        }
        .form-group input.valid {
            border-color: #28a745;
        }
        .form-group input.invalid {
            border-color: #dc3545;
        }
        .required {
            color: #dc3545;
        }
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
            font-weight: bold;
        }
        .newbutton {
            background: #11276B;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            height:50px:
        }
        .newbutton:hover:not(:disabled) {
            background: #0d1f52;
            transform: translateY(-2px);
        }
        .newbutton:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }
        .validation-icon {
            position: absolute;
            right: 10px;
            top: 35px;
            font-size: 18px;
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
              </form>
        <img src="nee.png" alt="Logo" width="100" style="position: absolute;  right: 80%; transform: translateX(-50%);">
        <button class="admin-button" style="position: absolute;  left: 87.5%; transform: translateX(-50%);" onclick="window.location.href='adminlogin.php'">ADMIN LOGIN</button>
        <img src="kisspng-computer-icons-login-management-user-5ae155f3386149.6695613615247170432309-removebg-preview.png" alt="Admin Logo" width="100">
    </div>
    </div>
     <nav class="navbar" >
            <div class="logo">
                <img src="Bus-logo-temokate-on-transparent-background-PNG-removebg-preview.png" alt="Bus Logo">
                <div class="logo-text">SLTB-Transit<span>Ease</span></div>
            </div>
            <ul class="nav-links" style="font-size:20px;">
                <li><a href="sltbhome.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="#">Schedule</a></li>
                <li><a href="sltbhotline.php">Hotline</a></li>
            </ul>
        </nav>
          <div class="container">
        <b><p class="pay_text">PASSENGER DETAILS</p></b>
        <div class="pay_box">
            <div class="pay1"> 
                <p style="font-family:calibri; font-size: 18px; padding-left: 10px; margin-top: 10px;"> 
                    <b>Your Details</b>
                </p>
            </div>
            <div class="pay2">
                <form id="passengerForm" method="POST" action="payment2.php">
                    <!-- Hidden fields for booking data -->
                    <input type="hidden" id="hiddenRouteId" name="routeId" value="">
                    <input type="hidden" id="hiddenFrom" name="from" value="">
                    <input type="hidden" id="hiddenTo" name="to" value="">
                    <input type="hidden" id="hiddenDate" name="date" value="">
                    <input type="hidden" id="hiddenSeats" name="seats" value="">
                    <input type="hidden" id="hiddenTotal" name="total" value="">
S
                    <div class="form-group">
                        <div class="name">
                            <p>
                                <label style=" margin-top:0px" for="passengerName">NAME</label>
                                <input type="text" id="passengerName" name="passengerName" required 
                                       placeholder="Enter full name as per ID"
                                       style="width: 380px; height: 20px; margin-left: 100px; margin-top:-50px">
                                <div class="error-message" id="nameError"></div>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="nic">
                            <p>
                                <label for="passengerNic" style="margin-right: 30px;">NIC NO <span class="required"></span></label>
                                <input type="text" id="passengerNic" name="passengerNic" required 
                                       placeholder="123456789V or 200012345678"
                                       style="width: 380px; height: 20px; margin-left: 100px;margin-top:-20px">
                                <div class="error-message" id="nicError"></div>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mobile">
                            <p>
                                <label for="passengerMobile" style="margin-right: 1px;">MOBILE NO <span class="required"></span></label>
                                <input type="tel" id="passengerMobile" name="passengerMobile" required 
                                       placeholder="0771234567" maxlength="10"
                                       style="width: 380px; height: 20px;margin-left: 100px; margin-top:-20px">
                                <div class="error-message" id="mobileError"></div>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="email">
                            <p>
                                <label for="passengerEmail">EMAIL <span class="required"></span></label>
                                <input type="email" id="passengerEmail" name="passengerEmail" required
                                       placeholder="example@gmail.com"
                                       style="width: 380px; height: 20px; margin-left: 95px; margin-top:-20px">
                                <div class="error-message" id="emailError"></div>
                            </p>
                        </div>
                    </div>

                    <div class="image">
                        <img src="Images/atm.png" style="width: 60px; margin-left: 9px;">
                        <p style="font-size:x-small; margin-top: 1px; margin-left: 8px;">CREDIT/DEBIT</p>
                    </div>

                    <div class="row">
                        <input type="checkbox" id="termsCheckbox" name="termsAccepted" required style="margin-top: 10px; cursor: pointer;">
                        <div class="box">
                            <p style="font-size:medium; margin-top: 2px; margin-right: 80px;">
                                I agree to all terms & conditions <span class="required">*</span>
                            </p>
                        </div>
                        <div class="error-message" id="termsError"></div>
                          <div class="button2">
                            <button type="submit" class="newbutton" id="proceedBtn" disabled>
                                Proceed to Payment
                            </button>
                        </div>
                    </div>
                </form>
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
        </div>    </footer>
    
    <script>
        // Load booking data from URL parameters and localStorage
        function loadBookingData() {
            const urlParams = new URLSearchParams(window.location.search);
            const bookingData = JSON.parse(localStorage.getItem('bookingData') || '{}');
            
            // Get data from URL or localStorage
            const routeId = urlParams.get('routeId') || bookingData.routeId || '';
            const from = urlParams.get('from') || bookingData.from || '';
            const to = urlParams.get('to') || bookingData.to || '';
            const date = urlParams.get('date') || bookingData.date || '';
            const seats = urlParams.get('seats') || (bookingData.selectedSeats ? bookingData.selectedSeats.join(',') : '');
            const total = urlParams.get('total') || bookingData.totalPrice || '';
            
            // Set hidden form fields
            document.getElementById('hiddenRouteId').value = routeId;
            document.getElementById('hiddenFrom').value = from;
            document.getElementById('hiddenTo').value = to;
            document.getElementById('hiddenDate').value = date;
            document.getElementById('hiddenSeats').value = seats;
            document.getElementById('hiddenTotal').value = total;
        }

        // Field validation functions
        function validateName(name) {
            const namePattern = /^[a-zA-Z\s]{2,50}$/;
            return namePattern.test(name.trim());
        }

        function validateNIC(nic) {
            const oldNIC = /^[0-9]{9}[vVxX]$/;
            const newNIC = /^[0-9]{12}$/;
            return oldNIC.test(nic) || newNIC.test(nic);
        }

        function validateMobile(mobile) {
            const mobilePattern = /^[0-9]{10}$/;
            return mobilePattern.test(mobile) && mobile.startsWith('0');
        }

        function validateEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

        // Real-time validation for each field
        function setupFieldValidation() {
            const nameField = document.getElementById('passengerName');
            const nicField = document.getElementById('passengerNic');
            const mobileField = document.getElementById('passengerMobile');
            const emailField = document.getElementById('passengerEmail');
            const termsCheckbox = document.getElementById('termsCheckbox');

            // Name validation
            nameField.addEventListener('input', function() {
                const isValid = validateName(this.value);
                showFieldValidation(this, 'nameError', isValid, 'Please enter a valid name (2-50 characters, letters only)');
                checkFormCompletion();
            });

            // NIC validation with formatting
            nicField.addEventListener('input', function() {
                let value = this.value.toUpperCase().replace(/[^0-9VX]/g, '');
                
                if (value.length <= 9) {
                    // Old format: allow only numbers for first 9 chars
                    value = value.replace(/[^0-9]/g, '');
                } else if (value.length === 10 && !value.endsWith('V') && !value.endsWith('X')) {
                    // If 10th character is not V or X, treat as new format
                    value = value.replace(/[^0-9]/g, '');
                }
                
                this.value = value;
                
                const isValid = validateNIC(value);
                showFieldValidation(this, 'nicError', isValid, 'Enter valid NIC (123456789V or 200012345678)');
                checkFormCompletion();
            });

            // Mobile validation with formatting
            mobileField.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
                
                const isValid = validateMobile(this.value);
                showFieldValidation(this, 'mobileError', isValid, 'Enter valid 10-digit mobile number starting with 0');
                checkFormCompletion();
            });

            // Email validation
            emailField.addEventListener('input', function() {
                const isValid = validateEmail(this.value);
                showFieldValidation(this, 'emailError', isValid, 'Enter a valid email address');
                checkFormCompletion();
            });

            // Terms checkbox
            termsCheckbox.addEventListener('change', function() {
                const errorElement = document.getElementById('termsError');
                if (this.checked) {
                    errorElement.style.display = 'none';
                } else {
                    errorElement.textContent = 'You must accept the terms and conditions';
                    errorElement.style.display = 'block';
                }
                checkFormCompletion();
            });
        }

        function showFieldValidation(field, errorElementId, isValid, errorMessage) {
            const errorElement = document.getElementById(errorElementId);
            
            if (field.value.trim() === '') {
                field.className = field.className.replace(/\s*(valid|invalid)/g, '');
                errorElement.style.display = 'none';
                return;
            }
            
            if (isValid) {
                field.className = field.className.replace(/\s*(valid|invalid)/g, '') + ' valid';
                errorElement.style.display = 'none';
            } else {
                field.className = field.className.replace(/\s*(valid|invalid)/g, '') + ' invalid';
                errorElement.textContent = errorMessage;
                errorElement.style.display = 'block';
            }
        }        function checkFormCompletion() {
            const nameValid = validateName(document.getElementById('passengerName').value);
            const nicValid = validateNIC(document.getElementById('passengerNic').value);
            const mobileValid = validateMobile(document.getElementById('passengerMobile').value);
            const emailValid = validateEmail(document.getElementById('passengerEmail').value);
            const termsAccepted = document.getElementById('termsCheckbox').checked;
            
            const allFieldsFilled = nameValid && nicValid && mobileValid && emailValid && termsAccepted;
            
            const proceedBtn = document.getElementById('proceedBtn');
            proceedBtn.disabled = !allFieldsFilled;
            
            if (allFieldsFilled) {
                proceedBtn.style.background = '#28a745';
                proceedBtn.textContent = 'Proceed to Payment ✓';
            } else {
                proceedBtn.style.background = '#6c757d';
                proceedBtn.textContent = 'Proceed to Payment';
            }
        }

        // Form submission
        document.getElementById('passengerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Final validation
            const nameValid = validateName(document.getElementById('passengerName').value);
            const nicValid = validateNIC(document.getElementById('passengerNic').value);
            const mobileValid = validateMobile(document.getElementById('passengerMobile').value);
            const emailValid = validateEmail(document.getElementById('passengerEmail').value);
            const termsAccepted = document.getElementById('termsCheckbox').checked;
            
            if (!nameValid || !nicValid || !mobileValid || !emailValid || !termsAccepted) {
                alert('Please fill all fields correctly before proceeding.');
                return;
            }

            // Store passenger data in localStorage for payment2.php
            const passengerData = {
                name: document.getElementById('passengerName').value,
                nic: document.getElementById('passengerNic').value,
                mobile: document.getElementById('passengerMobile').value,
                email: document.getElementById('passengerEmail').value,
                termsAccepted: termsAccepted
            };
            
            localStorage.setItem('passengerData', JSON.stringify(passengerData));
            
            // Show loading state
            const submitButton = document.getElementById('proceedBtn');
            submitButton.disabled = true;
            submitButton.textContent = 'Processing...';
            submitButton.style.background = '#ffc107';
            
            // Redirect to payment2.php with all data
            setTimeout(() => {
                this.submit();
            }, 1000);
        });

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadBookingData();
            setupFieldValidation();
            
            // Initial check for form completion
            checkFormCompletion();
        });
    </script>
    
</body>
</html>


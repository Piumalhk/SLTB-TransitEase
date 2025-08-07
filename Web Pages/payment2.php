<?php
// payment2.php - Enhanced payment processing page
session_start();

// Retrieve data from POST or session
$bookingData = [];
$passengerData = [];

if ($_POST) {
    // Store POST data in session for persistence
    $_SESSION['booking_data'] = [
        'routeId' => $_POST['routeId'] ?? '',
        'from' => $_POST['from'] ?? '',
        'to' => $_POST['to'] ?? '',
        'date' => $_POST['date'] ?? '',
        'seats' => $_POST['seats'] ?? '',
        'total' => $_POST['total'] ?? ''
    ];
    
    $_SESSION['passenger_data'] = [
        'name' => $_POST['passengerName'] ?? '',
        'nic' => $_POST['passengerNic'] ?? '',
        'mobile' => $_POST['passengerMobile'] ?? '',
        'email' => $_POST['passengerEmail'] ?? ''
    ];
}

$bookingData = $_SESSION['booking_data'] ?? [];
$passengerData = $_SESSION['passenger_data'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - Payment Processing</title>
    <link rel="stylesheet" href="payment2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        .booking-summary {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            font-family: 'Calibri', sans-serif;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 5px 0;
        }
        .summary-row.total {
            border-top: 2px solid #11276B;
            font-weight: bold;
            font-size: 18px;
            color: #11276B;
            margin-top: 15px;
            padding-top: 10px;
        }
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
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            width: 100%;
            box-sizing: border-box;
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
        .payment-button {
            background: #11276B;
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 20px auto;
            width: 100%;
            max-width: 300px;
        }
        .payment-button:hover:not(:disabled) {
            background: #0d1f52;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .payment-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }
        .card-row {
            display: flex;
            gap: 15px;
        }
        .card-row .form-group {
            flex: 1;
        }
        .card-logos {
            text-align: center;
            margin: 20px 0;
        }
        .card-logos img {
            margin: 0 10px;
        }
        .payment-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        .security-notice {
            background: #e8f5e8;
            border: 1px solid #28a745;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            font-size: 14px;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-main">
            <form>
                <div class="language">
                    <select name="language" id="language">
                        <option value="sinhala">Sinhala</option>
                        <option value="english">English</option>
                    </select>
                </div>
            </form>
            <img src="nee.png" alt="Logo" width="100" style="position: absolute; right: 80%; transform: translateX(-50%);">
            <button class="admin-button" style="position: absolute; left: 87.5%; transform: translateX(-50%);" onclick="window.location.href='adminlogin.php'">ADMIN LOGIN</button>
            <img src="kisspng-computer-icons-login-management-user-5ae155f3386149.6695613615247170432309-removebg-preview.png" alt="Admin Logo" width="100">
        </div>
    </div>
    
    <nav class="navbar">
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
        <b><p class="pay_text" style="text-align: center; font-size: 24px; color: #11276B; margin: 20px 0;">PAYMENT PROCESSING</p></b>
        
        <!-- Booking Summary -->
        <div class="booking-summary">
            <h3 style="color: #11276B; margin-bottom: 15px;">Booking Summary</h3>
            <div class="summary-row">
                <span>Passenger:</span>
                <span><?php echo htmlspecialchars($passengerData['name'] ?? 'N/A'); ?></span>
            </div>
            <div class="summary-row">
                <span>Route:</span>
                <span><?php echo htmlspecialchars($bookingData['from'] ?? 'N/A') . ' → ' . htmlspecialchars($bookingData['to'] ?? 'N/A'); ?></span>
            </div>
            <div class="summary-row">
                <span>Date:</span>
                <span><?php echo htmlspecialchars($bookingData['date'] ?? 'N/A'); ?></span>
            </div>
            <div class="summary-row">
                <span>Seats:</span>
                <span><?php echo htmlspecialchars($bookingData['seats'] ?? 'N/A'); ?></span>
            </div>
            <div class="summary-row total">
                <span>Total Amount:</span>
                <span>Rs. <?php echo htmlspecialchars($bookingData['total'] ?? '0'); ?></span>
            </div>
        </div>

        <div class="pay_box">
            <div class="payment-form">
                <div class="card-logos">
                    <img src="visa.png" style="width: 60px; height: 40px;" alt="Visa">
                    <img src="master.png" style="width: 80px; height: 45px;" alt="Mastercard">
                </div>
                
                <div class="security-notice">
                    🔒 Your payment information is secure and encrypted
                </div>

                <form id="paymentForm" method="POST" action="summary.php">
                    <!-- Hidden fields for booking data -->
                    <input type="hidden" name="routeId" value="<?php echo htmlspecialchars($bookingData['routeId'] ?? ''); ?>">
                    <input type="hidden" name="from" value="<?php echo htmlspecialchars($bookingData['from'] ?? ''); ?>">
                    <input type="hidden" name="to" value="<?php echo htmlspecialchars($bookingData['to'] ?? ''); ?>">
                    <input type="hidden" name="date" value="<?php echo htmlspecialchars($bookingData['date'] ?? ''); ?>">
                    <input type="hidden" name="seats" value="<?php echo htmlspecialchars($bookingData['seats'] ?? ''); ?>">
                    <input type="hidden" name="total" value="<?php echo htmlspecialchars($bookingData['total'] ?? ''); ?>">
                    
                    <!-- Hidden fields for passenger data -->
                    <input type="hidden" name="passengerName" value="<?php echo htmlspecialchars($passengerData['name'] ?? ''); ?>">
                    <input type="hidden" name="passengerNic" value="<?php echo htmlspecialchars($passengerData['nic'] ?? ''); ?>">
                    <input type="hidden" name="passengerMobile" value="<?php echo htmlspecialchars($passengerData['mobile'] ?? ''); ?>">
                    <input type="hidden" name="passengerEmail" value="<?php echo htmlspecialchars($passengerData['email'] ?? ''); ?>">

                    <div class="form-group">
                        <label for="cardNumber">Card Number <span class="required">*</span></label>
                        <input type="text" id="cardNumber" name="cardNumber" required 
                               placeholder="1234 5678 9012 3456" maxlength="19">
                        <div class="error-message" id="cardNumberError"></div>
                    </div>

                    <div class="card-row">
                        <div class="form-group">
                            <label for="expiryDate">Expiry Date <span class="required">*</span></label>
                            <input type="text" id="expiryDate" name="expiryDate" required 
                                   placeholder="MM/YY" maxlength="5">
                            <div class="error-message" id="expiryError"></div>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV <span class="required">*</span></label>
                            <input type="text" id="cvv" name="cvv" required 
                                   placeholder="123" maxlength="4">
                            <div class="error-message" id="cvvError"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cardholderName">Cardholder Name <span class="required">*</span></label>
                        <input type="text" id="cardholderName" name="cardholderName" required 
                               placeholder="John Doe" value="<?php echo htmlspecialchars($passengerData['name'] ?? ''); ?>">
                        <div class="error-message" id="cardholderError"></div>
                    </div>                    <button type="submit" class="payment-button" id="makePaymentBtn" disabled>
                        Make Payment
                    </button>
                </form>
            </div>
        </div>
    </div>    <footer class="footer">
        <div class="footer-column">
            <div class="social-media">
                <ul>
                    <li><a href="#"><img src="Images/socialmedea.png"></a></li>
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
                <img src="nee.png" alt="SLTB Logo" width="100">
            </div>
            <div class="new">
                <p><b>Sri Lanka Transport Board</b>
                <br>No. 200, Kirula Road, Colombo 5
                <br>+94(0)11 7706000|+94(0)11 25811120-4
                <br>+94(0)11 2589683|info@sltb.lk</p>
            </div>
        </div>
    </footer>

    <script>
        // Card validation functions
        function validateCardNumber(cardNumber) {
            // Remove spaces and validate
            const cleaned = cardNumber.replace(/\s/g, '');
            
            // Check if it's 13-19 digits (common credit card lengths)
            if (!/^\d{13,19}$/.test(cleaned)) {
                return false;
            }
            
            // Luhn algorithm for basic card validation
            let sum = 0;
            let alternate = false;
            
            for (let i = cleaned.length - 1; i >= 0; i--) {
                let n = parseInt(cleaned.charAt(i), 10);
                
                if (alternate) {
                    n *= 2;
                    if (n > 9) {
                        n = (n % 10) + 1;
                    }
                }
                
                sum += n;
                alternate = !alternate;
            }
            
            return (sum % 10) === 0;
        }

        function validateExpiryDate(expiry) {
            const pattern = /^(0[1-9]|1[0-2])\/\d{2}$/;
            if (!pattern.test(expiry)) {
                return false;
            }
            
            const [month, year] = expiry.split('/');
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear() % 100;
            const currentMonth = currentDate.getMonth() + 1;
            
            const expYear = parseInt(year, 10);
            const expMonth = parseInt(month, 10);
            
            if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
                return false;
            }
            
            return true;
        }

        function validateCVV(cvv) {
            return /^\d{3,4}$/.test(cvv);
        }

        function validateCardholderName(name) {
            return /^[a-zA-Z\s]{2,50}$/.test(name.trim());
        }

        // Real-time validation setup
        function setupPaymentValidation() {
            const cardNumberField = document.getElementById('cardNumber');
            const expiryField = document.getElementById('expiryDate');
            const cvvField = document.getElementById('cvv');
            const cardholderField = document.getElementById('cardholderName');

            // Card number validation with formatting
            cardNumberField.addEventListener('input', function() {
                let value = this.value.replace(/\s/g, '').replace(/[^0-9]/g, '');
                let formattedValue = value.replace(/(.{4})/g, '$1 ');
                
                if (formattedValue.endsWith(' ')) {
                    formattedValue = formattedValue.slice(0, -1);
                }
                
                this.value = formattedValue;
                
                const isValid = validateCardNumber(value);
                showFieldValidation(this, 'cardNumberError', isValid, 'Please enter a valid card number');
                checkPaymentFormCompletion();
            });

            // Expiry date validation with formatting
            expiryField.addEventListener('input', function() {
                let value = this.value.replace(/[^0-9]/g, '');
                
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                
                this.value = value;
                
                const isValid = value.length === 5 && validateExpiryDate(value);
                showFieldValidation(this, 'expiryError', isValid, 'Please enter a valid expiry date (MM/YY)');
                checkPaymentFormCompletion();
            });

            // CVV validation
            cvvField.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
                
                const isValid = validateCVV(this.value);
                showFieldValidation(this, 'cvvError', isValid, 'Please enter a valid CVV (3-4 digits)');
                checkPaymentFormCompletion();
            });

            // Cardholder name validation
            cardholderField.addEventListener('input', function() {
                const isValid = validateCardholderName(this.value);
                showFieldValidation(this, 'cardholderError', isValid, 'Please enter a valid cardholder name');
                checkPaymentFormCompletion();
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
        }        function checkPaymentFormCompletion() {
            const cardNumberValid = validateCardNumber(document.getElementById('cardNumber').value.replace(/\s/g, ''));
            const expiryValid = validateExpiryDate(document.getElementById('expiryDate').value);
            const cvvValid = validateCVV(document.getElementById('cvv').value);
            const cardholderValid = validateCardholderName(document.getElementById('cardholderName').value);
            
            const allFieldsValid = cardNumberValid && expiryValid && cvvValid && cardholderValid;
            
            const paymentBtn = document.getElementById('makePaymentBtn');
            paymentBtn.disabled = !allFieldsValid;
            
            if (allFieldsValid) {
                paymentBtn.style.background = '#28a745';
                paymentBtn.textContent = 'Make Payment ✓';
            } else {
                paymentBtn.style.background = '#6c757d';
                paymentBtn.textContent = 'Make Payment';
            }
        }

        // Form submission handling
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Final validation
            const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
            const expiry = document.getElementById('expiryDate').value;
            const cvv = document.getElementById('cvv').value;
            const cardholder = document.getElementById('cardholderName').value;
            
            if (!validateCardNumber(cardNumber) || !validateExpiryDate(expiry) || 
                !validateCVV(cvv) || !validateCardholderName(cardholder)) {
                alert('Please fill all payment fields correctly before proceeding.');
                return;
            }

            // Show processing state
            const submitButton = document.getElementById('makePaymentBtn');
            submitButton.disabled = true;
            submitButton.textContent = 'Processing Payment...';
            submitButton.style.background = '#ffc107';
            
            // Store payment data and submit
            const paymentData = {
                cardNumber: cardNumber.slice(-4), // Only store last 4 digits
                expiryDate: expiry,
                cardholderName: cardholder,
                timestamp: new Date().toISOString()
            };
            
            localStorage.setItem('paymentData', JSON.stringify(paymentData));
            
            // Simulate payment processing delay
            setTimeout(() => {
                this.submit();
            }, 2000);
        });

        // Load data from localStorage if available
        function loadStoredData() {
            const passengerData = JSON.parse(localStorage.getItem('passengerData') || '{}');
            const bookingData = JSON.parse(localStorage.getItem('bookingData') || '{}');
            
            // Auto-fill cardholder name from passenger data
            if (passengerData.name && document.getElementById('cardholderName').value === '') {
                document.getElementById('cardholderName').value = passengerData.name;
            }
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadStoredData();
            setupPaymentValidation();
            checkPaymentFormCompletion();
        });

        // Security feature: Clear sensitive data on page unload
        window.addEventListener('beforeunload', function() {
            // Clear any sensitive payment data from memory
            document.getElementById('cardNumber').value = '';
            document.getElementById('cvv').value = '';
        });
    </script>
    
</body>
</html>


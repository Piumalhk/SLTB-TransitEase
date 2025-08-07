<?php
// summary.php - Converted from summary.html
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

// Generate transaction ID and time
$transactionId = 'SLTB' . date('Ymd') . sprintf('%06d', rand(1, 999999));
$bookingTime = date('h:i A');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase</title>
    <link rel="stylesheet" href="summary.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

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
        <img src="kisspng-computer-icons-login-management-user-5ae155f3386149.6695613615247170432309-removebg-preview.png" alt="Logo" width="100">
    </div>
    </div>
     <nav class="navbar" >            <div class="logo">
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
 <b><p class="sum_text">SUMMARY</p></b>
      <div class="pay_box">
        <div class="pay1"><p style="font-family:calibri; font-size: 18px; padding-left: 10px; margin-top: 10px;"><b>Payment Details</b></p></div>        <div class="pay2">
            <div class="rect">
                <p style="padding-right: 80%;font-family: calibri;"> 
                    Name: <strong><?php echo htmlspecialchars($passengerData['name'] ?? 'N/A'); ?></strong><br><br> 
                    Time: <strong><?php echo $bookingTime; ?></strong><br><br> 
                    Date: <strong><?php echo htmlspecialchars($bookingData['date'] ?? 'N/A'); ?></strong><br><br> 
                    Amount: <strong>Rs. <?php echo htmlspecialchars($bookingData['total'] ?? '0'); ?></strong><br><br> 
                    Seat Number: <strong><?php echo htmlspecialchars($bookingData['seats'] ?? 'N/A'); ?></strong>
                </p>
            </div>
           
            
            <img src="mark.png" style="width: 110px; height: 110px; margin-left: 240px;" >
            <p style="font-family: calibri; margin-left: 220px;font-size: 18px; margin-top: -4%;"><b>Payment Successfull..!</b></p>
            <button class="print" onclick="printTicket()">Print</button><br>
            <button class="qr" onclick="downloadQR()">Download the QR Code</button>
            <p style="font-size: small;margin-top: 4px;">Transaction ID: <strong><?php echo $transactionId; ?></strong></p>
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
    
    <!-- Include jsPDF library for PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <script>
        // Print ticket function - Now generates PDF
        function printTicket() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Set document properties
            doc.setProperties({
                title: 'SLTB Bus Ticket',
                subject: 'Bus Booking Summary',
                author: 'SLTB-TransitEase'
            });
            
            // Header
            doc.setFontSize(20);
            doc.setFont("helvetica", "bold");
            doc.text('SLTB-TransitEase', 105, 20, { align: 'center' });
            
            doc.setFontSize(16);
            doc.text('Bus Ticket', 105, 30, { align: 'center' });
            
            // Transaction ID
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal");
            doc.text('Transaction ID: <?php echo $transactionId; ?>', 20, 45);
            
            // Add a line
            doc.line(20, 50, 190, 50);
            
            // Passenger Details Section
            doc.setFontSize(14);
            doc.setFont("helvetica", "bold");
            doc.text('Passenger Details:', 20, 65);
            
            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.text('Name: <?php echo htmlspecialchars($passengerData['name'] ?? 'N/A'); ?>', 20, 75);
            doc.text('NIC: <?php echo htmlspecialchars($passengerData['nic'] ?? 'N/A'); ?>', 20, 85);
            doc.text('Mobile: <?php echo htmlspecialchars($passengerData['mobile'] ?? 'N/A'); ?>', 20, 95);
            doc.text('Email: <?php echo htmlspecialchars($passengerData['email'] ?? 'N/A'); ?>', 20, 105);
            
            // Journey Details Section
            doc.setFontSize(14);
            doc.setFont("helvetica", "bold");
            doc.text('Journey Details:', 20, 125);
            
            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.text('From: <?php echo htmlspecialchars($bookingData['from'] ?? 'N/A'); ?>', 20, 135);
            doc.text('To: <?php echo htmlspecialchars($bookingData['to'] ?? 'N/A'); ?>', 20, 145);
            doc.text('Travel Date: <?php echo htmlspecialchars($bookingData['date'] ?? 'N/A'); ?>', 20, 155);
            doc.text('Booking Time: <?php echo $bookingTime; ?>', 20, 165);
            doc.text('Seat Number(s): <?php echo htmlspecialchars($bookingData['seats'] ?? 'N/A'); ?>', 20, 175);
            
            // Payment Details Section
            doc.setFontSize(14);
            doc.setFont("helvetica", "bold");
            doc.text('Payment Details:', 20, 195);
            
            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.text('Total Amount: Rs. <?php echo htmlspecialchars($bookingData['total'] ?? '0'); ?>', 20, 205);
            doc.text('Payment Status: Completed', 20, 215);
            
            // Add another line
            doc.line(20, 225, 190, 225);
            
            // Instructions
            doc.setFontSize(10);
            doc.setFont("helvetica", "italic");
            doc.text('Instructions:', 20, 240);
            doc.text('• Show this ticket to the conductor when boarding', 25, 250);
            doc.text('• Valid for single journey only', 25, 260);
            doc.text('• Please arrive 15 minutes before departure', 25, 270);
            
            // Footer
            doc.setFontSize(8);
            doc.setFont("helvetica", "normal");
            doc.text('Sri Lanka Transport Board - No. 200, Kirula Road, Colombo 5', 105, 285, { align: 'center' });
            doc.text('Generated on: ' + new Date().toLocaleString(), 105, 292, { align: 'center' });
            
            // Save the PDF
            const fileName = 'SLTB_Ticket_<?php echo $transactionId; ?>.pdf';
            doc.save(fileName);
        }

        // Download QR Code function (enhanced)
        function downloadQR() {
            const qrData = `SLTB Ticket: <?php echo $transactionId; ?>
Passenger: <?php echo htmlspecialchars($passengerData['name'] ?? 'N/A'); ?>
Route: <?php echo htmlspecialchars($bookingData['from'] ?? 'N/A'); ?> → <?php echo htmlspecialchars($bookingData['to'] ?? 'N/A'); ?>
Date: <?php echo htmlspecialchars($bookingData['date'] ?? 'N/A'); ?>
Seats: <?php echo htmlspecialchars($bookingData['seats'] ?? 'N/A'); ?>
Amount: Rs. <?php echo htmlspecialchars($bookingData['total'] ?? '0'); ?>`;
            
            // For now, show QR data in alert
            // In a full implementation, you would generate actual QR code
            alert('QR Code Data:\n\n' + qrData + '\n\nNote: QR code generation requires additional setup. This shows the data that would be encoded.');
            
            // Optional: Create a simple text file with QR data
            const blob = new Blob([qrData], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'SLTB_QR_Data_<?php echo $transactionId; ?>.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }

        // Load data from localStorage as backup if no POST data
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (empty($bookingData) || empty($passengerData)): ?>
            const passengerData = JSON.parse(localStorage.getItem('passengerData') || '{}');
            const bookingData = JSON.parse(localStorage.getItem('bookingData') || '{}');
            
            if (passengerData.name || bookingData.from) {
                console.log('Loading backup data from localStorage');
                // You could update the display here if needed
            }
            <?php endif; ?>
            
            console.log('Summary page loaded with PDF generation capability');
        });
    </script>
    
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase</title>
    <!-- Importing fonts as specified -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // Initialize variables for the search form.
    $from = "";
    $to = "";
    $date = date("Y-m-d"); // Set default date to today
    ?>
    <?php include_once '../includes/header.php'; ?>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/search.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> <!-- jQuery UI CSS -->

    <div class="container">
        <div class="rect1">
            <div class="rect2">
                <p><b>HIGWAY ROUTE SELECTION</b></p>
            </div>
            <div class="rect3">
                <form id="busSearchForm" action="search_buses.php" method="get">
                    <div class="search">
                        <div class="rect4">
                            <input type="text" id="fromField" name="from" placeholder="FROM" required autocomplete="off" value="<?php echo htmlspecialchars($from); ?>">
                            <div id="fromSuggestions" class="suggestions"></div> <!-- Keep for compatibility, though unused -->
                        </div>
                        <div class="rect4">
                            <input type="text" id="toField" name="to" placeholder="TO" required autocomplete="off" value="<?php echo htmlspecialchars($to); ?>">
                            <div id="toSuggestions" class="suggestions"></div> <!-- Keep for compatibility, though unused -->
                        </div>
                        <div class="rect4">
                            <input type="date" id="dateField" name="date" required value="<?php echo htmlspecialchars($date); ?>">
                        </div>
                        <div class="rect4">
                            <button type="submit" class="bus-button">SEARCH BUSES</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="back-image">
            <div class="info-card">
                <img src="../assest/feedback.png" class="feedbacke_image" alt="Feedback">
                <p class="F"><button class="f-button" onclick="window.location.href='feedback.php'"><b>FEEDBACK</b></button></p>
            </div>
            <div class="info-card">
                <img src="../assest/cancel.png" class="feedbacke_image" alt="Booking Cancel">
                <p class="F"><button class="f-button" onclick="window.location.href='cancel_booking.php'"><b>BOOKING CANCEL</b></button></p>
            </div>
            <div class="info-card">
                <img src="../assest/news.png" class="feedbacke_image" alt="News">
                <p class="F"><button class="f-button" onclick="window.location.href='news.php'"><b>NEWS</b></button></p>
            </div>
        </div>

        <div class="payment-section">
            <p class="Multiple">Multiple Payment Options</p>
            <div class="payment-cards">
                <div class="card">
                    <img src="../assest/visa.png" alt="Visa Card">
                </div>
                <div class="card">
                    <img src="../assest/master.png" alt="Mastercard">
                </div>
            </div>
        </div>
    </div>

    <?php include_once '../includes/footer.php'; ?>

    <!-- jQuery and jQuery UI Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            // Autocomplete for "From" field
            $("#fromField").autocomplete({
                source: 'fetch_cities.php',
                minLength: 2,
                select: function(event, ui) {
                    $("#fromField").val(ui.item.value);
                }
            });

            // Autocomplete for "To" field
            $("#toField").autocomplete({
                source: 'fetch_cities.php',
                minLength: 2,
                select: function(event, ui) {
                    $("#toField").val(ui.item.value);
                }
            });
        });
    </script>
</body>
</html>
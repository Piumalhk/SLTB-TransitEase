<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'sltb_transitease';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $from = isset($_GET['from']) ? trim($_GET['from']) : '';
    $to = isset($_GET['to']) ? trim($_GET['to']) : '';
    
    // Validate that both locations exist in database
    if (empty($from) || empty($to)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'From and To locations are required'
        ]);
        exit;
    }
    
    // Check if locations exist in database
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM locations WHERE name = ?");
    $stmt->execute([$from]);
    $fromExists = $stmt->fetchColumn() > 0;
    
    $stmt->execute([$to]);
    $toExists = $stmt->fetchColumn() > 0;
    
    if (!$fromExists) {
        echo json_encode([
            'status' => 'error',
            'message' => "Location '$from' is not available in our service area"
        ]);
        exit;
    }
    
    if (!$toExists) {
        echo json_encode([
            'status' => 'error',
            'message' => "Location '$to' is not available in our service area"
        ]);
        exit;
    }
    
    // Get routes between the locations
    $stmt = $pdo->prepare("
        SELECT 
            br.id,
            br.route_number,
            br.from_location,
            br.to_location,
            br.departure_time,
            br.arrival_time,
            br.bus_model,
            br.bus_type,
            br.available_seats,
            br.price
        FROM bus_routes br
        WHERE br.from_location = ? AND br.to_location = ?
        ORDER BY br.departure_time
    ");
    
    $stmt->execute([$from, $to]);
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($routes)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No routes available between selected locations'
        ]);
        exit;
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $routes
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>

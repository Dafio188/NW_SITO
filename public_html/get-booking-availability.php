<?php
// API per ottenere disponibilità giorni prenotazioni
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    require_once __DIR__ . '/includes/database.php';
    $db = getDb();
    
    $month = $_GET['month'] ?? date('Y-m');
    $service = $_GET['service'] ?? '';
    
    // Ottieni prenotazioni esistenti per il mese
    $stmt = $db->prepare("
        SELECT booking_date, COUNT(*) as bookings_count 
        FROM bookings 
        WHERE booking_date LIKE ? 
        AND status IN ('pending', 'confirmed')
        GROUP BY booking_date
    ");
    $stmt->execute([$month . '%']);
    $existing_bookings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    // Definisci limiti giornalieri per servizio
    $daily_limits = [
        'osservazione' => 2,
        'astrofotografia' => 1,
        'turismo' => 2,
        'corso' => 1
    ];
    
    // Genera calendario del mese
    $year = (int)substr($month, 0, 4);
    $month_num = (int)substr($month, 5, 2);
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_num, $year);
    
    $availability = [];
    
    for ($day = 1; $day <= $days_in_month; $day++) {
        $date = sprintf('%s-%02d', $month, $day);
        $bookings_count = $existing_bookings[$date] ?? 0;
        
        // Controlla se è un giorno valido (non passato)
        $is_past = strtotime($date) < strtotime('today');
        
        // Controlla se è weekend (più richiesto)
        $day_of_week = date('w', strtotime($date));
        $is_weekend = ($day_of_week == 0 || $day_of_week == 6);
        
        // Determina disponibilità
        $max_bookings = $is_weekend ? 3 : 2; // Weekend più disponibilità
        $is_available = !$is_past && $bookings_count < $max_bookings;
        
        $availability[$date] = [
            'available' => $is_available,
            'bookings_count' => $bookings_count,
            'max_bookings' => $max_bookings,
            'is_weekend' => $is_weekend,
            'is_past' => $is_past,
            'day_name' => date('l', strtotime($date))
        ];
    }
    
    echo json_encode([
        'success' => true,
        'month' => $month,
        'availability' => $availability,
        'legend' => [
            'available' => 'Disponibile',
            'limited' => 'Posti limitati',
            'full' => 'Completo',
            'past' => 'Data passata'
        ]
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 
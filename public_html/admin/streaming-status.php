<?php
/**
 * API Endpoint - Status Streaming
 * Restituisce lo stato dello streaming in formato JSON
 */
header('Content-Type: application/json');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/streaming.php';

try {
    // Verifica autenticazione admin
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        http_response_code(401);
        echo json_encode(['error' => 'Non autorizzato']);
        exit;
    }
    
    // Ottieni status streaming
    $status = $streamingManager->getStreamingStatus();
    
    // Aggiungi informazioni aggiuntive
    $status['timestamp'] = date('Y-m-d H:i:s');
    $status['url'] = $streamingManager->getStreamingUrl();
    $status['embed_url'] = $streamingManager->getEmbedUrl();
    
    echo json_encode($status);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Errore server',
        'message' => $e->getMessage()
    ]);
}
?> 
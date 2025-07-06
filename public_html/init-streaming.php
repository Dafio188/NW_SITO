<?php
/**
 * Script di inizializzazione streaming
 * Imposta l'URL YouTube di default nel database
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/streaming.php';

echo "=== INIZIALIZZAZIONE STREAMING ASTROGUIDA ===\n\n";

try {
    // URL YouTube fornito dall'utente
    $youtube_url = 'https://youtube.com/live/54O7rq5ZweY';
    
    echo "Impostazione URL streaming: $youtube_url\n";
    
    // Aggiorna URL streaming
    if ($streamingManager->updateStreamingUrl($youtube_url)) {
        echo "✅ URL streaming aggiornato con successo!\n";
    } else {
        echo "❌ Errore nell'aggiornamento URL streaming\n";
        exit(1);
    }
    
    // Imposta impostazioni di default
    $default_settings = [
        'streaming_title' => 'Cielo di Cassano delle Murge',
        'streaming_description' => 'Streaming live del cielo notturno in tempo reale',
        'streaming_location' => 'Cassano delle Murge, Puglia',
        'streaming_autoplay' => '1',
        'streaming_mute' => '1'
    ];
    
    echo "Impostazione configurazioni di default...\n";
    
    if ($streamingManager->saveStreamingSettings($default_settings)) {
        echo "✅ Impostazioni di default salvate!\n";
    } else {
        echo "❌ Errore nel salvataggio impostazioni\n";
        exit(1);
    }
    
    // Verifica stato streaming
    echo "\nVerifica stato streaming...\n";
    $status = $streamingManager->getStreamingStatus();
    echo "Stato: " . $status['status'] . "\n";
    echo "Messaggio: " . $status['message'] . "\n";
    
    // Mostra URL embed
    echo "\nURL Embed generato:\n";
    echo $streamingManager->getEmbedUrl() . "\n";
    
    echo "\n=== INIZIALIZZAZIONE COMPLETATA ===\n";
    echo "Ora puoi:\n";
    echo "1. Accedere come admin alla dashboard: /admin/streaming-settings.php\n";
    echo "2. Visualizzare lo streaming: /?page=live-sky\n";
    echo "3. Modificare l'URL quando necessario dalla dashboard\n";
    
} catch (Exception $e) {
    echo "❌ ERRORE: " . $e->getMessage() . "\n";
    exit(1);
}
?> 
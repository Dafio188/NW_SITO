<?php
/**
 * Gestione Streaming YouTube
 * Sistema per gestire dinamicamente i link di streaming
 */

class StreamingManager {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Ottiene l'URL di streaming corrente
     */
    public function getStreamingUrl() {
        try {
            $stmt = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'youtube_streaming_url'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result['setting_value'];
            }
            
            // Default fallback
            return 'https://youtube.com/live/54O7rq5ZweY';
        } catch (Exception $e) {
            error_log("Errore recupero streaming URL: " . $e->getMessage());
            return 'https://youtube.com/live/54O7rq5ZweY';
        }
    }
    
    /**
     * Aggiorna l'URL di streaming
     */
    public function updateStreamingUrl($url) {
        try {
            // Valida URL YouTube
            if (!$this->isValidYouTubeUrl($url)) {
                throw new Exception("URL YouTube non valido");
            }
            
            $stmt = $this->db->prepare("INSERT OR REPLACE INTO settings (setting_key, setting_value) VALUES ('youtube_streaming_url', ?)");
            $stmt->execute([$url]);
            
            return true;
        } catch (Exception $e) {
            error_log("Errore aggiornamento streaming URL: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Ottiene URL embed per YouTube
     */
    public function getEmbedUrl() {
        $url = $this->getStreamingUrl();
        return $this->convertToEmbedUrl($url);
    }
    
    /**
     * Converte URL YouTube in URL embed
     */
    private function convertToEmbedUrl($url) {
        // Estrae ID video da vari formati YouTube
        if (preg_match('/youtube\.com\/live\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1";
        }
        
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1";
        }
        
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1";
        }
        
        // Fallback
        return "https://www.youtube.com/embed/54O7rq5ZweY?autoplay=1&mute=1";
    }
    
    /**
     * Valida URL YouTube
     */
    private function isValidYouTubeUrl($url) {
        $patterns = [
            '/^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\//',
            '/youtube\.com\/live\/[a-zA-Z0-9_-]+/',
            '/youtube\.com\/watch\?v=[a-zA-Z0-9_-]+/',
            '/youtu\.be\/[a-zA-Z0-9_-]+/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Ottiene stato streaming (live/offline)
     */
    public function getStreamingStatus() {
        try {
            $url = $this->getStreamingUrl();
            $videoId = $this->extractVideoId($url);
            
            if (!$videoId) {
                return ['status' => 'offline', 'message' => 'URL non valido'];
            }
            
            // Simulazione stato (in produzione usare YouTube API)
            $isLive = $this->checkIfLive($videoId);
            
            return [
                'status' => $isLive ? 'live' : 'offline',
                'message' => $isLive ? 'Streaming in diretta' : 'Streaming offline - Lavori in corso',
                'video_id' => $videoId
            ];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Errore verifica stato'];
        }
    }
    
    /**
     * Estrae ID video da URL YouTube
     */
    private function extractVideoId($url) {
        if (preg_match('/youtube\.com\/live\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        
        return false;
    }
    
    /**
     * Verifica se lo streaming è live (simulazione)
     */
    private function checkIfLive($videoId) {
        // In produzione, qui useresti YouTube Data API v3
        // Per ora simuliamo basandoci sull'orario
        $hour = (int)date('H');
        
        // Simula live dalle 20:00 alle 6:00
        return ($hour >= 20 || $hour <= 6);
    }
    
    /**
     * Ottiene impostazioni streaming complete
     */
    public function getStreamingSettings() {
        try {
            $stmt = $this->db->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'streaming_%'");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $settings = [];
            foreach ($results as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
            
            return $settings;
        } catch (Exception $e) {
            error_log("Errore recupero impostazioni streaming: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Salva impostazioni streaming
     */
    public function saveStreamingSettings($settings) {
        try {
            $this->db->beginTransaction();
            
            foreach ($settings as $key => $value) {
                if (strpos($key, 'streaming_') === 0) {
                    $stmt = $this->db->prepare("INSERT OR REPLACE INTO settings (setting_key, setting_value) VALUES (?, ?)");
                    $stmt->execute([$key, $value]);
                }
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Errore salvataggio impostazioni streaming: " . $e->getMessage());
            return false;
        }
    }
}

// Inizializza il manager streaming solo se il database è disponibile
if (isset($pdo) && $pdo !== null) {
    $streamingManager = new StreamingManager($pdo);
} else {
    // Fallback per quando il database non è disponibile
    $streamingManager = null;
}
?> 
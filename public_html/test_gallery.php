<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Gallery - AstroGuida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1a1a1a;
            color: white;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .gallery-item {
            background: #2a2a2a;
            border-radius: 10px;
            overflow: hidden;
            padding: 10px;
        }
        .gallery-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .image-info {
            padding: 10px;
        }
        .image-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .image-path {
            font-size: 12px;
            color: #888;
            font-family: monospace;
        }
        .error {
            color: #ff6b6b;
            background: #2a1a1a;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            color: #51cf66;
            background: #1a2a1a;
            padding: 10px;
            border-radius: 5px;
        }
        h1 {
            text-align: center;
            color: #64ffda;
            margin-bottom: 30px;
        }
        .status {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌌 Test Gallery Immagini Astronomiche</h1>
        
        <div class="status">
            <p>Verifica che tutte le immagini della gallery si carichino correttamente</p>
        </div>

        <div class="gallery-grid">
            <?php
            // Immagini della gallery homepage
            $gallery_images = [
                [
                    'path' => '/fotoastronomia/m31.jpg',
                    'title' => 'Galassia di Andromeda (M31)',
                    'description' => 'La galassia più vicina alla Via Lattea'
                ],
                [
                    'path' => '/fotoastronomia/nebulosa-cuore.jpg',
                    'title' => 'Nebulosa Cuore',
                    'description' => 'Nebulosa ad emissione nella costellazione di Cassiopea'
                ],
                [
                    'path' => '/fotoastronomia/pleadi-m45.jpg',
                    'title' => 'Pleiadi (M45)',
                    'description' => 'Ammasso aperto nella costellazione del Toro'
                ],
                [
                    'path' => '/fotoastronomia/rosetta-red.jpg',
                    'title' => 'Nebulosa Rosetta',
                    'description' => 'Nebulosa ad emissione nella costellazione dell\'Unicorno'
                ],
                [
                    'path' => '/fotoastronomia/ic443.jpg',
                    'title' => 'Nebulosa Medusa (IC443)',
                    'description' => 'Resto di supernova nella costellazione dei Gemelli'
                ],
                [
                    'path' => '/fotoastronomia/ngc7635.jpg',
                    'title' => 'Nebulosa Bolla (NGC7635)',
                    'description' => 'Nebulosa ad emissione nella costellazione di Cassiopea'
                ]
            ];

            foreach ($gallery_images as $image) {
                $full_path = $_SERVER['DOCUMENT_ROOT'] . $image['path'];
                $web_path = $image['path'];
                $file_exists = file_exists($full_path);
                $file_size = $file_exists ? filesize($full_path) : 0;
                $file_size_mb = round($file_size / 1024 / 1024, 2);
                
                echo '<div class="gallery-item">';
                
                if ($file_exists) {
                    echo '<img src="' . $web_path . '" alt="' . htmlspecialchars($image['title']) . '" class="gallery-image">';
                    echo '<div class="image-info">';
                    echo '<div class="image-title">' . htmlspecialchars($image['title']) . '</div>';
                    echo '<div class="success">✅ Immagine caricata correttamente</div>';
                    echo '<div class="image-path">Percorso: ' . $web_path . '</div>';
                    echo '<div class="image-path">Dimensione: ' . $file_size_mb . ' MB</div>';
                    echo '<p>' . htmlspecialchars($image['description']) . '</p>';
                } else {
                    echo '<div class="error">❌ Immagine non trovata</div>';
                    echo '<div class="image-info">';
                    echo '<div class="image-title">' . htmlspecialchars($image['title']) . '</div>';
                    echo '<div class="image-path">Percorso: ' . $web_path . '</div>';
                    echo '<div class="image-path">Percorso completo: ' . $full_path . '</div>';
                    echo '<p>' . htmlspecialchars($image['description']) . '</p>';
                }
                
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="status">
            <?php
            // Controlla la directory
            $dir_path = $_SERVER['DOCUMENT_ROOT'] . '/fotoastronomia/';
            if (is_dir($dir_path)) {
                echo '<div class="success">✅ Directory /fotoastronomia/ trovata</div>';
                
                $files = scandir($dir_path);
                $jpg_files = array_filter($files, function($file) {
                    return pathinfo($file, PATHINFO_EXTENSION) === 'jpg';
                });
                
                echo '<div class="success">📁 Trovati ' . count($jpg_files) . ' file JPG nella directory</div>';
                
                if (count($jpg_files) > 0) {
                    echo '<div class="image-path">File trovati: ' . implode(', ', $jpg_files) . '</div>';
                }
            } else {
                echo '<div class="error">❌ Directory /fotoastronomia/ non trovata</div>';
                echo '<div class="image-path">Percorso cercato: ' . $dir_path . '</div>';
            }
            ?>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="/" style="color: #64ffda; text-decoration: none; font-size: 18px;">
                🏠 Torna alla Homepage
            </a>
        </div>
    </div>
</body>
</html> 
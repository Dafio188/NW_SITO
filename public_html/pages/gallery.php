<?php
require_once __DIR__ . '/../includes/config.php';

// Parametri di ricerca e filtro
$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');

// Simulazione dati gallery (in produzione verrebbero dal database)
$gallery_images = [
    [
        'id' => 1,
        'filename' => 'm31.jpg',
        'title' => 'Galassia di Andromeda (M31)',
        'description' => 'La galassia spirale più vicina alla Via Lattea, distante 2,5 milioni di anni luce.',
        'category' => 'galassia',
        'date' => '2024-01-15',
        'location' => 'Puglia - Cielo Scuro',
        'camera' => 'Canon EOS Ra',
        'telescope' => 'Celestron EdgeHD 11"',
        'exposure' => '3h 30min (210 x 60s)',
        'iso' => '1600'
    ],
    [
        'id' => 2,
        'filename' => 'nebulosa-cuore.jpg',
        'title' => 'Nebulosa Cuore (IC 1805)',
        'description' => 'Nebulosa ad emissione nella costellazione di Cassiopea, ricca di idrogeno.',
        'category' => 'nebulosa',
        'date' => '2024-01-20',
        'location' => 'Puglia - Cielo Scuro',
        'camera' => 'ZWO ASI2600MC-Pro',
        'telescope' => 'Takahashi FSQ-106EDX',
        'exposure' => '4h 15min (255 x 60s)',
        'iso' => '800'
    ],
    [
        'id' => 3,
        'filename' => 'pleadi-m45.jpg',
        'title' => 'Ammasso delle Pleiadi (M45)',
        'description' => 'Ammasso aperto nella costellazione del Toro, noto come "Le Sette Sorelle".',
        'category' => 'ammasso',
        'date' => '2024-01-25',
        'location' => 'Puglia - Cielo Scuro',
        'camera' => 'Canon EOS Ra',
        'telescope' => 'William Optics GT81',
        'exposure' => '2h 45min (165 x 60s)',
        'iso' => '1600'
    ],
    [
        'id' => 4,
        'filename' => 'rosetta-red.jpg',
        'title' => 'Nebulosa Rosetta (NGC 2237)',
        'description' => 'Nebulosa ad emissione nella costellazione dell\'Unicorno, famosa per la sua forma.',
        'category' => 'nebulosa',
        'date' => '2024-02-01',
        'location' => 'Puglia - Cielo Scuro',
        'camera' => 'ZWO ASI2600MC-Pro',
        'telescope' => 'Celestron EdgeHD 11"',
        'exposure' => '5h 20min (320 x 60s)',
        'iso' => '800'
    ],
    [
        'id' => 5,
        'filename' => 'ic443.jpg',
        'title' => 'Nebulosa Medusa (IC 443)',
        'description' => 'Resto di supernova nella costellazione dei Gemelli, con strutture filamentose.',
        'category' => 'nebulosa',
        'date' => '2024-02-05',
        'location' => 'Puglia - Cielo Scuro',
        'camera' => 'ZWO ASI2600MC-Pro',
        'telescope' => 'Takahashi FSQ-106EDX',
        'exposure' => '6h 10min (370 x 60s)',
        'iso' => '800'
    ],
    [
        'id' => 6,
        'filename' => 'ngc7635.jpg',
        'title' => 'Nebulosa Bolla (NGC 7635)',
        'description' => 'Nebulosa ad emissione nella costellazione di Cassiopea, creata da venti stellari.',
        'category' => 'nebulosa',
        'date' => '2024-02-10',
        'location' => 'Puglia - Cielo Scuro',
        'camera' => 'Canon EOS Ra',
        'telescope' => 'Celestron EdgeHD 11"',
        'exposure' => '4h 45min (285 x 60s)',
        'iso' => '1600'
    ],
    [
        'id' => 7,
        'filename' => 'm33.jpg',
        'title' => 'Galassia del Triangolo (M33)',
        'description' => 'Galassia spirale nel Gruppo Locale, ricca di regioni di formazione stellare.',
        'category' => 'galassia',
        'date' => '2024-02-15',
        'location' => 'Puglia - Cielo Scuro',
        'camera' => 'ZWO ASI2600MC-Pro',
        'telescope' => 'Takahashi FSQ-106EDX',
        'exposure' => '7h 30min (450 x 60s)',
        'iso' => '800'
    ],
    [
        'id' => 8,
        'filename' => 'ngc7000.jpg',
        'title' => 'Nebulosa Nord America (NGC 7000)',
        'description' => 'Nebulosa ad emissione nella costellazione del Cigno, dalla forma caratteristica.',
        'category' => 'nebulosa',
        'date' => '2024-02-20',
        'location' => 'Puglia - Cielo Scuro',
        'camera' => 'Canon EOS Ra',
        'telescope' => 'William Optics GT81',
        'exposure' => '3h 15min (195 x 60s)',
        'iso' => '1600'
    ]
];

// Applica filtri
$filtered_images = $gallery_images;

if ($search) {
    $filtered_images = array_filter($filtered_images, function($img) use ($search) {
        return stripos($img['title'], $search) !== false || 
               stripos($img['description'], $search) !== false;
    });
}

if ($category) {
    $filtered_images = array_filter($filtered_images, function($img) use ($category) {
        return $img['category'] === $category;
    });
}

// Categorie disponibili
$categories = [
    'galassia' => '🌌 Galassie',
    'nebulosa' => '☁️ Nebulose',
    'ammasso' => '⭐ Ammassi',
    'luna' => '🌙 Luna',
    'pianeta' => '🪐 Pianeti'
];
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Astrofotografica | AstroGuida</title>
    <meta name="description" content="Esplora la nostra collezione di astrofotografie: galassie, nebulose, ammassi stellari e molto altro. Foto astronomiche professionali scattate in Puglia.">
    <meta name="keywords" content="astrofotografia, gallery, galassie, nebulose, ammassi stellari, foto astronomiche, cielo profondo">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Gallery Astrofotografica | AstroGuida">
    <meta property="og:description" content="Esplora la nostra collezione di astrofotografie professionali">
    <meta property="og:image" content="/fotoastronomia/m31.jpg">
    <meta property="og:url" content="<?= SITE_URL ?>/?page=gallery">
    <meta property="og:type" content="website">
    
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/assets/images/logo/astroguida-logo.jpg">
</head>
<body>
    <div class="stellar-background">
        <div class="stars"></div>
        <div class="nebula"></div>
        <div class="cosmic-particles"></div>
    </div>

    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <img src="/assets/images/logo/astroguida-logo.jpg" alt="AstroGuida Logo" class="logo-image">
                    <span class="logo-text">AstroGuida</span>
                </div>
                
                <nav class="nav">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/?page=services" class="nav-link">Servizi</a>
                    <a href="/?page=gallery" class="nav-link active">Gallery</a>
                    <a href="/?page=about" class="nav-link">Chi Siamo</a>
                    <a href="/?page=contact" class="nav-link">Contatti</a>
                    <a href="/?page=live-sky" class="nav-link">🔴 Live</a>
                </nav>

                <div class="header-actions">
                    <a href="/?page=booking" class="btn btn-primary btn-sm">
                        🚀 Prenota
                    </a>
                    <a href="/?page=login" class="btn btn-ghost btn-sm">
                        👤 Login
                    </a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content text-center">
                    <h1 class="hero-title">
                        Gallery Astrofotografica
                    </h1>
                    <p class="hero-subtitle">
                        Esplora la nostra collezione di astrofotografie professionali. 
                        Ogni immagine racconta una storia dell'universo.
                    </p>
                </div>
            </div>
        </section>

        <!-- Filtri e Ricerca -->
        <section class="section">
            <div class="container">
                <div class="max-w-4xl mx-auto">
                    <div class="card mb-8">
                        <form method="GET" class="space-y-4">
                            <input type="hidden" name="page" value="gallery">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="search" class="form-label">🔍 Cerca</label>
                                    <input type="text" 
                                           id="search" 
                                           name="search" 
                                           value="<?= htmlspecialchars($search) ?>" 
                                           placeholder="Cerca per nome o descrizione..." 
                                           class="form-input">
                                </div>
                                <div>
                                    <label for="category" class="form-label">🏷️ Categoria</label>
                                    <select id="category" name="category" class="form-select">
                                        <option value="">Tutte le categorie</option>
                                        <?php foreach ($categories as $key => $label): ?>
                                            <option value="<?= $key ?>" <?= $category === $key ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex gap-4 justify-center">
                                <button type="submit" class="btn btn-primary">
                                    🔍 Cerca
                                </button>
                                <a href="/?page=gallery" class="btn btn-secondary">
                                    🔄 Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Statistiche -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="card text-center">
                            <div class="text-2xl font-bold text-cyan"><?= count($filtered_images) ?></div>
                            <div class="text-silver text-sm">Immagini Trovate</div>
                        </div>
                        <div class="card text-center">
                            <div class="text-2xl font-bold text-purple"><?= count($gallery_images) ?></div>
                            <div class="text-silver text-sm">Totale Gallery</div>
                        </div>
                        <div class="card text-center">
                            <div class="text-2xl font-bold text-green">50+</div>
                            <div class="text-silver text-sm">Ore di Esposizione</div>
                        </div>
                        <div class="card text-center">
                            <div class="text-2xl font-bold text-orange">8</div>
                            <div class="text-silver text-sm">Categorie</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Grid -->
        <section class="section">
            <div class="container">
                <?php if (empty($filtered_images)): ?>
                    <div class="text-center">
                        <div class="card max-w-md mx-auto">
                            <div class="text-6xl mb-4">🔍</div>
                            <h3 class="text-xl font-semibold text-white mb-4">Nessun Risultato</h3>
                            <p class="text-silver mb-6">
                                Non abbiamo trovato immagini che corrispondono ai tuoi criteri di ricerca.
                            </p>
                            <a href="/?page=gallery" class="btn btn-primary">
                                🔄 Vedi Tutte le Immagini
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="gallery-grid">
                        <?php foreach ($filtered_images as $image): ?>
                            <div class="gallery-item" data-category="<?= $image['category'] ?>">
                                <div class="gallery-image-container">
                                    <img src="/fotoastronomia/<?= $image['filename'] ?>" 
                                         alt="<?= htmlspecialchars($image['title']) ?>" 
                                         class="gallery-image"
                                         onclick="openLightbox(<?= $image['id'] ?>)">
                                    <div class="gallery-overlay">
                                        <div class="gallery-info">
                                            <h3 class="gallery-title"><?= htmlspecialchars($image['title']) ?></h3>
                                            <p class="gallery-category"><?= $categories[$image['category']] ?></p>
                                            <div class="gallery-actions">
                                                <button onclick="openLightbox(<?= $image['id'] ?>)" class="btn btn-primary btn-sm">
                                                    👁️ Visualizza
                                                </button>
                                                <button onclick="openDetails(<?= $image['id'] ?>)" class="btn btn-secondary btn-sm">
                                                    ℹ️ Dettagli
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Lightbox -->
        <div id="lightbox" class="lightbox">
            <div class="lightbox-content">
                <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
                <img id="lightbox-image" src="" alt="">
                <div class="lightbox-info">
                    <h3 id="lightbox-title"></h3>
                    <p id="lightbox-description"></p>
                </div>
                <div class="lightbox-nav">
                    <button onclick="previousImage()" class="lightbox-nav-btn">❮</button>
                    <button onclick="nextImage()" class="lightbox-nav-btn">❯</button>
                </div>
            </div>
        </div>

        <!-- Modal Dettagli -->
        <div id="details-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modal-title"></h3>
                    <button class="modal-close" onclick="closeModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <img id="modal-image" src="" alt="" class="w-full rounded-lg">
                        </div>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-white mb-2">📝 Descrizione</h4>
                                <p id="modal-description" class="text-silver"></p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-2">🔧 Dati Tecnici</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-silver">Data:</span>
                                        <span id="modal-date" class="text-white"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-silver">Località:</span>
                                        <span id="modal-location" class="text-white"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-silver">Camera:</span>
                                        <span id="modal-camera" class="text-white"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-silver">Telescopio:</span>
                                        <span id="modal-telescope" class="text-white"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-silver">Esposizione:</span>
                                        <span id="modal-exposure" class="text-white"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-silver">ISO:</span>
                                        <span id="modal-iso" class="text-white"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModal()" class="btn btn-secondary">Chiudi</button>
                    <a href="/?page=booking" class="btn btn-primary">🚀 Prenota Sessione</a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-grid">
                    <div class="footer-section">
                        <div class="flex items-center mb-4">
                            <div class="logo-icon mr-3">
                                <img src="/assets/images/logo/astroguida-logo.jpg" alt="AstroGuida Logo">
                            </div>
                            <h3 class="text-xl font-bold">AstroGuida</h3>
                        </div>
                        <p>
                            La tua guida professionale per esplorare l'universo. 
                            Astrofotografia e turismo astronomico in Puglia.
                        </p>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Servizi</h3>
                        <ul class="space-y-2">
                            <li><a href="/?page=services#astrofotografia">Astrofotografia</a></li>
                            <li><a href="/?page=services#turismo">Turismo Astronomico</a></li>
                            <li><a href="/?page=services#osservazione">Osservazione Guidata</a></li>
                            <li><a href="/?page=services#corsi">Corsi di Astronomia</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Info Utili</h3>
                        <ul class="space-y-2">
                            <li><a href="/?page=gallery" class="text-cyan">Gallery</a></li>
                            <li><a href="/?page=about">Chi Siamo</a></li>
                            <li><a href="/?page=contact">Contatti</a></li>
                            <li><a href="/?page=faq">FAQ</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Seguici</h3>
                        <div class="flex space-x-4 mb-4">
                            <a href="#" class="text-silver hover:text-white">📘 Facebook</a>
                            <a href="#" class="text-silver hover:text-white">📷 Instagram</a>
                        </div>
                        <p class="text-silver text-sm">
                            📧 info@astroguida.com<br>
                            📱 +39 123 456 7890
                        </p>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; <?= date('Y') ?> AstroGuida. Tutti i diritti riservati.</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="/assets/js/stellar-animations.js"></script>
    <script>
        // Dati delle immagini per JavaScript
        const galleryData = <?= json_encode($gallery_images) ?>;
        let currentImageIndex = 0;
        
        // Inizializza animazioni stellari
        document.addEventListener('DOMContentLoaded', function() {
            const stellarAnimations = new StellarAnimations();
            stellarAnimations.init();
        });

        // Funzioni Lightbox
        function openLightbox(imageId) {
            const image = galleryData.find(img => img.id === imageId);
            if (!image) return;
            
            currentImageIndex = galleryData.findIndex(img => img.id === imageId);
            
            document.getElementById('lightbox-image').src = '/fotoastronomia/' + image.filename;
            document.getElementById('lightbox-title').textContent = image.title;
            document.getElementById('lightbox-description').textContent = image.description;
            document.getElementById('lightbox').style.display = 'flex';
            
            // Previeni scroll della pagina
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function previousImage() {
            currentImageIndex = (currentImageIndex - 1 + galleryData.length) % galleryData.length;
            const image = galleryData[currentImageIndex];
            document.getElementById('lightbox-image').src = '/fotoastronomia/' + image.filename;
            document.getElementById('lightbox-title').textContent = image.title;
            document.getElementById('lightbox-description').textContent = image.description;
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleryData.length;
            const image = galleryData[currentImageIndex];
            document.getElementById('lightbox-image').src = '/fotoastronomia/' + image.filename;
            document.getElementById('lightbox-title').textContent = image.title;
            document.getElementById('lightbox-description').textContent = image.description;
        }

        // Funzioni Modal Dettagli
        function openDetails(imageId) {
            const image = galleryData.find(img => img.id === imageId);
            if (!image) return;
            
            document.getElementById('modal-image').src = '/fotoastronomia/' + image.filename;
            document.getElementById('modal-title').textContent = image.title;
            document.getElementById('modal-description').textContent = image.description;
            document.getElementById('modal-date').textContent = image.date;
            document.getElementById('modal-location').textContent = image.location;
            document.getElementById('modal-camera').textContent = image.camera;
            document.getElementById('modal-telescope').textContent = image.telescope;
            document.getElementById('modal-exposure').textContent = image.exposure;
            document.getElementById('modal-iso').textContent = image.iso;
            
            document.getElementById('details-modal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('details-modal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Gestione tasti
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox').style.display === 'flex') {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') previousImage();
                if (e.key === 'ArrowRight') nextImage();
            }
            if (document.getElementById('details-modal').style.display === 'flex') {
                if (e.key === 'Escape') closeModal();
            }
        });

        // Chiudi lightbox cliccando fuori
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });

        // Chiudi modal cliccando fuori
        document.getElementById('details-modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
    
    <style>
        /* Stili Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .gallery-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: rgba(42, 42, 42, 0.8);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
        }
        
        .gallery-image-container {
            position: relative;
            overflow: hidden;
        }
        
        .gallery-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .gallery-image:hover {
            transform: scale(1.05);
        }
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }
        
        .gallery-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .gallery-category {
            font-size: 0.9rem;
            color: #64ffda;
            margin-bottom: 1rem;
        }
        
        .gallery-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        /* Stili Lightbox */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .lightbox-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            text-align: center;
        }
        
        .lightbox-close {
            position: absolute;
            top: -40px;
            right: -40px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 2rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .lightbox-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .lightbox img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 8px;
        }
        
        .lightbox-info {
            margin-top: 1rem;
            color: white;
        }
        
        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            pointer-events: none;
        }
        
        .lightbox-nav-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 2rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            pointer-events: auto;
            transition: background 0.3s ease;
        }
        
        .lightbox-nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Stili Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1001;
        }
        
        .modal-content {
            background: rgba(26, 26, 26, 0.95);
            border-radius: 12px;
            max-width: 800px;
            width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
            backdrop-filter: blur(10px);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modal-header h3 {
            color: white;
            font-size: 1.5rem;
            margin: 0;
        }
        
        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }
            
            .lightbox-nav-btn {
                width: 40px;
                height: 40px;
                font-size: 1.5rem;
            }
            
            .modal-content {
                width: 95vw;
            }
        }
    </style>
</body>
</html> 
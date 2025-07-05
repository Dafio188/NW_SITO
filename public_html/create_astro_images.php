<?php
/**
 * Generatore di immagini astronomiche diverse per la gallery
 */

// Funzione per creare immagine con testo e colori diversi
function createAstroImage($width, $height, $title, $subtitle, $filename, $bgColors, $textColor = [255, 255, 255]) {
    $image = imagecreate($width, $height);
    
    // Gradiente di sfondo
    $bg1 = imagecolorallocate($image, $bgColors[0][0], $bgColors[0][1], $bgColors[0][2]);
    $bg2 = imagecolorallocate($image, $bgColors[1][0], $bgColors[1][1], $bgColors[1][2]);
    $text_color = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);
    $accent = imagecolorallocate($image, 100, 255, 218);
    
    // Riempimento gradiente
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = $bgColors[0][0] + ($bgColors[1][0] - $bgColors[0][0]) * $ratio;
        $g = $bgColors[0][1] + ($bgColors[1][1] - $bgColors[0][1]) * $ratio;
        $b = $bgColors[0][2] + ($bgColors[1][2] - $bgColors[0][2]) * $ratio;
        $color = imagecolorallocate($image, $r, $g, $b);
        imageline($image, 0, $y, $width, $y, $color);
    }
    
    // Aggiungi stelle casuali
    for ($i = 0; $i < 30; $i++) {
        $x = rand(0, $width);
        $y = rand(0, $height);
        $star_color = imagecolorallocate($image, 255, 255, 255);
        imagesetpixel($image, $x, $y, $star_color);
        if (rand(0, 3) == 0) {
            imagesetpixel($image, $x+1, $y, $star_color);
            imagesetpixel($image, $x, $y+1, $star_color);
        }
    }
    
    // Titolo principale
    $font_size = 5;
    $title_width = imagefontwidth($font_size) * strlen($title);
    $x = ($width - $title_width) / 2;
    $y = $height / 2 - 20;
    imagestring($image, $font_size, $x, $y, $title, $text_color);
    
    // Sottotitolo
    $font_size = 3;
    $subtitle_width = imagefontwidth($font_size) * strlen($subtitle);
    $x = ($width - $subtitle_width) / 2;
    $y = $height / 2 + 10;
    imagestring($image, $font_size, $x, $y, $subtitle, $accent);
    
    // Bordo decorativo
    imagerectangle($image, 2, 2, $width-3, $height-3, $accent);
    
    // Salva immagine
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
    
    echo "✅ Creata: $filename - $title\n";
}

// Crea immagini astronomiche diverse
$astro_data = [
    [
        'file' => 'fotoastronomia/nebulosa-cuore.jpg',
        'title' => 'NEBULOSA CUORE',
        'subtitle' => 'IC 1805 - Cassiopeia',
        'colors' => [[20, 5, 30], [80, 20, 60]]
    ],
    [
        'file' => 'fotoastronomia/pleadi-m45.jpg',
        'title' => 'PLEIADI M45',
        'subtitle' => 'Ammasso Aperto - Toro',
        'colors' => [[5, 15, 40], [30, 60, 120]]
    ],
    [
        'file' => 'fotoastronomia/velo.jpg',
        'title' => 'NEBULOSA VELO',
        'subtitle' => 'NGC 6960 - Cigno',
        'colors' => [[10, 30, 20], [40, 80, 60]]
    ],
    [
        'file' => 'fotoastronomia/ngc7000.jpg',
        'title' => 'NORD AMERICA',
        'subtitle' => 'NGC 7000 - Cigno',
        'colors' => [[30, 10, 5], [100, 40, 20]]
    ],
    [
        'file' => 'fotoastronomia/rosetta.jpg',
        'title' => 'NEBULOSA ROSETTA',
        'subtitle' => 'NGC 2237 - Unicorno',
        'colors' => [[40, 5, 20], [120, 30, 60]]
    ]
];

foreach ($astro_data as $data) {
    createAstroImage(400, 300, $data['title'], $data['subtitle'], $data['file'], $data['colors']);
}

echo "\n🌌 Tutte le immagini astronomiche sono state create!\n";
echo "📸 Gallery completa con 6 oggetti del cielo profondo\n";
?> 
<?php
/**
 * Generatore di immagini placeholder per AstroGuida
 * Crea immagini placeholder per la gallery astronomica
 */

// Crea le directory se non esistono
$dirs = [
    'fotoastronomia',
    'assets/images/services',
    'assets/images/logo'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Funzione per creare immagine placeholder
function createPlaceholder($width, $height, $text, $filename, $bgColor = [26, 26, 46], $textColor = [100, 255, 218]) {
    $image = imagecreate($width, $height);
    
    // Colori
    $bg = imagecolorallocate($image, $bgColor[0], $bgColor[1], $bgColor[2]);
    $text_color = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);
    $border = imagecolorallocate($image, 100, 210, 255);
    
    // Riempimento sfondo
    imagefill($image, 0, 0, $bg);
    
    // Bordo
    imagerectangle($image, 0, 0, $width-1, $height-1, $border);
    
    // Testo centrato
    $font_size = 5;
    $text_width = imagefontwidth($font_size) * strlen($text);
    $text_height = imagefontheight($font_size);
    
    $x = ($width - $text_width) / 2;
    $y = ($height - $text_height) / 2;
    
    imagestring($image, $font_size, $x, $y, $text, $text_color);
    
    // Salva immagine
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
    
    echo "✅ Creata: $filename\n";
}

// Crea immagini per la gallery astronomica
$astro_images = [
    ['m31.jpg', 'Galassia Andromeda M31'],
    ['nebulosa-cuore.jpg', 'Nebulosa Cuore'],
    ['pleadi-m45.jpg', 'Pleiadi M45'],
    ['rosetta.jpg', 'Nebulosa Rosetta'],
    ['velo.jpg', 'Nebulosa del Velo'],
    ['ngc7000.jpg', 'Nebulosa Nord America']
];

foreach ($astro_images as $img) {
    createPlaceholder(400, 300, $img[1], "fotoastronomia/{$img[0]}");
}

// Crea immagini per i servizi
$service_images = [
    ['tour-notturno.jpg', 'Tour Notturno'],
    ['osservazione-gruppo.jpg', 'Osservazione Gruppo'],
    ['telescopio.jpg', 'Telescopio Professionale'],
    ['astrofotografia.jpg', 'Sessione Astrofotografia']
];

foreach ($service_images as $img) {
    createPlaceholder(500, 350, $img[1], "assets/images/services/{$img[0]}");
}

// Crea logo placeholder
createPlaceholder(512, 512, 'AstroGuida Logo', 'assets/images/logo/logo-512.png', [0, 122, 255], [255, 255, 255]);
createPlaceholder(256, 256, 'AstroGuida', 'assets/images/logo/logo-256.png', [0, 122, 255], [255, 255, 255]);

echo "\n🎉 Tutte le immagini placeholder sono state create con successo!\n";
echo "📁 Cartelle create:\n";
foreach ($dirs as $dir) {
    echo "   - $dir/\n";
}
?> 
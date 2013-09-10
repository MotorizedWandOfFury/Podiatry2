<?php

// Variables

$string = empty($_GET['name']) ? "" : htmlspecialchars($_GET['name']);
$color = empty($_GET['color']) ? "yellow" : htmlspecialchars($_GET['color']);
$font_size = 3;
$height = imagefontheight($font_size) + 1;
$width = (imagefontwidth($font_size) * strlen($string)) + 1;

// Create Image

$img = imagecreatetruecolor($width, $height);

// Colors

$bg = imagecolorallocate($img, 0, 0, 0);
$black = imagecolorallocate($img, 1, 1, 1);

switch ($color)
{
    case "red":
        $color = imagecolorallocate($img, 255, 185, 185);
        break;
    case "orange":
        break;
    case "yellow":
        $color = imagecolorallocate($img, 255, 255, 185);
        break;
    case "green":
        $color = imagecolorallocate($img, 185, 255, 185);
        break;
    case "blue":
    case "purple":
    case "brown":
        break;
    case "black":
        $color = imagecolorallocate($img, 1, 1, 1);
        break;
    case "grey":
        $color = imagecolorallocate($img, 225, 225, 225);
        break;
    case "white":
        $color = imagecolorallocate($img, 255, 255, 255);
        break;
}

// Trans

imagecolortransparent($img, $bg);

// Functions

function doString($font, $x, $y, $string, $shadow, $color)
{
    global $img, $black;

    switch ($shadow)
    {
        // Add a shadow to the text.
        case true:
            // Text-Shadow
            imagestring($img, $font, $x, $y - 1, $string, $black);
            imagestring($img, $font, $x + 1, $y - 1, $string, $black);
            imagestring($img, $font, $x + 1, $y, $string, $black);
            imagestring($img, $font, $x + 1, $y + 1, $string, $black);
            imagestring($img, $font, $x, $y + 1, $string, $black);
            imagestring($img, $font, $x - 1, $y + 1, $string, $black);
            imagestring($img, $font, $x - 1, $y, $string, $black);
            imagestring($img, $font, $x - 1, $y - 1, $string, $black);
            // Text
            imagestring($img, $font, $x, $y, $string, $color);
            break;
        // Do not add a shadow to the text.
        case false:
            imagestring($img, $font, $x, $y, $string, $color);
            break;
    }
}

// Drawings

doString($font_size, 1, 0, $string, true, $color);

// Output

header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
?>
<?php
function resize_image($srcFrom, $destPath, $width, $height)
{
    list($srcWidth, $srcHeight, $srcType) = getimagesize($srcFrom);

    switch ($srcType) {
        case IMAGETYPE_JPEG:
            $srcImg = imagecreatefromjpeg($srcFrom);
            break;
        case IMAGETYPE_PNG:
            $srcImg = imagecreatefrompng($srcFrom);
            break;
        default:
            return false;
    }

    $thumbImg = imagecreatetruecolor($width, $height);

    $srcAspect = $srcWidth / $srcHeight;
    $thumbAspect = $width / $height;

    if ($srcAspect > $thumbAspect) {
        $thumbHeight = $height;
        $thumbWidth = $height * $srcAspect;
    } else {
        $thumbWidth = $width;
        $thumbHeight = $width / $srcAspect;
    }

    $x = 0 - ($thumbWidth - $width) / 2;
    $y = 0 - ($thumbHeight - $height) / 2;

    imagecopyresampled($thumbImg, $srcImg, $x, $y, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);

    switch ($srcType) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumbImg, $destPath);
            break;
        case IMAGETYPE_PNG:
            imagepng($thumbImg, $destPath);
            break;
    }

    imagedestroy($srcImg);
    imagedestroy($thumbImg);
    return true;
}


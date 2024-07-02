<?php

    if (isset($_FILES['image'])) {
        $tmpName = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];

        $uploadTo = 'images/';
        $uploadPath = $uploadTo . $imageName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            resize_image($uploadPath, $uploadPath,200, 200);
            echo '<h2>Uploaded Images</h2>';
            echo '<p>Original Image:</p>';
            echo '<img src="' . $uploadPath . '" width="400"><br><br>';
            echo '<p>Thumbnail Image:</p>';
            echo '<img src="' . $uploadPath . '" width="200">';
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Error uploading image.";
    }


    function resize_image($srcFrom, $destPath, $width, $height) {
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


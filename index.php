<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload and Resize</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .upload-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .upload-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .upload-form {
            text-align: center;
        }

        .upload-form input[type=file] {
            display: block;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 300px;
            box-sizing: border-box;
        }

        .upload-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .upload-form button:hover {
            background-color: #45a049;
        }
    </style>

</head>
<body>

<div class="upload-container">
    <h2>Upload an Image</h2>
    <form class="upload-form" action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <br><br>
        <button type="submit" name="submit">Upload Image</button>
    </form>
</div>


</body>
</html>

<?php

 require_once "functions.php";

if (isset($_FILES['image'])) {
    $tmpName = $_FILES['image']['tmp_name'];
    $imageName = $_FILES['image']['name'];

    $uploadTo = 'images/';
    $uploadPath = $uploadTo . $imageName;

    if (move_uploaded_file($tmpName, $uploadPath)) {
        resize_image($uploadPath, $uploadPath, 200, 200);
        echo '<h2>Uploaded Images</h2>';
        echo '<p>Original Image:</p>';
        echo '<img src="' . $uploadPath . '" width="400"><br><br>';
        echo '<p>Thumbnail Image:</p>';
        echo '<img src="' . $uploadPath . '" width="200">';
    } else {
        echo "Error uploading image.";
    }
}



?>




<!DOCTYPE html>
<html>
<head>
    <title>T-Shirt Design Tool</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            background: #f5f5f5;
        }

        .container {
            margin-top: 30px;
        }

        .tshirt-box {
            position: relative;
            width: 300px;
            margin: auto;
        }

        .tshirt-box img {
            width: 100%;
        }

        #design {
            position: absolute;
            top: 90px;
            left: 90px;
            width: 120px;
            cursor: move;
        }
    </style>
</head>
<body>

<h2>👕 AI T-Shirt Design Tool (Step 1)</h2>

<div class="container">

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="design" accept="image/png,image/jpeg" required>
        <button type="submit">Upload Design</button>
    </form>

    <br>

    <div class="tshirt-box">
        <img src="assets/tshirt.png">

        <?php if(isset($_GET['img'])): ?>
            <img id="design" src="uploads/<?php echo $_GET['img']; ?>">
        <?php endif; ?>
    </div>

</div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>T-Shirt Design Tool</title>
 <link rel="stylesheet" href="css/style.css">

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

        <div id="printArea">
            <?php if(isset($_GET['img'])): ?>
               <?php
                    if(isset($_GET['img'])){
                        $img = basename($_GET['img']); 
                        echo '<img id="design" src="uploads/'.$img.'">';
                    }
                    ?>

            <?php endif; ?>
        </div>
    </div>

       <!-- Resize -->
        <?php if(isset($_GET['img'])): ?>
            <br>
            <label>Resize Design:</label>
            <input type="range" id="sizeControl" min="50" max="300" value="120">
        <?php endif; ?>
        

        <!-- Control Buttons -->
        <br><br>
        <button onclick="autoFit()">🔥 AI Auto Fit</button>

        <button onclick="autoCenter()">Auto Center</button>
        <button onclick="resetDesign()">Reset</button>

        <button onclick="rotateLeft()">⟲ Rotate Left</button>
        <button onclick="rotateRight()">⟳ Rotate Right</button>

        <button onclick="showFront()">Front</button>
        <button onclick="showBack()">Back</button>

        <button onclick="saveDesign()">💾 Save Design</button>

        <button onclick="downloadMockup()">📥 Download Mockup</button>





</div>

<script src="js/main.js"></script>



</body>
</html>

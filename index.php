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
            border: 2px dashed #ccc;
            background: white;
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
            border: 1px dashed #000;
        }

        /* Resize slider */
        #sizeControl {
            margin-top: 15px;
            width: 200px;
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

        <?php if(isset($_GET['img'])): ?>
    <br>
    <label>Resize Design:</label>
    <input type="range" id="sizeControl" min="50" max="300" value="120">
<?php endif; ?>
    </div>

</div>




<script>
const design = document.getElementById("design");
const sizeControl = document.getElementById("sizeControl");

if (design) {

    // Resize with slider
    sizeControl.addEventListener("input", function() {
        design.style.width = this.value + "px";
    });

    // Drag functionality
    let isDragging = false;
    let offsetX, offsetY;

    design.addEventListener("mousedown", function(e) {
        isDragging = true;
        offsetX = e.offsetX;
        offsetY = e.offsetY;
    });

    document.addEventListener("mousemove", function(e) {
        if (isDragging) {
            const parent = document.querySelector(".tshirt-box");
            const rect = parent.getBoundingClientRect();

            let x = e.clientX - rect.left - offsetX;
            let y = e.clientY - rect.top - offsetY;

            design.style.left = x + "px";
            design.style.top = y + "px";
        }
    });

    document.addEventListener("mouseup", function() {
        isDragging = false;
    });
}
</script>


</body>
</html>

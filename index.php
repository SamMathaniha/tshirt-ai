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
            top: 0;
            left: 0;
            width: 120px;
            cursor: move;
            border: 1px dashed #000;
        }

        /* Resize slider */
        #sizeControl {
            margin-top: 15px;
            width: 200px;
        }
        #printArea {
            position: absolute;
            top: 55px;
            left: 70px;
            width: 160px;
            height: 220px;
            border: 2px dashed red;
            overflow: hidden;
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




</div>



<script>
const design = document.getElementById("design");
const sizeControl = document.getElementById("sizeControl");
const printArea = document.getElementById("printArea");

if (design) {

    // Resize
   if (design && sizeControl) {
    sizeControl.addEventListener("input", function() {
        design.style.width = this.value + "px";
    });
}


    let isDragging = false;
    let offsetX, offsetY;

    design.addEventListener("mousedown", function(e) {
    isDragging = true;
    offsetX = e.clientX - design.offsetLeft;
    offsetY = e.clientY - design.offsetTop;
    });

    document.addEventListener("mousemove", function(e) {
        if (!isDragging) return;

        let x = e.clientX - offsetX;
        let y = e.clientY - offsetY;

        const maxX = printArea.clientWidth - design.offsetWidth;
        const maxY = printArea.clientHeight - design.offsetHeight;

        x = Math.max(0, Math.min(x, maxX));
        y = Math.max(0, Math.min(y, maxY));

        design.style.left = x + "px";
        design.style.top = y + "px";
    });


    document.addEventListener("mouseup", function() {
        isDragging = false;
    });
}

// Auto Center
function autoCenter() {
    const x = (printArea.clientWidth - design.offsetWidth) / 2;
    const y = (printArea.clientHeight - design.offsetHeight) / 2;
    design.style.left = x + "px";
    design.style.top = y + "px";
}

// Reset
function resetDesign() {
    design.style.width = "120px";
    autoCenter();
}

function autoFit() {
    const areaW = printArea.clientWidth;
    const areaH = printArea.clientHeight;

    const img = design;

    const ratio = Math.min(areaW / img.naturalWidth, areaH / img.naturalHeight);

    img.style.width = (img.naturalWidth * ratio) + "px";

    autoCenter();
}


let currentRotation = 0;

function rotateLeft() {
    currentRotation -= 15;
    design.style.transform = `rotate(${currentRotation}deg)`;
}

function rotateRight() {
    currentRotation += 15;
    design.style.transform = `rotate(${currentRotation}deg)`;
}

const tshirtBox = document.querySelector(".tshirt-box img");
let isFront = true;

function showFront() {
    tshirtBox.src = "assets/tshirt.png"; // front view
    isFront = true;
}

function showBack() {
    tshirtBox.src = "assets/tshirt_back.png"; // back view
    isFront = false;
}


function getDesignData() {
    return {
        img: design.src.split("/").pop(),
        left: parseInt(design.style.left),
        top: parseInt(design.style.top),
        width: parseInt(design.style.width),
        rotation: currentRotation,
        view: isFront ? "front" : "back"
    };
}


function saveDesign() {
    const data = getDesignData();

    fetch("save_design.php", {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => alert(res.status));
}



</script>



</body>
</html>

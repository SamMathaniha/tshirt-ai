const design = document.getElementById("design");
const sizeControl = document.getElementById("sizeControl");
const printArea = document.getElementById("printArea");
const tshirtBox = document.querySelector(".tshirt-box img");
let currentRotation = 0;
let isFront = true;

if (design) {
    // Resize
    if (sizeControl) {
        sizeControl.addEventListener("input", function() {
            design.style.width = this.value + "px";
        });
    }

    // Drag
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

// Auto Fit
function autoFit() {
    const areaW = printArea.clientWidth;
    const areaH = printArea.clientHeight;
    const img = design;
    const ratio = Math.min(areaW / img.naturalWidth, areaH / img.naturalHeight);
    img.style.width = (img.naturalWidth * ratio) + "px";
    autoCenter();
}

// Rotate
function rotateLeft() {
    currentRotation -= 15;
    design.style.transform = `rotate(${currentRotation}deg)`;
}

function rotateRight() {
    currentRotation += 15;
    design.style.transform = `rotate(${currentRotation}deg)`;
}

// Front/Back
function showFront() {
    tshirtBox.src = "assets/tshirt.png";
    isFront = true;
}

function showBack() {
    tshirtBox.src = "assets/tshirt_back.png";
    isFront = false;
}

// Get Design Data
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

// Save
function saveDesign() {
    const data = getDesignData();
    fetch("save_design.php", {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => alert(res.status));
}

// Download Mockup
function downloadMockup() {
    if (!design) return;

    const tshirtRect = tshirtBox.getBoundingClientRect();
    const printRect = printArea.getBoundingClientRect();

    const scaleX = tshirtBox.naturalWidth / tshirtRect.width;
    const scaleY = tshirtBox.naturalHeight / tshirtRect.height;

    const canvas = document.createElement("canvas");
    canvas.width = tshirtBox.naturalWidth;
    canvas.height = tshirtBox.naturalHeight;
    const ctx = canvas.getContext("2d");

    const tshirtImg = new Image();
    tshirtImg.src = tshirtBox.src;
    tshirtImg.onload = () => {
        ctx.drawImage(tshirtImg, 0, 0, canvas.width, canvas.height);

        fetch(design.src)
        .then(res => res.blob())
        .then(blob => {
            const reader = new FileReader();
            reader.onload = function() {
                const designImg = new Image();
                designImg.src = reader.result;
                designImg.onload = () => {
                    ctx.save();

                    const designX = (design.offsetLeft) * scaleX + (printRect.left - tshirtRect.left) * scaleX;
                    const designY = (design.offsetTop) * scaleY + (printRect.top - tshirtRect.top) * scaleY;

                    const w = parseInt(design.offsetWidth) * scaleX;
                    const h = designImg.height * (w / designImg.width);

                    ctx.translate(designX + w / 2, designY + h / 2);
                    ctx.rotate(currentRotation * Math.PI / 180);
                    ctx.drawImage(designImg, -w/2, -h/2, w, h);
                    ctx.restore();

                    const link = document.createElement("a");
                    link.download = "tshirt_mockup.png";
                    link.href = canvas.toDataURL();
                    link.click();
                };
            };
            reader.readAsDataURL(blob);
        });
    }
}

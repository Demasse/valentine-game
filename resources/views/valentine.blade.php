<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Saint-Valentin 💖</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
        font-family: 'Poppins', sans-serif;
        overflow: hidden;
    }
    #container {
        text-align: center;
        z-index: 1;
        position: relative;
    }
    button {
        margin: 10px;
        padding: 15px 30px;
        font-size: 1.2rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    canvas {
        position: fixed;
        top: 0;
        left: 0;
        pointer-events: none;
        z-index: 0;
    }
</style>
</head>
<body>
<div id="container">
    <div id="step1">
        <h1 class="text-4xl font-bold mb-6">Quel est ton prénom ? 💖</h1>
        <input type="text" id="nameInput" class="p-3 rounded text-xl" placeholder="Ton prénom">
        <br>
        <button id="nextBtn" class="bg-blue-400 hover:bg-blue-500 text-white mt-4">Suivant ➡️</button>
    </div>

    <div id="step2" style="display:none;">
        <h1 class="text-4xl font-bold mb-6" id="question"></h1>
        <button id="yesBtn" class="bg-green-400 hover:bg-green-500 text-white">Oui ✅</button>
        <button id="noBtn" class="bg-red-400 hover:bg-red-500 text-white">Non ❌</button>
        <p id="message" class="text-2xl mt-6 font-semibold"></p>
    </div>
</div>

<canvas id="fireworks"></canvas>

<script>
const step1 = document.getElementById('step1');
const step2 = document.getElementById('step2');
const nextBtn = document.getElementById('nextBtn');
const nameInput = document.getElementById('nameInput');
const question = document.getElementById('question');

const yesBtn = document.getElementById('yesBtn');
const noBtn = document.getElementById('noBtn');
const message = document.getElementById('message');

// Étape 1 → Étape 2
nextBtn.addEventListener('click', () => {
    const name = nameInput.value.trim();
    if(name === "") {
        alert("Merci d'écrire ton prénom 😘");
        return;
    }
    step1.style.display = "none";
    step2.style.display = "block";
    question.textContent = `Salut ${name} 💖 Veux-tu être ma Valentine ?`;
});

// Bouton Non qui bouge
noBtn.addEventListener('mouseover', () => {
    const x = Math.random() * (window.innerWidth - noBtn.offsetWidth);
    const y = Math.random() * (window.innerHeight - noBtn.offsetHeight);
    noBtn.style.position = 'absolute';
    noBtn.style.left = x + 'px';
    noBtn.style.top = y + 'px';
});

// Bouton Oui → message + feux d’artifice
yesBtn.addEventListener('click', () => {
    const name = nameInput.value.trim();
    message.textContent = `Yay 💖 Merci ${name} ! Tu es incroyable !`;
    yesBtn.disabled = true;
    noBtn.disabled = true;
    yesBtn.style.backgroundColor = '#f06292';
    noBtn.style.display = 'none';

    // Lancer feu d’artifice continu
    startContinuousFireworks();
});

/* ------------------------
   Feux d'artifice continus
------------------------ */
const canvas = document.getElementById('fireworks');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

class Particle {
    constructor(x, y, color, velX, velY, life) {
        this.x = x;
        this.y = y;
        this.color = color;
        this.velX = velX;
        this.velY = velY;
        this.life = life;
        this.alpha = 1;
    }
    update() {
        this.x += this.velX;
        this.y += this.velY;
        this.velY += 0.02; // gravité
        this.alpha -= 0.02;
        this.life--;
    }
    draw() {
        ctx.globalAlpha = this.alpha;
        ctx.fillStyle = this.color;
        ctx.beginPath();
        ctx.arc(this.x, this.y, 3, 0, Math.PI * 2);
        ctx.fill();
        ctx.globalAlpha = 1;
    }
}

let particles = [];
let fireworksInterval;

function launchFirework(x, y) {
    const colors = ['#ff4b5c','#ff8a5b','#ffcf5b','#6bffb8','#5bd1ff','#c25bff'];
    for(let i=0;i<100;i++){
        const angle = Math.random() * 2 * Math.PI;
        const speed = Math.random() * 5 + 2;
        const color = colors[Math.floor(Math.random() * colors.length)];
        particles.push(new Particle(
            x, y, color,
            Math.cos(angle)*speed,
            Math.sin(angle)*speed,
            50
        ));
    }
}

function startContinuousFireworks() {
    fireworksInterval = setInterval(() => {
        const x = Math.random() * window.innerWidth;
        const y = Math.random() * window.innerHeight/2; // explosions dans le haut
        launchFirework(x, y);
    }, 1000); // nouvelle explosion toutes les secondes
    requestAnimationFrame(animateFireworks);
}

function animateFireworks() {
    ctx.fillStyle = 'rgba(0,0,0,0.1)';
    ctx.fillRect(0,0,canvas.width,canvas.height);

    particles.forEach((p, index) => {
        p.update();
        p.draw();
        if(p.life <= 0) particles.splice(index, 1);
    });

    requestAnimationFrame(animateFireworks);
}

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});
</script>
</body>
</html>

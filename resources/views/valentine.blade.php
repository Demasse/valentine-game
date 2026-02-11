<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saint-Valentin 💖 - Une question spéciale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-pink: #ff4b7a;
            --secondary-pink: #ff8fab;
            --light-pink: #ffe4ec;
            --gold: #ffd166;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ffe4ec 0%, #ffc2d1 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        .valentine-title {
            font-family: 'Dancing Script', cursive;
            background: linear-gradient(45deg, var(--primary-pink), var(--gold));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(255, 75, 122, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }
        .card:hover { transform: translateY(-5px) scale(1.01); }
        .input-field {
            background: white;
            border: 2px solid #ffd1dc;
            border-radius: 12px;
            font-size: 1.1rem;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 4px rgba(255, 75, 122, 0.1);
        }
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-pink), var(--secondary-pink));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(255, 75, 122, 0.3);
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        .btn-primary:hover::after { left: 100%; }

        .btn-yes { background: linear-gradient(45deg, #4CAF50, #66BB6A); }
        .btn-no { background: linear-gradient(45deg, #FF5252, #FF867F); }

        .floating { animation: floating 3s ease-in-out infinite; }
        @keyframes floating { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-20px);} }

        .heart-beat { animation: heartBeat 1.2s infinite; }
        @keyframes heartBeat { 0%,100%{transform:scale(1);} 25%{transform:scale(1.1);} 50%{transform:scale(1);} 75%{transform:scale(1.05);} }

        .background-hearts {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 0;
        }

        .confetti { position: fixed; width: 15px; height: 15px; background: var(--primary-pink); opacity: 0.8; transform: rotate(45deg); animation: fall linear forwards; }
        @keyframes fall { to { transform: translateY(100vh) rotate(360deg); opacity: 0; } }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="background-hearts" id="backgroundHearts"></div>
    <canvas id="fireworksCanvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-10"></canvas>

    <div class="card p-8 md:p-12 max-w-2xl w-full relative z-20 fade-in">

        <!-- Étape 1 : Prénom -->
        <div id="step1" class="text-center">
            <h1 class="valentine-title text-5xl md:text-6xl mb-4">💖 Saint-Valentin 💖</h1>
            <p class="text-gray-600 text-lg mb-4">Une question spéciale pour toi...</p>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Quel est ton prénom ?</h2>
            <input type="text" id="nameInput" class="input-field w-full max-w-md mb-6 text-center" placeholder="Écris ton prénom ici..." autocomplete="off">
            <button id="nextBtn" class="btn-primary pulse">Continuer ➡️</button>
        </div>

        <!-- Étape 2 : Genre -->
        <div id="stepGender" class="text-center hidden">
            <h2 class="text-2xl font-semibold mb-4">Tu es un garçon ou une fille ?</h2>
            <div class="flex justify-center gap-6">
                <button id="genderMale" class="btn-primary btn-yes px-6 py-3">Garçon</button>
                <button id="genderFemale" class="btn-primary btn-yes px-6 py-3">Fille</button>
            </div>
        </div>

        <!-- Étape 3 : Question -->
        <div id="step2" class="text-center hidden">
            <h1 class="valentine-title text-4xl md:text-5xl mb-6" id="questionText"></h1>
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-8">
                <button id="yesBtn" class="btn-primary btn-yes px-8 py-4 text-lg">OUI ! 💝</button>
                <button id="noBtn" class="btn-primary btn-no px-8 py-4 text-lg">Non 😢</button>
            </div>
            <div id="messageContainer" class="mt-8">
                <p id="messageText" class="text-2xl md:text-3xl font-semibold"></p>
            </div>
        </div>
    </div>

    <audio id="romanticMusic" preload="auto" loop>
        <source src="https://cdn.pixabay.com/download/audio/2021/12/15/audio_2e69097bc7.mp3?filename=romantic-guitar-14899.mp3" type="audio/mpeg">
    </audio>

    <script>
        const step1 = document.getElementById('step1');
        const stepGender = document.getElementById('stepGender');
        const step2 = document.getElementById('step2');
        const nextBtn = document.getElementById('nextBtn');
        const nameInput = document.getElementById('nameInput');
        const questionText = document.getElementById('questionText');
        const yesBtn = document.getElementById('yesBtn');
        const noBtn = document.getElementById('noBtn');
        const messageText = document.getElementById('messageText');
        const messageContainer = document.getElementById('messageContainer');
        const backgroundHearts = document.getElementById('backgroundHearts');
        const music = document.getElementById('romanticMusic');

        const genderMale = document.getElementById('genderMale');
        const genderFemale = document.getElementById('genderFemale');

        let userName = '';
        let userGender = '';
        let fireworksInterval;
        let particles = [];
        const canvas = document.getElementById('fireworksCanvas');
        const ctx = canvas.getContext('2d');

        function init() {
            createBackgroundHearts();
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            nextBtn.addEventListener('click', goToGenderStep);
            genderMale.addEventListener('click', () => selectGender('male'));
            genderFemale.addEventListener('click', () => selectGender('female'));

            yesBtn.addEventListener('click', handleYes);
            noBtn.addEventListener('mouseover', moveNoButton);

            nameInput.addEventListener('keypress', (e) => { if(e.key==='Enter') goToGenderStep(); });
        }

        function createBackgroundHearts() {
            const colors = ['#ffc2d1','#ffb3c6','#ff8fab','#fb6f92'];
            for(let i=0;i<25;i++){
                const heart=document.createElement('div');
                heart.innerHTML='❤️';
                heart.style.position='absolute';
                heart.style.left=Math.random()*100+'%';
                heart.style.top=Math.random()*100+'%';
                heart.style.fontSize=(Math.random()*20+10)+'px';
                heart.style.opacity=Math.random()*0.3+0.1;
                heart.style.color=colors[Math.floor(Math.random()*colors.length)];
                heart.style.animation=`floating ${Math.random()*5+3}s ease-in-out infinite ${Math.random()*2}s`;
                backgroundHearts.appendChild(heart);
            }
        }

        function resizeCanvas(){ canvas.width=window.innerWidth; canvas.height=window.innerHeight; }

        function goToGenderStep(){
            userName = nameInput.value.trim();
            if(!userName){ alert("Écris ton prénom 💕"); return; }
            step1.classList.add('hidden');
            stepGender.classList.remove('hidden');
        }

        function selectGender(gender){
            userGender = gender;
            stepGender.classList.add('hidden');
            step2.classList.remove('hidden');

            if(userGender==='male') questionText.textContent=`${userName}, veux-tu être mon Valentine ? 💘`;
            else questionText.textContent=`${userName}, veux-tu être ma Valentine ? 💘`;

            sendDataToServer();
        }

        function sendDataToServer(){
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/save-valentine',{
                method:'POST',
                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ name: userName, gender: userGender })
            })
            .then(res=>res.json())
            .then(data=>console.log(data.message))
            .catch(err=>console.error('Erreur:',err));
        }

        function moveNoButton(){
            const maxX=window.innerWidth-noBtn.offsetWidth;
            const maxY=window.innerHeight-noBtn.offsetHeight;
            const newX=Math.random()*maxX;
            const newY=Math.random()*maxY;
            noBtn.style.position='fixed';
            noBtn.style.left=newX+'px';
            noBtn.style.top=newY+'px';
        }

        function handleYes(){
            yesBtn.style.opacity='0';
            noBtn.style.opacity='0';
            yesBtn.style.pointerEvents='none';
            noBtn.style.pointerEvents='none';

            messageText.innerHTML=`🎉 Yay ! Merci ${userName} ! 💖`;
            messageText.style.color='#ff4b7a';
            messageText.style.fontSize='2.5rem';
            messageText.classList.add('heart-beat');

            music.volume=0.4; music.play().catch(()=>{});

            startCelebration();
        }

        function startCelebration(){
            startFireworks();
            setInterval(createConfetti,100);
            startFallingHearts();
        }

        class FireworkParticle{
            constructor(x,y,color){
                this.x=x; this.y=y; this.color=color;
                this.size=Math.random()*4+2;
                this.speedX=Math.random()*6-3;
                this.speedY=Math.random()*6-3;
                this.life=100; this.gravity=0.05; this.friction=0.97;
            }
            update(){ this.speedX*=this.friction; this.speedY*=this.friction; this.speedY+=this.gravity; this.x+=this.speedX; this.y+=this.speedY; this.life--; this.size*=0.98; }
            draw(){ ctx.globalAlpha=this.life/100; ctx.fillStyle=this.color; ctx.beginPath(); ctx.arc(this.x,this.y,this.size,0,Math.PI*2); ctx.fill(); ctx.globalAlpha=1; }
        }

        function startFireworks(){
            const colors=['#ff4b7a','#ff8fab','#ffd166','#9d4edd','#4cc9f0'];
            fireworksInterval=setInterval(()=>{
                for(let i=0;i<3;i++){
                    const x=Math.random()*canvas.width;
                    const y=Math.random()*canvas.height*0.5;
                    const color=colors[Math.floor(Math.random()*colors.length)];
                    for(let j=0;j<80;j++){ particles.push(new FireworkParticle(x,y,color)); }
                }
            },800);
            animateFireworks();
        }

        function animateFireworks(){
            ctx.fillStyle='rgba(255,226,236,0.1)';
            ctx.fillRect(0,0,canvas.width,canvas.height);
            for(let i=particles.length-1;i>=0;i--){
                particles[i].update(); particles[i].draw();
                if(particles[i].life<=0||particles[i].size<=0.5){ particles.splice(i,1); }
            }
            requestAnimationFrame(animateFireworks);
        }

        function startFallingHearts(){
            setInterval(()=>{
                const heart=document.createElement('div');
                heart.innerHTML='💖';
                heart.style.position='fixed';
                heart.style.left=Math.random()*100+'%';
                heart.style.fontSize=(Math.random()*30+20)+'px';
                heart.style.opacity=Math.random()*0.7+0.3;
                heart.style.zIndex='5';
                heart.style.pointerEvents='none';
                heart.style.color=['#ff4b7a','#ff8fab','#fb6f92'][Math.floor(Math.random()*3)];
                document.body.appendChild(heart);

                const startY=-50,endY=window.innerHeight+50,duration=Math.random()*3000+3000;
                let startTime=null;
                function animate(currentTime){
                    if(!startTime) startTime=currentTime;
                    const elapsed=currentTime-startTime;
                    const progress=Math.min(elapsed/duration,1);
                    heart.style.top=(startY+(endY-startY)*progress)+'px';
                    heart.style.transform=`rotate(${progress*360}deg)`;
                    if(progress<1){ requestAnimationFrame(animate); } else { heart.remove(); }
                }
                requestAnimationFrame(animate);
            },200);
        }

        function createConfetti(){
            for(let i=0;i<30;i++){
                const confetti=document.createElement('div');
                confetti.className='confetti';
                confetti.style.left=Math.random()*100+'%';
                confetti.style.backgroundColor=['#ff4b7a','#ffd166','#9d4edd','#4cc9f0'][Math.floor(Math.random()*4)];
                confetti.style.animationDuration=(Math.random()*3+2)+'s';
                document.body.appendChild(confetti);
                setTimeout(()=>confetti.remove(),5000);
            }
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>

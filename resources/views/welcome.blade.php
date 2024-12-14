<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back o Front - ¡El Juego!</title>
    <style>
        :root {
            --primary-color: #646cff;
            --secondary-color: #535bf2;
            --background-color: #242424;
            --text-color: #ffffff;
            --success-color: #4caf50;
            --error-color: #f44336;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            text-align: center;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .game-container {
            display: none;
        }

        .start-screen {
            display: block;
        }

        .image-container {
            margin: 2rem 0;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .dev-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .feedback-icon {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 4rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feedback-icon.correct {
            color: var(--success-color);
        }

        .feedback-icon.incorrect {
            color: var(--error-color);
        }

        .feedback-icon.visible {
            opacity: 1;
        }

        .button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            margin: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: var(--secondary-color);
        }

        .score {
            font-size: 1.5rem;
            margin: 1rem 0;
        }

        .progress {
            font-size: 1.2rem;
            color: #888;
            margin-bottom: 1rem;
        }

        .final-score {
            display: none;
            font-size: 2rem;
            margin: 2rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="start-screen">
            <h1>Back o Front</h1>
            <p>¿Puedes identificar si el desarrollador es Backend o Frontend?</p>
            <button class="button" onclick="startGame()">¡Jugar!</button>
        </div>

        <div class="game-container">
            <div class="progress">Pregunta <span id="current-question">1</span>/10</div>
            <div class="score">Puntos: <span id="score">0</span></div>
            <div class="image-container">
                <div class="feedback-icon"></div>
                <img class="dev-image" id="dev-image" src="" alt="Desarrollador">
            </div>
            <div id="voto" class="buttons">
                <button class="button" onclick="checkAnswer('backend')">Backend</button>
                <button class="button" onclick="checkAnswer('frontend')">Frontend</button>
            </div>
            <div class="final-score" id="final-score"></div>
        </div>
    </div>

    <script>
        const developers = [
            { image: "{{ asset('img/back-1.jpg') }}", type: 'backend' },
            { image: "{{ asset('img/back-2.jpg') }}", type: 'backend' },
            { image: "{{ asset('img/back-3.jpg') }}", type: 'backend' },
            { image: "{{ asset('img/back-4.jpg') }}", type: 'backend' },
            { image: "{{ asset('img/back-5.jpg') }}", type: 'backend' },
            { image: "{{ asset('img/back-6.jpg') }}", type: 'backend' },
            { image: "{{ asset('img/back-7.jpg') }}", type: 'backend' },
            { image: "{{ asset('img/front-1.jpg') }}", type: 'frontend' },
            { image: "{{ asset('img/front-2.jpg') }}", type: 'frontend' },
            { image: "{{ asset('img/front-3.jpg') }}", type: 'frontend' },
            { image: "{{ asset('img/front-4.jpg') }}", type: 'frontend' },
            { image: "{{ asset('img/front-5.jpg') }}", type: 'frontend' },
            { image: "{{ asset('img/front-6.jpg') }}", type: 'frontend' },
            { image: "{{ asset('img/front-7.jpg') }}", type: 'frontend' }
        ];

        developers.sort(() => Math.random() - 0.5);

        let currentQuestion = 0;
        let score = 0;

        function startGame() {
            document.querySelector('.start-screen').style.display = 'none';
            document.querySelector('.game-container').style.display = 'block';
            document.querySelector('.final-score').style.display = 'none';
            loadQuestion();
        }

        function loadQuestion() {
            if (currentQuestion >= 10) {
                endGame();
                return;
            }

            const developer = developers[currentQuestion];
            document.getElementById('dev-image').src = developer.image;
            document.getElementById('current-question').textContent = currentQuestion + 1;

            // Reset feedback icon
            const feedbackIcon = document.querySelector('.feedback-icon');
            feedbackIcon.classList.remove('visible', 'correct', 'incorrect');
        }

        function checkAnswer(answer) {
            document.getElementById('voto').style.opacity = '0';
            document.getElementById('voto').style.pointerEvents = 'none';
            const developer = developers[currentQuestion];
            const isCorrect = answer === developer.type;

            if (isCorrect) {
                score++;
                document.getElementById('score').textContent = score;
            }

            // Show feedback
            showFeedback(isCorrect);

            // Wait for feedback animation before moving to next question
            setTimeout(() => {
                currentQuestion++;
                loadQuestion();
                document.getElementById('voto').style.opacity = '1';
                document.getElementById('voto').style.pointerEvents = 'auto';
            }, 1000);
        }

        function showFeedback(isCorrect) {
            const feedbackIcon = document.querySelector('.feedback-icon');
            feedbackIcon.textContent = isCorrect ? '✓' : '✗';
            feedbackIcon.classList.add('visible', isCorrect ? 'correct' : 'incorrect');
        }

        function endGame() {
            document.querySelector('.image-container').style.display = 'none';
            document.querySelector('.buttons').style.display = 'none';
            document.querySelector('.progress').style.display = 'none';
            document.querySelector('.final-score').style.display = 'block';
            document.querySelector('.final-score').textContent =
                `¡Juego terminado! Tu puntuación final es: ${score} de 10`;

            document.querySelector('.final-score').innerHTML += `
                <br><button class="button" onclick="resetGame()">Jugar de nuevo</button>
            `;
        }

        function resetGame() {
            currentQuestion = 0;
            score = 0;
            document.getElementById('score').textContent = '0';
            document.querySelector('.image-container').style.display = 'flex';
            document.querySelector('.buttons').style.display = 'block';
            document.querySelector('.progress').style.display = 'block';
            startGame();
        }
    </script>
</body>
</html>

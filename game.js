const developers = [
    { image: "img/1.webp", type: 'backend' },
    { image: "img/2.webp", type: 'backend' },
    { image: "img/3.webp", type: 'backend' },
    { image: "img/4.webp", type: 'backend' },
    { image: "img/5.webp", type: 'backend' },
    { image: "img/6.webp", type: 'backend' },
    { image: "img/7.webp", type: 'backend' },
    { image: "img/11.webp", type: 'frontend' },
    { image: "img/12.webp", type: 'frontend' },
    { image: "img/13.webp", type: 'frontend' },
    { image: "img/14.webp", type: 'frontend' },
    { image: "img/15.webp", type: 'frontend' },
    { image: "img/16.webp", type: 'frontend' },
    { image: "img/17.webp", type: 'frontend' }
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
    developers.sort(() => Math.random() - 0.5);
    currentQuestion = 0;
    score = 0;
    document.getElementById('score').textContent = '0';
    document.querySelector('.image-container').style.display = 'flex';
    document.querySelector('.buttons').style.display = 'block';
    document.querySelector('.progress').style.display = 'block';
    startGame();
}
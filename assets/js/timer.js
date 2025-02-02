let timeLeft = 300; // 5 minutes
let timerInterval = null;

function startTimer(gameOverCallback) {
    const timerElement = document.getElementById("timer");
    const progressBar = document.getElementById("progress-bar");

    function updateTimer() {
        timeLeft--;
        timerElement.textContent = formatTime(timeLeft);

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            gameOverCallback(false);
        } else {
            updateProgressBar();
        }
    }

    function updateProgressBar() {
        let percentage = (timeLeft / 300) * 100;
        progressBar.style.width = percentage + "%";

        if (percentage > 50) {
            progressBar.style.backgroundColor = "green";
        } else if (percentage > 10) {
            progressBar.style.backgroundColor = "orange";
        } else {
            progressBar.style.backgroundColor = "red";
        }
    }

    timerInterval = setInterval(updateTimer, 1000);
}

function stopTimer() {
    clearInterval(timerInterval);
}

function getElapsedTime() {
    return 300 - timeLeft; // Retourne le temps utilisé
}

function formatTime(seconds) {
    let minutes = Math.floor(seconds / 60);
    let secs = seconds % 60;
    return `${minutes}:${secs < 10 ? "0" : ""}${secs}`;
}
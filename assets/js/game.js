
const difficultyOptions = {
    "Easy": { time: 300, pairs: 10 },
    "Medium": { time: 270, pairs: 12 },
    "Hard": { time: 240, pairs: 14 }
};

let difficulty = "Easy";

function selectDifficulty() {
    let choice = prompt("Choose difficulty: Easy, Medium, Hard", "Easy");
    if (difficultyOptions[choice]) {
        difficulty = choice;
    } else {
        alert("Invalid choice, defaulting to Easy.");
    }
}

selectDifficulty();

document.addEventListener("DOMContentLoaded", () => {
    const board = document.getElementById("game-board");
    const restartButton = document.getElementById("restart-btn");
    const difficultySetting = difficultyOptions[difficulty];
    
    let timeLeft = difficultySetting.time;
    let matchedPairs = 0;
    let lockBoard = false;
    let firstCard, secondCard;
    
    const images = [
        "card-1.png", "card-2.png", "card-3.png", "card-4.png",
        "card-5.png", "card-6.png", "card-7.png", "card-8.png",
        "card-9.png", "card-10.png", "card-11.png", "card-12.png"
    ].slice(0, difficultySetting.pairs); 

    let cards = [...images, ...images]; 
    cards.sort(() => Math.random() - 0.5); 

    board.innerHTML = "";
    cards.forEach(image => {
        const card = document.createElement("div");
        card.classList.add("card");
        card.dataset.image = image;
        card.innerHTML = `<img src="../assets/images/${image}" class="hidden">`;
        card.addEventListener("click", flipCard);
        board.appendChild(card);
    });

    function flipCard() {
        if (lockBoard || this === firstCard) return;
        this.querySelector("img").classList.remove("hidden");

        if (!firstCard) {
            firstCard = this;
            return;
        }

        secondCard = this;
        checkForMatch();
    }

    function checkForMatch() {
        if (firstCard.dataset.image === secondCard.dataset.image) {
            firstCard.removeEventListener("click", flipCard);
            secondCard.removeEventListener("click", flipCard);
            matchedPairs++;

            if (matchedPairs === difficultySetting.pairs) {
                gameOver(true);
            }
        } else {
            lockBoard = true;
            setTimeout(() => {
                firstCard.querySelector("img").classList.add("hidden");
                secondCard.querySelector("img").classList.add("hidden");
                resetBoard();
            }, 1000);
        }
    }

    function resetBoard() {
        [firstCard, secondCard, lockBoard] = [null, null, false];
    }

    function gameOver(won) {
        stopTimer();

        if (won) {
            alert("Congratulations! You won!");
            saveScore(difficultySetting.time - getElapsedTime());
        } else {
            alert("Time's up! You lost.");
        }
    }

    function saveScore(timeTaken) {
        fetch("../public/save_score.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `time_taken=${timeTaken}&difficulty=${difficulty}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("Your score has been saved!");
                location.reload();
            }
        });
    }

    restartButton.addEventListener("click", () => {
        location.reload();
    });

    startTimer(gameOver);
});

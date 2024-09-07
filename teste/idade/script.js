const birthDates = [
    new Date(1979, 6, 25),
    new Date(1955, 3, 12),
    new Date(1990, 10, 3),
    new Date(1977, 8, 8),
    new Date(1988, 1, 15),
    new Date(1970, 5, 20),
    new Date(1996, 2, 29),
    new Date(1987, 10, 14),
    new Date(1978, 8, 2),
    new Date(1960, 11, 18),
    new Date(1985, 2, 25),
    new Date(1969, 7, 30),
    new Date(1970, 5, 7),
    new Date(1987, 8, 22),
    new Date(1988, 3, 15),
    new Date(1953, 10, 19)
];
let currentBirthDate = new Date();
let currentDate = new Date();
const feedbackElement = document.getElementById("feedback");
const birthDateElement = document.getElementById("birth-date");

function getRandomBirthDate() {
    return birthDates[Math.floor(Math.random() * birthDates.length)];
}

function calculateAge(birthDate, currentDate) {
    let age = currentDate.getFullYear() - birthDate.getFullYear();
    const m = currentDate.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && currentDate.getDate() < birthDate.getDate())) {
        age--;
    }
    alert(age);
    return age;
}

function displayQuestion() {
    currentBirthDate = getRandomBirthDate();
    birthDateElement.textContent = currentBirthDate.toLocaleDateString('pt-BR');
    feedbackElement.textContent = "";
    document.getElementById("age-input").focus();
}

function checkAnswer() {
    const userAnswer = parseInt(document.getElementById("age-input").value);
    const correctAnswer = calculateAge(currentBirthDate, new Date());
    console.log(correctAnswer);
    if (userAnswer === correctAnswer) {
        feedbackElement.textContent = "Correto!";
        feedbackElement.style.color = "lime";
        triggerConfetti();
        setTimeout(nextQuestion, 2000);
    } else {
        feedbackElement.textContent = `Na verdade, a pessoa teria ${correctAnswer} anos em 09/06/2024.`;
        feedbackElement.style.color = "red";
    }
    document.getElementById("age-input").value = "";
}

function nextQuestion() {
    displayQuestion();
}

function handleKeyPress(event) {
    if (event.key === "Enter") {
        checkAnswer();
    }
}

document.addEventListener("DOMContentLoaded", displayQuestion);

function triggerConfetti() {
    const confettiContainer = document.getElementById("confetti-container");
    for (let i = 0; i < 100; i++) {
        const confetti = document.createElement("div");
        confetti.classList.add("confetti");
        confetti.style.left = `${Math.random() * 100}vw`;
        confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
        confettiContainer.appendChild(confetti);
        setTimeout(() => {
            confetti.remove();
        }, 3000);
    }
}

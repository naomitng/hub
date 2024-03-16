const imgPaths = [
    '../img/bg-quad.jpg',
    '../img/bg-rtu.jpg',
];

let currentIndex = 0;

function changeBackground() {
    document.body.style.backgroundImage = `url(${imgPaths[currentIndex]})`;
    currentIndex = (currentIndex + 1) % imgPaths.length;
}

const intervalId = setInterval(changeBackground, 3000); // Change image every 3 seconds

window.addEventListener('beforeunload', () => {
    clearInterval(intervalId);
});
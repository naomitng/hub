// Array of backgrounds
const imgPaths = [
    '../img/bg-rtu.jpg',
    '../img/bg-quad.jpg'
];

function changeBackground() {
    const randomIndex = Math.floor(Math.random() * imgPaths.length);
    const imageUrl = `url(${imgPaths[randomIndex]})`;
    document.body.style.backgroundImage = imageUrl;
}

//  Change bg every 3 seconds
    //const intervalId = setInterval(changeBackground, 3000);

window.addEventListener('beforeunload', () => {
    clearInterval(intervalId);
});

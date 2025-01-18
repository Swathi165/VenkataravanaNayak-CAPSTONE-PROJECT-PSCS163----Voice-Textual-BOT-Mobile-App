let nextButton = document.getElementById('next');
let prevButton = document.getElementById('prev');
let carousel = document.querySelector('.carousel');
let listHTML = document.querySelector('.carousel .list');
let seeMoreButtons = document.querySelectorAll('.seeMore');
let backButton = document.getElementById('back');

let autoSlideInterval; // Variable for the automatic slide interval

const startAutoSlide = () => {
    autoSlideInterval = setInterval(() => {
        showSlider('next'); // Automatically move to the next slide
    }, 5000); // Adjust the interval (in milliseconds) for automatic sliding
};

nextButton.onclick = function() {
    clearInterval(autoSlideInterval); // Stop auto sliding when manually clicking
    showSlider('next');
    startAutoSlide(); // Restart auto sliding
};

prevButton.onclick = function() {
    clearInterval(autoSlideInterval); // Stop auto sliding when manually clicking
    showSlider('prev');
    startAutoSlide(); // Restart auto sliding
};

let unAcceppClick;
const showSlider = (type) => {
    nextButton.style.pointerEvents = 'none';
    prevButton.style.pointerEvents = 'none';

    carousel.classList.remove('next', 'prev');
    let items = document.querySelectorAll('.carousel .list .item');
    
    if (type === 'next') {
        listHTML.appendChild(items[0]);
        carousel.classList.add('next');
    } else {
        listHTML.prepend(items[items.length - 1]);
        carousel.classList.add('prev');
    }
    
    clearTimeout(unAcceppClick);
    unAcceppClick = setTimeout(() => {
        nextButton.style.pointerEvents = 'auto';
        prevButton.style.pointerEvents = 'auto';
    }, 2000);
};

seeMoreButtons.forEach((button) => {
    button.onclick = function() {
        carousel.classList.remove('next', 'prev');
        carousel.classList.add('showDetail');
        clearInterval(autoSlideInterval); // Stop auto sliding when viewing details
    }
});

backButton.onclick = function() {
    carousel.classList.remove('showDetail');
    startAutoSlide(); // Restart auto sliding when going back
};

// Start the automatic sliding when the page loads
startAutoSlide();

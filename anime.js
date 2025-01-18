document.addEventListener('DOMContentLoaded', () => {
    const categoryItems = document.querySelectorAll('.category-item');
    const productCards = document.querySelectorAll('.product-card');

    const revealItems = (items, containerSelector, delay) => {
        const container = document.querySelector(containerSelector);
        const containerPosition = container.getBoundingClientRect().top;
        const screenPosition = window.innerHeight;

        if (containerPosition < screenPosition) {
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('show');
                }, index * delay);
            });
        }
    };

    const handleReveal = () => {
        if (categoryItems.length) {
            revealItems(categoryItems, '.category-container', 400); // 200ms delay for category items
        }
        if (productCards.length) {
            revealItems(productCards, '.product-container', 400); // 300ms delay for product cards
        }
    };

    window.addEventListener('scroll', handleReveal);
    window.addEventListener('resize', handleReveal);
});

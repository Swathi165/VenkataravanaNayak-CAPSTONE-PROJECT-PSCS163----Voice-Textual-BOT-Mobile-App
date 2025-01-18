document.querySelectorAll('.product-card').forEach((card) => {
    var input = card.querySelector('input[type="number"]');
    var btnminus = card.querySelector('.qtyminus');
    var btnplus = card.querySelector('.qtyplus');

    if (input && btnminus && btnplus) {
        var min = Number(input.getAttribute('min'));
        var max = Number(input.getAttribute('max'));
        var step = Number(input.getAttribute('step'));

        function qtyminus(e) {
            var current = Number(input.value);
            var newval = (current - step);
            if (newval < min) {
                newval = min;
            } else if (newval > max) {
                newval = max;
            }
            input.value = Number(newval);
            e.preventDefault();
        }

        function qtyplus(e) {
            var current = Number(input.value);
            var newval = (current + step);
            if (newval > max) newval = max;
            input.value = Number(newval);
            e.preventDefault();
        }

        btnminus.addEventListener('click', qtyminus);
        btnplus.addEventListener('click', qtyplus);
    }
});

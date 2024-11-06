window.onload = function() {
    const form = document.querySelector('form');
    form.style.opacity = 0;
    form.style.transform = 'translateY(-20px)';
    setTimeout(() => {
        form.style.transition = 'opacity 0.5s, transform 0.5s';
        form.style.opacity = 1;
        form.style.transform = 'translateY(0)';
    }, 100);
};

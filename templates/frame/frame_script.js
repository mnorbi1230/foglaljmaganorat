const menuIcon = document.querySelector('.icon');
const navMenu = document.querySelector('.nav');

menuIcon.addEventListener('click', () => {
    menuIcon.classList.toggle('active');
    navMenu.classList.toggle('active');
});

document.querySelectorAll('.nav-link').forEach(element => {
    element.addEventListener('click', () => {
    menuIcon.classList.remove('active');
    navMenu.classList.remove('active');
})
});
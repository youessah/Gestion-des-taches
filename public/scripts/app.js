// App logic goes here


//Modal Form
const btnShowForm = document.querySelector('.btnShowForm');
const formAddEmploye = document.querySelector('form.add');
const container = document.querySelector('.container');
const btnCloseForm = document.querySelector('form.add .close');

if (btnShowForm && formAddEmploye) {
    btnShowForm.addEventListener('click', () => {
        formAddEmploye.classList.add('show');
        if (container) container.style.opacity = '0.5';
    });
}

if (btnCloseForm && formAddEmploye) {
    btnCloseForm.addEventListener('click', () => {
        formAddEmploye.classList.remove('show');
        if (container) container.style.opacity = '1';
    });
}

// Dark Mode Toggle Logic
const themeToggle = document.getElementById('theme-toggle');
const body = document.body;
const icon = themeToggle ? themeToggle.querySelector('i') : null;

// Vérifier les préférences sauvegardées
const currentTheme = localStorage.getItem('theme');
if (currentTheme === 'dark') {
    body.classList.add('dark-mode');
    if(icon) { icon.classList.replace('bx-moon', 'bx-sun'); }
}

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            if(icon) { icon.classList.replace('bx-moon', 'bx-sun'); }
        } else {
            localStorage.setItem('theme', 'light');
            if(icon) { icon.classList.replace('bx-sun', 'bx-moon'); }
        }
    });
}
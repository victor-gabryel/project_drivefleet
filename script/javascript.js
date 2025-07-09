// Função para alternar a visibilidade do menu e salvar o estado no localStorage
function toggleMenu() {
    const mobileMenu = document.querySelector('.mobile-menu');
    const menuIcon = document.querySelector('.menu-icon');

    // Adiciona ou remove a classe "show" no menu mobile
    mobileMenu.classList.toggle('show');

    if (mobileMenu.classList.contains('show')) {
        // Menu aberto, muda para um ícone de "X"
        menuIcon.innerHTML = `<div style="background-color: #fff; transform: rotate(45deg);"></div>
                              <div style="background-color: #fff; opacity: 0;"></div>
                              <div style="background-color: #fff; transform: rotate(-45deg);"></div>`;
        localStorage.setItem('menuState', 'open');
    } else {
        // Menu fechado, volta para o ícone de 3 linhas
        menuIcon.innerHTML = `<div></div>
                              <div></div>
                              <div></div>`;
        localStorage.setItem('menuState', 'closed');
    }
}




// Verifica o estado do menu no localStorage quando a página carrega
window.onload = function() {
    const savedState = localStorage.getItem('menuState');
    const mobileMenu = document.querySelector('.mobile-menu');
    const menuIcon = document.querySelector('.menu-icon');

    if (savedState === 'open') {
        mobileMenu.classList.add('show');
        menuIcon.innerHTML = `<div style="background-color: #fff; transform: rotate(45deg);"></div>
                              <div style="background-color: #fff; opacity: 0;"></div>
                              <div style="background-color: #fff; transform: rotate(-45deg);"></div>`;
    }

    // Fecha o menu se a tela estiver grande
    if (window.innerWidth >= 768) {
        mobileMenu.classList.remove('show');
        menuIcon.innerHTML = `<div></div>
                              <div></div>
                              <div></div>`;
        localStorage.setItem('menuState', 'closed');
    }
};







// Fecha o menu automaticamente ao redimensionar a janela para desktop
window.addEventListener('resize', () => {
    const mobileMenu = document.querySelector('.mobile-menu');
    const menuIcon = document.querySelector('.menu-icon');

    if (window.innerWidth >= 768) {
        mobileMenu.classList.remove('show');
        menuIcon.innerHTML = `<div></div>
                              <div></div>
                              <div></div>`;
        localStorage.setItem('menuState', 'closed');
    }
});

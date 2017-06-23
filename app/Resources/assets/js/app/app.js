$(document).ready(function () {

    /** Définition des variables */
    var navBrand = $('.block-nav-brand');
    var nav = $('.navbar-element');
    var authLogin = $('.auth-login');

    /** Si on clique sur l'icone 'bar' du header*/
    navBrand.click(function () {
        nav.fadeToggle();
        authLogin.fadeToggle();
    });
});

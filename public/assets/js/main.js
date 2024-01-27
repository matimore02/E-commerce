function toggleNavbar() {
    let navGroup = document.querySelector('.nav-group');
    navGroup.classList.contains('show') ? navGroup.classList.remove('show') : navGroup.classList.add('show');
}
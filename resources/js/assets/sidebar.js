let menu_btn = document.querySelector('#menu')
let sidebar = document.querySelector('.sidebar')
let search_btn = document.querySelector('.bx-search')

menu_btn.onclick = function() {
    sidebar.classList.toggle('active')
}

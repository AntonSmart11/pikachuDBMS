document.addEventListener('DOMContentLoaded', function() {
    selectedPage();
});

function selectedPage() {

    let list = document.querySelectorAll('.navigation li.db');
    let list_tables = document.querySelectorAll('.navigation li.tables');

    if(window.location.pathname.substring(17) == "index.php") {
        localStorage.setItem('link', '');
        list.forEach((item) => 
        item.classList.remove('selected'));
    }

    if(window.location.pathname.substring(17) == "databases.php") {
        localStorage.setItem('linkTable', '');
        list.forEach((item) => 
        item.classList.remove('selected2'));
    }

    list.forEach((item) => {
        if(item.childNodes[1].attributes.href.nodeValue.substring(19) == window.location.search.substring(6) ) {
            localStorage.setItem('link', item.childNodes[1].attributes.href.nodeValue.substring(19));
        }
    })

    const linkLocal = localStorage.getItem('link');
    const li = document.querySelector('a[href$="'+linkLocal+'"]');

    list_tables.forEach((item) => {
        item.classList.remove('point')
        if(item.classList.contains(linkLocal+'_db')) {
            item.classList.remove('hidden');
            item.classList.add('point');
        }
    })

    list_tables.forEach((item) => {
        if(item.childNodes[1].attributes.href.nodeValue.substring(16) == window.location.search.substring(6) && window.location.pathname.substring(17) == "tables.php") {
            localStorage.setItem('linkTable', item.childNodes[1].attributes.href.nodeValue.substring(16));
        }
    })

    const linkLocal_table = localStorage.getItem('linkTable');
    const li_table = document.querySelector('li.point a[href$="'+linkLocal_table+'"]');

    list.forEach((item) => 
    item.classList.remove('selected'));
    li.classList.add('selected');

    list_tables.forEach((item) => 
    item.classList.remove('selected2'));
    li_table.classList.add('selected2');
}
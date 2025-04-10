

document.querySelector('.nonjesuppr').addEventListener('click', enlever)

function enlever() {
    document.querySelector('.fixeddanslefixed').classList.remove('ouverturepopoup')
    document.querySelector('.cache_fond').classList.remove('cache_plein')
    document.querySelector('.cache_fond').classList.remove('ouvert2')
}
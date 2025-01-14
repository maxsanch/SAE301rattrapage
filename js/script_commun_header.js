// pour ouvrir le menu dans la version mobile du site 

document.querySelector('.tribarres').addEventListener('click', openmenu)

function openmenu(){
    document.querySelector('.liensdéroulant').classList.toggle('ouvertmenu')
}
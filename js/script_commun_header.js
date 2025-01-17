// pour ouvrir le menu dans la version mobile du site 

document.querySelector('.tribarres').addEventListener('click', openmenu)

function openmenu() {
    document.querySelector('.liensdéroulant').classList.toggle('ouvertmenu')
}

document.querySelector(".HeaderPartieDroite").addEventListener('mouseover', DeplacerBarreHeader)
document.querySelector(".HeaderPartieDroite").addEventListener('mouseleave', ReplacerBarreHeader)


function DeplacerBarreHeader() {
    if (this.children["2"].mouseover) {
        document.querySelector(".LaBarre").style = "background-color:#2fff00;"
    }
}

function ReplacerBarreHeader() {
    document.querySelector(".LaBarre").style = "background-color:#B95E06;"
}

// En vrai fait une fonction par enfant de la div HeaderPartieDroite ça sera plus simple
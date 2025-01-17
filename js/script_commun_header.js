// pour ouvrir le menu dans la version mobile du site 

document.querySelector('.tribarres').addEventListener('click', openmenu)

function openmenu() {
    document.querySelector('.liensdéroulant').classList.toggle('ouvertmenu')
}

// document.querySelector(".HeaderPartieDroite").addEventListener('mouseover', DeplacerBarreHeader)
document.querySelector(".HeaderPartieDroite").addEventListener('mouseleave', ReplacerBarreHeader)
// console.log(document.querySelector(".HeaderPartieDroite").children[2])
document.querySelector(".HeaderPartieDroite").children[0].addEventListener('mouseover', DeplacerBarreHeader1)
document.querySelector(".HeaderPartieDroite").children[1].addEventListener('mouseover', DeplacerBarreHeader2)
document.querySelector(".HeaderPartieDroite").children[2].addEventListener('mouseover', DeplacerBarreHeader3)
document.querySelector(".HeaderPartieDroite").children[3].addEventListener('mouseover', DeplacerBarreHeader4)
document.querySelector(".HeaderPartieDroite").children[4].addEventListener('mouseover', DeplacerBarreHeader5)


function DeplacerBarreHeader1() {
    document.querySelector(".LaBarre").style = "transform: translate(0%, -200%);";
}

function DeplacerBarreHeader2() {
    document.querySelector(".LaBarre").style = "transform: translate(235%, -200%);";
}

function DeplacerBarreHeader3() {
    document.querySelector(".LaBarre").style = "transform: translate(785%, -200%);";
}

function DeplacerBarreHeader4() {
    document.querySelector(".LaBarre").style = "transform: translate(1095%, -200%);";
}

function DeplacerBarreHeader5() {
    document.querySelector(".LaBarre").style = "transform: translate(1420%, -200%);";
}

function ReplacerBarreHeader() {
    document.querySelector(".LaBarre").style = "transform: translate(0%, -200%);";
}

// FAIRE LA SEPARATION DE LA BARRE POUR ADMIN ET CELLE POUR GENS NORMAUX 
// ASTUCE : FAIRE UN IF() AVEC LE NOMBRE D'ENFANT DU HEADER DEDANS CAR IL CHANGE ENTRE LES DEUX
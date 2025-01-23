// pour ouvrir le menu dans la version mobile du site 

document.querySelector('.tribarres').addEventListener('click', openmenu)

function openmenu() {
    document.querySelector('.liensdéroulant').classList.toggle('ouvertmenu')
}

// document.querySelector(".HeaderPartieDroite").addEventListener('mouseover', DeplacerBarreHeader)
// console.log(document.querySelector(".HeaderPartieDroite").children[2])
// console.log(document.querySelector(".HeaderPartieDroite").childElementCount)
if (document.querySelector(".HeaderPartieDroite").childElementCount == 5) {
    document.querySelector(".LaBarre").classList.add("LaBarre2")
    document.querySelector(".LaBarre2").classList.remove("LaBarre")
    document.querySelector(".HeaderPartieDroite").children[0].addEventListener('mouseover', DeplacerBarreHeader6)
    document.querySelector(".HeaderPartieDroite").children[1].addEventListener('mouseover', DeplacerBarreHeader7)
    document.querySelector(".HeaderPartieDroite").children[2].addEventListener('mouseover', DeplacerBarreHeader8)
    document.querySelector(".HeaderPartieDroite").children[3].addEventListener('mouseover', DeplacerBarreHeader9)
    document.querySelector(".HeaderPartieDroite").children[4].addEventListener('mouseover', DeplacerBarreHeader11)
    document.querySelector(".HeaderPartieDroite").addEventListener('mouseleave', ReplacerBarreHeader2)
}
else if (document.querySelector(".HeaderPartieDroite").childElementCount == 7) {
    document.querySelector(".HeaderPartieDroite").children[0].addEventListener('mouseover', DeplacerBarreHeader1)
    document.querySelector(".HeaderPartieDroite").children[1].addEventListener('mouseover', DeplacerBarreHeader2)
    document.querySelector(".HeaderPartieDroite").children[2].addEventListener('mouseover', DeplacerBarreHeader3)
    document.querySelector(".HeaderPartieDroite").children[3].addEventListener('mouseover', DeplacerBarreHeader4)
    document.querySelector(".HeaderPartieDroite").children[4].addEventListener('mouseover', DeplacerBarreHeader5)
    document.querySelector(".HeaderPartieDroite").children[5].addEventListener('mouseover', DeplacerBarreHeader10)
    document.querySelector(".HeaderPartieDroite").addEventListener('mouseleave', ReplacerBarreHeader)
}


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

function DeplacerBarreHeader10() {
    document.querySelector(".LaBarre").style = "transform: translate(1920%, -220%);";
}

function ReplacerBarreHeader() {
    document.querySelector(".LaBarre").style = "";
}

function DeplacerBarreHeader6() {
    document.querySelector(".LaBarre2").style = "transform: translate(0%, -100%);";
}

function DeplacerBarreHeader7() {
    document.querySelector(".LaBarre2").style = "transform: translate(235%, -100%);";
}

function DeplacerBarreHeader8() {
    document.querySelector(".LaBarre2").style = "transform: translate(480%, -100%);";
}

function DeplacerBarreHeader9() {
    document.querySelector(".LaBarre2").style = "transform: translate(780%, -100%);";
}

function DeplacerBarreHeader11() {
    document.querySelector(".LaBarre2").style = "transform: translate(1420%, -100%);";
}

function ReplacerBarreHeader2() {
    document.querySelector(".LaBarre2").style = "";
}
// FAIRE LA SEPARATION DE LA BARRE POUR ADMIN ET CELLE POUR GENS NORMAUX
// ASTUCE : FAIRE UN IF() AVEC LE NOMBRE D'ENFANT DU HEADER DEDANS CAR IL CHANGE ENTRE LES DEUX

const url = new URLSearchParams(window.location.search);

const jsruche = url.get('jsruche');
const ajout = url.get('page');
const suppression = url.get('idnote')

// pour ajouter une note

if (ajout == 'ajoutNote' && suppression != null) {
    document.querySelector('.confirmation').classList.add('ouvert2')
    document.querySelector('.cache_fond').classList.add('ouvert2')
}


document.querySelector('.croix').addEventListener('click', fermerlaconf)

function fermerlaconf() {

    document.querySelector('.confirmation').classList.remove('ouvert2')
    document.querySelector('.cache_fond').classList.remove('ouvert2')
}

if (jsruche != "null") {

    document.querySelector('#rchoisi').innerHTML = jsruche.split('0')[0] + ' ' + jsruche.split('0')[jsruche.split('0').length - 1]

    document.querySelectorAll('.recup').forEach(element => {
        element.parentElement.parentElement.classList.remove('disparu4')
        if (element.innerHTML == jsruche) {
            console.log('good')
        }
        else {
            console.log(element.innerHTML + '' + jsruche);
            element.parentElement.parentElement.classList.add('disparu4')
        }
    });
}

document.querySelectorAll('#choixruche').forEach(e => {
    e.innerHTML = e.innerHTML.split('0')[0] + " " + e.innerHTML.split('0')[e.innerHTML.split('0').length - 1]
});

document.querySelectorAll('.menu_deroulant').forEach(element => {
    element.addEventListener('click', openmenu)
    function openmenu() {
        element.querySelector('.absolute_deroulant').classList.toggle('ouvert')
    }
});


// pour les menus du filtre
if (document.querySelector('.groupe') != '') {

    document.querySelectorAll('#bps>.choix').forEach(e => {
        e.addEventListener('click', filtrer)

        function filtrer() {
            document.querySelector('#bpschoisi').innerHTML = e.innerHTML
            document.querySelectorAll('.batps').forEach(element => {
                element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.remove('disparu')
                if (Number(element.innerHTML.split(' ')[0]) >= Number(e.innerHTML.split(' ')[1]) && Number(element.innerHTML.split(' ')[0])) {
                    console.log('good')
                }
                else {
                    if (e.innerHTML == 'Pas de filtre.') {
                        element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.remove('disparu')
                    }
                    else {
                        element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add('disparu')
                    }
                }
            });
        }
    });
    document.querySelectorAll('#temps>.choix').forEach(e => {
        e.addEventListener('click', filtrer)
        function filtrer() {
            document.querySelector('#tpschoisi').innerHTML = e.innerHTML
            document.querySelectorAll('.temp').forEach(element => {
                element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.remove('disparu2')
                if (Number(element.innerHTML.split(' ')[0]) >= Number(e.innerHTML.split(' ')[0]) && Number(element.innerHTML.split(' ')[0]) < (Number(e.innerHTML.split(' ')[0]) + 5)) {
                    console.log('good')
                }
                else {
                    if (e.innerHTML == 'Pas de filtre.') {
                        element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.remove('disparu2')
                    }
                    else {
                        element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add('disparu2')
                    }
                }
            });
        }
    });
    document.querySelectorAll('#poid>.choix').forEach(e => {
        e.addEventListener('click', filtrer)
        function filtrer() {
            document.querySelector('#pdschoisi').innerHTML = e.innerHTML
            document.querySelectorAll('.pounds').forEach(element => {
                element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.remove('disparu3')
                if (Number(element.innerHTML.split(' ')[0]) >= Number(e.innerHTML.split(' ')[1])) {
                    console.log('good')
                }
                else {
                    console.log(element.innerHTML);
                    if (e.innerHTML == 'Pas de filtre.') {
                        element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.remove('disparu3')
                    }
                    else {
                        element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add('disparu3')
                    }

                }
            });
        }
    });
    document.querySelectorAll('#ruche>.choix').forEach(e => {
        e.addEventListener('click', filtrer)

        function filtrer() {
            document.querySelector('#rchoisi').innerHTML = e.innerHTML
            document.querySelectorAll('.recup').forEach(element => {
                element.parentElement.parentElement.classList.remove('disparu4')
                if (element.innerHTML == e.innerHTML) {
                    console.log('good')
                }
                else {
                    console.log(element.innerHTML);
                    if (e.innerHTML == 'Pas de filtre.') {
                        element.parentElement.parentElement.classList.remove('disparu4')
                    }
                    else {
                        element.parentElement.parentElement.classList.add('disparu4')
                    }

                }
            });
        }
    });
}

// faire une classe de séparitions par catégories

document.querySelectorAll('.right_button').forEach(e => {
    e.addEventListener('click', ouvrir)

    function ouvrir() {
        document.querySelector('.formulairetest>form').action = "index.php?page=ajoutNote&jsruche=null"
        document.querySelector('.formulairetest').classList.add('ouvert2')
        document.querySelector('.cache_fond').classList.add('ouvert2')
        document.querySelector('#numeroruche').value = e.id
    }
})

document.querySelector('.iconcarte').addEventListener('click', opencarte)

function opencarte() {
    document.querySelector('.fixed_carte').classList.add('ouvert2')
    document.querySelector('.fixed_carte').classList.add('carteouverture')
    document.querySelector('.cache_fond').classList.add('ouvert2')
}

document.querySelector('.croixfixed').addEventListener('click', fermermap)
document.querySelector('.cache_fond').addEventListener('click', fermermap)
function fermermap() {
    document.querySelector('.fixeddanslefixed').classList.remove('ouverturepopoup')
    document.querySelector('.confirmation').classList.remove('ouvert2')
    document.querySelector('.fixed_carte').classList.remove('carteouverture')
    document.querySelector('.fixed_carte').classList.remove('ouvert2')
    document.querySelector('.cache_fond').classList.remove('ouvert2')
    document.querySelector('.formulairetest').classList.remove('ouvert2')
}


document.querySelectorAll('.grid_notes').forEach(e => {
    if (e.querySelector('.note') && e.querySelector('.bouton_note:first-child') && e.querySelector('.modifier')) {

        e.querySelector('.note').classList.remove('disabled')

        e.querySelector('.bouton_note:first-child').classList.add('bouton_note_select')

        e.querySelector('.modifier').id = 'modifier' + e.querySelector('.bouton_note').id
    }
    else {
        e.querySelector('.modifier').remove()
    }
})

// pour modifier ou supprimer une note
document.querySelectorAll('.bouton_note').forEach(element => {

    element.addEventListener('click', delet)
    let parent = element.parentElement.parentElement.parentElement
    function delet() {
        console.log(parent)
        document.querySelectorAll('.bouton_note').forEach(note => {
            note.classList.remove('bouton_note_select')
        })

        parent.querySelectorAll('.note').forEach(e => {
            console.log(e.innerHTML)
            e.classList.add('disabled')
        });
        element.classList.add('bouton_note_select')
        parent.querySelector('.modifier').id = 'modifier' + element.id
        parent.querySelector('.supprimer').href = "index.php?page=supprnote&jsruche=null&idnote=" + element.id
        modifier = element.id
        parent.querySelector('#note' + element.id + '').classList.remove('disabled')
    }
});

// modifier une note

document.querySelectorAll('.modifier').forEach(e => {
    e.addEventListener('click', changer)

    function changer() {
        let splited = e.id.split('r')[1]

        console.log(splited)
        document.querySelector('.formulairetest').classList.add('ouvert2')
        document.querySelector('.cache_fond').classList.add('ouvert2')
        document.querySelector('.formulairetest>form').action = "index.php?page=modifnote&jsruche=null";
        document.querySelector('#numeroruche').value = splited
        document.querySelector('#editor>.ql-editor').innerHTML = document.querySelector('#contenu' + splited).innerHTML
    }
})

document.querySelectorAll('.supprimer').forEach(e => {
    e.addEventListener('click', ouvrirconf)

    let test = e.href

    function ouvrirconf(event) {
        event.preventDefault();
        document.querySelector('.cache_fond').classList.add('ouvert2')
        document.querySelector('.fixeddanslefixed').classList.add('ouverturepopoup')
        document.querySelector('.ouijesuppr').parentElement.href = test
    }
})
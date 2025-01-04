<?php

define("HEADER_Déconnecté", "<div class='ConteneurHeader'>
            <div class='TitreHeader>'<span class='RucheHeader'>R</span>uches connectées</div>
            <div class='BoutonHeader'>Se connecter</div>
            </div>");

define('HEADER_connecté', '<div class="ConteneurHeader">
            <a href="index.php" class="TitreHeader"><span class="RucheHeader">R</span>uches connectées</a>
            <div class="HeaderPartieDroite">
                <a href="index.php?page=Gestion" class="BoutonHeader2">Gestion</a>
                <a href="index.php?page=Notes" class="BoutonHeader2">Mes notes</a>
                <a href="index.php?page=quitter" class="BoutonHeader2">Se déconnecter</a>
                <a href="index.php?page=Ruches&jsruche=null" class="BoutonHeader">Mes ruches</a>
            </div>
            </div>');

define('HEADER_admin', '<div class="ConteneurHeader">
            <a href="index.php" class="TitreHeader"><span class="RucheHeader">R</span>uches connectées</a>
            <div class="HeaderPartieDroite">
                <a href="index.php" class="BoutonHeader2">Accueil</a>
                <a href="index.php?page=Gestion" class="BoutonHeader2">Gestions des ruches</a>
                <a href="index.php?page=Notes" class="BoutonHeader2">Mes notes</a>
                <a href="index.php?page=Utilisateurs" class="BoutonHeader2">Utilisateurs</a>
                <a href="index.php?page=quitter" class="BoutonHeader2">Se déconnecter</a>
                <a href="index.php?page=Ruches&jsruche=null" class="BoutonHeader">Mes ruches</a>
                <div class="mail"><img class="notif" src="../img/mail.svg" alt="Une icone de mail"></img></div>
            </div>
            </div>');


define("Footer_déconnecté", '<div class="FooterGlobal">
            <div class="FooterPartie1">
                <h3>RUCHES CONNECTEES</h3>
                <div class="BordureFooterGauche">
                    <div>Parce que permettre au apiculteurs une agriculture durable grâce à la technologie est notre
                        devoir,
                        le
                        projet ruche connecté est né et permet au apiculteurs de facilement obtenir toute les
                        informations
                        nécéssaires facilement, avec une simle conneion sur le site !</div>
                    <div>Facilitez vous la vie avec le projet ruches connectées.</div>
                    <a href="#Information" class="FooterBouton1">Découvrir ></a>
                </div>
                <div class="ParentFooterLogo">
                    <!-- Logo de youtube -->
                    <svg class="FooterLogo" width="808" height="574" viewBox="0 0 808 574" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M405.347 0.833737C425.21 0.833737 659.193 1.50707 719.793 17.6671C736.996 22.4082 752.647 31.593 765.175 44.2986C777.704 57.0043 786.668 72.7833 791.167 90.0504C808 154.017 808 287 808 287V288.347C808 302.824 806.99 424.024 791.167 483.614C786.72 500.943 777.779 516.792 765.247 529.56C752.715 542.328 737.036 551.564 719.793 556.334C660.54 572.494 435.31 573.167 406.693 573.504H400.97C372.353 573.504 147.123 572.494 88.2067 556.67C70.9228 551.871 55.2162 542.585 42.681 529.754C30.1457 516.923 21.2282 501.005 16.8333 483.614C2.69333 429.41 0.336667 325.38 0 295.08V278.247C0.336667 247.947 2.69333 143.917 16.8333 89.7137C21.384 72.5087 30.371 56.7994 42.8959 44.1563C55.4209 31.5132 71.0451 22.3791 88.2067 17.6671C148.807 1.1704 382.79 0.49707 402.653 0.49707L405.347 0.833737ZM321.18 165.8V407.527L532.607 287L321.18 166.137V165.8Z"
                            fill="white" />
                    </svg>

                    <!-- Logo de facebook -->
                    <svg class="FooterLogo" width="646" height="646" viewBox="0 0 646 646" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_260_54)">
                            <path
                                d="M646 324.884C646 145.619 501.457 0 323 0C144.542 0 0 145.35 0 324.884C0 487.192 118.164 621.775 272.666 646V418.823H190.57V324.884H272.397V253.286C272.397 171.997 320.847 126.777 394.598 126.777C429.859 126.777 466.735 133.237 466.735 133.237V213.18H426.36C385.985 213.18 373.603 238.213 373.603 264.053V324.884H462.967L448.701 419.092H373.334V646C528.105 621.775 646 487.192 646 324.884Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_260_54">
                                <rect width="646" height="646" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <!-- Logo de instagram -->
                    <svg class="FooterLogo" width="647" height="646" viewBox="0 0 647 646" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_260_56)">
                            <path
                                d="M457.752 0.00026202C483.008 -0.870408 508.177 3.40626 531.722 12.5693C555.268 21.7323 576.697 35.5895 594.701 53.2953C612.056 71.2704 625.626 92.5368 634.609 115.838C643.591 139.138 647.805 164.001 647 188.955V457.045C647 513.032 628.668 561.213 593.622 595.128C556.445 629.399 507.246 647.675 456.674 646H190.326C140.177 647.551 91.4428 629.268 54.7254 595.128C36.5244 576.926 22.2724 555.176 12.8573 531.235C3.44207 507.293 -0.934568 481.673 -1.71387e-05 455.969V188.955C-1.71387e-05 75.3669 75.4833 0.00026202 189.247 0.00026202H457.752ZM459.1 60.0244H190.326C151.236 60.0244 117.538 71.5986 95.1629 93.6703C83.2067 106.385 73.9409 121.377 67.9194 137.749C61.8978 154.12 59.2442 171.536 60.1171 188.955V455.969C60.1171 496.344 71.7091 528.644 95.1629 552.33C121.321 575.43 155.437 587.493 190.326 585.976H456.674C491.563 587.493 525.679 575.43 551.837 552.33C564.396 539.925 574.235 525.049 580.732 508.646C587.229 492.243 590.242 474.672 589.579 457.045V188.955C590.448 154.305 577.895 120.655 554.533 95.0161C541.798 83.0784 526.783 73.8269 510.386 67.8147C493.989 61.8025 476.546 59.1529 459.1 60.0244ZM323.5 155.04C414.889 155.04 490.642 230.407 490.642 321.924C490.642 366.184 473.032 408.631 441.687 439.928C410.342 471.225 367.829 488.807 323.5 488.807C279.171 488.807 236.658 471.225 205.313 439.928C173.968 408.631 156.358 366.184 156.358 321.924C156.358 277.663 173.968 235.216 205.313 203.919C236.658 172.623 279.171 155.04 323.5 155.04ZM323.5 214.795C295.159 214.937 268.019 226.241 247.979 246.25C227.938 266.259 216.617 293.357 216.475 321.654C216.617 349.952 227.938 377.05 247.979 397.059C268.019 417.068 295.159 428.372 323.5 428.514C351.841 428.372 378.981 417.068 399.021 397.059C419.062 377.05 430.383 349.952 430.525 321.654C430.383 293.357 419.062 266.259 399.021 246.25C378.981 226.241 351.841 214.937 323.5 214.795ZM497.112 113.319C507.121 113.319 516.721 117.29 523.799 124.357C530.877 131.424 534.853 141.009 534.853 151.003C534.853 160.997 530.877 170.582 523.799 177.649C516.721 184.716 507.121 188.686 497.112 188.686C487.102 188.686 477.502 184.716 470.424 177.649C463.346 170.582 459.37 160.997 459.37 151.003C459.37 141.009 463.346 131.424 470.424 124.357C477.502 117.29 487.102 113.319 497.112 113.319Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_260_56">
                                <rect width="647" height="646" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
            <div class="FooterPartie2Parent">
                <h4>Besoin de nous contacter ?</h4>
                <div class="FooterPartie2">
                    <div class="FooterPartie2SousPartie1">
                        <div>Retrouvez nous pas mail !</div>
                        <div>maxence.sanchez-varas-leclercq@uha.fr</div>
                        <div>alexis.tauleigne@uha.fr</div>
                        <div>noah.goguet@uha.fr</div>
                        <div>gregoire.tournoux@uha.fr</div>
                    </div>
                    <div class="ArrangementDeLaPartie2DuFooter">
                        <div class="FooterPartie2SousPartie2">
                            <div>contactez nous par téléphone !</div>
                            <div>07 83 85 16 54</div>
                            <div>retrouvez nous !</div>
                            <div>61 Rue Albert Camus, 68200 Mulhouse</div>
                        </div>
                        <div class="FooterPartie2SousPartie2">Plan du site</div>
                    </div>
                </div>
                <div class="LienRapides">Liens rapides</div>
                <div class="ListeDesActions">
                    <a href="index.php?page=Connexion" class="Actions">Se connecter</a>
                </div>
            </div>
        </div>
        <div class="FooterPartieBasseBordure"></div>
        <div class="FooterPartieBasse">
            <div>Projet ruches connectées</div>
        </div>');



define("Footer_connecté", '<div class="FooterGlobal">
            <div class="FooterPartie1">
                <h3>RUCHES CONNECTEES</h3>
                <div class="BordureFooterGauche">
                    <div>Parce que permettre au apiculteurs une agriculture durable grâce à la technologie est notre
                        devoir,
                        le
                        projet ruche connecté est né et permet au apiculteurs de facilement obtenir toute les
                        informations
                        nécéssaires facilement, avec une simle conneion sur le site !</div>
                    <div>Facilitez vous la vie avec le projet ruches connectées.</div>
                    <a href="#Information" class="FooterBouton1">Découvrir ></a>
                </div>
                <div class="ParentFooterLogo">
                    <!-- Logo de youtube -->
                    <svg class="FooterLogo" width="808" height="574" viewBox="0 0 808 574" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M405.347 0.833737C425.21 0.833737 659.193 1.50707 719.793 17.6671C736.996 22.4082 752.647 31.593 765.175 44.2986C777.704 57.0043 786.668 72.7833 791.167 90.0504C808 154.017 808 287 808 287V288.347C808 302.824 806.99 424.024 791.167 483.614C786.72 500.943 777.779 516.792 765.247 529.56C752.715 542.328 737.036 551.564 719.793 556.334C660.54 572.494 435.31 573.167 406.693 573.504H400.97C372.353 573.504 147.123 572.494 88.2067 556.67C70.9228 551.871 55.2162 542.585 42.681 529.754C30.1457 516.923 21.2282 501.005 16.8333 483.614C2.69333 429.41 0.336667 325.38 0 295.08V278.247C0.336667 247.947 2.69333 143.917 16.8333 89.7137C21.384 72.5087 30.371 56.7994 42.8959 44.1563C55.4209 31.5132 71.0451 22.3791 88.2067 17.6671C148.807 1.1704 382.79 0.49707 402.653 0.49707L405.347 0.833737ZM321.18 165.8V407.527L532.607 287L321.18 166.137V165.8Z"
                            fill="white" />
                    </svg>

                    <!-- Logo de facebook -->
                    <svg class="FooterLogo" width="646" height="646" viewBox="0 0 646 646" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_260_54)">
                            <path
                                d="M646 324.884C646 145.619 501.457 0 323 0C144.542 0 0 145.35 0 324.884C0 487.192 118.164 621.775 272.666 646V418.823H190.57V324.884H272.397V253.286C272.397 171.997 320.847 126.777 394.598 126.777C429.859 126.777 466.735 133.237 466.735 133.237V213.18H426.36C385.985 213.18 373.603 238.213 373.603 264.053V324.884H462.967L448.701 419.092H373.334V646C528.105 621.775 646 487.192 646 324.884Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_260_54">
                                <rect width="646" height="646" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <!-- Logo de instagram -->
                    <svg class="FooterLogo" width="647" height="646" viewBox="0 0 647 646" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_260_56)">
                            <path
                                d="M457.752 0.00026202C483.008 -0.870408 508.177 3.40626 531.722 12.5693C555.268 21.7323 576.697 35.5895 594.701 53.2953C612.056 71.2704 625.626 92.5368 634.609 115.838C643.591 139.138 647.805 164.001 647 188.955V457.045C647 513.032 628.668 561.213 593.622 595.128C556.445 629.399 507.246 647.675 456.674 646H190.326C140.177 647.551 91.4428 629.268 54.7254 595.128C36.5244 576.926 22.2724 555.176 12.8573 531.235C3.44207 507.293 -0.934568 481.673 -1.71387e-05 455.969V188.955C-1.71387e-05 75.3669 75.4833 0.00026202 189.247 0.00026202H457.752ZM459.1 60.0244H190.326C151.236 60.0244 117.538 71.5986 95.1629 93.6703C83.2067 106.385 73.9409 121.377 67.9194 137.749C61.8978 154.12 59.2442 171.536 60.1171 188.955V455.969C60.1171 496.344 71.7091 528.644 95.1629 552.33C121.321 575.43 155.437 587.493 190.326 585.976H456.674C491.563 587.493 525.679 575.43 551.837 552.33C564.396 539.925 574.235 525.049 580.732 508.646C587.229 492.243 590.242 474.672 589.579 457.045V188.955C590.448 154.305 577.895 120.655 554.533 95.0161C541.798 83.0784 526.783 73.8269 510.386 67.8147C493.989 61.8025 476.546 59.1529 459.1 60.0244ZM323.5 155.04C414.889 155.04 490.642 230.407 490.642 321.924C490.642 366.184 473.032 408.631 441.687 439.928C410.342 471.225 367.829 488.807 323.5 488.807C279.171 488.807 236.658 471.225 205.313 439.928C173.968 408.631 156.358 366.184 156.358 321.924C156.358 277.663 173.968 235.216 205.313 203.919C236.658 172.623 279.171 155.04 323.5 155.04ZM323.5 214.795C295.159 214.937 268.019 226.241 247.979 246.25C227.938 266.259 216.617 293.357 216.475 321.654C216.617 349.952 227.938 377.05 247.979 397.059C268.019 417.068 295.159 428.372 323.5 428.514C351.841 428.372 378.981 417.068 399.021 397.059C419.062 377.05 430.383 349.952 430.525 321.654C430.383 293.357 419.062 266.259 399.021 246.25C378.981 226.241 351.841 214.937 323.5 214.795ZM497.112 113.319C507.121 113.319 516.721 117.29 523.799 124.357C530.877 131.424 534.853 141.009 534.853 151.003C534.853 160.997 530.877 170.582 523.799 177.649C516.721 184.716 507.121 188.686 497.112 188.686C487.102 188.686 477.502 184.716 470.424 177.649C463.346 170.582 459.37 160.997 459.37 151.003C459.37 141.009 463.346 131.424 470.424 124.357C477.502 117.29 487.102 113.319 497.112 113.319Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_260_56">
                                <rect width="647" height="646" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
            <div class="FooterPartie2Parent">
                <h4>Besoin de nous contacter ?</h4>
                <div class="FooterPartie2">
                    <div class="FooterPartie2SousPartie1">
                        <div>Retrouvez nous pas mail !</div>
                        <div>maxence.sanchez-varas-leclercq@uha.fr</div>
                        <div>alexis.tauleigne@uha.fr</div>
                        <div>noah.goguet@uha.fr</div>
                        <div>gregoire.tournoux@uha.fr</div>
                    </div>
                    <div class="ArrangementDeLaPartie2DuFooter">
                        <div class="FooterPartie2SousPartie2">
                            <div>contactez nous par téléphone !</div>
                            <div>07 83 85 16 54</div>
                            <div>retrouvez nous !</div>
                            <div>61 Rue Albert Camus, 68200 Mulhouse</div>
                        </div>
                        <div class="FooterPartie2SousPartie2">Plan du site</div>
                    </div>
                </div>
                <div class="LienRapides">Lien rapides</div>
                <div class="ListeDesActions">
                    <a href="index.php?page=Notes" class="Actions">Mes notes</a>
                    <a href="index.php?page=Gestion" class="Actions">Gestion des ruches</a>
                    <a href="index.php?page=Ruches&jsruche=null" class="Actions">Suivi des ruches</a>
                    <a href="index.php?page=quitter" class="Actions">Se déconnecter</a>
                </div>
            </div>
        </div>
        <div class="FooterPartieBasseBordure"></div>
        <div class="FooterPartieBasse">
            <div>Projet ruches connectées</div>
        </div>');

define("DBHOST", "localhost");
define("DBNAME", "rucheconnectes");
define("DBUSER", "root");
define("DBPWD", "");
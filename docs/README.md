# Travaux d'Héraclès #4 : les&nbsp;juments&nbsp;de&nbsp;Diomède
 
Démarrage : cloner ce *repository*.
{: .alert-info }
Puis lancer la commande 
```bash
composer install
```

## État des lieux du projet
Le travail continue pour Héraclès. Il doit maintenant venir à bout des juments carnivores du roi Diomède.

Pour ce nouvel atelier, tu reprends là encore où tu t'étais arrêté à l'étape précédente. Tu as un héros qui peut se déplacer et une gestion de la portée pour tes attaques. 

Tu noteras que quelques modifications ont été apportées ici, car le déroulement d'une partie se fait maintenant sur plusieurs tours.  
 - À chaque tour, tu pourras te déplacer ou attaquer afin de rendre la partie un peu plus intéractive. 
 - Les sessions sont utilisées pour persister les informations d'un tour à l'autre, mais tu n'as pas à te soucier de cela, concentre toi sur tes classes. 
 - Tu ne devrais pas non plus avoir à modifier le fichier *index.php*, l'arène, le héros et les monstres sont déjà instanciés.
 - Enfin, tu remarqueras aussi un bouton "**Reset**" en haut à droite qui te permets de "recommencer" une partie en réinitialisant le jeu.

## 🧔 Monsters, Hero and Fighters&nbsp;🐴
Dans l'atelier précédent, tu as créé les classes `Hero` et `Monster` qui étendent tous deux `Fighter`. Cela n'a maintenant plus de sens d'instancier directement un objet de la classe `Fighter`. Un combattant est un concept abstrait, qui englobe les héros et les monstres qui eux sont plus concrets et ont leurs propre spécificités. Pour empêcher les utilisateurs de ces classes d'instancier un objet `Fighter` (et donc les obliger à passer par une des deux classes filles), il faut que tu rendes la classe `Fighter` abstraite. 

## 🏟️ Un peu de déplacement
Les `Fighter` peuvent déjà se déplacer sur la carte grâce aux fonctions `setX()` et `setY()`. Mais cela n'est pas très pratique à manipuler et ne propose pas un déplacement réaliste puisqu'il est possible de "téléporter" le combattant n'importe où. 
Tu va créer maintenant une fonction `move()` qui permettra de déplacer un `Fighter` d'une case à la fois, dans une direction donnée (nord, sud, est ou ouest).

Crée cette méthode `move(Fighter $fighter, string $direction)` dans la classe `Arena`. 

Le paramètre `$direction` prendra obligatoire une des quatre valeurs `"N", "S", "W" ou "E"`. En fonction de la "lettre" récupérée, les coordonnées du combattant devront être modifiées en conséquence.

Par exemple, un mouvement vers le sud incrémente `$y`, un mouvement vers l'ouest décrémente `$x`, etc.
{: .alert-info }

De plus, fait en sorte qu'il soit impossible de "sortir" de la carte, mais également impossible de se déplacer sur une case déjà occupée par un autre `Fighter`. 

Pour t'aider à construire cette méthode, procède de la sorte : 
1. Récupère les coordonnées actuelle du `Fighter` passé en paramètre.
2. En fonction de la direction, calcule les coordonnées où le personnage *souhaite* se déplacer (mais ne le déplace pas encore). 
3. Vérifie que ces coordonnées de destination correspondent à une case accessible (dans la carte et libre). 
- Si le déplacement n'est pas autorisé, lance une **Exception** (avec idéalement deux messages différents pour une case occupée ou une sortie de carte). Dans *index.php* le code qui permet de captures les exceptions (`try/catch`) est déjà implémenté et si une exception est levée, elle s'affichera dans un bloc d'erreur en haut à droite de la page.
- Si le déplacement est valide, modifie les coordonées du `Fighter` pour qu'il se déplace à sa destination.

Pour "tester" le déplacement, tu peux simplement utiliser les touches de ton clavier.  
Un peu de JS est utilisé pour détecter si tu utilises ces touches, et si c'est le cas, va exécuter la méthode `move()`. N'hésite pas à regarder comment le code est fait si cela t'intéresse, mais ne le modifie pas. 
{: .alert-info }


Ton personnage se déplace, c'est bien !  
Normalement, la notion de portée (en fonction de l'arme que le héros porte) est toujours fonctionnelle et les monstres doivent se griser ou non en fonction de la distance. Tu peux t'amuser à changer l'arme d'Héraclès si tu veux.

## 🛡️ Que la bataille commence !

Les juments de Diomède sont là, devant toi, les naseaux fumants. Tu peux te déplacer autour, te mettre hors de portée de leur dents tranchantes, avides de chair fraîche. C'est le moment de passer à l'attaque !

Sur l'arène, le troupeau est constitué de quatre juments qu'il va falloir combattre. Mais comment gérer qui attaque qui ? Il y a bien une méthode `fight()` dans `Fighter`, mais un `Fighter` n'a pas connaissance directement des autres combattants, c'est là encore la classe `Arena` qui a cette information. Tu vas donc implémenter une méthode `battle()` directement dans `Arena`. Il est possible d'implémenter une bataille de plusieurs façon, il faut donc choisir des règles. Voici comment le *gameplay* va se dérouler pour ton jeu :
- Le `Hero` choisit sur la carte quel monstre il souhaite attaquer en cliquant dessus. Le clic sur le monstre est déjà implémenté, et un `id` correspondant au monstre choisi est envoyé. Ta méthode `battle(int $id)` devra donc prendre un unique paramètre `$id` qui correspond à l'index du monstre dans le tableau `$monsters` de `Arena`.
- Si le monstre est à portée du héros (utilise la méthode `touchable()` pour le vérifier), il est attaqué et subit les points de dégâts correspondant. La méthode `fight()` du héros est alors utilisée. Si le monstre n'est pas à portée du héros, lance une Exception.
- Ensuite, si le monstre est à portée (utilise à nouveau `touchable()` mais du point de vue du monstre ciblé), ce dernier réplique et attaque à son tour le héros. Si le héros n'est pas à portée du monstre, lance une **Exception**. 

## Boucherie chevaline

Héraclès doit venir à bout des monstres, il peut attaquer et faire des dégâts. Pour le moment, si un monstre est "vaincu" (points de vie < 0), il reste sur la carte et est toujours attaquable. Gérons ce cas de figure, toujours dans la méthode `battle()`. 
- À l'aide de la méthode `isAlive()` présente dans `Fighter`, teste après une attaque du héros, si le monstre attaqué est toujours en vie. Si oui la méthode continue et le monstre attaque alors Héraclès. 
- Mais si le monstre est mort suite à l'attaque du héros, fais en sorte d'enlever le monstre du tableau `$monsters`. De ce fait, il n'attaquera pas et doit également "disparaître" de la carte, la case où il se trouvait devenant donc libre.

La mort du héros n'étant pas envisageable, cela ne sera pas implémenté ! De plus, si tous les monstres de l'arène sont vaincus, il ne se passera rien non plus. Mais tu es libre d'implémenter le code pour ces différents cas de figure en BONUS 🤓
{: .alert-info }

## Expérience

Lorsque le héros terrasse un ennemi, il doit gagner de l'expérience. Au bout d'un certain nombre de points d'expérience accumulés, il gagne un niveau. Ce type de mécanisme peut là encore être implémenté de bien des manières différentes. Voici ce que tu devras faire ici :
- Ajoute une propriété `$experience` dans la classe `Fighter`, *integer* avec la valeur 1000 par défaut pour le héros, et 500 pour les monstres.
- Lorsqu'un monstre meurt, en plus de disparaître de la carte, le nombre de points d'expérience du monstre sera ajouté à l'expérience du héros.
- Le niveau du héros sera automatiquement déduit de la quantité de point d'XP qu'il possède. Ce calcul de niveau n'est pas vraiment lié à l'arène. Il pourrait être relié au `Fighter` mais nous allons essayer de respecter un peu mieux le premier principe **SOLID** (**S**ingle Responsability Principle), qui incite à limiter la responsabilité d'une classe et éviter d'avoir des classes qui deviennent énormes et fourre-tout. 
- Commence par créer une nouvelle classe `Level` qui contiendra une unique méthode `calculate(int $experience)`. La méthode renverra le niveau en fonction d'un paramètre expérience, selon la formule suivante: `XP / 1000, arrondi à l'entier supérieur = LEVEL ` donc à 1500 points d'XP, le héros est au niveau 2 ; à 6300 points, le héros est au niveau 7, *etc*. 
- La façon de calculer le niveau découle directement du nombre de point d'XP et serait la même pour n'importe quel combattant. Ainsi, la méthode `calculate()` a le comportement d'une fonction PHP classique, tu peux ici l'utiliser de manière *statique*. Ajoute le mot clé `static` devant ta méthode, et tu l'utiliseras ainsi `Level::calculate($xp)` sans avoir besoin d'instancier un objet de type `Level`.

Tue un monstre ou deux, et observe ton panneau d'inventaire. Ton nombre de points d'expérience et ton niveau doivent changer.
{: .alert-info }

- Enfin, pour que le niveau serve à quelque chose dans le *gameplay*, fait en sorte que `getStrength()` et `getDexterity()` retourne la force et la dextérité, multiplié par le niveau du combattant. Ainsi, si Héraclès à une force de base à 20, au niveau 1 `getStength()` renverra 20, puis 40 au niveau 2, *etc.* 

Bravo, ce nouvel atelier est maintenant terminé, notre héros peut aller se reposer un peu avant sa prochaine mission !

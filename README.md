# PHP-FirstAppli

## Cahier des charges

L'application doit permettre à un utilisateur de renseigner différents produits par le 
biais d'un formulaire, produits qui seront consultables sur une page récapitulative. 
L'enregistrement en session de chaque produit est nécessaire. L'application ne 
nécessite pour l'instant aucun rendu visuel spécifique.
Trois pages sont nécessaires à cela :

1. index.php
   
Présentera un formulaire permettant de renseigner : 

- Le nom du produit 

- Son prix unitaire

- La quantité désirée

2. traitement.php
   
Traitera la requête provenant de la page index.php (après soumission du 
formulaire), ajoutera le produit avec son nom, son prix, sa quantité et le total calculé 
(prix × quantité) en session.

3. recap.php

Affichera tous les produits en session (et en détail) et présentera le total général de 
tous les produits ajoutés.

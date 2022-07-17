
## About parrainage-app

Cette appliquation permet à l'administrateur de calculer le chiffre personel, le chiffre équipe, le prime d'animation et le prime de parrainage des adhérants.
Par la suite et selon les résultats précédentes, un calcule de passage de grade sera effectué pour les adhérants

## Installation

- Veuillez télécharger l'appliquation avec la commande : git clone https://github.com/limemsadok/parrainage-app.git
- Copier le fichier .env.exemple et le renommé .env
- Modifier le nom de la base de donnée

## Recommandation

- Il faut modifier les champs de la BD de type float en decimal pour plus de précision sur les chiffres après la virgule
- On peut ajouter la colone rank_id dans les tables personal_scores et team_scores pour minimiser les jointures



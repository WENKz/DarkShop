
<nav id="menu-accueil">
    <ul>
        <li><a href="Catalogue">Accueil</a></li>
        <?php
        if (count($this->categories) < 1) {
            echo "Aucune catégorie disponible.";
        } else {
            foreach ($this->categories as $categorie) {
                ($categorie['id_categorie'] == $this->cur_item) ? $li = "<li class='current'>" : $li = "<li>";
                echo $li . "<a href='catalogue-categorie-" . $categorie['id_categorie'] . "'>" . $categorie['nom_categorie'] . "</a></li>";
            }
        }
        ?>
        <li><a href="catalogue-darkpoints">Acheter Des DarkPoints</a></li>
    </ul>
</nav>
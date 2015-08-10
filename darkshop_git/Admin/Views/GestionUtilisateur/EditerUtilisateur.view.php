<?php extract($this->data); ?>

<ul class="tabs">
    <li class="here"><a href="#">Edition produit</a></li>
</ul>

<div class="tab-content">

    <?php
    foreach ($this->infoClient as $val) {
        extract($val);
        ?>
        <form id="form-profil" action="GestionUtilisateur-editerClient-<?php echo $id_client ?>-send" method="POST">
            <p> le client se nomme <strong><?php echo $prenom_client ?></strong> son SteamID est <strong><?php echo $steam_client ?></strong></p>
            <p style="color:red">Vous pouvez uniquement modifier ses points</p>


            <label>Darkpoints</label> <input type="text" id="point_client" name="point_client" value="<?php echo $point_client ?>"placeholder="prix produit"><br />
            <label>Eventpoints</label> <input type="text" id="event_client" name="event_client" value="<?php echo $event_client ?>"placeholder="prix event produit"><br />
            <br />
           

           
            
                <p class="jump"><input type="submit" class="btn btn-third" value="Envoyer"></p>
        </form>
        <?php }
    ?>
</div>
</div>
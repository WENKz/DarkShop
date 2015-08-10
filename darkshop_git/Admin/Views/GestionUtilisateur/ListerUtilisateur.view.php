<h2 class="center">Clients</h2>
<?php echo $this->flashBag(); ?>
<ul class="tabs">
    <li class="here"><a href="">Gérer les Clients</a></li>
</ul>

<div class="tab-content">

    <table class="table-list">
        <thead>
            <tr>
                <th>
                    Pseudo
                </th>
                <th>
                    SteamID
                </th>
                <th>
                    DarkPoint
                </th>
                <th>
                    EventPoint
                </th>
                <th>
                    Editer
                </th>

            </tr>
        </thead>
        <?php
        foreach ($this->data as $value) {
            extract($value);
            ?>
            <tr>

                <td>
                    <?php
                    echo "<b>" . $prenom_client . "</b><br />"
                    ?>
                </td>
                <td>
                    <?php echo $steam_client ?>
                </td>
                <td>
                    <?php echo $point_client ?>
                </td>
                <td>
                    <?php echo $event_client ?>
                </td>
                <td>
                    <a href="GestionUtilisateur-editerClient-<?php echo $id_client ?>">Editer</a>
                </td>

            </tr>

            <?php
        }
        ?>
    </table>
</div>

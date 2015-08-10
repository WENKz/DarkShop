

<div class="jumbotron">
    <h1>Acheter des DarkPoints</h1>
    <p>Vous pouvez acheter ici des Darkpoints afin d'utiliser la boutique DarkGames, voici la representation du taux de changes d'un paiement allopass ou par paypal<br>
        1 allopass = 300DP <br/>
        1€ = 600DP<br/>
        Nous favorisons le paiement par paypal (moins de taxes).</p>
</div>

<div class="col-sm-5">
    <h1>Achat par paypal</h1>
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" methos="post">
  <fieldset>
    <legend>Achat Paypal:</legend>

<input name="currency_code" type="hidden" value="EUR">
<input type="number" placeholder="entrez votre valeur" name="amount" pattern="^\d+(\.|\,)\d{2}$">
<input name="shipping" type="hidden" value="0.00">
<input name="tax" type="hidden" value="0.00">
<input name="return" type="hidden" value="http://boutique.darkgames.fr/catalogue">
<input name="cancel_return" type="hidden" value="http://boutique.darkgames.fr/catalogue">
<input name="notify_url" type="hidden" value="http://boutique.darkgames.fr/ipn.php">
<input name="cmd" type="hidden" value="_xclick">
<input name="business" type="hidden" value="quentin.grisard@gmail.com">
<input name="item_name" type="hidden" value="Compte premium">
<input name="no_note" type="hidden" value="1">
<input name="lc" type="hidden" value="FR">
<input name="bn" type="hidden" value="PP-BuyNowBF">
<input name="custom" type="hidden" value="email=<?php echo $_SESSION['token_client']?>">
<div class
="submit">
<input  type="submit" value="Acheter">
</fieldset>
</form>

</div>
<div class="col-sm-5">
<h1>Achat par Allopass</h1>
 <fieldset>
    <script type="text/javascript" src="https://payment.allopass.com/buy/checkout.apu?ids=303187&idd=1297239&lang=fr"></script>
<noscript>
 <a href="https://payment.allopass.com/buy/buy.apu?ids=303187&idd=1297239" style="border:0">
  <img src="https://payment.allopass.com/static/buy/button/fr/162x56.png" style="border:0" alt="Buy now!" />
 </a>
</noscript>
	</fieldset>
	<!-- Begin Allopass Checkout-Button Code -->

<!-- End Allopass Checkout-Button Code -->
</div>
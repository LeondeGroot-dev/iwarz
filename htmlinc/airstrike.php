<div id="Main">
<h1>Airstrike from <?php echo($_GET[location]); ?></h1>

<p>Your airplanes are ready to attack <?php echo($_GET[location]); ?></p>
<div class="center">
<?php DrawTable( "DOMINATION", "ANYBASE", "?page=airstrike&from=$_GET[location]&to=%location%", false, "Select your target" ); ?>
</div>

</div>

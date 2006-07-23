<!-- AGENT 'admin/header' enquete=$enquete owner_key=$owner_key lien_promo=$lien_promo owner=$owner etat_enquete=$etat_enquete -->
<!-- AGENT $form -->

<fieldset id="modele"><legend>Modèle d'email</legend>
<table>
<!-- AGENT $f_subject _caption_="Sujet" _format_='<tr><td>%0 :</td><td>%1%2</td></tr>' size=65 -->
<!-- AGENT $f_template _caption_="Corps" _format_='<tr><td>%0 :</td><td>%1%2</td></tr>' rows=15 cols=50 -->
</table>
</fieldset>

<fieldset><legend>Choisir une promotion diplômée</legend>
<!-- AGENT $f_promo _caption_="Promotion" _format_='%0&nbsp;: %1%2' -->
<!-- AGENT $f_showpromo value="Afficher" -->
</fieldset>

<!-- SET a$a -->1<!-- END:SET -->
<!-- SET $PC1 -->
<!-- IF $PC1 -->
<fieldset><legend>L'enquête n'a pas été envoyée aux diplômés suivants&nbsp;:</legend>
<div style="height:300px;overflow:auto;width:100%">
<table>
<!-- IF $etat_enquete == 'fermé' -->
<tr>
	<td colspan="2">
	L'enquête est <b>fermée</b>.
	Vous pouvez envoyer des clefs hors-délai.
	Elle ne seront actives que pendant {$hors_delai} jours.
	</td>
</tr>
<!-- END:IF -->
<tr>
	<th>Nom</th>
	<th>Email</th>
</tr>
<!-- LOOP $PC1 --><!-- SET a$a --><!-- END:SET -->
<tr style="background-color:{'color'|cycle:'#B2FBCF':'#ffffff'}">
	<td>{$promo} {$nom} {$prenom}</td>
	<td><!-- AGENT $f_email size=40 --></td>
</tr>
<!-- END:LOOP -->
</table>
</div>
<p>
<!-- AGENT $f_send value="Envoyer l'enquête à ces adresses" onclick='return openSendbox(this)' -->
</p>
</fieldset>
<!-- ELSE --><!-- SET a$a --><!-- END:SET -->
<!-- END:IF -->
<!-- END:SET -->

<!-- IF a$a -->
Tous les diplômés de cette promotion ont reçu l'enquête.
<!-- ELSE -->
{$PC1}
<!-- END:IF -->

<!-- AGENT $form _mode_='close' -->
<!-- AGENT 'footer' -->

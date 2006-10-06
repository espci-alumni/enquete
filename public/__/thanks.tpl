<!-- AGENT 'header' title="Merci" -->

<style type="text/css">
li
{
	padding-bottom: 10px;
	vertical-align: top;
}
</style>

<script type="text/javascript" src="{~}js/admin"></script>

<h2>Merci de votre participation</h2>

<ul style="width: 500px;">
<li>
	<!-- IF 'enregistre' != $statut -->
	Vous n'avez pas encore répondu à l'enquête.
	<!-- ELSE -->
	Tant que l'enquête n'est pas cloturée, vous pouvez encore modifier votre réponse.
	<!-- END:IF -->
	<a href="{~}{$user_key}">Cliquez ici ...</a>
</li>

<!-- IF $membre -->
<li>
<b>A savoir à propos de l'<a href="{/}annuaire/" target="_blank">annuaire espci.org</a> :</b> Si vous remplissez votre fiche comme un mini-CV (du stage 3A jusqu'à aujourd'hui), nous pourrons faire une étude détaillée sur le parcours des PCéens.
</li>
<!-- ELSE -->
<li>
Pour faciliter les enquêtes futures, nous vous invitons à <a href="{/}fr/auth" target="_blank">vous inscrire sur espci.org</a>.
</li>
<!-- END:IF -->

<!-- SET a$a -->1<!-- END:SET -->
<!-- SET $PC1 -->
<!-- IF $PC1 -->

<!-- AGENT $form -->

<fieldset><legend>Email manquants&nbsp;:</legend>
Je n'ai pas l'email de ces PCéens. Si vous en connaissez certain, pouvez-vous les renseigner s'il vous plait ?
Bien sur en échange, je m'engage à ne les donner à personne d'autre.<br />
<br />
Merci d'avance,<br />
<br />
{$owner}<br />
<br />
<div style="height:300px;overflow:auto;width:100%">
<table>
<tr>
	<th>Nom</th>
	<th>Email</th>
</tr>
<!-- LOOP $PC1 --><!-- SET a$a --><!-- END:SET -->
<tr style="background-color:{'color'|cycle:'#B2FBCF':'#ffffff'}">
	<td>{$nom} {$prenom}</td>
	<td><!-- AGENT $f_email size=40 --></td>
</tr>
<!-- END:LOOP -->
</table>
</div>

<fieldset id="modele"><legend>Modèle de l'invitation</legend>
<table>
<!-- AGENT $f_subject _caption_="Sujet" _format_='<tr><td>%0 :</td><td>%1%2</td></tr>' size=65 -->
<!-- AGENT $f_template _caption_="Message d'invitation" _format_='<tr><td>%0 :</td><td>%1%2</td></tr>' rows=15 cols=50 -->
</table>
</fieldset>

<p>
<!-- AGENT $f_send value="Envoyer l'enquête aux adresses renseignées ..." onclick='return openSendbox(this)' -->
</p>
</fieldset>

<!-- AGENT $form _mode_='close' -->

<!-- ELSE --><!-- SET a$a --><!-- END:SET -->
<!-- END:IF -->
<!-- END:SET -->

<!-- IF !a$a -->
<li>{$PC1}</li>
<!-- END:IF -->

<li>
Si vous n'êtes pas encore cotisant, nous avons besoin de vous pour supporter le projet espci.org. <a href="{/}fr/cotiser" target="_blank">Cliquez ici pour en savoir plus sur l'adhésion</a>.
</li>
</ul>
<!-- AGENT 'footer' -->

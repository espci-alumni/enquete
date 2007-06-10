<!-- AGENT 'admin/header' enquete=$enquete owner_key=$owner_key lien_promo=$lien_promo owner=$owner etat_enquete=$etat_enquete -->
<!-- AGENT $form -->

<fieldset id="modele"><legend>Modèle d'email</legend>
<table>
<!-- AGENT $f_subject _caption_="Sujet" _format_='<tr><td>%0 :</td><td>%1%2</td></tr>' size=65 -->
<!-- AGENT $f_template _caption_="Corps" _format_='<tr><td>%0 :</td><td>%1%2</td></tr>' rows=15 cols=50 -->
</table>
</fieldset>

<fieldset><legend>Résultats de l'enquête (<a href="{~}admin/excel/{$owner_key}">export Excel</a>)</legend>
<div>
<table>
<tr>
	<th></th>
	<th></th>
<!-- IF !$anonyme -->
	<th>Nom</th>
<!-- END:IF -->
<!-- LOOP $ENTETE --><!-- IF $iteratorPosition --><th>{$entete}</th><!-- END:IF --><!-- END:LOOP -->
</tr>
<!-- LOOP $USER -->
<tr style="background-color:{'color'|cycle:'#B2FBCF':'#ffffff'}">
	<td><!-- AGENT $f_relance title="{$nom} {$prenom} - {$promo}" --></td>
	<td align="center"><img src="{~}img/{$statut}.gif" title="{$statut}"> <!-- IF $bounced --><img src="{~}img/bounce.gif" title="Email en erreur"><!-- END:IF --></td>
	<!-- IF !$$anonyme -->
	<td>{$promo} {$nom} {$prenom}</td>
	<!-- END:IF -->
	<!-- LOOP $DATA --><td>{$VALUE|default:'&nbsp;'|nl2br}</td><!-- END:LOOP -->
</tr>
<!-- END:LOOP -->
</table>
</div>

<!-- IF $USER -->
<img src="{~}img/arrow_ltr.png" />
<!-- AGENT $f_relancer value="Envoyer à nouveau" onclick='return openSendbox(this)' -->
<!-- END:IF -->

</fieldset>

<!-- AGENT $form _mode_='close' -->
<!-- AGENT 'footer' -->

<!-- AGENT 'admin/header' enquete=$enquete owner_key=$owner_key lien_promo=$lien_promo owner=$owner etat_enquete=$etat_enquete -->
<!-- AGENT $form -->

<fieldset id="modele"><legend>Modèle d'email</legend>
<table>
<!-- AGENT $f_subject _caption_="Sujet" _format_='<tr><td>%0 :</td><td>%1%2</td></tr>' size=65 -->
<!-- AGENT $f_template _caption_="Corps" _format_='<tr><td>%0 :</td><td>%1%2</td></tr>' rows=15 cols=50 -->
</table>
</fieldset>

<fieldset><legend>
	<!-- IF $etat_enquete == 'ouvert' -->
	Historique des envois
	<!-- ELSE -->
	Envoi de clés hors délai
	<!-- END:IF -->
</legend>

<div style="height:300px;overflow:auto">
<table cellspacing='0' cellpadding='0'>
<tr>
	<th></th>
	<th>Promo</th>
	<th>
		<!-- IF g$order_by_date --><a href="{~}{g$__AGENT__}{g$__1__}">Nom</a>
		<!-- ELSE --><i>Nom</i>
		<!-- END:IF -->
	</th>
	<th>Prénom</th>
	<th>Email</th>
	<th>
		<!-- IF !g$order_by_date --><a href="{~}{g$__AGENT__}{g$__1__}?order_by_date=1">Date d'envoi</a>
		<!-- ELSE --><i>Date d'envoi</i>
		<!-- END:IF -->
	</th>
	<th></th>
</tr>
<tr>
	<td></td>
	<td><!-- AGENT $f_promo size=5 --></td>
	<td><!-- AGENT $f_nom --></td>
	<td><!-- AGENT $f_prenom --></td>
	<td><!-- AGENT $f_email --><!-- AGENT $f_save value="Envoyer" onclick='return openSendbox(this)' --></td>
	<td></td>
	<td></td>
</tr>
<!-- IF $etat_enquete == 'fermé' -->
<tr>
	<td colspan="7">
	L'enquête est <b>fermée</b>.
	Vous pouvez envoyer des clefs hors-délai.
	Elle ne seront actives que pendant {$hors_delai} jours.
	</td>
</tr>
<!-- END:IF -->
<!-- LOOP $USER -->
<!-- SET $ligneRef -->{$promo}-{$nom}-{$prenom}<!-- END:SET -->
<tr style="background-color:{'color'|cycle:'C4DAFB':'FFFFFF'}">
	<td><!-- AGENT $f_relance --></td>
	<!-- IF $ligneRef == a$previousLigneRef -->
	<td colspan="3"></td>
	<!-- ELSE -->
	<td>{$promo}</td>
	<td>{$nom}</td>
	<td>{$prenom}</td>
	<!-- END:IF -->
	<td>{$email}</td>
	<td>{$date_envoi}</td>
	<td>
		<img src="{~}img/{$statut}.gif" title="{$statut}">
		<!-- IF $bounced --><img src="{~}img/bounce.gif" title="Email en erreur"><!-- END:IF -->
		<!-- IF $hors_delai --><img src="{~}img/hd.gif" title="Envoyé hors délais"><!-- END:IF -->
		<!-- IF $source --><img src="{~}img/sourced.png" title="Invité par {$source}"><!-- END:IF -->
	</td>
</tr>
<!-- SET a$previousLigneRef -->{$ligneRef}<!-- END:SET -->
<!-- END:LOOP -->
</table>
</div>
<!-- IF $USER -->
<img src="{~}img/arrow_ltr.png" /> <!-- AGENT $f_relancer value="Envoyer à nouveau" onclick='return openSendbox(this)' -->
&nbsp;&nbsp;&nbsp;&nbsp;<img src="{~}img/envoye.gif" /> Envoyé
&nbsp;&nbsp;&nbsp;&nbsp;<img src="{~}img/ouvert.gif" /> Ouvert
&nbsp;&nbsp;&nbsp;&nbsp;<img src="{~}img/enregistre.gif" /> Enregistré
&nbsp;&nbsp;&nbsp;&nbsp;<img src="{~}img/bounce.gif" /> Email en erreur
&nbsp;&nbsp;&nbsp;&nbsp;<img src="{~}img/hd.gif" /> Hors-delai
&nbsp;&nbsp;&nbsp;&nbsp;<img src="{~}img/sourced.png" /> Bouche à oreille
<!-- END:IF -->
</fieldset>

<fieldset><legend>Destinataires multiples</legend>
Ajoutez autant de destinataires que nécessaire en respectant pour chaque ligne le format "promotion ; nom ; prénom ; email".
Un copier/coller depuis votre tableur préféré fonctionnera également si vous respectez l'ordre des colonnes donné ci-dessus. Toutes les colonnes de toutes les lignes doivent être remplies.<br />
<!-- AGENT $f_liste rows=15 cols=50 --><br />
<!-- AGENT $f_save_list value="Envoyer à la liste" onclick='return openSendbox(this)' -->
</fieldset>

<!-- AGENT $form _mode_='close' -->
<!-- AGENT 'footer' -->

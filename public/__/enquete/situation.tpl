<!-- AGENT 'header' title = 'Enquête : situation' --><style type="text/css"><!--

.required
{
	color: black;
}

.errormsg
{
	font-style: italic;
}

span.errormsg
{
	padding-left: 10px;
	position: absolute;
}

.detail
{
	font-style: italic;
	font-size: 70%;
}

input.text, textarea
{
	width: 100%;
}

--></style>

<!-- IF !$form -->
Bienvenue sur l'enquête situation<br />
Si vous souhaitez répondre à l'enquete vous devez utiliser<br />
la clé personnelle qui vous a été envoyée par email<br />
Si vous avez un problème, vous pouvez contacter le propriétaire de cette enquete<br />
<!-- ELSE -->
<!-- AGENT $form _mode_='errormsg' -->

<!-- AGENT $form -->

<!-- SET g$inputFormat --><tr><td>%0&nbsp;:</td><td>%1%2</td></tr><!-- END:SET -->

<blockquote style="width: 600px">
{$prenom} {$nom}, promotion {$promo}<br />
{$email}<br />
<br />
<!-- AGENT $f_adresse              _caption_="Adresse(s) où l'on peut vous joindre" _format_='%0&nbsp;:<br />%1%2' rows=2 -->

<h2>Situation actuelle</h2>
<!-- AGENT $f_actif                _caption_="Avez-vous actuellement un emploi ?" _glue_='&nbsp;' _format_='%0<br />%1%2' --><br />
<br />
Si oui, pouvez-vous répondre aux questions suivantes ?<br />
Si votre situation n'a pas changé depuis la dernière enquête, vous pouvez valider le formulaire.

<!-- SET $inputWithDetails --><tr><td rowspan="2">%0&nbsp;:</td><td>%1%2</td></tr><!-- END:SET -->

<blockquote>
<table>
<!-- AGENT $f_date_debut           _caption_="Depuis quelle date" _format_=$inputWithDetails -->
<tr><td class="detail">au format jj-mm-aaaa.</td></tr>
<tr><td>&nbsp;</td></tr>
<!-- AGENT $f_type_emploi          _caption_="Type d'emploi" _format_=$inputWithDetails -->
<tr><td class="detail">CDI, CDD, Bourse (type, en particulier pour une thèse), autre.</td></tr>
<tr><td>&nbsp;</td></tr>
<!-- AGENT $f_date_fin             _caption_="Date de fin" _format_=$inputWithDetails -->
<tr><td class="detail">Echéance de votre contrat de travail en cas d'emploi non pérenne,<br />au format jj-mm-aaaa.</td></tr>
<tr><td>&nbsp;</td></tr>
<!-- AGENT $f_profil_emploi        _caption_="Profil de l'emploi" -->
<tr><td>&nbsp;</td></tr>
<!-- AGENT $f_societe              _caption_="Société" -->
<tr><td>&nbsp;</td></tr>
<!-- AGENT $f_1er_emploi           _caption_="S'agit-il de votre premier emploi" _glue_='&nbsp;' -->
<tr><td>&nbsp;</td></tr>
<!-- AGENT $f_salaire              _caption_="Salaire brut annuel en €" -->
</table>
</blockquote>
<!-- SET g$inputFormat -->%1%2<!-- END:SET -->
Si non :
<blockquote>
<!-- AGENT $f_etudiant             _caption_="Poursuivez-vous des études" _glue_='&nbsp;' _format_='%0&nbsp:%1%2' --><br />
<br />
Sinon, quelles difficultés principales rencontrez-vous dans votre recherche d'emploi ?<br />
<!-- AGENT $f_difficulte  rows=6 -->
</blockquote>

<h2>Historique</h2>
Pouvez-vous retracer avec les dates les différentes étapes de votre parcours depuis votre sortie de l’Ecole : poursuite d’études ou formations complémentaires (quel type ?), recherche d’emploi, emploi effectif (type, profil, société) ?<br />
<!-- AGENT $f_historique rows=15 -->


<h2>Remarques</h2>
<!-- AGENT $f_remarque  rows=15 --><br />
</br>
<div align="right"><!-- AGENT $f_save value='Valider' --></div>
</blockquote>

<!-- AGENT $form _mode_='close' -->
<!-- END:IF -->
<!-- AGENT 'footer' -->

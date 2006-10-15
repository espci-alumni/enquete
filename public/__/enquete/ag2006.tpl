<!-- AGENT 'header' title = 'Enquête : situation' --><style type="text/css"><!--

.mandatory
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
Vote pour l'assemblée générale 2006 d'espci.org<br />
Merci d'utiliser la clef personnelle qui vous a été envoyée par email.<br />
En cas de problème, merci de contacter {'bureau@espci.org'|mailto}<br />
<!-- ELSE -->
<!-- AGENT $form _mode_='errormsg' -->

<!-- AGENT $form -->

<!-- SET g$inputFormat -->%0&nbsp;:%1%2<!-- END:SET -->
<!-- SET g$checkboxGlue -->&nbsp;<!-- END:SET -->

<blockquote style="width: 600px">
{$prenom} {$nom}, promotion {$promo}<br />
{$email}<br />
<br />

<h2>Présence à l'AG du 22 octobre</h2>
<!-- AGENT $f_present _caption_="Serez-vous présent à l'AG du 22 octobre à l'ESPCI ?" -->

<h2>Présentation des comptes</h2>
<!-- AGENT $f_present _caption_="Approuvez-vous ces comptes ?" -->

<h2>Election du nouveau conseil</h2>
<!-- AGENT $f_present _caption_="Approuvez-vous ce nouveau conseil ?" -->

<h2>Champ libre (commentaires, questions, idées, ...)</h2>
<!-- AGENT $f_libre _format_='%1%2' -->


<div align="right"><!-- AGENT $f_save value='Valider' --></div>
</blockquote>

<!-- AGENT $form _mode_='close' -->
<!-- END:IF -->
<!-- AGENT 'footer' -->

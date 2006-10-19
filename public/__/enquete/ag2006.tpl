<!-- AGENT 'header' title = 'Bulletin AG espci.org 2006' --><style type="text/css"><!--

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

h2
{
	margin-top: 30px;
	border-bottom: 2px solid black;
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

<blockquote style="width: 700px">
<h1>Assemblée Générale ESPCI.ORG - 2006</h1>
<p>Bulletin de vote de {$prenom} {$nom}, promotion {$promo}, {$email}.</p>

<p>
<!-- IF $membre -->Vous êtes à jour de votre cotisation 2006, et à ce titre avez une voix délibérative à cette assemblée.
<!-- ELSE -->Vous êtes membre d'espci.org, mais n'êtes pas à jour de votre cotisation 2006. A ce titre, vous avez une voix consultative à cette assemblée. Si vous souhaitez que votre voix soit délibérative, vous devez cotiser avant l'assembée générale (cf.&nbsp;<a href="http://espci.org/fr/cotiser">http://espci.org/fr/cotiser</a>)
<!-- END:IF -->
</p>

<h2>Présence</h2>
<blockquote>
L'association espci.org dont vous êtes membre organise sa première assemblée générale le 22 octobre à 16h dans les locaux de l'ESPCI.<br />
<!-- AGENT $f_present _caption_="Serez-vous présent à cette AG ?" -->
</blockquote>

<h2>Présentation des comptes</h2>
<!-- AGENT 'enquete/ag2006comptes' -->
<blockquote>
<!-- AGENT $f_comptes2006 _caption_="Approuvez-vous les comptes 2006 ?" --><br />
<!-- AGENT $f_previsionnel2007 _caption_="Soutenez-vous les comptes prévisionnels 2007 ?" -->
</blockquote>

<h2>Election du nouveau conseil</h2>
<blockquote>
D'après les statuts, le conseil d'administration de l'association est composé d'un minimum de 6 personnes, et d'un maximum de 12, chacune élue pour 3 ans.
Pour sa première assemblée générale, espci.org vous demande d'élire les membres de son prochain conseil.
Compte tenu du fait que 12 candidats se sont déclarés pour en faire partie,
toutes les propositions que nous avons reçues vous sont présentées (par ordre alphabétique) :
<ul>
	<li>Gérard Bacquet, 103ème</li>
	<li>Marc Barritault, 121ème</li>
	<li>Raphaël Cases, 115ème</li>
	<li>Christian Dailly, 87ème</li>
	<li>Gauthier Errasti, 121ème</li>
	<li>Nicolas Grekas, 120ème</li>
	<li>Rami Jabbour, 119ème</li>
	<li>Yann Lamy, 118ème</li>
	<li>Roland Lartigue, 100ème</li>
	<li>Fabien Montel, 120ème</li>
	<li>Charles Simon, 120ème</li>
	<li>Arnaud Spinelli-Audouin, 119ème</li>
</ul>
<!-- AGENT $f_conseil _caption_="Approuvez-vous ce nouveau conseil ?" -->
</blockquote>

<h2>Champ libre (commentaires, questions, idées, ...)</h2>
<blockquote>
<!-- AGENT $f_libre _format_='%1%2' rows=10 -->
</blockquote>

<h2>Valider : <!-- AGENT $f_save value='Valider' _format_='%1' --></h2>
</blockquote>
<br />
<br />
<br />
<br />
<!-- AGENT $form _mode_='close' -->
<!-- END:IF -->
<!-- AGENT 'footer' -->

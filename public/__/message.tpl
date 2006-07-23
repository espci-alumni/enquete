<!-- SET a$title -->Enquête::message<!-- END:SET -->
<!-- SET a$message -->
<!-- IF a$__0__ == 'enregistre' -->
Merci, vos données ont été enregistrées.

<!-- ELSEIF a$__0__ == 'error/user_key' -->
Vous ne pouvez pas accéder à l'enquête :
<ul>
	<li>soit la clé de connection utilisée est invalide</li>
	<li>soit l'enquête a été cloturée</li>
</ul>

<a href="{~}">retour à l'acceuil des enquêtes</a>

<!-- ELSEIF a$__0__ == 'error/owner_key' -->
La clé utilisée pour la connection à l'interface d'administration des enquêtes est invalide.<br />
Contactez-nous si vous avez perdu votre clé.
<!-- END:IF -->
<!-- END:SET -->
<!-- INCLUDE message -->

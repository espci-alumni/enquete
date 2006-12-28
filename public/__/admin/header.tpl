<!-- AGENT 'header' title = 'Administration des enquêtes' -->
<script type="text/javascript" src="{~}js/admin"></script >

<h1>Enquête {a$enquete}</h1>

<!-- SET a$a -->admin/{a$owner_key}<!-- END:SET -->
{"Destinataires"|linkto:a$a}

<!-- SET a$a -->admin/result/{a$owner_key}<!-- END:SET -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {"Résultats"|linkto:a$a}

<!-- SET a$a -->admin/reglage/{a$owner_key}<!-- END:SET -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {"Réglages"|linkto:a$a}

<!-- IF a$lien_promo -->
<!-- SET a$a -->admin/promo/{a$owner_key}<!-- END:SET -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {"Diplômés"|linkto:a$a}
<!-- END:IF -->

<pre>
Propriétaire : {a$owner}
Etat de l'enquête : {a$etat_enquete}
</pre>

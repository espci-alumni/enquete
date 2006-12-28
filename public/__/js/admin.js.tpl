document.write('<style type="text/css">#modele{display:none}</style>');

function openSendbox($from)
{
	if ($from.confirmed) return true;

	window.fromSubmit = $from;

	var w = 640, h = 550,
		win = open(
		{home:'send':1|js},
		'sendbox',
		'status=no,scrollbars=yes,resizable=yes,height='+h+',width='+w+',left=' + (screen.availWidth-w)/2 + ',top=' + (screen.availHeight-h)/2
	);

	if (!win) alert('Vous devez désactiver votre anti-popup pour envoyer des emails');
	else win.focus();

	return false;
}

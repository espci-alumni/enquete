<?php

set_time_limit(0);

abstract class
{
	public $isSaved = false;

	protected $data;

	abstract protected function setupForm($form, $save);

	function __construct($data)
	{
		$this->data = $data;
	}

	function setup()
	{
		$db = DB();

		$a = $this->data;

		$db->autoExecute(
			'admin_user',
			array('statut' => 'ouvert'),
			MDB2_AUTOQUERY_UPDATE,
			"statut='envoye' AND user_key=" . $db->quote($a->user_key)
		);

		$form = new iaForm($a);

		$sql = "SELECT * FROM enquete_{$a->enquete} WHERE result_id=" . $db->quote($a->result_id);
		if ($defaults = $db->queryRow($sql)) $form->setDefaults($defaults);

		$save = $form->add('submit', 'save');

		$this->setupForm($form, $save);

		if ($save->isOn()) $this->save();
	}

	function save()
	{
		$db = DB();
		$a = $this->data;

		$this->isSaved = true;

		$db->autoExecute(
			'admin_user',
			array('statut' => 'enregistre'),
			MDB2_AUTOQUERY_UPDATE,
			"statut='ouvert' AND user_key=" . $db->quote($a->user_key)
		);

		$db->autoExecute(
			'enquete_' . $a->enquete,
			$a->f_save->getData(),
			MDB2_AUTOQUERY_UPDATE,
			'result_id=' . $a->result_id
		);
	}

	static protected $sentlist = array();

	static function send($from, $replyTo, $enquete, $data, $persist)
	{
		$db = DB();

		$subject = $data['subject'];
		$body = $data['template'];

		if ($persist)
		{
			// Mémorisation du dernier modèle utilisé

			$db->autoExecute(
				'admin_enquete',
				array('subject' => $subject, 'template' => $body),
				MDB2_AUTOQUERY_UPDATE,
				"enquete='{$enquete->enquete}'"
			);
		}

		unset($data['subject']);
		unset($data['template']);


		// Enregistrement du destinataire

		$data['date_envoi'] = date('Y-m-d H:i:s');
		$data['enquete'] = $enquete->enquete;

		if (!isset($data['result_id']))
		{
			$nom = addslashes( trim($data['nom']) );
			$prenom = addslashes( trim($data['prenom']) );
			$promo = (int) $data['promo'];

			$sql = 'SELECT result_id
				FROM admin_user
				WHERE REPLACE(nom, "-", " ") = REPLACE(?, "-", " ")
					AND REPLACE(prenom, "-", " ") = REPLACE(?, "-", " ")
					AND promo = ?
					AND enquete = ?';
			if ( $result_id = $db->getOne($sql, null, array($nom, $prenom, $promo, $enquete->enquete)) )
			{
				$data['result_id'] = $result_id;
			}
			else
			{
				$sql = "INSERT INTO enquete_{$enquete->enquete} (result_id) VALUES (0)";
				$db->exec($sql);
				$data['result_id'] = $db->lastInsertID();
			}
		}


		// Vérifie que l'on n'a pas déjà envoyé un email à cette personne dans ce processus

		if (isset(self::$sentlist[$data['result_id'] . '-' . $data['email']])) return;
		self::$sentlist[$data['result_id'] . '-' . $data['email']] = 1;


		// Génère la clef et enregistre l'action

		do $data['user_key'] = substr(CIA::uniqid(), 0, 16);
		while ($db->queryOne("SELECT 1 FROM admin_user WHERE user_key=" . $db->quote($data['user_key'])));

		$db->autoExecute('admin_user', $data);


		// Envoi du mail au destinataire

		$subject = str_replace(
			array('{PROMO}',      '{NOM}',      '{PRENOM}'),
			array($data['promo'], $data['nom'], $data['prenom']),
			$subject
		);

		$lien_promo = '';
		if ($enquete->lien_promo)
		{
			$PC1 = new loop_pc1nondestinataires($enquete->enquete, $data['promo']);
			$lien_promo = 0;
			while ($PC1->loop()) ++$lien_promo;

			if ($lien_promo)
			{
				$lien_promo = $lien_promo > 1
					? "\nLorsque cet email vous a été envoyé, {$lien_promo} personnes de votre promotion n'avaient pas reçu l'enquête. Vous en connaissez peut-être quelques-uns ? Le lien ci-dessous vous permet de leur envoyer cette enquête. Merci d'avance !"
					: "\nLorsque cet email vous a été envoyé, une personne de votre promotion n'avait pas reçu l'enquête. Vous la connaissez peut-être ? Le lien ci-dessous vous permet de lui envoyer cette enquête. Merci d'avance !";

				$lien_promo .= "\nhttp://espci.org/enquete/fr/thanks/{$data['user_key']}\n";
			}
			else $lien_promo = '';
		}

		$anonym = $enquete->anonyme ? "\nLes informations recueillies sont protégées et ne font l'objet que d'une exploitation anonyme. Vos coordonnées personnelles serviront à garder le contact avec vous pour les prochaines enquêtes.\n" : '';

		$body = str_replace(
			array('{PROMO}',      '{NOM}',      '{PRENOM}'),
			array($data['promo'], $data['nom'], $data['prenom']),
			$body
		);

		$body .= "

-----------------------------------------------------------------------
{$anonym}
Pour répondre à l'enquête, merci de cliquer sur votre clef personnelle ({$data['prenom']} {$data['nom']}) :
http://espci.org/enquete/fr/{$data['user_key']}
{$lien_promo}
Description de l'enquête :
{$enquete->description}

-----------------------------------------------------------------------

Cette enquête est réalisée avec les moyens techniques d'espci.org
                --- http://espci.org/ ---


";

		$headers = array(
			'To' => $data['email'],
			'From' => $from,
			'Reply-To' => $replyTo,
			'Subject' => $subject,
			'Return-Path' => "enquete+{$data['user_key']}@espci.org"
		);

		iaMail::send($headers, $body);
	}
}

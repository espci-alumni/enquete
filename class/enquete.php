<?php

set_time_limit(0);

abstract class
{
	protected

	$data,
	$link_template = '%s',
	$thanks_template = 'thanks/%s',
	$email_footer = "

_______________________________________________________________________
Cette enquête est réalisée avec les moyens techniques d'espci.org
                --- http://espci.org/ ---


";

	abstract protected function setupForm($form, $save);

	function __construct($data)
	{
		$this->data = $data;
	}

	function setup()
	{
		$db = DB();

		$o = $this->data;

		$db->autoExecute(
			'admin_user',
			array('statut' => 'ouvert'),
			MDB2_AUTOQUERY_UPDATE,
			"statut='envoye' AND user_key=" . $db->quote($o->user_key)
		);

		$form = new pForm($o);

		$sql = "SELECT * FROM enquete_{$o->enquete} WHERE result_id=" . $db->quote($o->result_id);
		if ($defaults = $db->queryRow($sql)) $form->setDefaults($defaults);

		$save = $form->add('submit', 'save');

		$this->setupForm($form, $save);

		if ($save->isOn())
		{
			$this->save();
			p::redirect(sprintf($this->thanks_template, $o->user_key));
		}
	}

	function save()
	{
		$db = DB();
		$o = $this->data;

		$db->autoExecute(
			'admin_user',
			array('statut' => 'enregistre'),
			MDB2_AUTOQUERY_UPDATE,
			"statut='ouvert' AND user_key=" . $db->quote($o->user_key)
		);

		$db->autoExecute(
			'enquete_' . $o->enquete,
			$o->f_save->getData(),
			MDB2_AUTOQUERY_UPDATE,
			'result_id=' . $o->result_id
		);
	}

	protected $sentlist = array();

	function send($from, $replyTo, $enquete, $data, $persist)
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


		if ('ouvert' == $enquete->etat_enquete)
		{
			// Génère la clef et enregistre l'action

			do $data['user_key'] = substr(p::strongid(), 0, 16);
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
						? "\nLorsque cet email vous a été envoyé, {$lien_promo} personnes de votre promotion n'avaient pas reçu l'enquête. Vous en connaissez peut-être quelques-uns ? Le lien ci-dessous vous permet de la leur envoyer. Merci d'avance !"
						: "\nLorsque cet email vous a été envoyé, une personne de votre promotion n'avait pas reçu l'enquête. Vous la connaissez peut-être ? Le lien ci-dessous vous permet de la lui envoyer. Merci d'avance !";

					$lien_promo .= "\n" . p::__BASE__() . sprintf($this->thanks_template, $data['user_key']) . "\n";
				}
				else $lien_promo = '';
			}

			$anonym = $enquete->anonyme ? "\nLes informations recueillies sont protégées et ne font l'objet que d'une exploitation anonyme.\n" : '';
			$link = sprintf($this->link_template, $data['user_key']);

			$body = str_replace(
				array('{PROMO}',      '{NOM}',      '{PRENOM}',      '{LIEN}'),
				array($data['promo'], $data['nom'], $data['prenom'], $link   ),
				$body
			);

			$body .= "
	_______________________________________________________________________";
		
			if (false === strpos($body, $link)) $body .= "
{$anonym}
Pour répondre, merci de cliquer sur ce lien (réservé à {$data['prenom']} {$data['nom']}) :
{$link}";

			$body .= "
{$lien_promo}
Description :
{$enquete->description}";

		}

		$body .= $this->email_footer;

		$headers = array(
			'To' => $data['email'],
			'From' => $from,
			'Reply-To' => $replyTo,
			'Subject' => $subject,
			'Return-Path' => "enquete+{$data['user_key']}@espci.org"
		);

		pMail::send($headers, $body);
	}
}

<?php

class extends agent
{
	public $get = array('__1__', 'order_by_date:b', 'p:i:2' => 1);

	protected $enquete;
	protected $form;

	const perPage = 0;

	function control()
	{
		parent::control();

		$db = DB();

		$sql = "SELECT * FROM admin_enquete WHERE owner_key=" . $db->quote($this->get->__1__);
		if ($row = $db->queryRow($sql)) $this->enquete = $row;
		else p::redirect('message/error/owner_key');
	}

	function compose($o)
	{
		$o = $this->enquete;

		$db = DB();

		if (self::perPage)
		{
			$sql = "SELECT COUNT(*) FROM admin_user u WHERE enquete='{$this->enquete->enquete}'";
			$o->numPages = ceil($db->getOne($sql) / self::perPage);

			$o->page = min($this->get->p, $o->numPages) - 1;
		}
		else $o->page = 0;

		$sql = "SELECT *, IF(source_key!='', (SELECT CONCAT(prenom,' ',nom,' - ',promo) FROM admin_user WHERE user_key=u.source_key), '') AS source
			FROM admin_user u
			WHERE enquete='{$this->enquete->enquete}'
			ORDER BY " . (
				$this->get->order_by_date
				? 'mtime DESC,promo,nom,prenom'
				: 'promo,nom,prenom,mtime DESC'
			);
		$o->USER = new loop_sql($sql, array($this, 'filterUser'), self::perPage * ($o->page), self::perPage);


		$form = $this->form = new pForm($o);

		$save = $form->add('submit', 'save');
		$relancer = $form->add('submit', 'relancer');
		$save_list = $form->add('submit', 'save_list');

		$form->add('text', 'subject', array('default' => $o->subject));
		$form->add('textarea', 'template', array('default' => $o->template));

		$form->add('text', 'promo', array('valid' => 'int') );
		$form->add('text', 'nom');
		$form->add('text', 'prenom');
		$form->add('text', 'email', array('valid' => 'email') );

		$s1 = "\s*[\\n\\r]\s*";
		$s2 = "\s*[,;\\t]\s*";
		$s2 = "[0-9]+{$s2}[^,;\\t]+{$s2}[^,;\\t]+{$s2}[-a-zA-Z0-9_\.\+]+@([-a-zA-Z0-9]+(\.[-a-zA-Z0-9]+)+)";
		$form->add('textarea', 'liste', "\s*{$s2}({$s1}{$s2})*\s*");

		$save->add(
			'subject', "Quel est le sujet du mail à envoyer ?", "",
			'template', "", "",

			'promo', "Complétez le champs promotion", "La promotion doit être un nombre entier",
			'nom', "Complétez le champ nom", "",
			'prenom', "Complétez le champs prénom", "",
			'email', "Complétez le champ email", "Email non valide"
		);

		if ($save->isOn())
		{
			$this->save( $save->getData() );
			p::redirect();
		}

		$relancer->add(
			'subject', "Quel est le sujet du mail à envoyer ?", "",
			'template', "", ""
		);

		if ($relancer->isOn())
		{
			$data = $relancer->getData();

			$user = (array) @$_POST['relance'];
			foreach ($user as &$user)
			{
				$sql = 'SELECT * FROM admin_user WHERE user_key=?';
				if ($user = $db->getRow($sql, null, array($user)))
				{
					$this->save(array(
						'subject' => $data['subject'],
						'template' => $data['template'],

						'result_id' => $user->result_id,
						'promo' => $user->promo,
						'nom' => $user->nom,
						'prenom' => $user->prenom,
						'email' => $user->email,
						'source_key' => $user->source_key,
					));
				}
			}

			p::redirect();
		}

		$save_list->add(
			'liste', "La liste à envoyer est vide", "Le format de la liste n'est pas valide.",
			'subject', "Quel est le sujet du mail à envoyer ?", "",
			'template', "", ""
		);

		if ($save_list->isOn())
		{
			$data = $save_list->getData();

			$liste = trim( $data['liste'] );
			$liste = preg_split("'\s*[\n\r]\s*'su", $liste);

			foreach ($liste as &$liste)
			{
				$liste = str_replace( "\t", ';', $liste );
				$liste = preg_replace( "'\s{2,}'su", ' ', $liste );
				$liste = preg_split( "'\s*[,;]\s*'su", $liste );

				$ligne_is_ok = true;

				if (!(int) $liste[0]) $ligne_is_ok = false;
				if (!$liste[1]) $ligne_is_ok = false;
				if (!$liste[2]) $ligne_is_ok = false;
				if (!FILTER::get($liste[3], 'email')) $ligne_is_ok = false;

				if ($ligne_is_ok)
				{
					$this->save(array(
						'subject' => $data['subject'],
						'template' => $data['template'],

						'promo' => $liste[0],
						'nom' => $liste[1],
						'prenom' => $liste[2],
						'email' => $liste[3],
					));
				}
			}

			p::redirect();
		}

		return $o;
	}

	function filterUser($data)
	{
		$data->f_relance = new pForm_check($this->form, 'relance', array(
			'item' => array($data->user_key => ''),
			'multiple' => true
		));

		unset($data->user_key);
		unset($data->result_id);

		return $data;
	}

	function save($data)
	{
		if ($this->enquete->etat_enquete == 'fermé')
		{
			$data['hors_delai'] = $this->enquete->hors_delai;
		}

		enquete::send($this->enquete->owner, $this->enquete->owner, $this->enquete, $data, true);
	}
}

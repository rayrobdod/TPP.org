<?php

use TPP\Models\Badge;
use TPP\Models\Box;
use TPP\Models\Credit;
use TPP\Models\EliteFour;
use TPP\Models\Fact;
use TPP\Models\Item;
use TPP\Models\Milestone;
use TPP\Models\Pokemon;
use TPP\Models\TPP;

class EditController extends Controller
{

	public function actionIndex() {
		$this->render('layouts/editheader');

		$this->render('pokemon_edit/index', [
			'pokemon' => Pokemon::queryPokemon(),
			'owned'   => $this->getGeneral()->pokedex_owned,
			'seen'    => $this->getGeneral()->pokedex_seen,
		], true);

		$this->render('layouts/footer');
	}

	/**
	 * @param $box_pokemon Pokemon[]
	 *
	 * @return array
	 */
	private function initOrderBoxPokemon($box_pokemon) {
		$boxes = [];
		$getBoxes = Box::getBoxes();

		if(!$getBoxes) return [];

		foreach($getBoxes as $box) {
			$boxes[$box->id] = $box;
		}

		foreach($box_pokemon as $pokemon) {
			$boxes[$pokemon->box]->pokemon[] = $pokemon;
		}
		ksort($boxes);

		return $boxes;
	}

	/**
	 * @param $boxPokemon Pokemon[]
	 *
	 * @return array
	 */
	private function orderBoxPokemon($boxPokemon) {
		$boxes = $this->initOrderBoxPokemon($boxPokemon);
		/**
		 * @var $box Box
		 */
		foreach($boxes as &$box) {
			$chunks = array_chunk($box->pokemon, Pokemon::BOXES_ROWS);
			if(empty($chunks)) {
				continue;
			}
			foreach($chunks as $row => $chunk) {
				foreach($chunk as $pokemon) {
					$box->content[$row][] = $pokemon;
				}
			}
		}

		return $boxes;
	}
	/**
	 * @return stdClass
	 */
	public function getGeneral() {
		$getGeneral = TPP::db()
						 ->query("SELECT `name`, `value` FROM `general`") or die(TPP::db()->error);
		$model = new stdClass();
		while($general = $getGeneral->fetch()) {
			$model->$general['name'] = utf8_encode(stripslashes($general['value']));
		}
		if(isset($model->notice) && $model->notice !== '') {
			$model->notices = $this->getNotices($model->notice);
		}

		return $model;
	}

	/**
	 * @param string $notices
	 *
	 * @return array
	 */
	public function getNotices($notices) {
		return explode('%%%', $notices);
	}

	/**
	 * @return array
	 */
	public function getMessages() {
		$getMessages = TPP::db()->prepare("
 SELECT m.`id`, m.`message`, m.`sent_user`, s.`suggestion`
 FROM `message` m
 LEFT JOIN `suggestion` s ON m.`suggestion_id` = s.`id`
 WHERE m.`read` = 0 AND m.`ip` = :ip
 ORDER BY `date_created` ASC
 LIMIT 1") or die(TPP::db()->error);
		$getMessages->execute([
								  ':ip' => $_SERVER['REMOTE_ADDR'],
							  ]);

		if($getMessages->rowCount() > 0) {
			while($m = $getMessages->fetch()) {
				$return = [
					'message'    => $m['message'], 'id' => $m['id'], 'sentUser' => $m['sent_user'],
					'suggestion' => $m['suggestion'],
				];
			}

			return $return;
		}

		return [];
	}

}

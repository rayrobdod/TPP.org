<?php

class Pokemon extends Model {

	public $id;
	public $name;
	public $pokemon;
	public $level;
	public $nickname;
	public $poke_ball;
	public $gender;
	public $hold_item;
	public $status;

	public static function getPokemon($where = null, $order = null, $limit = null) {
		if(!is_null($where)) {
			$where = ' WHERE ' . $where;
		} if(!is_null($order)) {
			$order = ' ORDER BY ' . $order;
		} if(!is_null($limit)) {
			$limit = ' LIMIT ' . $limit;
		}
		$getPokemon = TPP::db()->query("SELECT
			p.`id`, p.`pokemon`, p.`name`, p.`level`, p.`nickname`, p.`gender`, p.`hold_item`, p.`status`, p.`box_id`, p.`poke_ball`, p.`comment`,
			GROUP_CONCAT(DISTINCT m.`name` SEPARATOR ',') as `moves`,
			s.`status` as `status_name`
			FROM `pokemon` p
			LEFT JOIN `move` m
			ON m.`pokemon` = p.`id`
			JOIN `status` s
			ON s.`id` = p.`status`
			" . $where . " GROUP BY p.`id`" . $order . $limit) or die(TPP::db()->error);
		while($pok = $getPokemon->fetch_assoc()) {
			$newPokemon = new self();
			$newPokemon->setAttributes([
				'id' => $pok['id'],
				'name' => $newPokemon->setName($pok['name'], $pok['pokemon']),
				'pokemon' => $newPokemon->setPokemon($pok['pokemon']),
				'level' => $newPokemon->setLevel($pok['level']),
				'nickname' => $newPokemon->setNickname($pok['nickname']),
				'poke_ball' => $newPokemon->setPokeBall($pok['poke_ball']),
				'gender' => $newPokemon->setGender($pok['gender']),
				'hold_item' => $newPokemon->setHoldItem($pok['hold_item']),
				'status' => $pok['status_name'],
				'comment' => FuncHelp::getDateTime($pok['comment']),
				'moves' => $newPokemon->setMoves($pok['moves']),
			]);
			$newPokemon->setAttributes($newPokemon->getFields());

			$return[] = $newPokemon;
		}
		return $return;
	}

	public function getFields() {
		$fields = [];
		$getFields = TPP::db()->query("
		SELECT
			f.`name`,
			pfe.`pokemon_id`,
			pfe.`value`
		FROM
			`pokemon_field_eav` pfe,
			`field` f
		WHERE
			pfe.`pokemon_id` = $this->id
		AND
			pfe.`field_id` = f.`id`");
		$i = 0;
		while($fi = $getFields->fetch_assoc()) {
			$fields[$fi['name']] = $fi['value'];
		}
		if(isset($fields['next_move'])) {
			$move = new Move();
			$move->name = $fields['next_move'];
			unset($fields['next_move']);
			if(isset($fields['next_move_level'])) {
				$move->level = $fields['next_move_level'];
				unset($fields['next_move_level']);
			}
			$fields['next_move'] = $move;
		}
		return $fields;
	}

	public function setName($name, $pokemon) {
		return !empty($name)
		? str_replace([' ', '\Pk'], ['&nbsp;', '<img src="/img/pk.png" title="" alt="">'], stripslashes(FuncHelp::utf8ify($name)))
		: FuncHelp::utf8ify($pokemon);
	}

	public function setPokemon($pokemon) {
		return FuncHelp::utf8ify($pokemon);
	}

	public function setLevel($level) {
		return $level !== 0 ? $level : '?';
	}

	public function setNickname($nickname) {
		return isset($nickname) ? stripslashes(utf8_encode($nickname)) : 'No nickname';
	}

	public function setPokeBall($poke_ball) {
		if($poke_ball) {
			$item = new Item();
			$item->setName($poke_ball);
			return $item;
		}
		unset($this->poke_ball);
	}

	public function setGender($gender) {
		if($gender) {
			return $this->getGender($gender);
		}
		unset($this->gender);
	}

	public function setHoldItem($hold_item) {
		if($hold_item) {
			$item = new Item();
			$item->setName($hold_item);
			return $item;
		}
		unset($this->hold_item);
	}

	public function setMoves($moves) {
		if($moves) {
			$ex = explode(',', $moves);
			foreach($ex as $m) {
				$model = new Move();
				$model->name = $m;
				$return[] = $model;
			}
			return $return;
		}
		unset($this->moves);
	}

	public static function getPartyPokemon() {
		return Pokemon::getPokemon('p.`status` = 1', `party_order`, '6');
	}

	public static function getBoxPokemon() {
		return Pokemon::getPokemon('p.`status` = 2', '`id` DESC');
	}

	public static function getDaycarePokemon() {
		return Pokemon::getPokemon('p.`status` = 6', '`id` DESC');
	}

	public static function getHistoryPokemon() {
		return Pokemon::getPokemon('p.`status` NOT IN(1,2,6,9)', '`comment` DESC');
	}

	private function getGender($g) {
		return $g;
	}

	public function beautifyGender() {
		if(isset($this->gender)) {
			switch($this->gender) {
				case 'm': $return = '4';
					break;
				case 'f': $return = '2';
					break;
				default: 
					return '';
			}
			return ' <span class="gender">(&#979' . $return . ';)</span>';
		}
		return null;
	}

	public function showImage($htmlOptions = [], $size = null) {
		$path = '/pokemon';
		$path .= !is_null($size) ? '/80' : '';
		$pokemon = $this->pokemon;

		if($pokemon == 'Jellicent' && $this->gender == 'f') {
			$pokemon = 'Jellicent-Female';
		}
		return parent::image($path, $pokemon, $htmlOptions);
	}

	public function showMenuImage($htmlOptions = []) {
		$addToImage = '';
		$addToImage .= isset($this->season) ? '_' . $this->season : '';
		$addToImage .= isset($this->gender) ? '_' . $this->gender : '';
		$addToImage .= isset($this->is_shiny) ? '_s' : '';
		return parent::image('/pokemon/sprites/red', $this->pokemon . $addToImage, $htmlOptions);
	}

	public function getNicknames() {
		if($this->nickname == '') {
			return '<em>No nickname</em>';
		}

		$return = '';
		$array = explode('%', $this->nickname);
		$i = 0;
		if($this->nickname == 'No nickname') {
			return '<em>' . $this->nickname . '</em>';
		} else {
			foreach($array as $ar) {
				$return .= '"' . utf8_decode($ar) . '"';
				if(count($array) > 1) {
					$return .= $i < count($array) - 1 ? ',<br>' : '';
				}
				$i++;
			}
		}
		echo $return;
	}

	public function getMoves() {
		$return = [];
		if(isset($this->moves)) {
			$hms = FuncHelp::getHmMoves();
			foreach($this->moves as $move) {
				if(in_array($move->name, $hms)) {
					$return[] = '<strong>' . $move->name . '</strong>';
				} else {
					$return[] = $move->name;
				}
			}
		}
		return $return;
	}

	public function getHistoryStatusText() {
		switch($this->status) {
			case 'Traded': return 'for';
			case 'Evolved': return 'into';
			case 'Hatched': return 'into';
			default: return null;
		}
	}

	public function getHistoryColour() {
		return strtolower($this->status);
	}

	public function getAbilityDescription() {
		return $this->ability;
	}

	public function getNatureDescription() {
		return $this->nature;
	}

        public function getCharacteristicDescription() {
                return $this->characteristic;
        }

}

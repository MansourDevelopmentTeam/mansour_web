<?php 

namespace App\Models\Orders;

/**
* 
*/
class StatePolicy
{
	
	public static $states = [
		"1" => [
			[
				"to" => "2",
				"roles" => ["1"]
			],
			[
				"to" => "6",
				"roles" => ["1", "2"]
			],
			[
				"to" => "9",
				"roles" => ["2"]
			]
		],
		"2" => [
			[
				"to" => "8",
				"roles" => ["3"]
			],
			[
				"to" => "5",
				"roles" => ["3"]
			],
			[
				"to" => "6",
				"roles" => ["1"]
			]
		],
		"3" => [
			[
				"to" => "7",
				"roles" => ["1"]
			],
			[
				"to" => "4",
				"roles" => ["3"]
			]
		],
		"4" => [
		],
		"5" => [
			[
				"to" => "1",
				"roles" => ["1"]
			],
			[
				"to" => "6",
				"roles" => ["1"]
			],
		],
		"6" => [
		],
		"7" => [
		],
		"8" => [
			[
				"to" => "3",
				"roles" => ["1"]
			],
			[
				"to" => "7",
				"roles" => ["1"]
			],
		],
		"9" => [
			[
				"to" => "6",
				"roles" => ["1"]
			],
			[
				"to" => "2",
				"roles" => ["1"]
			],
			[
				"to" => "1",
				"roles" => ["1", "2"]
			]
		]
	];

	public static function validateStateChange($old_state, $new_state, $role_id)
	{
		$transitions = self::$states[$old_state];
		foreach ($transitions as $transition) {
			if ($role_id == 1) {
				return true;
			}
			if($transition["to"] == $new_state) {
				if (is_array($role_id)) {
					foreach ($role_id as $role) {
						if(in_array($role, $transition["roles"])) {
							return true;
						}	
					}
				} else {
					if(in_array($role_id, $transition["roles"])) {
						return true;
					}
				}
			}
		}

		return false;
	}
}
<?php

namespace App\Models\Repositories;

use App\Models\ACL\Role;
use App\Models\Users\Profile;
use App\Models\Users\User;

/**
* Social repo
*/
class SocialRepository
{

	public function firstOrCreate($providerUser, $provider)
	{

		if($profile = $this->profileExist($provider, $providerUser->id)){
			if(isset($providerUser->email)){
				$profile = $this->updateProfileEmail($profile, $providerUser->email);
			}
			return $profile->user;
		}

		$profile = Profile::create([
			"provider" => $provider,
			"provider_id" => $providerUser->id,
			"email" => isset($providerUser->email) ? $providerUser->email : null,
			]);

		if(isset($providerUser->email)){
			$user = User::where("email", $providerUser->email)->get()->first();

			if($user){
				$profile->linkUser($user);
			}else{
				$user = $profile->createUser($providerUser->name, $providerUser->email);
			}
		}else{
			$user = $profile->createUser($providerUser->name);
		}

		// if(!$user->avatar && isset($providerUser->avatar)){
		// 	$user->avatar = $providerUser->avatar;
		// 	$user->save();
		// }

		return $user;
	}

	public function isFirst($provider, $provider_id)
	{
		if((bool)$this->profileExist($provider, $provider_id)){
			return false;
		}
		return true;
	}

	private function profileExist($provider, $provider_id){
		return Profile::where("provider", $provider)->where('provider_id' ,$provider_id)->get()->first();
	}

	public function updateProfileEmail($profile, $email)
	{
		$profile->email = $email;
		$profile->save();

		$user = $profile->user;
		$user->email = $email;
		$user->phone_verified = $user->phone_verified ? $user->phone_verified : 0;
		$user->save();

		return $profile;
	}
}

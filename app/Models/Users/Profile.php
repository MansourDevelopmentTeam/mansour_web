<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ["provider", "provider_id", "email", "user_id"];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function linkUser(User $user)
    {
    	$this->user_id = $user->id;
    	$this->save();

    	return $user;
    }

    public function createUser($name, $email = null)
    {
        $names = explode(" ", $name);
    	$user = User::create([
    		"name" => $names[0],
    		"last_name" => isset($names[1]) ? $names[1] : null,
    		"email" => $email,
            "active" => 1,
            "phone_verified" => 1,
            "type" => 1
    		]);

    	$this->linkUser($user);

    	return $user;
    }
}

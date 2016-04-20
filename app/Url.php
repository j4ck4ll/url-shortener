<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Url extends Model
{
    //
    protected $fillable = array('url', 'shortened');

    public static $rules = array('url' => 'required|url');

    public static function validate($input)
    {
    	$validation = Validator::make($input, static::$rules);
    	return $validation->fails() ? $validation : true;
    }

    public static function getUniqueShortenedURL()
	{
		$shortened = base_convert(rand(10000,99999), 10, 36);

		if( static::where('shortened', '=', $shortened)->get()->first() ) {
			return static::getUniqueShortenedURL();
		}

		return $shortened;
	}
}

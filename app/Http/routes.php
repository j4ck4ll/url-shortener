<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', function() {
	//Get and validate user input
	$url = Input::get('url');	

	$validation = App\Url::validate(array('url' => $url));
	if( $validation !== true )
		return redirect('/')->withErrors($validation->errors());

	//Get the first record with the URL
	//If the URL is already in the table, then return it
	$record = App\Url::where('url', '=', $url)->get()->first();
	if ($record) {
		$shortenedUrl = $record->shortened;
		return view('result')->with('shortened', $shortenedUrl);
	}

	//Shorten the URL with this function (lives in Url.php)	
	//Create a row and insert data
	$row = App\Url::create(array(
		'url' => $url, 'shortened' => App\Url::getUniqueShortenedURL()
	));
	//If shortened URL exists, show it in the view (result.blade.php)
	if( $row )
		return view('result')->with('shortened', $row->shortened);

});

Route::get('(:any)', function($shortened) {
	//Query the DB for the row with that short URL
	$row = App\Url::where('shortened', '=', $shortened)->get()->first();
	//If not found, redirect to home page
	if($row == null) 
		return redirect('/');
	//Otherwise, fetch the URL and redirect
	else
		return redirect($row->url);
});

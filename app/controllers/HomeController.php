<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getPlayer($organisation_slug = 'exdeliver-office')
	{

        $user = null;
        $userIsMember = false;

        if(Sentry::check()){
            $user = $this->getCurrentUser();

            $group = GroupName::where('slug', '=', $organisation_slug)->firstOrFail();

            if(in_array($group->id,$this->getGroups())){
                $userIsMember = true;
            }
        }

        if(!isset($organisation_slug)){
            return Redirect::to('/404');
        }

        try{
            $team = GroupName::where('slug', '=', $organisation_slug)->firstOrFail();
        }catch(Exception $e){
            $status = 'Team not found';
        }

        try{
            $tracks = Track::where('playlist_id', '=', $team->playlist->first()->id)->orderBy('position', 'asc')->get();
        }catch(Exception $e) {
            $status = 'Playlist not found';
        }

		return View::make('player.organisation-player')
            ->with('user', $user)
            ->with('userismember', $userIsMember)
            ->with('team', $team)
            ->with('tracks', $tracks)
            ->with('mediatypes', $this->mediaTypesIcons());
	}

    public function doArduino()
    {
            $jsonArray = json_encode(Input::all());

            $reObject = (array) json_decode($jsonArray);

            // time
            $time = str_replace('time-','',$reObject[0]);
            $value = str_replace("\r\n",'',$reObject[1]);

            $newObject = json_encode(array(0 => $time, 1 => $value));

            if($value == null || $value == ''){
                return 'not saved';
            }
            $value = str_replace('\r\n','',$reObject[1]);
            // save to database
            $foobar = new Tester;
            $foobar->val = $newObject;
            $result = $foobar->save();

            // send mail or sms
            if($value < "150") {
                mail('renalpha@hotmail.com', 'overlast ingrijpen!', 'decibel waarde van' . $value . ' gemeten');
                return 'ALARM SEND';
            }
            return 'SET';

    }

}

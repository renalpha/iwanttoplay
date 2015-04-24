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
    public function getHome()
    {
        $user = $this->getCurrentUser();
        if(isset($user)) {

            $groups = $this->getGroups();
            if(isset($groups)){
                $playlistArray = array();
                foreach($groups as $group){
                    array_push($playlistArray, GroupName::where('id', '=', $group)->where('name', '!=', 'admin')->firstOrFail());
                }
            }
            return View::make('user.home')
                ->with('playlistsArray', $playlistArray)
                ->with('user', $user);

        }else{
            $playlistArray = GroupName::where('name', '!=', 'admin')->get();

        }
        return View::make('user.home')
            ->with('playlistsArray', $playlistArray);
    }

    public function getPlayer($organisation_slug = 'exdeliver-office', $tracknumber = null)
    {

        if(!isset($organisation_slug)){
            return Redirect::to('/404');
        }

        $user = null;
        $userIsMember = false;

        try{
            $team = GroupName::where('slug', '=', $organisation_slug)->firstOrFail();
        }catch(Exception $e){
            $status = 'Team not found';
        }


        if(Sentry::check()){
            $user = $this->getCurrentUser();

            $group = GroupName::where('slug', '=', $organisation_slug)->firstOrFail();

            if(in_array($group->id,$this->getGroups())){
                $userIsMember = true;
            }
        }

        $members = UserGroup::where('group_id', '=', $team->id)->get();
        $playlists = Playlist::get();
        $countplaylists = count($playlists);
        $djranks = array(
            1 => 'Hardwell',
            2 => 'Dimitri Vegas & Like Mike',
            3 => 'Armin van Buuren',
            4 => 'Martin Garrix',
            5 => 'Tiesto',
            6 => 'Avicii',
            7 => 'David Guetta',
            8 => 'Nicky Romero',
            9 => 'Skrillex',
            10 => 'Steve Aoki',
            11 => 'Calvin Harris',
            12 => 'Afrojack',
            13 => 'Blasterjaxx',
            14 => 'Dash Berlin',
            15 => 'Alesso',
        );

        return View::make('player.organisation-player')
            ->with('user', $user)
            ->with('team', $team)
            ->with('djranks',$djranks)
            ->with('countplaylists', $countplaylists)
            ->with('members', $members)
            ->with('userismember', $userIsMember)
            ->with('tracknumber',$tracknumber)
            ->with('organisation_slug', $organisation_slug);
    }

    public function getYTPlayer($yturl = null, $no = null)
    {
        if(!isset($yturl) || !isset($no)){
            return '404';
        }

        return View::make('player.youtube')
            ->with('youtubeurl', $yturl)
            ->with('no', $no);
    }

    public function getList($organisation_slug = 'exdeliver-office', $nowid = null)
    {
        $userIsMember = null;
        try{
            $team = GroupName::where('slug', '=', $organisation_slug)->firstOrFail();
        }catch(Exception $e){
            $status = 'Team not found';
        }

        if(Sentry::check()){
            $user = $this->getCurrentUser();

            $group = GroupName::where('slug', '=', $organisation_slug)->firstOrFail();

            if(in_array($group->id,$this->getGroups())){
                $userIsMember = true;
            }
        }

        $countPlayList = count(Playlist::where('group_id', '=', $team->id)->get());
        if($countPlayList == 0){
            return Redirect::back()
                ->with('status', 'No playlist available for this group.');
        }

        try{
            $trackscounter = count(Track::where('playlist_id', '=', $team->playlist->first()->id)->orderBy('position', 'asc')->get());

            if($trackscounter == 0){
                $tracks = null;
            }else{
                $tracks = Track::where('playlist_id', '=', $team->playlist->first()->id)->orderBy('position', 'asc')->get();
            }

        }catch(Exception $e) {
            $track = null;
            $status = 'Playlist not found';
        }

        return View::make('player.list')
            ->with('team', $team)
            ->with('tracks', $tracks)
            ->with('currentid', $nowid)
            ->with('organisation', $organisation_slug)
            ->with('userismember', $userIsMember)
            ->with('mediatypes', $this->mediaTypesIcons());
    }

    public function dontShowCookie() {
        $cookie = Cookie::make('dontshowvenster', 'set', 12000000);
        return Redirect::back()
            ->withCookie($cookie);
    }

}

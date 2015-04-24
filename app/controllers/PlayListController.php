<?php

class PlayListController extends BaseController {

    public function doReorderList($playlist_id = null)
    {
        if($playlist_id == null){
            return 'Permission denied!';
        }

        $formData = \Input::get('formData');
        $arrayData = explode(',',$formData);
        $i = 0;

        foreach($arrayData as $listitem){
            $splitItem = explode('-', $listitem);
            //echo $splitItem[0];
            $track = Track::where('playlist_id', '=', $playlist_id)->where('id', '=', $splitItem[0])->firstOrFail();
            $track->position = $i++;
            $checksuccess = $track->save();
        }

        return 'Moved order Track';

    }

    public function doAddTrack($playlist_id = null)
    {
        if($playlist_id == null){
            return 'Permission denied!';
        }

        $rules = array(
            'artist' => 'required',
            'title'  => 'required',
            'link'   => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }

        $tracktype = $this->getTrackType(str_replace('www.','',Input::get('link')));

        $track = new Track();
        $track->artist = Input::get('artist');
        $track->title = Input::get('title');
        $track->playlist_id = $playlist_id;
        $track->url = Input::get('link');
        $track->type = $tracktype;
        $track->save();

        return Redirect::back()
            ->with('status', Lang::get('user.trackadded'));
    }

    public function addUserToPlaylist($playlist_id = null)
    {
        if($playlist_id == null){
            return 'Permission denied!';
        }

        $email = Input::get('email-invitation');
        $user = User::where('email', '=', $email)->firstOrFail();
        $group_id = Playlist::where('id', '=', $playlist_id)->firstOrFail()->group_id;

        // check if user is already member
        try {
            $getgroup = UserGroup::where('user_id', '=', $user->id)->where('group_id', '=', $group_id)->firstOrFail();
            return Redirect::back()
                ->with('add-user-status', Lang::get('user.existsingroup'));
        }catch(Exception $e){

        }

        $group = new UserGroup();
        $group->user_id = $user->id;
        $group->group_id = $group_id;
        $group->save();

        return Redirect::back()
            ->with('add-user-status', Lang::get('addedtogroup'));

    }

    public function doCreateNew()
    {
        $rules = array(
            'name' => 'required|unique:groups',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }

        $data = array(
            'name' => Input::get('name'),
            'slug' => Str::slug(Input::get('name')),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        );
        $group = GroupName::create($data);

        $playlistdata = array(
            'group_id' => $group->id,
            'name' => Input::get('name'),
            'invitecode' => $this->generateRandomString(100),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        );
        $playlist = Playlist::create($playlistdata);

        $addtogroup = UserGroup::create(array('user_id' => $this->getCurrentUser()->id, 'group_id' => $group->id));

        return Redirect::back()
            ->with('status', Lang::get('user.playlistcreated'));

    }

    public function getRemoveTrack($organisation = null, $trackid = null)
    {
        $trackid = str_replace('remove-', '', $trackid);
        $groupid = GroupName::where('slug', '=', $organisation)->firstOrFail()->id;
        $playlist = Playlist::where('group_id', '=', $groupid)->firstOrFail()->id;
        $track = Track::where('id', '=', $trackid)->where('playlist_id', '=', $playlist)->firstOrFail();
        $track->delete();

        return 'removed';
    }

    public function doAddMeInvite($playlistid = null, $invitecode = null)
    {

        if(!Sentry::check()){
            return Redirect::to('/signup')
                ->with('status', Lang::get('user.youneedaccountfirst'));
        }

        if(!isset($invitecode)) {

            $rules = array(
                'invitecode' => 'required',
            );


        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('invite-status', Lang::get('user.wronginvitecode'));
        }
        }
        $code = (isset($invitecode)) ? $invitecode : Input::get('invitecode');

        try {
            $playlist = Playlist::where('id', '=', $playlistid)->where('invitecode', '=', $code)->firstOrFail();
        }catch(Exception $e){
            return Redirect::back()
                ->with('invite-status', Lang::get('user.wronginvitecode'));
        }
            // user already known?
        try {
            $checkuser = UserGroup::where('group_id', '=', $playlist->group_id)->where('user_id', '=', $this->getCurrentUser()->id)->firstOrFail();

            return Redirect::back()
                ->with('invite-status', Lang::get('user.existsingroup'));

        }catch(Exception $e){
            $group = new UserGroup();
            $group->group_id = $playlist->group_id;
            $group->user_id = $this->getCurrentUser()->id;
            $group->save();

            $groupname = GroupName::find($playlist->group_id);
            return Redirect::to('/playlist/'.$groupname->slug.'/play')
                ->with('invite-status', Lang::get('user.successinvited'));
        }

    }

    private function generateRandomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function doVote($playlist_id = null)
    {
        $playlist = Playlist::find($playlist_id);
        $currentrank = $playlist->votes++;
        $playlist->update();

        $cookie = Cookie::make('dontshowvote'.$playlist_id, 'set', 12000000);

        return Redirect::back()
            ->with('voted-status', Lang::get('user.votesuccess'))
            ->withCookie($cookie);

    }

}

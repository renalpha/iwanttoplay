<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
            // send variables to master layout
            if (Sentry::check()){
                View::share([
                    'groupid'       => $this->getCurrentUserGroup(),
                    'currentuser'   => $this->getCurrentUser()
                ]);
            }
		}
	}

    public function getGroupId()
    {
        if(Sentry::check()) {
            $user = User::find(Sentry::getUser()->id);
            return $user->group->group_id;
        }
    }

    public function getGroup()
    {
        if(Sentry::check()) {
            $user = User::find(Sentry::getUser()->id);
            $groupname = GroupName::where('id', '=', $user->group->group_id)->firstOrFail();
            return $groupname;
        }
    }

    public function getGroups()
    {
        if(Sentry::check()) {
            $groups = UserGroup::where('user_id', '=', Sentry::getUser()->id)->get();
            $newgrouparray = array();
            foreach($groups as $group){
                array_push($newgrouparray, $group->group_id);
            }
            return $newgrouparray;
        }
    }

    public function getCurrentUser()
    {
        if(Sentry::check()) {
            $user = User::find(Sentry::getUser()->id);
            return $user;
        }
    }

    public function mediaTypesIcons()
    {
        $mediaTypes = array('soundcloud' => 'soundcloud-icon.png', 'youtube' => 'youtube-icon.png', 'spotify' => 'spotify-icon.png');
        return $mediaTypes;
    }

    public function mediaTypes()
    {
        $mediaTypes = array('soundcloud' => 'soundcloud', 'youtube' => 'youtube', 'spotify' => 'spotify');
        return $mediaTypes;
    }

    public function getTrackType($url)
    {
        $trackURLinfo = (object) parse_url($url);
        $getDomain = preg_split('/(?=\.[^.]+$)/', $trackURLinfo->host);
        return $getDomain[0];
    }

}

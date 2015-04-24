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
                    'currentuser'   => $this->getCurrentUser(),
                    'yt-height'     => '600',

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
        $mediaTypes = array('mixcloud' => 'mixcloud-icon.png','soundcloud' => 'soundcloud-icon.png', 'youtube' => 'youtube-icon.png', 'spotify' => 'spotify-icon.png');
        return $mediaTypes;
    }

    public function mediaTypes()
    {
        $mediaTypes = array('mixcloud' => 'mixcloud', 'soundcloud' => 'soundcloud', 'youtube' => 'youtube', 'spotify' => 'spotify');
        return $mediaTypes;
    }

    public function getTrackType($url)
    {
        $trackURLinfo = (object) parse_url($url);
        $getDomain = preg_split('/(?=\.[^.]+$)/', $trackURLinfo->host);
        return $getDomain[0];
    }

    public function facebookOauth()
    {
            // Use a single object of a class throughout the lifetime of an application.
            $application = array(
                'appId' => '1560119087592235',
                'secret' => '46e033980833bc06a2fec8e9d29e5154'
            );

            // getInstance
            return FacebookConnect::getFacebook($application);
    }

}

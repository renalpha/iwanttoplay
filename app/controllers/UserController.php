<?php

class UserController extends BaseController
{

    public function getSignup()
    {
        if(!Sentry::check()) {
            return View::make('user.signup');
        }else{
            return Redirect::to('/');
        }
    }

    public function getLogin()
    {
        if(!Sentry::check()) {
            return View::make('user.login');
        }else{
            return Redirect::to('/');
        }
    }

    public function facebookRegister()
    {
        $facebook = $this->facebookOauth();

        // get user or login or authorize user

        if ($facebook->getUser() != 0) {
            $user = $facebook->getUser();
            $fbme = (object) $facebook->api('/me');
            // add user to database
            try{
                $checkuser = User::where('fbid', $fbme->id)->firstOrFail();

            }catch(Exception $e){
                return View::make('user.fbsignup')
                    ->with('facebookapi', $fbme);
            }

                // Find the user using the user id
                $fuser = Sentry::findUserById($checkuser->id);

                // Log the user in
                $result = Sentry::loginAndRemember($fuser);

                return Redirect::to('/');


        }else{

            $params = array(
                'fbconnect'=>0,
                'canvas'=>1,
                'scope'=>'publish_stream,email',
            );
            $loginUrl = $facebook->getLoginUrl($params);
            return Redirect::to($loginUrl);
        }

    }

    public function getSignout()
    {
        Sentry::logout();
        return Redirect::to('/');
    }

    public function doSignup()
    {

        $authtype = Input::get('authtype');

        if($authtype == 'facebook'){
            $rules = array(
                'groupname' => 'required|between:3,32',
                'email' => 'required|email',
                'first_name' => 'required',
                'last_name' => 'required',
                'terms' => 'required:min:1',
            );
        }else {
            $rules = array(
                'groupname' => 'required|between:3,32',
                'email' => 'required|email',
                'password' => 'required|between:3,32',
                'password_verification' => 'required|between:3,32|same:password',
                'first_name' => 'required',
                'last_name' => 'required',
                'terms' => 'required:min:1',
            );
        }

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }

        // continue HELO
        $emailValidation = new EmailValidator(Input::get('email'), 'getyoursitenoticed.com', 'noreply@getyoursitenoticed.com');
        $resultEmailDNS = $emailValidation->validate();

        /*
        if($resultEmailDNS == false){
            $validator = Lang::get('user.emaildnsfaulty');
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }*/

        $fbid = Input::get('fbid');

        $user = new User();
        $user->fbid = (isset($fbid) && $fbid != null) ? $fbid : NULL;
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->activated = 1;
        $user->created_at = date('Y-m-d');
        $user->updated_at = date('Y-m-d');
        $user->save();

        $groupname = new GroupName();
        $groupname->name = Input::get('groupname');
        $groupname->slug = Str::slug(Input::get('groupname'));
        $groupname->created_at = date('Y-m-d');
        $groupname->updated_at = date('Y-m-d');
        $groupname->save();

        $group = new UserGroup();
        $group->user_id = $user->id;
        $group->group_id = $groupname->id;
        $group->save();

        $playlist = new Playlist();
        $playlist->group_id = $groupname->id;
        $playlist->name = Input::get('groupname');
        $playlist->invitecode = $this->generateRandomString(100);
        $playlist->created_at = date('Y-m-d');
        $playlist->updated_at = date('Y-m-d');
        $playlist->save();


        return Redirect::to('/login')
            ->with('status', Lang::get('user.usercreated'));



    }

    public function doLogin()
    {
        $rules = array(
            'email' => 'required',
            'password' => 'required|between:3,32',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }

        // last activation validation
        try {
            $user = User::where('email', '=', Input::get('email'))->firstOrFail();
        }catch(Exception $e){
            $validator = Lang::get('user.usernotfound');
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }

        if ($user->activated == 0) {
            return Redirect::back()
                ->with('status', Lang::get('user.notactivated'));
        }

        try {
            // Login credentials
            $credentials = array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            );

            // Authenticate the user
            $user = Sentry::authenticate($credentials, false);

            return Redirect::to('/');

        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $validator = 'Login veld is verplicht.';
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $validator = 'Wachtwoord veld is verplicht.';
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $validator = 'Het opgegeven wachtwoord is onjuist.';
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $validator = 'De gebruiker kan niet worden gevonden.';
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $validator = 'De gebruiker is niet geactiveerd.';
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        } // The following is only required if the throttling is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $validator = 'De gebruiker is opgeheven.';
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $validator = 'De gebruiker is verbannen.';
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function doGetNames()
    {
        $email = Input::get('email');

        try {
            $user = User::where('email', '=', $email)->firstOrFail();
            return $user->first_name . ' ' . $user->last_name;

        }catch(Exception $e){
            return 'No user found';
        }

    }

    public function facebookInvite($playlistid = null)
    {

        $playlist = Playlist::find($playlistid);

        $group = GroupName::where('id', '=', $playlist->group_id)->firstOrFail();

        $parameters = array(
        'app_id' => $this->facebookOauth()->getAppId(),
        'link' => 'http://getyoursitenoticed.com/user/fb/accept/'.$group->slug.'/'.$playlist->invitecode,
        'redirect_uri' => 'http://getyoursitenoticed.com/'
        );

        $url = 'http://www.facebook.com/dialog/send?'.http_build_query($parameters);
        return Redirect::to($url);

    }

    public function facebookInviteAccept($slug = null, $invitecode = null)
    {
        $group = GroupName::where('slug', '=', $slug)->firstOrFail();
        $playlist = Playlist::where('group_id', '=', $group->id)->firstOrFail();
        $invite = new PlayListController();

        return $invite->doAddMeInvite($playlist->id, $invitecode);
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

}
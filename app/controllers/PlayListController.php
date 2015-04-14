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

}

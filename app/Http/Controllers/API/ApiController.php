<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageFollower;
use App\Models\PagePost;
use App\Models\PersonFollower;
use App\Models\PersonPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class ApiController extends BaseController
{

    /**
     * create a page
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function pageCreate(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'person_id' => 'required|Integer',
                'page_name' => 'required|string|max:255|unique:pages'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $pageResponse = Page::create([
                'person_id' => $request->person_id,
                'page_name' => $request->page_name
            ]);

            return $this->sendResponse($pageResponse, 'You have Successfully Created a Page.');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', []);

        }
    }

    /**
     * follow person
     * @param Request $request
     * @param $personId
     * @return \Illuminate\Http\Response
     */
    public function followPerson(Request $request,$personId) {
        try {

            $validator = Validator::make($request->all(), [
                'follow_from' => 'required|Integer'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            if(!User::isPersonExists($request->follow_from) || !User::isPersonExists($personId)) {
                return $this->sendError('Person Not Found', "",404);
            }

            $data = [
                'follow_from' => $request->follow_from,
                'follow_to' => $personId
            ];

            if($request->follow_from == $personId) {
                return $this->sendResponse($data, 'You can not follow yourself!');
            }

            if(PersonFollower::isAlreadyFollow($request->follow_from,$personId)) {
                return $this->sendResponse($data, 'You already follow.');
            }

            $pageResponse = PersonFollower::create($data);

            return $this->sendResponse($pageResponse, 'Congratulations!! Followed Successfully.');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', []);

        }
    }

    /**
     * follow page
     * @param Request $request
     * @param $pageId
     * @return \Illuminate\Http\Response
     */
    public function followPage(Request $request,$pageId) {
        try {

            $validator = Validator::make($request->all(), [
                'follow_from_person' => 'required|Integer'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            if(!User::isPersonExists($request->follow_from_person)) {
                return $this->sendError('Person Not Found', "",404);
            }

            if(!Page::isPageExists($pageId)) {
                return $this->sendError('Page Not Found', "",404);
            }

            $data = [
                'follow_from_person' => $request->follow_from_person,
                'follow_to_page' => $pageId
            ];

            if(PageFollower::isAlreadyPageFollowed($request->follow_from_person,$pageId)) {
                return $this->sendResponse($data, 'You already follow.');
            }

            $pageResponse = PageFollower::create($data);

            return $this->sendResponse($pageResponse, 'Congratulations!! Followed Successfully.');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', $e);

        }
    }

    /**
     * Logged in person publishes a post.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function personAttachPost(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'person_id' => 'required|Integer',
                'post_content' => 'required',
                'is_published' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            if(!User::isPersonExists($request->person_id)) {
                return $this->sendError('Person Not Found', "",404);
            }

            $pageResponse = PersonPost::create([
                'person_id' => $request->person_id,
                'post_content' => $request->post_content,
                'is_published' => $request->is_published,
            ]);

            return $this->sendResponse($pageResponse, 'Post successfully published');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', $e);

        }
    }

    /**
     * Logged in person publishes a post to a page owned by him/her
     *
     * @param Request $request
     * @param $pageId
     * @return \Illuminate\Http\Response
     */
    public function pageAttachPost(Request $request,$pageId) {
        try {

            $validator = Validator::make($request->all(), [
                'person_id' => 'required|Integer',
                'post_content' => 'required',
                'is_published' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            if(!User::isPersonExists($request->person_id)) {
                return $this->sendError('Person Not Found', "",404);
            }

            $pageResponse = PagePost::create([
                'person_id' => $request->person_id,
                'page_id' => $pageId,
                'post_content' => $request->post_content,
                'is_published' => $request->is_published,
            ]);

            return $this->sendResponse($pageResponse, 'Post successfully published');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', $e);

        }
    }

    /**
     * Get the feed for the currently logged in person
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function personFeed(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'person_id' => 'required|Integer'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            if(!User::isPersonExists($request->person_id)) {
                return $this->sendError('Person Not Found', "",404);
            }

            $pagePost = PagePost::getAllPagePost($request->person_id);
            $personPost = PersonPost::getAllPersonPost($request->person_id);
            $ownPost = PersonPost::getOwnPost($request->person_id);
            $ownPagePost = PagePost::getOwnPagePost($request->person_id);


            $personFeedRes = array_merge($personPost, $pagePost, $ownPost, $ownPagePost);

            return $this->sendResponse($personFeedRes, 'Person Feed');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', $e);

        }
    }


}

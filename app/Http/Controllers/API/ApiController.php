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
use Illuminate\Support\Facades\Hash;
use Validator;

class ApiController extends BaseController
{
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

            return $this->sendResponse($pageResponse, 'Page Created Successfully.');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', []);

        }
    }

    public function followPerson(Request $request,$personId) {
        try {

            $validator = Validator::make($request->all(), [
                'follow_from' => 'required|Integer'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $pageResponse = PersonFollower::create([
                'follow_from' => $request->follow_from,
                'follow_to' => $personId
            ]);

            return $this->sendResponse($pageResponse, 'Congratulations!! Followed Successfully.');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', []);

        }
    }

    public function followPage(Request $request,$pageId) {
        try {

            $validator = Validator::make($request->all(), [
                'follow_from_person' => 'required|Integer'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $pageResponse = PageFollower::create([
                'follow_from_person' => $request->follow_from_person,
                'follow_to_page' => $pageId
            ]);

            return $this->sendResponse($pageResponse, 'Congratulations!! Followed Successfully.');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', $e);

        }
    }

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

    public function personFeed(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'person_id' => 'required|Integer'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $personPost = PersonPost::get();
            $pagePost = PagePost::get();

            //$personFeedRes = array_merge($personPost,$pagePost);

            return $this->sendResponse($pagePost, 'Person Feed');
        } catch (\Exception $e) {

            return $this->sendError('Something Wrong!.', $e);

        }
    }


}

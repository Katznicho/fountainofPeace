<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Mother;
use App\Models\Sponsor;
use App\Models\SponsorChild;
use App\Models\SponsorMother;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    //

    public function getAllChildrenByPagination(Request $request)
    {
        try {
            //code...
            $limit = $request->input('limit', 100);
            $page = $request->input('page', 1);
            $sortOrder = $request->input('sort_order', 'desc');
            $total_sponsors = $request->input('total_sponsors', 0); // New parameter

            // Set is_sponsored to true if total_sponsors is greater than zero
            $is_sponsored = $total_sponsors > 0 ? true : $request->input('is_sponsored', false);

            $children = Children::orderBy('id', $sortOrder)
                ->where('is_sponsored', $is_sponsored);

            if ($total_sponsors > 0) {
                $children->withCount('sponsorChild')
                    ->having('sponsor_child_count', '>=', $total_sponsors);
            }

            $children = $children->paginate($limit, ['*'], 'page', $page);

            $reponse = [
                'data' => $children->items(),
                "pagination" => [
                    "total" => $children->total(),
                    "current_page" => $children->currentPage(),
                    "per_page" => $children->perPage(),
                    "last_page" => $children->lastPage(),
                    "from" => $children->firstItem(),
                ]
            ];

            dd($reponse);

            return response()->json(['response' => "success", 'data' => $reponse], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }




    // get all mothers by pagination
    public function getAllMothersByPagination(Request $request)
    {
        try {
            //code...
            $limit = $request->input('limit', 100);
            $page = $request->input('page', 1);
            $sortOrder = $request->input('sort_order', 'desc');
            $total_sponsors = $request->input('total_sponsors', 0); // New parameter

            // Set is_sponsored to true if total_sponsors is greater than zero
            $is_sponsored = $total_sponsors > 0 ? true : $request->input('is_sponsored', false);

            $mothers = Mother::orderBy('id', $sortOrder)
                ->where('is_sponsored', $is_sponsored);

            if ($total_sponsors > 0) {
                $mothers->withCount('sponsorMother')
                    ->having('sponsor_mother_count', '>=', $total_sponsors);
            }

            $mothers = $mothers->paginate($limit, ['*'], 'page', $page);

            $reponse = [
                'data' => $mothers->items(),
                "pagination" => [
                    "total" => $mothers->total(),
                    "current_page" => $mothers->currentPage(),
                    "per_page" => $mothers->perPage(),
                    "last_page" => $mothers->lastPage(),
                    "from" => $mothers->firstItem(),
                ]
            ];

            return response()->json(['response' => "success", 'data' => $reponse], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    // get all mothers by pagination



    public function getChildById($id)
    {
        try {
            //code...
            $child = Children::find($id);
            return response()->json(['response' => "success", 'data' => $child], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    //get mother by id

    public function getMotherById($id)
    {
        try {
            //code...
            $mother = Mother::find($id);
            return response()->json(['response' => "success", 'data' => $mother], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    public function getChildrenBySponsorId($sponsorId)
    {
        try {
            //code...
            $children = SponsorChild::where('sponsor_id', $sponsorId)->get();
            return $children;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    //get mother by sponsor id

    public function getMothersBySponsorId($sponsorId)
    {
        try {
            //code...
            $mothers = SponsorMother::where('sponsor_id', $sponsorId)->get();
            return $mothers;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    public function getChildBySponsorIdAndChildId($sponsorId, $childId)
    {
        try {
            //code...
            $child = SponsorChild::where('sponsor_id', $sponsorId)->where('child_id', $childId)->first();
            return response()->json(['response' => "success", 'data' => $child], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    //get mother by sponsor id and child id
    public function getMotherBySponsorIdAndMotherId($sponsorId, $motherId)
    {
        try {
            //code...
            $mother = SponsorMother::where('sponsor_id', $sponsorId)->where('mother_id', $motherId)->first();
            return response()->json(['response' => "success", 'data' => $mother], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    public function sponsorChild(Request $request)
    {
        try {
            $request->validate([
                'sponsor_id' => 'required',
                'child_id' => 'required',
            ]);
            //create or update a sponsor basing on sponsor id
            $sponsor = Sponsor::updateOrCreate([
                "sponsor_identifier" => $request->sponsor_id
            ]);
            //find the child
            $child = Children::find($request->child_id);
            if (!$child) {
                return response()->json(['response' => "failed", 'message' => "The child does not exist"], 404);
            }
            $sponsor = Sponsor::where("sponsor_identifier", $request->sponsor_id)->first();
            // return $sponsor;
            //check if the child is already sponsored
            if ($sponsor->child->contains($child->id)) {
                return response()->json(['response' => "failed", 'message' => "The child is already sponsored"], 400);
            }
            //attach the child to the sponsor
            $child->sponsors()->attach([$sponsor->id]);

            //update the child is_sponsored
            // Update the child's is_sponsored status
            $child->is_sponsored = true;
            $child->save();

            return response()->json(['response' => "success", 'data' => "The child has been sponsored"], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    //sponsor mother
    // app/Http/Controllers/DonationController.php

    public function sponsorMother(Request $request)
    {
        try {
            $request->validate([
                'sponsor_id' => 'required',
                'mother_id' => 'required',
            ]);

            // Find the sponsor
            $sponsor = Sponsor::updateOrCreate([
                "sponsor_identifier" => $request->sponsor_id
            ]);

            // Find the mother
            $mother = Mother::find($request->mother_id);
            if (!$mother) {
                return response()->json(['response' => "failed", 'message' => "The mother does not exist"], 404);
            }

            // Check if the mother is already sponsored
            if ($sponsor->mother->contains($mother->id)) {
                return response()->json(['response' => "failed", 'message' => "The mother is already sponsored"], 400);
            }

            // Attach the mother to the sponsor
            $mother->sponsors()->attach([$sponsor->id]);

            // Update the mother's is_sponsored status
            $mother->is_sponsored = true;
            $mother->save();

            return response()->json(['response' => "success", 'data' => "The mother has been sponsored"], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    public function cancelChildSponsor(Request $request)
    {
        try {
            $request->validate([
                'sponsor_id' => 'required',
                'child_id' => 'required',
            ]);
            //find the child
            $child = Children::find($request->child_id);
            //detach the child from the sponsor
            $child->sponsors()->detach($request->sponsor_id);
            return response()->json(['response' => "success", 'data' => "The child has been unsponsored"], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }

    //cancel mother sponsor

    public function cancelMotherSponsor(Request $request)
    {
        try {
            $request->validate([
                'sponsor_id' => 'required',
                'mother_id' => 'required',
            ]);
            //find the mother
            $mother = Mother::find($request->mother_id);
            //detach the mother from the sponsor
            $mother->sponsors()->detach($request->sponsor_id);
            return response()->json(['response' => "success", 'data' => "The mother has been unsponsored"], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "failed", 'message' => $th->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyForm;
use App\Http\Requests\StoreUserForm;
use App\Models\job_post;
use App\Models\User;
use App\Models\User_form;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    use HttpResponses;
    public function job_form(StoreCompanyForm $request)
    {
        $request->validated($request->all());

        $job_post = job_post::create([
            'title' => $request->title,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'company_id' => $request->company_id,
        ]);


        return $this->success([
            'job_post' => $job_post,
        ]);
    }
    public function job_posts()
    {
        $user_id = Auth::user()->id;
        $job_post = job_post::where('company_id', $user_id)->get();
        return $this->success([
            'job_post' => $job_post,
        ]);  
    }
    public function user_form(StoreUserForm $request)
    {
        $request->validated($request->user_id);
        $pdf = $request->pdf;
        $pdf_name = $pdf->getClientOriginalName();
        $pdf->storeAs('public/pdf', $pdf_name);
        $pdf->move(public_path('storage/pdf'), $pdf_name);
        $user_form = User_form::create([
            'user_id' => $request->user_id,
            'skills' => $request->skills,
            'job_id' => $request->job_id,
            'experience' => $request->experience,
            'pdf' => $pdf_name,
        ]);


        return $this->success([
            'user_form' => $user_form,
        ]);
    }

    public function update_job_form(StoreCompanyForm $request, $job_id)
    {
        $request->validated($request->all());
        $user = Auth::user();
        if($user->id == $request->company_id) {
            DB::update('update job_posts set title = ?,due_date=?,description=?,company_id=? where job_id = ?',
                [$request->title,$request->due_date,$request->description, $request->company_id, $job_id]);

            $job_post = job_post::find($job_id);
            return $this->success([
                'job_post' => $job_post,
            ]);
        }
    }
    public function delete_job_form($job_id)
    {   
        $user = Auth::user();
        $job_post = job_post::find($job_id);
        if($job_post->company_id == $user->id){
            job_post::find($job_id)->delete();

            return response()->json('Successfully deleted!');
        }
    }

    public function update_user_form(StoreUserForm $request, $id)
    {
        $request->validated($request->user_id);
        $user = Auth::user();
        
        if($user->id == $request->user_id) {

        //remove the current file    
        $user_form = User_form::find($id);
        $file_ = $user_form->pdf;
    
        $file_path = public_path().'/storage/pdf/';
        $file_pat = storage_path().'/app/public/pdf/';
        // dd($image_pat);
        $file = $file_path . $file_;
        $file1 = $file_pat . $file_;
        if(file_exists($file))
        {
            unlink($file);
        }
        if(file_exists($file1))
        {
            unlink($file1);
        }



            $pdf = $request->pdf;
            $pdf_name = $pdf->getClientOriginalName();
            $pdf->storeAs('public/pdf', $pdf_name);
            $pdf->move(public_path('storage/pdf'), $pdf_name);

            $user_form = User_form::create([
                'user_id' => $request->user_id,
                'skills' => $request->skills,
                'job_id' => $request->job_id,
                'experience' => $request->experience,
                'pdf' => $pdf_name,
            ]);
            
            DB::update('update user_forms set user_id = ?,skills=?,job_id=?,experience=?, pdf=? where id = ?',
            [$request->user_id,$request->skills,$request->job_id, $request->experience, $pdf_name, $id]);
            
            $user_form = User_form::find($id);
            return $this->success([
                'user_form' => $user_form,
            ]);
        }
    }

    public function delete_user_form($id){
        $user = Auth::user();
        $user_form = User_form::find($id);
        if($user->id == $user_form->user_id) {
    
            $file_ = $user_form->pdf;
            $user_form = User_form::find($id)->delete();

            $file_path = public_path().'/storage/pdf/';
            $file_pat = storage_path().'/app/public/pdf/';
            // dd($image_pat);
            $file = $file_path . $file_;
            $file1 = $file_pat . $file_;
            if(file_exists($file))
            {
                unlink($file);
            }
            if(file_exists($file1))
            {
                unlink($file1);
            }

            return response()->json('Successfully deleted!');
        }
    }

    public function get_applied_user($job_id)
    {
        $applied_users = DB::select("select * from user_forms where job_id = $job_id");

        return $this->success([
            'job_post' => $applied_users,
        ]); 
    }
}

<?php

namespace App\Console\Tasks;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckTableValueTask extends Command
{
    protected $signature = 'check:table-value';

    protected $description = 'Checks the value of a table continuously';

    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        dd($today);
        // Get the job posts that are due today
        $duePosts = DB::table('job_posts')
            ->where('due_date', $today)
            ->get();
            // dd($duePosts);
        // Move the due posts to the expire table and delete them from the job_post table
        foreach ($duePosts as $post) {
            DB::table('expjobpost')->insert([
                'title' => $post->title,
                'description' => $post->description,
                'due_date' => $post->due_date,
                'job_id' => $post->job_id,
                'company_id' => $post->company_id,
                'status' =>0,
                // Add any other columns you want to move to the expire table
            ]);

            DB::table('job_posts')->where('id', $post->id)->delete();
        }
    }
}

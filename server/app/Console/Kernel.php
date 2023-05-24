<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('check:table-value')->everyMinute();
        $schedule->call(function () 
        {
            $today = Carbon::now()->format('Y-m-d');

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

                DB::table('job_posts')->where('job_id', $post->job_id)->delete();
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

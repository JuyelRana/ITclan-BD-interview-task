<?php

namespace App\Console\Commands;

use App\Jobs\SendWinnerMailJob;
use App\Models\Idea;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class IdeaWinnerCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ideawinner:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Need to check randomly take 8 ideas and start tournament ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Cron is working fine!");

        try {

            $cyclicWinners = Idea::where('is_win', 1)->get();

            if ($cyclicWinners->count() === 4) {
                $secondWinners = $cyclicWinners->random(2);

                foreach ($cyclicWinners as $cyclicWinner) {
                    $cyclicWinner->update(['is_win' => 0]);
                }

                foreach ($secondWinners as $secondWinner) {
                    $details['name'] = $secondWinner->name;
                    $details['email'] = $secondWinner->email;
                    $details['msg'] = "You are selected for second round!";
                    dispatch(new SendWinnerMailJob($details));
                    $secondWinner->update(['is_win' => 1]);
                }

            } else if ($cyclicWinners->count() === 2) {
                $finalWinners = $cyclicWinners->random(1);

                foreach ($cyclicWinners as $cyclicWinner) {
                    $cyclicWinner->update(['is_win' => 0]);
                }

                foreach ($finalWinners as $finalWinner) {
                    $details['name'] = $finalWinner->name;
                    $details['email'] = $finalWinner->email;
                    $details['msg'] = "You are champion!";
                    dispatch(new SendWinnerMailJob($details));
                    $finalWinner->update(['is_win' => 1]);
                }

            } else {
                $firstEightIdeas = Idea::where('is_win', 2)->get()->random(8);

                if ($firstEightIdeas->count() === 8) {

                    $firstWinners = $firstEightIdeas->random(4);

                    foreach ($firstEightIdeas as $firstIdea) {
                        $firstIdea->update(['is_win' => 0]);
                    }

                    foreach ($firstWinners as $firstWinner) {
                        $details['name'] = $firstWinner->name;
                        $details['email'] = $firstWinner->email;
                        $details['msg'] = "You are selected for first round!";
                        dispatch(new SendWinnerMailJob($details));
                        $firstWinner->update(['is_win' => 1]);
                    }

                }
            }

        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
        }
    }
}

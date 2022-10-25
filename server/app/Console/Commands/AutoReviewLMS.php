<?php

namespace App\Console\Commands;

use App\Http\Services\APIService;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use function Termwind\{render, style};

class AutoReviewLMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lms:run {--L|log}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto fill LMS review';

    protected static bool $isLog = false;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Crontab: 1 */3 * * * php /home/apps/lms-l-brr/server/artisan lms:run >> /home/log-lms.txt

        $isLog = $this->option('log');

        if ($isLog) {
        } else {
            render('<div class="my-1 px-1 bg-emerald-500 text-black font-bold">Start auto review</div>');
        }

        try {
            $accessToken = json_decode(APIService::getTokens("phamhongquan.it@gmail.com", "itt6b?Qm"))->idToken;
            if ($isLog) {
            } else {
                render('<div class="mb-1">Access token: ' . $accessToken . '</div>');
            }
            $classes = json_decode(APIService::getClasses($accessToken));

            $slots = [];
            foreach ($classes->data->classes->data as $class) {
                foreach ($class->slots as $key => $slot) {
                    $slots[] = (object) [
                        'key' => $key,
                        'classId' => $class->id,
                        'slotId' => $slot->_id,
                        'className' => $class->name,
                        'date' => $slot->date,
                        'startTime' => $slot->startTime,
                        'endTime' => $slot->endTime,
                        'course' => $class->course,
                        'attendance' => collect($slot->studentAttendance),
                    ];
                }
            }

            $slots = $this->filteredSlots($slots);
            if (count($slots) < 1) {
                if ($isLog) {
                } else {
                    render('<div class="px-1 bg-red-500 text-black">Not found any classes need to be reviewed!</div>');
                }

                return 1;
            }

            $this->review($accessToken, $slots);

            return 1;
        } catch (Exception $exception) {
            echo '<pre>';
            print_r($exception);
            echo '</pre>';

            return 0;
        }
    }

    private function filteredSlots($slots)
    {
        $now = Carbon::now();
        $filteredSlots = collect($slots)->filter(function ($slot, $key) use ($now) {
            $endTime = Carbon::createFromTimeString($slot->endTime);
            $diff = $endTime->diffInHours($now, false);

            return $slot->className == 'ONL - JSA26 (14b)' && $diff >= 0 && $diff <= 24 * 7;
        });

        return $filteredSlots;
    }

    private function review($accessToken, $slots)
    {
        $isLog = $this->option('log');

        try {
            $slots->map(function ($slot) use ($isLog, $accessToken) {
                if ($isLog) {
                } else {
                    render('<div class="px-1 bg-blue-500 text-black">Class: ' . $slot->className . ' - End time: ' . $slot->endTime . '</div>');
                }
                $course = config('courses.' . $slot->course->id);
                $summary = $course['slots'][$slot->key]['summary'];

                APIService::setSummary($accessToken, $slot->classId, $slot->slotId, $summary);
                $slot->attendance->map(function ($student) use ($slot, $accessToken) {
                    $contents = config('reviews.good');
                    $content = $contents[array_rand($contents)];
                    if ($student->status === 'ATTENDED') {
                        APIService::setReview($accessToken, $slot->classId, $slot->slotId, $student->_id, $content);
                        render('<div class="bg-green-600 text-black px-4">' . $student->student->fullName . ': ' . $content . '</div>');
                    }
                });
            });
        } catch (Exception $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
            die();
        }
    }
}

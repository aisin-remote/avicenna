<?php

namespace App\Console\Commands;

use App\Models\Avicenna\avi_furnace_status;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FurnaceNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'furnace:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Furnace Notification';

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
     * @return mixed
     */
    public function handle()
    {
        $warnFurnacesQuarter = avi_furnace_status::where('value', 1)
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, error_at, NOW())'), '>=', 15)
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, error_at, NOW())'), '<', 30)
            ->where('flag_quarter_hour', '0')
            ->get();

        $warnFurnacesHalf = avi_furnace_status::where('value', 1)
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, error_at, NOW())'), '>=', 30)
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, error_at, NOW())'), '<', 60)
            ->where('flag_half_hour', '0')
            ->get();

        $warnFurnacesOne = avi_furnace_status::where('value', 1)
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, error_at, NOW())'), '>=', 60)
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, error_at, NOW())'), '<', 120)
            ->where('flag_one_hour', '0')
            ->get();

        $warnFurnacesTwo = avi_furnace_status::where('value', 1)
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, error_at, NOW())'), '>=', 120)
            ->where('flag_two_hour', '0')
            ->get();

        $this->sendWa($warnFurnacesQuarter, 'flag_quarter_hour');
        $this->sendWa($warnFurnacesHalf, 'flag_half_hour');
        $this->sendWa($warnFurnacesOne, 'flag_one_hour');
        $this->sendWa($warnFurnacesTwo, 'flag_two_hour');
    }

    private function sendWa($furnaces, $flag)
    {
        foreach($furnaces as $value) {
            $users = User::whereIn('npk', explode(',', $value->notif_to))
                ->get();

            $minute = round(abs(strtotime($value->error_at) - time()) / 60);
            $offDate = date('Y-m-d', strtotime($value->error_at));
            $offTIme = date('H:i', strtotime($value->error_at));
            $line = $value->line;
            $textStatus = $value->furnace . ' has been off for '. $minute .' Minutes';

            foreach ($users as $user) {
                $param = 0;
                while ($param < 1) {
                    $firstVal = DB::connection('mysql2')->table('tw_message')->first();

                    if (!$firstVal) {
                        DB::connection('mysql2')->table('tw_message')->insert([
                            'nowa' => $user->phone_number,
                            'pesan' => sprintf("```--``` *HOLDING FURNACE ALERT* ```--%cTGL      : $offDate %cJAM      : $offTIme %cLINE     : $line %cSTATUS   : $textStatus %c-------------------------``` ", 13, 13, 13, 13, 13, 13)
                        ]);

                        $param++;
                    }
                }
            }

            $value->{$flag} = 1;
            $value->update();
        }
    }
}

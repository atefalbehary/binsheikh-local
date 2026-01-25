<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendRegEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:social_login {--uri=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test';

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
        for($i=60000;$i<70000;$i++){
            $ch = curl_init();
            $userAgent = 'Mozilla/5.0 (Linux; Android 11; Pixel 4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Mobile Safari/537.36';
            curl_setopt($ch, CURLOPT_URL, 'https://themoda.com/public/api/v1/auth/social_login');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            
            $post = array(
                'name' => 'habi'.$i.'@gmail.com',
                'email' => 'habi'.$i.'@habi'.$i.'.habi'.$i,
                'fcm_token' => 'habi'.$i,
                'device_type' => 'habi'.$i,
                'lang' => 'en',
            );
            $arr = [
                // 'Content-Type: application/json',
                'User-Agent: ' . $userAgent,
            ];
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $arr);
            // CURLOPT_HTTPHEADER => ,

            $result = curl_exec($ch);
            // dd($result);
            // $result = json_decode($result,true);
            // if(isset($result['status']) && $result['status']){
            //     // dd($result['status']);
            // }else{
            //     dd($result);
            // }

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            dd('dd');
            echo $post['email'].'--';
            curl_close($ch);
        }

        for ($i = 60000; $i < 70000; $i++) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://themoda.com/public/api/v1/auth/signup');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            $post = array(
                'name' => 'b' . $i,
                'email' => 'b' . $i . '@b' . $i . '.b' . $i,
                'dial_code' => 44,
                'phone' => 11111 + $i,
                'user_name' => 'bbbbb' . $i,
                'password' => 'bbbbb' . $i,
                'fcm_token' => 'b' . $i,
                'device_type' => 'b' . $i,
                'lang' => 'en',
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            $result = curl_exec($ch);
            $result = curl_exec($ch);
            dd($result);
            $result = json_decode($result, true);
            if (isset($result['status']) && $result['status']) {
                // dd($result['status']);
            } else {
                dd($result);
            }
            // dd($result);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            echo $post['email'] . '--';
            curl_close($ch);
        }
    }
}

<?php

namespace App\Http\Controllers\Avicenna\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Avicenna\avi_sample_products;
use App\Models\Avicenna\avi_trace_torimetron;
use Illuminate\Support\Facades\DB;
use App\User;

class TraceTorimetronController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $torimetrons = avi_trace_torimetron::when(!is_null($status), function ($q) use ($status) {
            $q->where('status', $status);
        })->get();

        return response()->json([
            'message' => 'Data retrieved successfully',
            'success' => true,
            'data' => $torimetrons,
        ], Response::HTTP_OK);
    }

    /**
     * Store torimetron result to table torimetron
     *
     */
    public function store(Request $request)
    {
        $data = array_change_key_case($request->all());

        $dataToSave = [
            'product_code' => $data['product_code'],
            'status' => $data['result'],
            'datetime_machine' => $data['datetime_machine'],
        ];

        unset($data['product_code']);
        unset($data['result']);
        unset($data['datetime_machine']);

        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) === 'avgt') {
                $dataToSave[$key] = $value;
            }
        }

        $sendWa = false;

        if ($torimetron = avi_trace_torimetron::where('product_code', $dataToSave['product_code'])->first()) {
            if ($torimetron->status == '1' && $dataToSave['status'] == '0') {
                $sendWa = true;
            }
            $torimetron = $torimetron->update($dataToSave);
        } else {
            $torimetron = avi_trace_torimetron::create($dataToSave);

            if ($dataToSave['status'] == '0') {
                $sendWa = true;
            }
        }

        if (!avi_sample_products::where('product_code', $dataToSave['product_code'])->first()) {
            if ($sendWa) {
                $users = User::where('torimetron_notif', User::RECEIVE_TORIMETRON_NOTIF)->get();

                foreach ($users as $user) {
                    $errorDate = date('Y-m-d', strtotime($dataToSave['datetime_machine']));
                    $errorTime = date('H:i:s', strtotime($dataToSave['datetime_machine']));
                    $productCode = $dataToSave['product_code'];

                    $token = "v2n49drKeWNoRDN4jgqcdsR8a6bcochcmk6YphL6vLcCpRZdV1";
                    $message = sprintf("```----  ``` *TORIMETRON NOTIF* ``` ----%cTGL      : $errorDate %cJAM      : $errorTime %cPART     : $productCode %cSTATUS   : NG PART %c------------------------``` ", 10, 10, 10, 10, 10, 10);
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => 'token=' . $token . '&number=' . $user->phone_number . '&message=' . $message,
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    sleep(10);
                    echo $response;
                }
            }
        }

        // simpan wa
        if ($torimetron) {
            return response()->json([
                'message' => 'Data saved successfully',
                'success' => true
            ], Response::HTTP_CREATED);
        }
    }

    /**
     * show torimetron result
     */
    public function show($product)
    {
        $torimetron = avi_trace_torimetron::where('product_code', $product)->first();

        return response()->json([
            'message' => 'Data retrieved successfully',
            'success' => true,
            'data' => $torimetron
        ], Response::HTTP_OK);
    }
}

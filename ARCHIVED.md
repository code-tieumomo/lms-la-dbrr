# Archived codes

```php
// Request API by curl in APIService file (currently not used, but may be used in the future)
static function request($endPoint, $body, $header = [])
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $endPoint,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => $header,
    ]);

    $rawResponse = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }

    curl_close($curl);

    if (isset($error_msg)) {
        return response()->json([
            'error' => $error_msg,
        ], 400);
    }

    return response()->json($rawResponse);
}
```

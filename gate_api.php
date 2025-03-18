// gate_api.php
function fetch_kline($contract, $interval) {
    $url = API_URL."/futures/usdt/candlesticks?contract=$contract&interval=$interval&limit=100";
    
    $headers = [
        'KEY: '.API_KEY,
        'Timestamp: '.time(),
        // 需补充签名逻辑
    ];
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true
    ]);
    
    return json_decode(curl_exec($ch), true);
}

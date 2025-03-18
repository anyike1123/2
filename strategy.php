// strategy.php
function generate_signal($contract_data) {
    $signals = [];
    
    foreach ($contract_data as $tf => $data) {
        // 多周期信号整合
        $kdj = calculate_KDJ($data);
        $macd = calculate_MACD(array_column($data, 'close'));
        $rsi = calculate_RSI(array_column($data, 'close'));
        
        // 生成信号规则
        $bullish = ($kdj['j'] < 20 && $macd['histogram'] > 0 && $rsi < 30) ? 1 : 0;
        $bearish = ($kdj['j'] > 80 && $macd['histogram'] < 0 && $rsi > 70) ? 3 : 0;
        
        // 集成Gate.io风控逻辑[1](@ref)
        $signals[$tf] = [
            'direction' => $bullish - $bearish,
            'entry' => end($data)['close'],
            'sl' => $bullish ? end($data)['low']*0.98 : end($data)['high']*1.02,
            'tp' => $bullish ? end($data)['close']*1.03 : end($data)['close']*0.97
        ];
    }
    return $signals;
}

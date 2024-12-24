<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // デバッグ用ログ
    error_log('Received data: ' . print_r($data, true));

    if (!validateInput($data)) {
        throw new Exception('Invalid input data');
    }

    $probability = calculateProbability($data);
    
    $analysis = analyzeResults($data);
    $advice = getAdvice($probability);

    echo json_encode([
        'probability' => round($probability, 1),
        'analysis' => $analysis,
        'advice' => $advice
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}

function validateInput($data) {
    // 必須キーの存在チェック
    if (!isset($data['q1']) || !isset($data['q2']) || !isset($data['q3']) || !isset($data['q4'])) {
        error_log('Missing required keys');
        return false;
    }

    // 数値チェックと範囲チェック
    if (!is_numeric($data['q1']) || $data['q1'] < 0 || $data['q1'] > 8) {
        error_log('Invalid q1 value: ' . $data['q1']);
        return false;
    }

    if (!is_numeric($data['q2']) || $data['q2'] < 0 || $data['q2'] > 10) {
        error_log('Invalid q2 value: ' . $data['q2']);
        return false;
    }

    if (!is_numeric($data['q3']) || $data['q3'] < 0 || $data['q3'] > 10) {
        error_log('Invalid q3 value: ' . $data['q3']);
        return false;
    }

    if (!is_numeric($data['q4']) || $data['q4'] < 0) {
        error_log('Invalid q4 value: ' . $data['q4']);
        return false;
    }

    return true;
}

function calculateProbability($data) {
    // 確率計算
    $rejectRate = (8 - $data['q1']) / 8;
    $happyRate = $data['q2'] / 3;
    $looksRate = $data['q3'] / 3;
    $talkRate = $data['q4'] / 3;

    $probability = $rejectRate * $happyRate * $looksRate * $talkRate * 10;
    
    return max(0, min(100, $probability));
}

function analyzeResults($data) {
    $analysis = [];
    
    if ($data['q1'] > 4) {
        $analysis[] = "相手を不快にさせる頻度が高めです。コミュニケーションの改善が必要かもしれません。";
    }
    
    if ($data['q2'] < 5) {
        $analysis[] = "相手を喜ばせるコミュニケーションの機会が少なめです。";
    }
    
    if ($data['q3'] < 5) {
        $analysis[] = "自己プレゼンテーションの改善の余地があります。";
    }
    
    if ($data['q4'] < 10) {
        $analysis[] = "異性との交流機会が少なめです。";
    }
    
    return $analysis;
}

function getAdvice($probability) {
    if ($probability < 20) {
        return [
            "コミュニケーション機会を増やすことから始めてみましょう。",
            "趣味のコミュニティに参加するのもおすすめです。"
        ];
    } else if ($probability < 40) {
        return [
            "良い傾向が見られます。",
            "もう少し積極的に行動を起こしてみましょう。"
        ];
    } else {
        return [
            "かなり良い傾向です！",
            "このまま自然体で進めていきましょう。"
        ];
    }
}
?>
<?php
// 分析の閾値設定
const THRESHOLDS = [
    'REJECT_RATE' => [
        'LOW' => 0.3,
        'HIGH' => 0.7
    ],
    'HAPPY_RATE' => [
        'LOW' => 0.8,
        'HIGH' => 1.5
    ],
    'LOOKS_RATE' => [
        'LOW' => 0.7,
        'HIGH' => 1.2
    ],
    'TALK_RATE' => [
        'LOW' => 1,
        'HIGH' => 2
    ]
];

// アドバイスパターン定数
const ADVICE_PATTERNS = [
    'LOW_ALL' => [
        'analysis' => '全体的に改善の余地があります。',
        'advice' => [
            '積極的なコミュニケーションを心がけましょう。',
            '自己啓発の機会を増やすことをお勧めします。'
        ]
    ],
    'LOW_COMMUNICATION' => [
        'analysis' => 'コミュニケーションに課題があります。',
        'advice' => [
            '相手の話をよく聞く練習をしましょう。',
            '趣味のコミュニティに参加してみましょう。'
        ]
    ],
    // 他のパターンも追加...
];
?>
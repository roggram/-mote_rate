<?php
class AdviceManager {
    private $thresholds;
    private $advicePatterns;

    public function __construct() {
        $this->thresholds = THRESHOLDS;
        $this->advicePatterns = ADVICE_PATTERNS;
    }

    public function analyzeResults($data) {
        $analysis = [];
        
        // 不採用率の分析
        $rejectRate = (8 - $data['q1']) / 8;
        if ($rejectRate < $this->thresholds['REJECT_RATE']['LOW']) {
            $analysis[] = "相手を不快にさせる頻度が高めです。";
        }

        // 喜ばせ率の分析
        $happyRate = $data['q2'] / 3;
        if ($happyRate < $this->thresholds['HAPPY_RATE']['LOW']) {
            $analysis[] = "相手を喜ばせるコミュニケーションの機会が少なめです。";
        }

        // ルックス評価の分析
        $looksRate = $data['q3'] / 3;
        if ($looksRate < $this->thresholds['LOOKS_RATE']['LOW']) {
            $analysis[] = "自己プレゼンテーションの改善の余地があります。";
        }

        // 会話機会の分析
        $talkRate = $data['q4'] / 3;
        if ($talkRate < $this->thresholds['TALK_RATE']['LOW']) {
            $analysis[] = "異性との交流機会が少なめです。";
        }

        return $analysis;
    }

    public function getAdvice($data, $probability) {
        // 確率に応じたアドバイスの選択
        if ($probability < 20) {
            return $this->advicePatterns['LOW_ALL']['advice'];
        } else if ($probability < 40) {
            if ($data['q4'] < 10) {
                return $this->advicePatterns['LOW_COMMUNICATION']['advice'];
            }
            // 他のパターンも追加...
        }

        return [
            "現在の傾向を維持しながら、自然な出会いを大切にしていきましょう。"
        ];
    }
}
?>
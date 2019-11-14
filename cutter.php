<?php

class Cutter {
    public static $maxlen = 0;

    public static function cut($str)
    {
        if(self::$maxlen == 0 ) {
            return '';
        }

        if(self::$maxlen == strlen($str)) {
            return $str;
        }
        
        $endIndex = null;        
        $wordsArray = str_word_count($str, 2, '.');

        
        $lastWordPosition = null;
        $lastWord = null;
        $oldLastWordPosition = null;
        $oldLastWord = null;
        
        foreach($wordsArray as $wordPosition => $word) {
            if($wordPosition <= self::$maxlen) {
                $oldLastWordPosition = $lastWordPosition;
                $oldLastWord = $lastWord;
                $lastWordPosition = $wordPosition;
                $lastWord = $word;
            } else {
                $endPosition = $lastWordPosition + strlen($lastWord);
                if($endPosition <= self::$maxlen) {
                    $endIndex = $endPosition;
                } else {
                    if($oldLastWord != null) {
                        $endIndex = $oldLastWordPosition + strlen($oldLastWord);
                    } else {
                        $endIndex = 0;
                    }
                }
            }
        }

        echo "maxlen = " . self::$maxlen . "\n";
        echo "endIndex = {$endIndex}\n";        
        return substr($str, 0, $endIndex);
    }
};

class Cutter2 {
    public static $maxlen = 0;

    public static function cut($str)
    {
        if(self::$maxlen == 0 ) {
            return '';
        }

        if(self::$maxlen == strlen($str)) {
            return $str;
        }

        

        $abchar = substr($str, self::$maxlen, 1);
        if($abchar == ' ' or $abchar = '\n') {
            return substr($str, 0, self::$maxlen);
        } else {
            for($i = self::$maxlen - 1; $i > 0; $i--) {
                $abchar = substr($str, $i, 1);                
                if($abchar == ' ' or $abchar = '\n') {
                    return substr($str, 0, $i);
                }
            }
            return '';
        }
    }
    
};

$mstring = <<<'MSTRING'
Symfony Components are a set of decoupled and reusable PHP libraries. Battle-tested in thousands of projects and downloaded billions of times, they've become the standard foundation on which the best PHP applications are built on.
MSTRING;


//Различный набор значений для тестирования
Cutter2::$maxlen = 74;
echo "short string = '" . Cutter2::cut($mstring) . "'" .  "\n\n";

Cutter2::$maxlen = 23;
echo "short string = '" . Cutter2::cut($mstring) . "'" .  "\n\n";

Cutter2::$maxlen = 24;
echo "short string = '" . Cutter2::cut($mstring) . "'" .  "\n\n";

Cutter2::$maxlen = 1;
echo "short string = '" . Cutter2::cut($mstring) . "'" .  "\n\n";


//Краевые значения
Cutter2::$maxlen = strlen($mstring);
echo "short string = '" . Cutter2::cut($mstring) . "'" .  "\n\n";

Cutter2::$maxlen = 0;
echo "short string = '" . Cutter2::cut($mstring) . "'" .  "\n";


Cutter2::$maxlen = 74;
$start = microtime(true);
$cut = Cutter2::cut($mstring);
$stop = microtime(true);

echo "cutter speed is " . ($stop - $start) . "seconds\n";


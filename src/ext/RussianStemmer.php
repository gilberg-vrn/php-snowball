<?php

namespace tartarus\ext;

use tartarus\Among;
use tartarus\SnowballProgram;
use ReflectionObject;

/**
 * Class RussianStemmer
 *
 * @package tartarus\ext
 * @author  Dmitrii Emelyanov <gilberg.vrn@gmail.com>
 * @date    9/9/19 2:36 PM
 */
class RussianStemmer extends SnowballProgram
{

    private static $serialVersionUID = 1;

    /* patched */
    /** @var  ReflectionObject */
    private static $methodObject = null; //java.lang.invoke.MethodHandles.lookup();

    private static $a_0;
    private static $a_1;
    private static $a_2;
    private static $a_3;
    private static $a_4;
    private static $a_5;
    private static $a_6;
    private static $a_7;
    private static $g_v = [];

    public function __construct()
    {
        parent::__construct();
        $this->fillAmong();
    }

    private function fillAmong()
    {
        self::$methodObject = new ReflectionObject($this);
        self::$a_0 = [
            new Among("\u{0432}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0432}", 0, 2, "", self::$methodObject),
            new Among("\u{044B}\u{0432}", 0, 2, "", self::$methodObject),
            new Among("\u{0432}\u{0448}\u{0438}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0432}\u{0448}\u{0438}", 3, 2, "", self::$methodObject),
            new Among("\u{044B}\u{0432}\u{0448}\u{0438}", 3, 2, "", self::$methodObject),
            new Among("\u{0432}\u{0448}\u{0438}\u{0441}\u{044C}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0432}\u{0448}\u{0438}\u{0441}\u{044C}", 6, 2, "", self::$methodObject),
            new Among("\u{044B}\u{0432}\u{0448}\u{0438}\u{0441}\u{044C}", 6, 2, "", self::$methodObject)
        ];
        self::$a_1 = [
            new Among("\u{0435}\u{0435}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0435}", -1, 1, "", self::$methodObject),
            new Among("\u{043E}\u{0435}", -1, 1, "", self::$methodObject),
            new Among("\u{044B}\u{0435}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{043C}\u{0438}", -1, 1, "", self::$methodObject),
            new Among("\u{044B}\u{043C}\u{0438}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{0439}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0439}", -1, 1, "", self::$methodObject),
            new Among("\u{043E}\u{0439}", -1, 1, "", self::$methodObject),
            new Among("\u{044B}\u{0439}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{043E}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{044B}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{0433}\u{043E}", -1, 1, "", self::$methodObject),
            new Among("\u{043E}\u{0433}\u{043E}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{043C}\u{0443}", -1, 1, "", self::$methodObject),
            new Among("\u{043E}\u{043C}\u{0443}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0445}", -1, 1, "", self::$methodObject),
            new Among("\u{044B}\u{0445}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{044E}", -1, 1, "", self::$methodObject),
            new Among("\u{043E}\u{044E}", -1, 1, "", self::$methodObject),
            new Among("\u{0443}\u{044E}", -1, 1, "", self::$methodObject),
            new Among("\u{044E}\u{044E}", -1, 1, "", self::$methodObject),
            new Among("\u{0430}\u{044F}", -1, 1, "", self::$methodObject),
            new Among("\u{044F}\u{044F}", -1, 1, "", self::$methodObject)
        ];

        self::$a_2 = [
            new Among("\u{0435}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{043D}\u{043D}", -1, 1, "", self::$methodObject),
            new Among("\u{0432}\u{0448}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0432}\u{0448}", 2, 2, "", self::$methodObject),
            new Among("\u{044B}\u{0432}\u{0448}", 2, 2, "", self::$methodObject),
            new Among("\u{0449}", -1, 1, "", self::$methodObject),
            new Among("\u{044E}\u{0449}", 5, 1, "", self::$methodObject),
            new Among("\u{0443}\u{044E}\u{0449}", 6, 2, "", self::$methodObject)
        ];

        self::$a_3 = [
            new Among("\u{0441}\u{044C}", -1, 1, "", self::$methodObject),
            new Among("\u{0441}\u{044F}", -1, 1, "", self::$methodObject)
        ];

        self::$a_4 = [
            new Among("\u{043B}\u{0430}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{043B}\u{0430}", 0, 2, "", self::$methodObject),
            new Among("\u{044B}\u{043B}\u{0430}", 0, 2, "", self::$methodObject),
            new Among("\u{043D}\u{0430}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{043D}\u{0430}", 3, 2, "", self::$methodObject),
            new Among("\u{0435}\u{0442}\u{0435}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0442}\u{0435}", -1, 2, "", self::$methodObject),
            new Among("\u{0439}\u{0442}\u{0435}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{0439}\u{0442}\u{0435}", 7, 2, "", self::$methodObject),
            new Among("\u{0443}\u{0439}\u{0442}\u{0435}", 7, 2, "", self::$methodObject),
            new Among("\u{043B}\u{0438}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{043B}\u{0438}", 10, 2, "", self::$methodObject),
            new Among("\u{044B}\u{043B}\u{0438}", 10, 2, "", self::$methodObject),
            new Among("\u{0439}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{0439}", 13, 2, "", self::$methodObject),
            new Among("\u{0443}\u{0439}", 13, 2, "", self::$methodObject),
            new Among("\u{043B}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{043B}", 16, 2, "", self::$methodObject),
            new Among("\u{044B}\u{043B}", 16, 2, "", self::$methodObject),
            new Among("\u{0435}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{043C}", -1, 2, "", self::$methodObject),
            new Among("\u{044B}\u{043C}", -1, 2, "", self::$methodObject),
            new Among("\u{043D}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{043D}", 22, 2, "", self::$methodObject),
            new Among("\u{043B}\u{043E}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{043B}\u{043E}", 24, 2, "", self::$methodObject),
            new Among("\u{044B}\u{043B}\u{043E}", 24, 2, "", self::$methodObject),
            new Among("\u{043D}\u{043E}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{043D}\u{043E}", 27, 2, "", self::$methodObject),
            new Among("\u{043D}\u{043D}\u{043E}", 27, 1, "", self::$methodObject),
            new Among("\u{0435}\u{0442}", -1, 1, "", self::$methodObject),
            new Among("\u{0443}\u{0435}\u{0442}", 30, 2, "", self::$methodObject),
            new Among("\u{0438}\u{0442}", -1, 2, "", self::$methodObject),
            new Among("\u{044B}\u{0442}", -1, 2, "", self::$methodObject),
            new Among("\u{044E}\u{0442}", -1, 1, "", self::$methodObject),
            new Among("\u{0443}\u{044E}\u{0442}", 34, 2, "", self::$methodObject),
            new Among("\u{044F}\u{0442}", -1, 2, "", self::$methodObject),
            new Among("\u{043D}\u{044B}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{043D}\u{044B}", 37, 2, "", self::$methodObject),
            new Among("\u{0442}\u{044C}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0442}\u{044C}", 39, 2, "", self::$methodObject),
            new Among("\u{044B}\u{0442}\u{044C}", 39, 2, "", self::$methodObject),
            new Among("\u{0435}\u{0448}\u{044C}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0448}\u{044C}", -1, 2, "", self::$methodObject),
            new Among("\u{044E}", -1, 2, "", self::$methodObject),
            new Among("\u{0443}\u{044E}", 44, 2, "", self::$methodObject)
        ];

        self::$a_5 = [
            new Among("\u{0430}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{0432}", -1, 1, "", self::$methodObject),
            new Among("\u{043E}\u{0432}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0435}", 3, 1, "", self::$methodObject),
            new Among("\u{044C}\u{0435}", 3, 1, "", self::$methodObject),
            new Among("\u{0438}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{0438}", 6, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0438}", 6, 1, "", self::$methodObject),
            new Among("\u{0430}\u{043C}\u{0438}", 6, 1, "", self::$methodObject),
            new Among("\u{044F}\u{043C}\u{0438}", 6, 1, "", self::$methodObject),
            new Among("\u{0438}\u{044F}\u{043C}\u{0438}", 10, 1, "", self::$methodObject),
            new Among("\u{0439}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{0439}", 12, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0435}\u{0439}", 13, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0439}", 12, 1, "", self::$methodObject),
            new Among("\u{043E}\u{0439}", 12, 1, "", self::$methodObject),
            new Among("\u{0430}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{0435}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{0435}\u{043C}", 18, 1, "", self::$methodObject),
            new Among("\u{043E}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{044F}\u{043C}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{044F}\u{043C}", 21, 1, "", self::$methodObject),
            new Among("\u{043E}", -1, 1, "", self::$methodObject),
            new Among("\u{0443}", -1, 1, "", self::$methodObject),
            new Among("\u{0430}\u{0445}", -1, 1, "", self::$methodObject),
            new Among("\u{044F}\u{0445}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{044F}\u{0445}", 26, 1, "", self::$methodObject),
            new Among("\u{044B}", -1, 1, "", self::$methodObject),
            new Among("\u{044C}", -1, 1, "", self::$methodObject),
            new Among("\u{044E}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{044E}", 30, 1, "", self::$methodObject),
            new Among("\u{044C}\u{044E}", 30, 1, "", self::$methodObject),
            new Among("\u{044F}", -1, 1, "", self::$methodObject),
            new Among("\u{0438}\u{044F}", 33, 1, "", self::$methodObject),
            new Among("\u{044C}\u{044F}", 33, 1, "", self::$methodObject)
        ];

        self::$a_6 = [
            new Among("\u{043E}\u{0441}\u{0442}", -1, 1, "", self::$methodObject),
            new Among("\u{043E}\u{0441}\u{0442}\u{044C}", -1, 1, "", self::$methodObject)
        ];

        self::$a_7 = [
            new Among("\u{0435}\u{0439}\u{0448}\u{0435}", -1, 1, "", self::$methodObject),
            new Among("\u{043D}", -1, 2, "", self::$methodObject),
            new Among("\u{0435}\u{0439}\u{0448}", -1, 1, "", self::$methodObject),
            new Among("\u{044C}", -1, 3, "", self::$methodObject)
        ];

        self::$g_v = [chr(33), chr(65), chr(8), chr(232)];
    }

    /** @var int */
    public $I_p2;
    /** @var int */
    public $I_pV;

    /**
     * @param RussianStemmer $other
     */
    protected function copy_from($other)
    {
        $this->I_p2 = $other->I_p2;
        $this->I_pV = $other->I_pV;
        parent::copy_from($other);
    }

    private function r_mark_regions(): bool
    {
        // (, line 57
        $this->I_pV = $this->limit;
        $this->I_p2 = $this->limit;
        // do, line 61
        $v_1 = $this->cursor;

        do {
            // (, line 61
            // gopast, line 62
            while (true) {
                do {
                    if (!($this->in_grouping(self::$g_v, 1072, 1103))) {
                        break;
                    }
                    break 2;
                } while (false);
                if ($this->cursor >= $this->limit) {
                    break 2;
                }
                $this->cursor++;
            }
            // setmark pV, line 62
            $this->I_pV = $this->cursor;
            // gopast, line 62

            while (true) {
                do {
                    if (!($this->out_grouping(self::$g_v, 1072, 1103))) {
                        break;
                    }
                    break 2;
                } while (false);
                if ($this->cursor >= $this->limit) {
                    break 2;
                }
                $this->cursor++;
            }
            // gopast, line 63

            while (true) {
                do {
                    if (!($this->in_grouping(self::$g_v, 1072, 1103))) {
                        break;
                    }
                    break 2;
                } while (false);
                if ($this->cursor >= $this->limit) {
                    break 2;
                }
                $this->cursor++;
            }
            // gopast, line 63

            while (true) {
                do {
                    if (!($this->out_grouping(self::$g_v, 1072, 1103))) {
                        break;
                    }
                    break 2;
                } while (false);
                if ($this->cursor >= $this->limit) {
                    break 2;
                }
                $this->cursor++;
            }
            // setmark p2, line 63
            $this->I_p2 = $this->cursor;
        } while (false);
        $this->cursor = $v_1;

        return true;
    }

    private function r_R2(): bool
    {
        if (!($this->I_p2 <= $this->cursor)) {
            return false;
        }

        return true;
    }

    private function r_perfective_gerund(): bool
    {
        // (, line 71
        // [, line 72
        $this->ket = $this->cursor;
        // substring, line 72
        $among_var = $this->find_among_b(self::$a_0, 9);
        if ($among_var == 0) {
            return false;
        }
        // ], line 72
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                // (, line 76
                // or, line 76
                do {
                    $v_1 = $this->limit - $this->cursor;
                    do {
                        // literal, line 76
                        if (!($this->eq_s_b(1, "\u{0430}"))) {
                            break;
                        }
                        break 2;
                    } while (false);
                    $this->cursor = $this->limit - $v_1;
                    // literal, line 76
                    if (!($this->eq_s_b(1, "\u{044F}"))) {
                        return false;
                    }
                } while (false);
                // delete, line 76
                $this->slice_del();
                break;
            case 2:
                // (, line 83
                // delete, line 83
                $this->slice_del();
                break;
        }
        return true;
    }

    private function r_adjective(): bool
    {
        // (, line 87
        // [, line 88
        $this->ket = $this->cursor;
        // substring, line 88
        $among_var = $this->find_among_b(self::$a_1, 26);
        if ($among_var == 0) {
            return false;
        }
        // ], line 88
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                // (, line 97
                // delete, line 97
                $this->slice_del();
                break;
        }
        return true;
    }

    private function r_adjectival(): bool
    {
        // (, line 101
        // call adjective, line 102
        if (!$this->r_adjective()) {
            return false;
        }
        // try, line 109
        $v_1 = $this->limit - $this->cursor;
        do {
            // (, line 109
            // [, line 110
            $this->ket = $this->cursor;
            // substring, line 110
            $among_var = $this->find_among_b(self::$a_2, 8);
            if ($among_var == 0) {
                $this->cursor = $this->limit - $v_1;
                break;
            }
            // ], line 110
            $this->bra = $this->cursor;
            switch ($among_var) {
                case 0:
                    $this->cursor = $this->limit - $v_1;
                    break 2;
                case 1:
                    // (, line 115
                    // or, line 115
                    do {
                        $v_2 = $this->limit - $this->cursor;
                        do {
                            // literal, line 115
                            if (!($this->eq_s_b(1, "\u{0430}"))) {
                                break;
                            }
                            break 2;
                        } while (false);
                        $this->cursor = $this->limit - $v_2;
                        // literal, line 115
                        if (!($this->eq_s_b(1, "\u{044F}"))) {
                            $this->cursor = $this->limit - $v_1;
                            break 3;
                        }
                    } while (false);
                    // delete, line 115
                    $this->slice_del();
                    break;
                case 2:
                    // (, line 122
                    // delete, line 122
                    $this->slice_del();
                    break;
            }
        } while (false);
        return true;
    }

    private function r_reflexive(): bool
    {
        // (, line 128
        // [, line 129
        $this->ket = $this->cursor;
        // substring, line 129
        $among_var = $this->find_among_b(self::$a_3, 2);
        if ($among_var == 0) {
            return false;
        }
        // ], line 129
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                // (, line 132
                // delete, line 132
                $this->slice_del();
                break;
        }
        return true;
    }

    private function r_verb(): bool
    {
        // (, line 136
        // [, line 137
        $this->ket = $this->cursor;
        // substring, line 137
        $among_var = $this->find_among_b(self::$a_4, 46);
        if ($among_var == 0) {
            return false;
        }
        // ], line 137
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                // (, line 143
                // or, line 143
                do {
                    $v_1 = $this->limit - $this->cursor;
                    do {
                        // literal, line 143
                        if (!($this->eq_s_b(1, "\u{0430}"))) {
                            break;
                        }
                        break 2;
                    } while (false);
                    $this->cursor = $this->limit - $v_1;
                    // literal, line 143
                    if (!($this->eq_s_b(1, "\u{044F}"))) {
                        return false;
                    }
                } while (false);
                // delete, line 143
                $this->slice_del();
                break;
            case 2:
                // (, line 151
                // delete, line 151
                $this->slice_del();
                break;
        }
        return true;
    }

    private function r_noun(): bool
    {
        // (, line 159
        // [, line 160
        $this->ket = $this->cursor;
        // substring, line 160
        $among_var = $this->find_among_b(self::$a_5, 36);
        if ($among_var == 0) {
            return false;
        }
        // ], line 160
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                // (, line 167
                // delete, line 167
                $this->slice_del();
                break;
        }
        return true;
    }

    private function r_derivational(): bool
    {
//int among_var;
        // (, line 175
        // [, line 176
        $this->ket = $this->cursor;
        // substring, line 176
        $among_var = $this->find_among_b(self::$a_6, 2);
        if ($among_var == 0) {
            return false;
        }
        // ], line 176
        $this->bra = $this->cursor;
        // call R2, line 176
        if (!$this->r_R2()) {
            return false;
        }
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                // (, line 179
                // delete, line 179
                $this->slice_del();
                break;
        }
        return true;
    }

    private function r_tidy_up(): bool
    {
        // (, line 183
        // [, line 184
        $this->ket = $this->cursor;
        // substring, line 184
        $among_var = $this->find_among_b(self::$a_7, 4);
        if ($among_var == 0) {
            return false;
        }
        // ], line 184
        $this->bra = $this->cursor;
        switch ($among_var) {
            case 0:
                return false;
            case 1:
                // (, line 188
                // delete, line 188
                $this->slice_del();
                // [, line 189
                $this->ket = $this->cursor;
                // literal, line 189
                if (!($this->eq_s_b(1, "\u{043D}"))) {
                    return false;
                }
                // ], line 189
                $this->bra = $this->cursor;
                // literal, line 189
                if (!($this->eq_s_b(1, "\u{043D}"))) {
                    return false;
                }
                // delete, line 189
                $this->slice_del();
                break;
            case 2:
                // (, line 192
                // literal, line 192
                if (!($this->eq_s_b(1, "\u{043D}"))) {
                    return false;
                }
                // delete, line 192
                $this->slice_del();
                break;
            case 3:
                // (, line 194
                // delete, line 194
                $this->slice_del();
                break;
        }
        return true;
    }

    public function stem(): bool
    {
        // (, line 199
        // do, line 201
        $v_1 = $this->cursor;
        do {
            // call mark_regions, line 201
            if (!$this->r_mark_regions()) {
                break;
            }
        } while (false);
        $this->cursor = $v_1;
        // backwards, line 202
        $this->limit_backward = $this->cursor;
        $this->cursor = $this->limit;
        // setlimit, line 202
        $v_2 = $this->limit - $this->cursor;
        // tomark, line 202
        if ($this->cursor < $this->I_pV) {
            return false;
        }
        $this->cursor = $this->I_pV;
        $v_3 = $this->limit_backward;
        $this->limit_backward = $this->cursor;
        $this->cursor = $this->limit - $v_2;
        // (, line 202
        // do, line 203
        $v_4 = $this->limit - $this->cursor;
        do {
            // (, line 203
            // or, line 204
            do {
                $v_5 = $this->limit - $this->cursor;
                do {
                    // call perfective_gerund, line 204
                    if (!$this->r_perfective_gerund()) {
                        break;
                    }
                    break 2;
                } while (false);
                $this->cursor = $this->limit - $v_5;
                // (, line 205
                // try, line 205
                $v_6 = $this->limit - $this->cursor;
                do {
                    // call reflexive, line 205
                    if (!$this->r_reflexive()) {
                        $this->cursor = $this->limit - $v_6;
                        break;
                    }
                } while (false);
                // or, line 206
                do {
                    $v_7 = $this->limit - $this->cursor;
                    do {
                        // call adjectival, line 206
                        if (!$this->r_adjectival()) {
                            break;
                        }
                        break 2;
                    } while (false);
                    $this->cursor = $this->limit - $v_7;
                    do {
                        // call verb, line 206
                        if (!$this->r_verb()) {
                            break;
                        }
                        break 2;
                    } while (false);
                    $this->cursor = $this->limit - $v_7;
                    // call noun, line 206
                    if (!$this->r_noun()) {
                        break 3;
                    }
                } while (false);
            } while (false);
        } while (false);
        $this->cursor = $this->limit - $v_4;
        // try, line 209
        $v_8 = $this->limit - $this->cursor;
        do {
            // (, line 209
            // [, line 209
            $this->ket = $this->cursor;
            // literal, line 209
            if (!($this->eq_s_b(1, "\u{0438}"))) {
                $this->cursor = $this->limit - $v_8;
                break;
            }
            // ], line 209
            $this->bra = $this->cursor;
            // delete, line 209
            $this->slice_del();
        } while (false);
        // do, line 212
        $v_9 = $this->limit - $this->cursor;
        do {
            // call derivational, line 212
            if (!$this->r_derivational()) {
                break;
            }
        } while (false);
        $this->cursor = $this->limit - $v_9;
        // do, line 213
        $v_10 = $this->limit - $this->cursor;
        do {
            // call tidy_up, line 213
            if (!$this->r_tidy_up()) {
                break;
            }
        } while (false);
        $this->cursor = $this->limit - $v_10;
        $this->limit_backward = $v_3;
        $this->cursor = $this->limit_backward;

        return true;
    }

    public function equals($o): bool
    {
        return $o instanceof RussianStemmer;
    }

    public function hashCode()
    {
        return spl_object_id($this);
    }


}


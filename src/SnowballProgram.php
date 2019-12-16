<?php

namespace tartarus;

use IntlChar;

/**
 * This is the rev 502 of the Snowball SVN trunk,
 * now located at <a target="_blank" href="https://github.com/snowballstem/snowball/tree/e103b5c257383ee94a96e7fc58cab3c567bf079b">GitHub</a>,
 * but modified:
 * <ul>
 * <li>made abstract and introduced abstract method stem to avoid expensive reflection in filter class.
 * <li>refactored StringBuffers to StringBuilder
 * <li>uses char[] as buffer instead of StringBuffer/StringBuilder
 * <li>eq_s,eq_s_b,insert,replace_s take CharSequence like eq_v and eq_v_b
 * <li>use MethodHandles and fix <a target="_blank" href="http://article.gmane.org/gmane.comp.search.snowball/1139">method visibility bug</a>.
 * </ul>
 */
abstract class SnowballProgram
{

    /** @var array */
    public $current;
    /** @var int */
    public $cursor;
    /** @var int */
    public $limit;
    /** @var int */
    public $limit_backward;
    /** @var int */
    public $bra;
    /** @var int */
    public $ket;

    protected function __construct()
    {
        $this->current = []; //new char[8];
        $this->setCurrent('');
    }

    public abstract function stem(): bool;

    /**
     * Set the current string.
     *
     * @param array|string $value
     * @param int          $length
     */
    public function setCurrent($value, $length = null)
    {
        if (is_array($value)) {
            $this->current = $value;
            $this->limit = $length;
        } else {
            $this->current = preg_split('//u', $value, -1, PREG_SPLIT_NO_EMPTY);
            $this->limit = mb_strlen($value);
        }
        $this->cursor = 0;
        $this->limit_backward = 0;
        $this->bra = $this->cursor;
        $this->ket = $this->limit;
    }

    /**
     * Get the current string.
     */
    public function getCurrent(): string
    {
        return implode('', array_slice($this->current, 0, $this->limit));
    }

    /**
     * Get the current buffer containing the stem.
     * <p>
     * NOTE: this may be a reference to a different character array than the
     * one originally provided with setCurrent, in the exceptional case that
     * stemming produced a longer intermediate or result string.
     * </p>
     * <p>
     * It is necessary to use {@link #getCurrentBufferLength()} to determine
     * the valid length of the returned buffer. For example, many words are
     * stemmed simply by subtracting from the length to remove suffixes.
     * </p>
     * @see #getCurrentBufferLength()
     */
    public function getCurrentBuffer(): array
    {
        return $this->current;
    }

    /**
     * Get the valid length of the character array in
     * {@link #getCurrentBuffer()}.
     * @return int valid length of the array.
     */
    public function getCurrentBufferLength(): int
    {
        return $this->limit;
    }

    /**
     * @param SnowballProgram $other
     */
    protected function copy_from($other)
    {
        $this->current = $other->current;
        $this->cursor = $other->cursor;
        $this->limit = $other->limit;
        $this->limit_backward = $other->limit_backward;
        $this->bra = $other->bra;
        $this->ket = $other->ket;
    }

    protected function in_grouping(array $s, int $min, int $max): bool
    {
        if ($this->cursor >= $this->limit) {
            return false;
        }
        $ch = IntlChar::ord($this->current[$this->cursor]);
        if ($ch > $max || $ch < $min) {
            return false;
        }
        $ch -= $min;
        if ((IntlChar::ord($s[$ch >> 3]) & (0X1 << ($ch & 0X7))) == 0) {
            return false;
        }
        $this->cursor++;
        return true;
    }

    protected function in_grouping_b(array $s, int $min, int $max): bool
    {
        if ($this->cursor <= $this->limit_backward) {
            return false;
        }
        $ch = IntlChar::ord($this->current[$this->cursor - 1]);
        if ($ch > $max || $ch < $min) {
            return false;
        }
        $ch -= $min;
        if ((IntlChar::ord($s[$ch >> 3]) & (0X1 << ($ch & 0X7))) == 0) {
            return false;
        }
        $this->cursor--;
        return true;
    }

    protected function out_grouping(array $s, int $min, int $max): bool
    {
        if ($this->cursor >= $this->limit) {
            return false;
        }
        $ch = IntlChar::ord($this->current[$this->cursor]);
        if ($ch > $max || $ch < $min) {
            $this->cursor++;
            return true;
        }
        $ch -= $min;
        if ((IntlChar::ord($s[$ch >> 3]) & (0X1 << ($ch & 0X7))) == 0) {
            $this->cursor++;
            return true;
        }
        return false;
    }

    protected function out_grouping_b(array $s, int $min, int $max): bool
    {
        if ($this->cursor <= $this->limit_backward) {
            return false;
        }
        $ch = IntlChar::ord($this->current[$this->cursor - 1]);
        if ($ch > $max || $ch < $min) {
            $this->cursor--;
            return true;
        }
        $ch -= $min;
        if ((IntlChar::ord($s[$ch >> 3]) & (0X1 << ($ch & 0X7))) == 0) {
            $this->cursor--;
            return true;
        }
        return false;
    }

    protected function in_range(int $min, int $max): bool
    {
        if ($this->cursor >= $this->limit) {
            return false;
        }
        $ch = IntlChar::ord($this->current[$this->cursor]);
        if ($ch > $max || $ch < $min) {
            return false;
        }
        $this->cursor++;
        return true;
    }

    protected function in_range_b(int $min, int $max): bool
    {
        if ($this->cursor <= $this->limit_backward) {
            return false;
        }
        $ch = IntlChar::ord($this->current[$this->cursor - 1]);
        if ($ch > $max || $ch < $min) {
            return false;
        }
        $this->cursor--;
        return true;
    }

    protected function out_range(int $min, int $max): bool
    {
        if ($this->cursor >= $this->limit) {
            return false;
        }
        $ch = IntlChar::ord($this->current[$this->cursor]);
        if (!($ch > $max || $ch < $min)) {
            return false;
        }
        $this->cursor++;
        return true;
    }

    protected function out_range_b(int $min, int $max): bool
    {
        if ($this->cursor <= $this->limit_backward) {
            return false;
        }
        $ch = IntlChar::ord($this->current[$this->cursor - 1]);
        if (!($ch > $max || $ch < $min)) {
            return false;
        }
        $this->cursor--;
        return true;
    }

    protected function eq_s(int $s_size, string $s): bool
    {
        $charSequence = preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY);
        if ($this->limit - $this->cursor < $s_size) {
            return false;
        }
        for ($i = 0; $i != $s_size; $i++) {
            if ($this->current[$this->cursor + $i] != $charSequence[$i]) {
                return false;
            }
        }
        $this->cursor += $s_size;
        return true;
    }

    protected function eq_s_b(int $s_size, string $s): bool
    {
        $charSequence = preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY);
        if ($this->cursor - $this->limit_backward < $s_size) {
            return false;
        }

        for ($i = 0; $i != $s_size; $i++) {
            if ($this->current[$this->cursor - $s_size + $i] != $charSequence[$i]) {
                return false;
            }
        }
        $this->cursor -= $s_size;
        return true;
    }

    protected function eq_v(string $s): bool
    {
        return $this->eq_s(mb_strlen($s), $s);
    }

    protected function eq_v_b(string $s): bool
    {
        return $this->eq_s_b(mb_strlen($s), $s);
    }

    /**
     * @param Among[] $v
     * @param int     $v_size
     *
     * @return int
     */
    protected function find_among(array $v, int $v_size): int
    {
        $i = 0;
        $j = $v_size;

        $c = $this->cursor;
        $l = $this->limit;

        $common_i = 0;
        $common_j = 0;

        $first_key_inspected = false;

        while (true) {
            $k = $i + (($j - $i) >> 1);
            $diff = 0;
            $common = $common_i < $common_j ? $common_i : $common_j; // smaller
            /** @var Among $w */
            $w = $v[$k];
            for ($i2 = $common; $i2 < $w->s_size; $i2++) {
                if ($c + $common == $l) {
                    $diff = -1;
                    break;
                }
                $diff = IntlChar::ord($this->current[$c + $common]) - IntlChar::ord($w->s[$i2]);
                if ($diff != 0) {
                    break;
                }
                $common++;
            }
            if ($diff < 0) {
                $j = $k;
                $common_j = $common;
            } else {
                $i = $k;
                $common_i = $common;
            }
            if ($j - $i <= 1) {
                if ($i > 0) {
                    break;
                } // v->s has been inspected
                if ($j == $i) {
                    break;
                } // only one item in v

                // - but now we need to go round once more to get
                // v->s inspected. This looks messy, but is actually
                // the optimal approach.

                if ($first_key_inspected) {
                    break;
                }
                $first_key_inspected = true;
            }
        }
        while (true) {
            /** @var Among $w */
            $w = $v[$i];
            if ($common_i >= $w->s_size) {
                $this->cursor = $c + $w->s_size;
                if ($w->method == null) {
                    return $w->result;
                }
                $res = false;
                try {
                    $res = $w->method->invoke($this);
                } catch (\Throwable $e) {
                    self::rethrow($e);
                }
                $this->cursor = $c + $w->s_size;
                if ($res) {
                    return $w->result;
                }
            }
            $i = $w->substring_i;
            if ($i < 0) {
                return 0;
            }
        }
    }

    // find_among_b is for backwards processing. Same comments apply

    /**
     * @param Among[] $v
     * @param int     $v_size
     *
     * @return int
     */
    protected function find_among_b(array $v, int $v_size): int
    {
        $i = 0;
        $j = $v_size;

        $c = $this->cursor;
        $lb = $this->limit_backward;

        $common_i = 0;
        $common_j = 0;

        $first_key_inspected = false;

        while (true) {
            $k = $i + (($j - $i) >> 1);
            $diff = 0;
            $common = $common_i < $common_j ? $common_i : $common_j;
            /** @var Among $w */
            $w = $v[$k];
            for ($i2 = $w->s_size - 1 - $common; $i2 >= 0; $i2--) {
                if ($c - $common == $lb) {
                    $diff = -1;
                    break;
                }
                $diff = IntlChar::ord($this->current[$c - 1 - $common]) - IntlChar::ord($w->s[$i2]);
                if ($diff != 0) {
                    break;
                }
                $common++;
            }
            if ($diff < 0) {
                $j = $k;
                $common_j = $common;
            } else {
                $i = $k;
                $common_i = $common;
            }
            if ($j - $i <= 1) {
                if ($i > 0) {
                    break;
                }
                if ($j == $i) {
                    break;
                }
                if ($first_key_inspected) {
                    break;
                }
                $first_key_inspected = true;
            }
        }
        while (true) {
            /** @var Among $w */
            $w = $v[$i];
            if ($common_i >= $w->s_size) {
                $this->cursor = $c - $w->s_size;
                if ($w->method == null) {
                    return $w->result;
                }

                $res = false;
                try {
                    $res = $w->method->invoke($this);
                } catch (\Throwable $e) {
                    self::rethrow($e);
                }
                $this->cursor = $c - $w->s_size;
                if ($res) {
                    return $w->result;
                }
            }
            $i = $w->substring_i;
            if ($i < 0) {
                return 0;
            }
        }
    }

    /* to replace chars between c_bra and c_ket in current by the
       * chars in s.
       */
    protected function replace_s(int $c_bra, int $c_ket, string $sequence): int
    {
        $s = preg_split('//u', $sequence, -1, PREG_SPLIT_NO_EMPTY);
        $adjustment = count($s) - ($c_ket - $c_bra);
        $newLength = $this->limit + $adjustment;
        //resize if necessary
        if ($newLength > count($this->current)) {
//        $newBuffer = [];//new char[ArrayUtil.oversize(newLength, Character.BYTES)];
            $newBuffer = array_slice($this->current, 0, $this->limit);
            $this->current = $newBuffer;
        }
        // if the substring being replaced is longer or shorter than the
        // replacement, need to shift things around
        if ($adjustment != 0 && $c_ket < $this->limit) {
            $dstOffset = $c_bra + count($s);
            for ($srcOffset = $c_ket; $srcOffset < $this->limit - $c_ket; $srcOffset++, $dstOffset++) {
                $this->current[$dstOffset] = $this->current[$srcOffset];
            }
//        System.arraycopy($this->current, $c_ket, $this->current, $c_bra + count($s), $this->limit - $c_ket);
        }
        // insert the replacement text
        // Note, faster is s.getChars(0, s.length(), current, c_bra);
        // but would have to duplicate this method for both String and StringBuilder
        for ($i = 0; $i < count($s); $i++)
            $this->current[$c_bra + $i] = $s[$i];

        $this->limit += $adjustment;
        if ($this->cursor >= $c_ket) {
            $this->cursor += $adjustment;
        } elseif ($this->cursor > $c_bra) {
            $this->cursor = $c_bra;
        }
        return $adjustment;
    }

    protected function slice_check()
    {
        if ($this->bra < 0 ||
            $this->bra > $this->ket ||
            $this->ket > $this->limit) {
            throw new \InvalidArgumentException("faulty slice operation: bra={$this->bra},ket={$this->ket},limit={$this->limit}");
            // FIXME: report error somehow.
            /*
            fprintf(stderr, "faulty slice operation:\n");
            debug(z, -1, 0);
            exit(1);
            */
        }
    }

    protected function slice_from(string $s)
    {
        $this->slice_check();
        $this->replace_s($this->bra, $this->ket, $s);
    }

    protected function slice_del()
    {
        $this->slice_from('');
    }

    protected function insert(int $c_bra, int $c_ket, string $s)
    {
        $adjustment = $this->replace_s($c_bra, $c_ket, $s);
        if ($c_bra <= $this->bra) {
            $this->bra += $adjustment;
        }
        if ($c_bra <= $this->ket) {
            $this->ket += $adjustment;
        }
    }

    /* Copy the slice into the supplied StringBuffer */
    protected function slice_to(string $s): string
    {
        $this->slice_check();
        $len = $this->ket - $this->bra;
        $s = '';
        $s .= implode('', array_slice($this->current, $this->bra, $len));
        return $s;
    }

    protected function assign_to(string $s): string
    {
        $s = '';
        $s .= implode('', array_slice($this->current, 0, $this->limit));
        return $s;
    }

    /*
    extern void debug(struct SN_env * z, int number, int line_count)
    {   int i;
        int limit = SIZE(z->p);
        //if (number >= 0) printf("%3d (line %4d): '", number, line_count);
        if (number >= 0) printf("%3d (line %4d): [%d]'", number, line_count,limit);
        for (i = 0; i <= limit; i++)
        {   if (z->lb == i) printf("{");
            if (z->bra == i) printf("[");
            if (z->c == i) printf("|");
            if (z->ket == i) printf("]");
            if (z->l == i) printf("}");
            if (i < limit)
            {   int ch = z->p[i];
                if (ch == 0) ch = '#';
                printf("%c", ch);
            }
        }
        printf("'\n");
    }
    */

    // Hack to rethrow unknown Exceptions from {@link MethodHandle#invoke}:
    private static function rethrow(\Throwable $t)
    {
        SnowballProgram::rethrow0($t);
    }

    private static function rethrow0(\Throwable $t)
    {
        throw $t;
    }
}

;


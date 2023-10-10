<?php

declare(strict_types=1);

namespace CityHash;

/**
 * CityHash v1.0.2
 * @see http://code.google.com/p/cityhash/
 * @see https://clickhouse.com/docs/en/native-protocol/hash
 */
final class CityHash102
{
    private const k0 = -4348849565147123417;
    private const k1 = -5435081209227447693;
    private const k2 = -7286425919675154353;
    private const k3 = -3942382747735136937;
    private const kMul = -7070675565921424023;

    public static function cityHash64(string $s, int $index = 0, int $len = null): int
    {
        if ($len === null) {
            $len = strlen($s);
        }

        if ($len <= 16) {
            return self::hashLen0to16($s, $index, $len);
        }

        if ($len <= 32) {
            return self::hashLen17to32($s, $index, $len);
        }

        if ($len <= 64) {
            return self::hashLen33to64($s, $index, $len);
        }

        $x = self::fetch64($s, $index);
        $y = self::fetch64($s, $index + $len - 16) ^ self::k1;
        $z = self::fetch64($s, $index + $len - 56) ^ self::k0;
        $v = self::weakHashLen32WithSeeds($s, $index + $len - 64, $len, $y);
        $w = self::weakHashLen32WithSeeds($s, $index + $len - 32, self::mul($len, self::k1), self::k0);
        $z = self::add($z, self::mul(self::shiftMix($v[1]), self::k1));
        $x = self::mul(self::rotate(self::add($z, $x), 39), self::k1);
        $y = self::mul(self::rotate($y, 33), self::k1);

        $len = ($len - 1) & ~63;
        do {
            $x = self::mul(self::rotate(self::add(self::add($x, $y), self::add($v[0], self::fetch64($s, $index + 16))), 37), self::k1);
            $y = self::mul(self::rotate(self::add($y, self::add($v[1], self::fetch64($s, $index + 48))), 42), self::k1);
            $x ^= $w[1];
            $y ^= $v[0];
            $z = self::rotate($z ^ $w[0], 33);
            $v = self::weakHashLen32WithSeeds($s, $index, self::mul($v[1], self::k1), self::add($x, $w[0]));
            $w = self::weakHashLen32WithSeeds($s, $index + 32, self::add($z, $w[1]), $y);
            $t = $z;
            $z = $x;
            $x = $t;
            $index += 64;
            $len -= 64;
        } while ($len !== 0);
        return self::hashLen16(
            self::add(self::hashLen16($v[0], $w[0]), self::add(self::mul(self::shiftMix($y), self::k1), $z)),
            self::add(self::hashLen16($v[1], $w[1]), $x)
        );
    }

    private static function hashLen0to16(string $s, int $index, int $len): int
    {
        if ($len > 8) {
            $a = self::fetch64($s, $index);
            $b = self::fetch64($s, $index + $len - 8);
            return self::hashLen16($a, self::rotateByAtLeastOne(self::add($b, $len), $len)) ^ $b;
        }
        if ($len >= 4) {
            $a = self::fetch32($s, $index);
            return self::hashLen16($len + ($a << 3), self::fetch32($s, $index + $len - 4));
        }
        if ($len > 0) {
            $a = ord($s[$index]);
            $b = ord($s[$index + ($len >> 1)]);
            $c = ord($s[$index + $len - 1]);
            $y = $a + ($b << 8);
            $z = $len + ($c << 2);
            return self::mul(self::shiftMix(self::mul($y, self::k2) ^ self::mul($z, self::k3)), self::k2);
        }
        return self::k2;
    }

    private static function hashLen17to32(string $s, int $index, int $len): int
    {
        $a = self::mul(self::fetch64($s, $index), self::k1);
        $b = self::fetch64($s, $index + 8);
        $c = self::mul(self::fetch64($s, $index + $len - 8), self::k2);
        $d = self::mul(self::fetch64($s, $index + $len - 16), self::k0);
        return self::hashLen16(
            self::add(self::add(self::rotate(self::sub($a, $b), 43), self::rotate($c, 30)), $d),
            self::add(self::sub(self::add($a, self::rotate($b ^ self::k3, 20)), $c), $len)
        );
    }

    private static function hashLen33to64(string $s, int $index, int $len): int
    {
        $z = self::fetch64($s, $index + 24);
        $a = self::add(self::fetch64($s, $index), self::mul(self::add($len, self::fetch64($s, $index + $len - 16)), self::k0));
        $b = self::rotate(self::add($a, $z), 52);
        $c = self::rotate($a, 37);
        $a = self::add($a, self::fetch64($s, $index + 8));
        $c = self::add($c, self::rotate($a, 7));
        $a = self::add($a, self::fetch64($s, $index + 16));
        $vf = self::add($a, $z);
        $vs = self::add(self::add($b, self::rotate($a, 31)), $c);
        $a = self::add(self::fetch64($s, $index + 16), self::fetch64($s, $index + $len - 32));
        $z = self::fetch64($s, $index + $len - 8);
        $b = self::rotate(self::add($a, $z), 52);
        $c = self::rotate($a, 37);
        $a = self::add($a, self::fetch64($s, $index + $len - 24));
        $c = self::add($c, self::rotate($a, 7));
        $a = self::add($a, self::fetch64($s, $index + $len - 16));
        $wf = self::add($a, $z);
        $ws = self::add(self::add($b, self::rotate($a, 31)), $c);
        $r = self::shiftMix(self::add(self::mul(self::add($vf, $ws), self::k2), self::mul(self::add($wf, $vs), self::k0)));
        return self::mul(self::shiftMix(self::add(self::mul($r, self::k0), $vs)), self::k2);
    }

    private static function fetch64(string $p, int $index): int
    {
        return self::fetch32($p, $index) | self::fetch32($p, $index + 4) << 32;
    }

    private static function fetch32(string $p, int $index): int
    {
        return ord($p[$index + 3]) << 24 | ord($p[$index + 2]) << 16 | ord($p[$index + 1]) << 8 | ord($p[$index]);
    }

    private static function weakHashLen32WithSeedsInternal(int $w, int $x, int $y, int $z, int $a, int $b): array
    {
        $a = self::add($a, $w);
        $b = self::rotate(self::add($b, self::add($a, $z)), 21);
        $c = $a;
        $a = self::add($a, $x);
        $a = self::add($a, $y);
        $b = self::add($b, self::rotate($a, 44));
        return [self::add($a, $z), self::add($b, $c)];
    }

    private static function weakHashLen32WithSeeds(string $s, int $index, int $a, int $b): array
    {
        return self::weakHashLen32WithSeedsInternal(
            self::fetch64($s, $index),
            self::fetch64($s, $index + 8),
            self::fetch64($s, $index + 16),
            self::fetch64($s, $index + 24),
            $a,
            $b
        );
    }

    private static function rotateByAtLeastOne(int $val, int $shift): int
    {
        return $val >> $shift & PHP_INT_MAX >> $shift - 1 | $val << 64 - $shift;
    }

    private static function shiftMix(int $val): int
    {
        return $val ^ $val >> 47 & PHP_INT_MAX >> 46;
    }

    private static function rotate(int $val, int $shift): int
    {
        return $shift === 0 ? $val : $val >> $shift & PHP_INT_MAX >> $shift - 1 | $val << 64 - $shift;
    }

    private static function hashLen16(int $l, int $h): int
    {
        $a = self::mul($l ^ $h, self::kMul);
        $a ^= $a >> 47 & PHP_INT_MAX >> 46;
        $b = self::mul($h ^ $a, self::kMul);
        $b ^= $b >> 47 & PHP_INT_MAX >> 46;
        return self::mul($b, self::kMul);
    }

    private static function add(int $a, int $b): int
    {
        $sum = ~PHP_INT_MAX + ($a & PHP_INT_MAX) + ($b & PHP_INT_MAX);
        return ($a ^ $b) < 0 ? $sum : $sum ^ ~PHP_INT_MAX;
    }

    private static function sub(int $a, int $b): int
    {
        $min = ~PHP_INT_MAX;
        if ($a < 0) {
            $a &= PHP_INT_MAX;
            if ($b < 0) {
                $b &= PHP_INT_MAX;
                return $a < $b ? $min + PHP_INT_MAX - $b + $a + 1 : $a - $b;
            }
            return $a < $b ? $min + PHP_INT_MAX - $b + $a + 1 ^ $min : $a - $b ^ $min;
        }
        if ($b < 0) {
            $b &= PHP_INT_MAX;
            return $a < $b ? $min + PHP_INT_MAX - $b + $a + 1 ^ $min : $a - $b ^ $min;
        }
        return $a < $b ? $min + PHP_INT_MAX - $b + $a + 1 : $a - $b;
    }

    private static function mul(int $a, int $b): int
    {
        $min = ~PHP_INT_MAX;
        $mask60 = 0x000000000000000f;
        $mask34 = 0x000000003fffffff;
        $aL = $a & $mask60;
        $bH = $b >> 60 & $mask60;
        $bL = $b & $mask60;
        $aH = $a >> 60 & $mask60;
        $La = $a & $mask34;
        $Ha = $a >> 30 & $mask34;
        $Lb = $b & $mask34;
        $Hb = $b >> 30 & $mask34;
        $sum1 = $La * $Hb + $Ha * $Lb << 30;
        $sum2 = $Ha * $Hb + $aL * $bH + $bL * $aH << 60 | $La * $Lb;
        $sum = $min + ($sum1 & PHP_INT_MAX) + ($sum2 & PHP_INT_MAX);
        if (($sum1 ^ $sum2) >= 0) {
            $sum ^= $min;
        }
        return $sum;
    }
}
<?php

require __DIR__ . '/../src/CityHash102.php';

$testData = [
    u('9ae16a3b2f90404f'), u('75e9dee28ded761d'), u('75de892fdc5ba914'), u('69cfe9fca1cc683a'),
    u('675b04c582a34966'), u('46fa817397ea8b68'), u('406e959cdffadec7'), u('46663908b4169b95'),
    u('f214b86cffeab596'), u('eba670441d1a4f7d'), u('172c17ff21dbf88d'), u('5a0838df8a019b8c'),
    u('8f42b1fbb2fc0302'), u('72085e82d70dcea9'), u('32b75fc2223b5032'), u('e1dd010487d2d647'),
    u('2994f9245194a7e2'), u('32e2ed6fa03e5b22'), u('37a72b6e89410c9f'), u('10836563cb8ff3a1'),
    u('4dabcb5c1d382e5c'), u('296afb509046d945'), u('f7c0257efde772ea'), u('61e021c8da344ba1'),
    u('c0a86ed83908560b'), u('35c9cf87e4accbf3'), u('e74c366b3091e275'), u('a3f2ca45089ad1a6'),
    u('e5181466d8e60e26'), u('fb528a8dd1e48ad7'), u('da6d2b7ea9d5f9b6'), u('61d95225bc2293e'),
    u('81247c01ab6a9cc1'), u('c17f3ebd3257cb8b'), u('9802438969c3043b'), u('3dd8ed248a03d754'),
    u('c5bf48d7d3e9a5a3'), u('bc4a21d00cf52288'), u('172c8674913ff413'), u('17a361dbdaaa7294'),
    u('5cc268bac4bd55f'), u('db04969cc06547f1'), u('25bd8d3ca1b375b2'), u('166c11fbcbc89fd8'),
    u('3565bcc4ca4ce807'), u('b7897fd2f274307d'), u('aba98113ab0e4a16'), u('17f7796e0d4b636c'),
    u('33c0128e62122440'), u('988bc5d290b97aef'), u('23c8c25c2ab72381'), u('450fe4acc4ad3749'),
    u('48e1eff032d90c50'), u('c048604ba8b6c753'), u('67ff1cbe469ebf84'), u('b45c7536bd7a5416'),
    u('215c2eaacdb48f6f'), u('241baf16d80e0fe8'), u('d10a9743b5b1c4d1'), u('919ef9e209f2edd1'),
    u('b5f9519b6c9280b'), u('77a75e89679e6757'), u('9d709e1b086aabe2'), u('91c89971b3c20a8a'),
    u('16468c55a1b3f2b4'), u('8015f298161f861e'), u('71e244d7e2843a41'), u('5d3cb0d2c7ccf11f'),
    u('d6cffe6c223aba65'), u('8a17c5054e85e2be'), u('77d112a0b7084c6a'), u('708f2a6e8bd57583'),
    u('50bc8f76b62c8de9'), u('8b15a656b553641a'), u('6ba74ccf722a52be'), u('fb317bb7533454d0'),
    u('8eec643f62c90fea'), u('81ce6becdf10dff2'), u('549c669fb0049f69'), u('2b6a3433940bbf2d'),
    u('d80b7a3c691401b7'), u('ab3bf6b494f66ef3'), u('83f7b824a3911d44'), u('3fb8d482d0d9d03f'),
    u('ad346a1f100b3944'), u('db210eb547a3dbc5'), u('e55fab4f920abdc0'), u('3b530fff7e848c5e'),
    u('bde3379279d1cae1'), u('4008062bc7755b37'), u('76a66ce0ee8094d1'), u('2bc3dfb3b1756918'),
    u('d060dc1e8ca204ee'), u('c8ec4fc839254a74'), u('7cdf98a07b1315b0'), u('78284cb5c0143ed8'),
    u('5c2c485bdc8e3317'), u('6e38acb798627f75'), u('c5fb48f0939b4878'), u('292da6390260110'),
    u('1e0ee26b7044741b'), u('69b8f7e762db77ec'), u('9b321366d6585031'), u('9375c89169bf70cf'),
    u('a8db1643cc52d94d'), u('cf7a9ea6a7a30dee'), u('42c2e9f84dc7f129'), u('394c2c1cca4e9271'),
    u('d38df9e9740cb16c'), u('ec12466d1379cfdf'), u('9050986d9ced6a2e'), u('c7362967930e8a48'),
    u('47bd8137d464eab3'), u('cff30d9303db2dfe'), u('8d086fc30b6694b2'), u('b7d681356bdd9e4f'),
    u('5bb01fcb2e6ad355'), u('cd2ff001a80d1b11'), u('8bfbf611401100cd'), u('ec9ae0cf9290d012'),
    u('4ac2a5e9dc03176d'), u('5fd51f635bc557a8'), u('ec3521e8efdb1779'), u('a9147f0fb2e38bb1'),
    u('a080e609751f2e81'), u('3bc578f69905fa2d'), u('9e6a5e0641d1c0d9'), u('83b0cdb3c934c679'),
    u('f174161497c5fa97'), u('d7262cb2f2755e70'), u('1444ce264e8784b7'), u('532e6b5c95a2e229'),
    u('183d112159f539eb'), u('8f18272400b3ace9'), u('43761e6a5f6f2fd6'), u('44f615fcd096fbfe'),
    u('27613f9db818cf78'), u('3f6984c7afaebd0b'), u('8fc511284f47c772'), u('15ae5f12f88592e2'),
    u('905f995bddf92cb7'), u('a23ac6bef8905fec'), u('403b94a75160a06b'), u('14d1ee05672fc19b'),
    u('f59376c617951a2a'), u('63982fdc37a9dc5'), u('eb480334ed838b48'), u('d0b9004efa0a1164'),
    u('b31f2b6cc2a15506'), u('4f9da8a709bec12f'), u('5504000602e6f8cf'), u('2d022d82f513a883'),
    u('a87268205997eddb'), u('fde5f0a803c3affc'), u('fa46e0e215c1aabd'), u('7e1f98b2c16f8b2b'),
    u('65a58d22d8665e60'), u('b781b9a55e7d6ab9'), u('a88c857b1aeb0835'), u('2a25994979124643'),
    u('17236ed61e669c6f'), u('304f56359ac375a8'), u('2e236ded6ce34194'), u('837ecb10d69f9bb9'),
    u('c94bc80993d726f2'), u('463b54729349357a'), u('52e298a69bc61248'), u('f31bde28294be223'),
    u('d1d98f3bbaf26f1e'), u('77969267e761a5e2'), u('763f1101a3d8e5d6'), u('b6ffcab942c26180'),
    u('65a85965268277a5'), u('6579248c4cabcf91'), u('fcea6deb6fbc95de'), u('a5afb4dac88f15f0'),
    u('35f437b7acbfd454'), u('8f45f63a2f2d77d5'), u('62258e6fe64ea749'), u('fc109f4192ba2587'),
    u('5364968136715e44'), u('dd84538848e07acb'), u('397d78f9c2fb2a8a'), u('a3a22aed573f4128'),
    u('94bcd5be64b0caf0'), u('81d9fe1f35fe8dc'), u('aa21f88e4310c4aa'), u('88e65c8bd8fd0dc3'),
    u('ee7c287c7a74eaf6'), u('59492bfd26df7a46'), u('79471e68a2e7b4c3'), u('f806f8b0f54bbbf4'),
    u('af0a9fa8d197fc2a'), u('a93491c935028bfd'), u('35fb344f57414e7e'), u('650c588ae7997006'),
    u('8e83c18ec4fac9b2'), u('35422c6582e3fa2e'), u('fc0cb7f55d516f4e'), u('e6245e6273cd7da4'),
    u('bfb40261b25b0146'), u('298876b240a1f937'), u('bf26833d8f21542e'), u('ff85120bd8fa3cd4'),
    u('a37277b9eb9b16fc'), u('b95c558eb132482f'), u('eb2a51b23ea2f82d'), u('c85dcc13ce7d29c0'),
    u('8a8707d80cb54c7a'), u('12c7ffecff1800ba'), u('cb16c5c1e342e34d'), u('27fddd06bd368c50'),
    u('5e6c6ee85cec7703'), u('2117190446b50f9d'), u('f3f12b62f51a9b55'), u('2ee01b9e2a7692a6'),
    u('53ca5e2da19191b7'), u('ce6d0917744faa2f'), u('f9b8ca6b46052208'), u('fb1cb91d94d6cddb'),
    u('a39e2eab5f174f15'), u('e9bfc7e088623326'), u('24d3561ce4eda075'), u('3edb299037e41adc'),
    u('4ccafed99120c34c'), u('811039d76b0f5c10'), u('f26eca16e4f6b311'), u('8ce51e30cf1501bb'),
    u('80d0fa7707773de4'), u('698d6cc716818773'), u('caaa5ff55032cbcf'), u('3333d53faadbec42'),
    u('10882aac3dd3587'), u('b11fde1059b22334'), u('8977ae72ed603d45'), u('f65b17f58e2f82f6'),
    u('63689bb426fad75'), u('f09d687ab01da414'), u('f9946308ce8bcec0'), u('5f2a932916c5c63f'),
    u('3a7933b10ff2e831'), u('41f45d562a6689b'), u('bcec7d59b5858e63'), u('82ea92d6830c37ad'),
    u('27cc4624e3a8fd6c'), u('bfa129745aeb3923'), u('9b19fb3f08515329'), u('b944c2c819b2038d'),
    u('6e8d2803df3b267a'), u('a5ed64048af45d9d'), u('6d56acb61a9abe8e'), u('4f03f6750128b16f'),
    u('6e717510c8e732c4'), u('6167f57448c6559b'), u('4c445bb3cc5dc033'), u('3d63ec327c84a0bf'),
    u('eab5f4a8d3ec6334'), u('1ffad87ddc8ca76a'), u('fcc3b1db7bb174a0'), u('cffe79062bb4e7cd'),
    u('a21717e2b3d282ee'), u('7e4143da4d878be5'), u('23b80b8bc4e75405'), u('a6ae749a1ed10838'),
    u('d4b4a81be36638f2'), u('5bab2890f354896d'), u('4c0a184632b0499a'), u('b45a39714746ec86'),
    u('c4b90839e91abfb2'), u('e81d35c8ed7827fe'), u('587c5ee43e034ebd'), u('b1ec87f8823040ac'),
    u('7677dff12f92fbd9'), u('b69cea6e5a0e28fd'), u('f7180ae2e0f325e5'), u('a08d214869e84ccf'),
    u('cfff666740e2f99f'), u('2fc743551c71634e'), u('9bf4d77b464c9435'), u('5e6b758083214c84'),
    u('40548138ef68aa78'), u('7c6b73ef50249070'), u('462a1dc5b9cb1b3b'), u('b8b156aa6c884b21'),
    u('c7afcc722488f9e6'), u('7a45b5b10dc24dbc'), u('efe499d7a567391d'), u('b60d26b461d05e25'),
    u('c15d366b98d92986'), u('9addb551a523df05'), u('bd0a37a2ad2465b9'), u('e7a7162d930c5056'),
    u('b9982c5395b09406'), u('e41766d004eef8fd'), u('a3074a96c88c47de'), u('881caa3913271394'),
    u('77d95a600f824230'), u('1984adb7bcfec495'), u('66f613698d2263a7'), u('50cf2a1c284f5a5a'),
];

function u(string $hex): int
{
    return unpack("J", hex2bin(str_pad($hex, 16, '0', STR_PAD_LEFT)))[1];
}

function add(int $a, int $b): int
{
    $sum = ~PHP_INT_MAX + ($a & PHP_INT_MAX) + ($b & PHP_INT_MAX);
    return ($a ^ $b) < 0 ? $sum : $sum ^ ~PHP_INT_MAX;
}

function mul(int $a, int $b): int
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

function createData(int $dataSize): string
{
    $k = -4348849565147123417;
    $a = 9;
    $b = 777;
    $data = '';
    for ($i = 0; $i < $dataSize; $i++) {
        $a = add(mul($a ^ $a >> 41 & PHP_INT_MAX >> 40, $k), $b);
        $b = add(mul($b ^ $b >> 41 & PHP_INT_MAX >> 40, $k), $i);
        $u = $b >> 37 & PHP_INT_MAX >> 36;
        $data .= chr($u & 0xFF);
    }
    return $data;
}

function test(string $data, int $expected, int $offset, int $len): bool
{
    $actual = CityHash\CityHash102::cityHash64($data, $offset, $len);
    if ($expected !== $actual) {
        printf("ERROR: expected 0x%s, but got 0x%s\n", dechex($expected), dechex($actual));
        return true;
    }
    return false;
}

$errors = 0;
$dataSize = 1 << 20;
$data = createData($dataSize);

$t0 = microtime(true);
$testSize = count($testData);
for ($i = 0; $i < $testSize - 1; $i++) {
    $errors += test($data, $testData[$i], $i * $i, $i);
}
$errors += test($data, $testData[$i], 0, $dataSize);
printf("Done in %f sec\n", microtime(true) - $t0);
$errors ? printf("ERROR: %s tests => %d failed\n", $testSize, $errors) : printf("OK\n");
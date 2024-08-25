<?php

namespace UnitTests\DataSources;

use Coloreeze\ColorCIELab;
use Coloreeze\ColorCMYK;
use Coloreeze\ColorHex;
use Coloreeze\ColorHSB;
use Coloreeze\ColorHSL;
use Coloreeze\ColorInt;
use Coloreeze\ColorRGBA;
use Coloreeze\ColorXYZ;

return [
    'toString' => [
        [new ColorRGBA(95, 158, 160), 'rgba(95,158,160,1)'],
        [new ColorRGBA(144, 238, 144), 'rgba(144,238,144,1)'],
        [new ColorRGBA(255, 140, 0), 'rgba(255,140,0,1)'],
        [new ColorRGBA(32, 178, 170), 'rgba(32,178,170,1)'],
        [new ColorRGBA(143, 188, 143), 'rgba(143,188,143,1)'],
        [new ColorRGBA(255, 0, 255), 'rgba(255,0,255,1)'],
        [new ColorRGBA(119, 136, 153), 'rgba(119,136,153,1)'],
        [new ColorRGBA(128, 0, 128), 'rgba(128,0,128,1)'],
        [new ColorRGBA(0, 255, 255), 'rgba(0,255,255,1)'],
        [new ColorRGBA(186, 85, 211), 'rgba(186,85,211,1)'],
        [new ColorRGBA(0, 0, 0), 'rgba(0,0,0,1)'],
        [new ColorRGBA(255, 255, 255), 'rgba(255,255,255,1)'],
    ],
    'toHex' => [
        [new ColorRGBA(95, 158, 160), new ColorHex('#5F9EA0FF')],
        [new ColorRGBA(144, 238, 144), new ColorHex('#90EE90FF')],
        [new ColorRGBA(255, 140, 0), new ColorHex('#FF8C00FF')],
        [new ColorRGBA(32, 178, 170), new ColorHex('#20B2AAFF')],
        [new ColorRGBA(143, 188, 143), new ColorHex('#8FBC8FFF')],
        [new ColorRGBA(255, 0, 255), new ColorHex('#FF00FFFF')],
        [new ColorRGBA(119, 136, 153), new ColorHex('#778899FF')],
        [new ColorRGBA(128, 0, 128), new ColorHex('#800080FF')],
        [new ColorRGBA(0, 255, 255), new ColorHex('#00FFFFFF')],
        [new ColorRGBA(186, 85, 211), new ColorHex('#BA55D3FF')],
        [new ColorRGBA(0, 0, 0), new ColorHex('#000000FF')],
        [new ColorRGBA(255, 255, 255), new ColorHex('#FFFFFFFF')],
    ],
    'toInt' => [
        [new ColorRGBA(95, 158, 160), new ColorInt(1604231423)],
        [new ColorRGBA(144, 238, 144), new ColorInt(2431553791)],
        [new ColorRGBA(255, 140, 0), new ColorInt(4287365375)],
        [new ColorRGBA(32, 178, 170), new ColorInt(548580095)],
        [new ColorRGBA(143, 188, 143), new ColorInt(2411499519)],
        [new ColorRGBA(255, 0, 255), new ColorInt(4278255615)],
        [new ColorRGBA(119, 136, 153), new ColorInt(2005441023)],
        [new ColorRGBA(128, 0, 128), new ColorInt(2147516671)],
        [new ColorRGBA(0, 255, 255), new ColorInt(16777215)],
        [new ColorRGBA(186, 85, 211), new ColorInt(3126187007)],
        [new ColorRGBA(0, 0, 0), new ColorInt(255)],
        [new ColorRGBA(255, 255, 255), new ColorInt(4294967295)],
    ],
    'toRGBA' => [
        [new ColorRGBA(95, 158, 160), new ColorRGBA(95, 158, 160)],
        [new ColorRGBA(144, 238, 144), new ColorRGBA(144, 238, 144)],
        [new ColorRGBA(255, 140, 0), new ColorRGBA(255, 140, 0)],
        [new ColorRGBA(32, 178, 170), new ColorRGBA(32, 178, 170)],
        [new ColorRGBA(143, 188, 143), new ColorRGBA(143, 188, 143)],
        [new ColorRGBA(255, 0, 255), new ColorRGBA(255, 0, 255)],
        [new ColorRGBA(119, 136, 153), new ColorRGBA(119, 136, 153)],
        [new ColorRGBA(128, 0, 128), new ColorRGBA(128, 0, 128)],
        [new ColorRGBA(0, 255, 255), new ColorRGBA(0, 255, 255)],
        [new ColorRGBA(186, 85, 211), new ColorRGBA(186, 85, 211)],
        [new ColorRGBA(0, 0, 0), new ColorRGBA(0, 0, 0)],
        [new ColorRGBA(255, 255, 255), new ColorRGBA(255, 255, 255)],
    ],
    'toCMYK' => [
        [new ColorRGBA(95, 158, 160), new ColorCMYK(0.4063, 0.0125, 0.0000, 0.3725)],
        [new ColorRGBA(144, 238, 144), new ColorCMYK(0.3950, 0.0000, 0.3950, 0.0667)],
        [new ColorRGBA(255, 140, 0), new ColorCMYK(0.0000, 0.4510, 1.0000, 0.0000)],
        [new ColorRGBA(32, 178, 170), new ColorCMYK(0.8202, 0.0000, 0.0449, 0.3020)],
        [new ColorRGBA(143, 188, 143), new ColorCMYK(0.2394, 0.0000, 0.2394, 0.2627)],
        [new ColorRGBA(255, 0, 255), new ColorCMYK(0.0000, 1.0000, 0.0000, 0.0000)],
        [new ColorRGBA(119, 136, 153), new ColorCMYK(0.2222, 0.1111, 0.0000, 0.4000)],
        [new ColorRGBA(128, 0, 128), new ColorCMYK(0.0000, 1.0000, 0.0000, 0.4980)],
        [new ColorRGBA(0, 255, 255), new ColorCMYK(1.0000, 0.0000, 0.0000, 0.0000)],
        [new ColorRGBA(186, 85, 211), new ColorCMYK(0.1185, 0.5972, 0.0000, 0.1725)],
        [new ColorRGBA(0, 0, 0), new ColorCMYK(0.0000, 0.0000, 0.0000, 1.0000)],
        [new ColorRGBA(255, 255, 255), new ColorCMYK(0.0000, 0.0000, 0.0000, 0.0000)],
    ],
    'toHSL' => [
        [new ColorRGBA(95, 158, 160), new ColorHSL(182, 25, 50)],
        [new ColorRGBA(144, 238, 144), new ColorHSL(120, 73, 75)],
        [new ColorRGBA(255, 140, 0), new ColorHSL(33, 100, 50)],
        [new ColorRGBA(32, 178, 170), new ColorHSL(177, 70, 41)],
        [new ColorRGBA(143, 188, 143), new ColorHSL(120, 25, 65)],
        [new ColorRGBA(255, 0, 255), new ColorHSL(300, 100, 50)],
        [new ColorRGBA(119, 136, 153), new ColorHSL(210, 14, 53)],
        [new ColorRGBA(128, 0, 128), new ColorHSL(300, 100, 25)],
        [new ColorRGBA(0, 255, 255), new ColorHSL(180, 100, 50)],
        [new ColorRGBA(186, 85, 211), new ColorHSL(288, 59, 58)],
        [new ColorRGBA(0, 0, 0), new ColorHSL(0, 0, 0)],
        [new ColorRGBA(255, 255, 255), new ColorHSL(0, 0, 100)],
    ],
    'toXYZ' => [
        [new ColorRGBA(95, 158, 160), new ColorXYZ(23.2913, 29.4247, 37.7097)],
        [new ColorRGBA(144, 238, 144), new ColorXYZ(47.1102, 69.0920, 37.2387)],
        [new ColorRGBA(255, 140, 0), new ColorXYZ(50.6181, 40.0162, 5.0560)],
        [new ColorRGBA(32, 178, 170), new ColorXYZ(23.7718, 35.0501, 43.5427)],
        [new ColorRGBA(143, 188, 143), new ColorXYZ(34.2688, 43.7892, 32.6326)],
        [new ColorRGBA(255, 0, 255), new ColorXYZ(59.2900, 28.4800, 96.9800)],
        [new ColorRGBA(119, 136, 153), new ColorXYZ(22.1617, 23.8302, 33.5686)],
        [new ColorRGBA(128, 0, 128), new ColorXYZ(12.7984, 6.1477, 20.9342)],
        [new ColorRGBA(0, 255, 255), new ColorXYZ(53.8100, 78.7400, 106.9700)],
        [new ColorRGBA(186, 85, 211), new ColorXYZ(35.2561, 21.6393, 63.9466)],
        [new ColorRGBA(0, 0, 0), new ColorXYZ(0.0000, 0.0000, 0.0000)],
        [new ColorRGBA(255, 255, 255), new ColorXYZ(95.0470, 100.0000, 108.8830)],
    ],
    'toHSB' => [
        [new ColorRGBA(95, 158, 160), new ColorHSB(181.8462, 40.6250, 62.7451)],
        [new ColorRGBA(144, 238, 144), new ColorHSB(120.0000, 39.4958, 93.3333)],
        [new ColorRGBA(255, 140, 0), new ColorHSB(32.9412, 100.0000, 100.0000)],
        [new ColorRGBA(32, 178, 170), new ColorHSB(176.7123, 82.0225, 69.8039)],
        [new ColorRGBA(143, 188, 143), new ColorHSB(120.0000, 23.9362, 73.7255)],
        [new ColorRGBA(255, 0, 255), new ColorHSB(300.0000, 100.0000, 100.0000)],
        [new ColorRGBA(119, 136, 153), new ColorHSB(210.0000, 22.2222, 60.0000)],
        [new ColorRGBA(128, 0, 128), new ColorHSB(300.0000, 100.0000, 50.1961)],
        [new ColorRGBA(0, 255, 255), new ColorHSB(180.0000, 100.0000, 100.0000)],
        [new ColorRGBA(186, 85, 211), new ColorHSB(288.0952, 59.7156, 82.7451)],
        [new ColorRGBA(0, 0, 0), new ColorHSB(0.0000, 0.0000, 0.0000)],
        [new ColorRGBA(255, 255, 255), new ColorHSB(0.0000, 0.0000, 100.0000)],
    ],
    'toCIELab' => [
        [new ColorRGBA(95, 158, 160), new ColorCIELab(61.1546, -19.6754, -7.4267)],
        [new ColorRGBA(144, 238, 144), new ColorCIELab(86.5496, -46.3276, 36.9449)],
        [new ColorRGBA(255, 140, 0), new ColorCIELab(69.4811, 36.8308, 75.4949)],
        [new ColorRGBA(32, 178, 170), new ColorCIELab(65.7877, -37.5083, -6.3362)],
        [new ColorRGBA(143, 188, 143), new ColorCIELab(72.0874, -23.8179, 18.0323)],
        [new ColorRGBA(255, 0, 255), new ColorCIELab(60.3199, 98.2542, -60.843)],
        [new ColorRGBA(119, 136, 153), new ColorCIELab(55.9174, -2.2433, -11.1146)],
        [new ColorRGBA(128, 0, 128), new ColorCIELab(29.7821, 58.9401, -36.498)],
        [new ColorRGBA(0, 255, 255), new ColorCIELab(91.1165, -48.0796, -14.1381)],
        [new ColorRGBA(186, 85, 211), new ColorCIELab(53.6422, 59.0725, -47.4148)],
        [new ColorRGBA(0, 0, 0), new ColorCIELab(0.0000, 0.0000, 0.0000)],
        [new ColorRGBA(255, 255, 255), new ColorCIELab(100.0000, 0.0000, 0.0000)],
    ],
    'toGreyscale' => [
        [new ColorRGBA(95, 158, 160), new ColorRGBA(138, 138, 138)],
        [new ColorRGBA(144, 238, 144), new ColorRGBA(175, 175, 175)],
        [new ColorRGBA(255, 140, 0), new ColorRGBA(132, 132, 132)],
        [new ColorRGBA(32, 178, 170), new ColorRGBA(127, 127, 127)],
        [new ColorRGBA(143, 188, 143), new ColorRGBA(158, 158, 158)],
        [new ColorRGBA(255, 0, 255), new ColorRGBA(170, 170, 170)],
        [new ColorRGBA(119, 136, 153), new ColorRGBA(136, 136, 136)],
        [new ColorRGBA(128, 0, 128), new ColorRGBA(85, 85, 85)],
        [new ColorRGBA(0, 255, 255), new ColorRGBA(170, 170, 170)],
        [new ColorRGBA(186, 85, 211), new ColorRGBA(161, 161, 161)],
        [new ColorRGBA(0, 0, 0), new ColorRGBA(0, 0, 0)],
        [new ColorRGBA(255, 255, 255), new ColorRGBA(255, 255, 255)],
    ],
    'toComplementary' => [
        [new ColorRGBA(95, 158, 160), new ColorRGBA(160, 97, 95)],
        [new ColorRGBA(144, 238, 144), new ColorRGBA(111, 17, 111)],
        [new ColorRGBA(255, 140, 0), new ColorRGBA(0, 115, 255)],
        [new ColorRGBA(32, 178, 170), new ColorRGBA(223, 77, 85)],
        [new ColorRGBA(143, 188, 143), new ColorRGBA(112, 67, 112)],
        [new ColorRGBA(255, 0, 255), new ColorRGBA(0, 255, 0)],
        [new ColorRGBA(119, 136, 153), new ColorRGBA(136, 119, 102)],
        [new ColorRGBA(128, 0, 128), new ColorRGBA(127, 255, 127)],
        [new ColorRGBA(0, 255, 255), new ColorRGBA(255, 0, 0)],
        [new ColorRGBA(186, 85, 211), new ColorRGBA(69, 170, 44)],
        [new ColorRGBA(0, 0, 0), new ColorRGBA(255, 255, 255)],
        [new ColorRGBA(255, 255, 255), new ColorRGBA(0, 0, 0)],
    ],
    'toDarker' => [
        [new ColorRGBA(95, 158, 160), new ColorRGBA(70, 133, 135)],
        [new ColorRGBA(144, 238, 144), new ColorRGBA(119, 213, 119)],
        [new ColorRGBA(255, 140, 0), new ColorRGBA(230, 115, 0)],
        [new ColorRGBA(32, 178, 170), new ColorRGBA(7, 153, 145)],
        [new ColorRGBA(143, 188, 143), new ColorRGBA(118, 163, 118)],
        [new ColorRGBA(255, 0, 255), new ColorRGBA(230, 0, 230)],
        [new ColorRGBA(119, 136, 153), new ColorRGBA(94, 111, 128)],
        [new ColorRGBA(128, 0, 128), new ColorRGBA(103, 0, 103)],
        [new ColorRGBA(0, 255, 255), new ColorRGBA(0, 230, 230)],
        [new ColorRGBA(186, 85, 211), new ColorRGBA(161, 60, 186)],
        [new ColorRGBA(0, 0, 0), new ColorRGBA(0, 0, 0)],
        [new ColorRGBA(255, 255, 255), new ColorRGBA(230, 230, 230)],
    ],
    'toLighter' => [
        [new ColorRGBA(95, 158, 160), new ColorRGBA(120, 183, 185)],
        [new ColorRGBA(144, 238, 144), new ColorRGBA(169, 255, 169)],
        [new ColorRGBA(255, 140, 0), new ColorRGBA(255, 165, 25)],
        [new ColorRGBA(32, 178, 170), new ColorRGBA(57, 203, 195)],
        [new ColorRGBA(143, 188, 143), new ColorRGBA(168, 213, 168)],
        [new ColorRGBA(255, 0, 255), new ColorRGBA(255, 25, 255)],
        [new ColorRGBA(119, 136, 153), new ColorRGBA(144, 161, 178)],
        [new ColorRGBA(128, 0, 128), new ColorRGBA(153, 25, 153)],
        [new ColorRGBA(0, 255, 255), new ColorRGBA(25, 255, 255)],
        [new ColorRGBA(186, 85, 211), new ColorRGBA(211, 110, 236)],
        [new ColorRGBA(0, 0, 0), new ColorRGBA(25, 25, 25)],
        [new ColorRGBA(255, 255, 255), new ColorRGBA(255, 255, 255)],
    ],
];

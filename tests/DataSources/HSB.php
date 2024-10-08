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
        [new ColorHSB(181.8462, 40.6250, 62.7451), 'hsb(182,41%,63%)'],
        [new ColorHSB(120.0000, 39.4958, 93.3333), 'hsb(120,39%,93%)'],
        [new ColorHSB(32.9412, 100.0000, 100.0000), 'hsb(33,100%,100%)'],
        [new ColorHSB(176.7123, 82.0225, 69.8039), 'hsb(177,82%,70%)'],
        [new ColorHSB(120.0000, 23.9362, 73.7255), 'hsb(120,24%,74%)'],
        [new ColorHSB(300.0000, 100.0000, 100.0000), 'hsb(300,100%,100%)'],
        [new ColorHSB(210.0000, 22.2222, 60.0000), 'hsb(210,22%,60%)'],
        [new ColorHSB(300.0000, 100.0000, 50.1961), 'hsb(300,100%,50%)'],
        [new ColorHSB(180.0000, 100.0000, 100.0000), 'hsb(180,100%,100%)'],
        [new ColorHSB(288.0952, 59.7156, 82.7451), 'hsb(288,60%,83%)'],
        [new ColorHSB(0.0000, 0.0000, 0.0000), 'hsb(0,0%,0%)'],
        [new ColorHSB(0.0000, 0.0000, 100.0000), 'hsb(0,0%,100%)'],
    ],
    'toHex' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorHex('#5F9EA0')],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorHex('#90EE90')],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorHex('#FF8C00')],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorHex('#20B2AA')],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorHex('#8FBC8F')],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorHex('#FF00FF')],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorHex('#778899')],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorHex('#800080')],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorHex('#00FFFF')],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorHex('#BA55D3')],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorHex('#000000')],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorHex('#FFFFFF')],
    ],
    'toInt' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorInt(1604231423)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorInt(2431553791)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorInt(4287365375)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorInt(548580095)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorInt(2411499519)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorInt(4278255615)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorInt(2005441023)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorInt(2147516671)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorInt(16777215)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorInt(3126187007)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorInt(255)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorInt(4294967295)],
    ],
    'toRGBA' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorRGBA(95, 158, 160)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorRGBA(144, 238, 144)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorRGBA(255, 140, 0)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorRGBA(32, 178, 170)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorRGBA(143, 188, 143)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorRGBA(255, 0, 255)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorRGBA(119, 136, 153)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorRGBA(128, 0, 128)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorRGBA(0, 255, 255)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorRGBA(186, 85, 211)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorRGBA(0, 0, 0)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorRGBA(255, 255, 255)],

        // EXTRA
        [new ColorHSB(60, 100, 39.2), new ColorRGBA(100, 100, 0)],
    ],
    'toCMYK' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorCMYK(0.4063, 0.0125, 0.0000, 0.3725)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorCMYK(0.3950, 0.0000, 0.3950, 0.0667)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorCMYK(0.0000, 0.4510, 1.0000, 0.0000)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorCMYK(0.8202, 0.0000, 0.0449, 0.3020)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorCMYK(0.2394, 0.0000, 0.2394, 0.2627)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorCMYK(0.0000, 1.0000, 0.0000, 0.0000)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorCMYK(0.2222, 0.1111, 0.0000, 0.4000)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorCMYK(0.0000, 1.0000, 0.0000, 0.4980)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorCMYK(1.0000, 0.0000, 0.0000, 0.0000)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorCMYK(0.1185, 0.5972, 0.0000, 0.1725)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorCMYK(0, 0, 0, 1)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorCMYK(0.0000, 0.0000, 0.0000, 0.0000)],
    ],
    'toHSL' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorHSL(182, 25, 50)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorHSL(120, 73, 75)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorHSL(33, 100, 50)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorHSL(177, 70, 41)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorHSL(120, 25, 65)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorHSL(300, 100, 50)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorHSL(210, 14, 53)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorHSL(300, 100, 25)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorHSL(180, 100, 50)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorHSL(288, 59, 58)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorHSL(0, 0, 0)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorHSL(0, 0, 100)],
    ],
    'toXYZ' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorXYZ(23.2913, 29.4247, 37.7097)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorXYZ(47.1102, 69.0920, 37.2387)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorXYZ(50.6181, 40.0162, 5.0560)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorXYZ(23.7718, 35.0501, 43.5427)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorXYZ(34.2688, 43.7892, 32.6326)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorXYZ(59.2900, 28.4800, 96.9800)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorXYZ(22.1617, 23.8302, 33.5686)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorXYZ(12.7984, 6.1477, 20.9342)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorXYZ(53.8100, 78.7400, 106.9700)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorXYZ(35.2561, 21.6393, 63.9466)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorXYZ(0.0000, 0.0000, 0.0000)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorXYZ(95.047, 100.0, 108.883)],
    ],
    'toHSB' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorHSB(181.8462, 40.6250, 62.7451)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorHSB(120.0000, 39.4958, 93.3333)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorHSB(32.9412, 100.0000, 100.0000)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorHSB(176.7123, 82.0225, 69.8039)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorHSB(120.0000, 23.9362, 73.7255)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorHSB(300.0000, 100.0000, 100.0000)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorHSB(210.0000, 22.2222, 60.0000)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorHSB(300.0000, 100.0000, 50.1961)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorHSB(180.0000, 100.0000, 100.0000)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorHSB(288.0952, 59.7156, 82.7451)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorHSB(0.0000, 0.0000, 0.0000)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorHSB(0.0000, 0.0000, 100.0000)],
    ],
    'toCIELab' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorCIELab(61.1546, -19.6754, -7.4267)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorCIELab(86.5496, -46.3276, 36.9449)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorCIELab(69.4811, 36.8308, 75.4949)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorCIELab(65.7877, -37.5083, -6.3362)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorCIELab(72.0874, -23.8179, 18.0323)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorCIELab(60.3199, 98.2542, -60.843)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorCIELab(55.9174, -2.2433, -11.1146)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorCIELab(29.7821, 58.9401, -36.498)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorCIELab(91.1165, -48.0796, -14.1381)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorCIELab(53.6422, 59.0725, -47.4148)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorCIELab(0.0000, 0.0000, 0.0000)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorCIELab(100.0000, 0.0000, 0.0000)],
    ],
    'toGreyscale' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorHSB(0, 0, 54.1176)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorHSB(0, 0, 68.6275)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorHSB(0, 0, 51.7647)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorHSB(0, 0, 49.8039)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorHSB(0, 0, 61.9608)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorHSB(0, 0, 66.6667)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorHSB(0, 0, 53.3333)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorHSB(0, 0, 33.3333)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorHSB(0, 0, 66.6667)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorHSB(0, 0, 63.1373)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorHSB(0, 0, 0.0000)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorHSB(0, 0, 100.0000)],
    ],
    'toComplementary' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorHSB(1.8462, 40.625, 62.7451)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorHSB(300.0, 84.6847, 43.5294)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorHSB(212.9412, 100.0, 100.0)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorHSB(356.7123, 65.4709, 87.451)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorHSB(300, 40.1786, 43.9216)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorHSB(120, 100, 100)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorHSB(30, 25, 53.3333)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorHSB(120.0, 50.1961, 100.0)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorHSB(0, 100, 100)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorHSB(108.0952, 74.1176, 66.6667)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorHSB(0, 0, 100.0000)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorHSB(0, 0, 0.0000)],
    ],
    'toDarker' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorHSB(181.8462, 48.1481, 52.9412)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorHSB(120.0000, 44.1315, 83.5294)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorHSB(30.0000, 100.0000, 90.1961)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorHSB(176.7123, 95.4248, 60.0000)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorHSB(120.0000, 27.6074, 63.9216)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorHSB(300.0000, 100.0000, 90.1961)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorHSB(210.0000, 26.5625, 50.1961)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorHSB(300.0000, 100.0000, 40.3922)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorHSB(180.0000, 100.0000, 90.1961)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorHSB(288.0952, 67.7419, 72.9412)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorHSB(0.0000, 0.0000, 0.0000)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorHSB(0.0000, 0.0000, 90.1961)],
    ],
    'toLighter' => [
        [new ColorHSB(181.8462, 40.6250, 62.7451), new ColorHSB(181.8462, 35.1351, 72.549)],
        [new ColorHSB(120.0000, 39.4958, 93.3333), new ColorHSB(120.0000, 33.7255, 100.0000)],
        [new ColorHSB(32.9412, 100.0000, 100.0000), new ColorHSB(36.5217, 90.1961, 100.0000)],
        [new ColorHSB(176.7123, 82.0225, 69.8039), new ColorHSB(176.7123, 71.9212, 79.6078)],
        [new ColorHSB(120.0000, 23.9362, 73.7255), new ColorHSB(120.0000, 21.1268, 83.5294)],
        [new ColorHSB(300.0000, 100.0000, 100.0000), new ColorHSB(300.0000, 90.1961, 100.0000)],
        [new ColorHSB(210.0000, 22.2222, 60.0000), new ColorHSB(210.0000, 19.1011, 69.8039)],
        [new ColorHSB(300.0000, 100.0000, 50.1961), new ColorHSB(300.0000, 83.6601, 60.0000)],
        [new ColorHSB(180.0000, 100.0000, 100.0000), new ColorHSB(180.0000, 90.1961, 100.0000)],
        [new ColorHSB(288.0952, 59.7156, 82.7451), new ColorHSB(288.0952, 53.3898, 92.549)],
        [new ColorHSB(0.0000, 0.0000, 0.0000), new ColorHSB(0.0000, 0.0000, 9.8039)],
        [new ColorHSB(0.0000, 0.0000, 100.0000), new ColorHSB(0.0000, 0.0000, 100.0000)],
    ],
];

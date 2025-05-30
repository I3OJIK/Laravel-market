<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            ['category_id' => '1', 'name' => 'Apple iPhone 14', 'description' => 'Apple iPhone 14 оснащён 6.1″ Super Retina XDR OLED-дисплеем, чипом A15 Bionic, двойной 12 МП камера-системой (широкоугольная и ультраширокая), поддержкой MagSafe и Ceramic Shield. Аккумулятор держит до 20 ч видео. Корпус — авиационный алюминий, защита IP68.', 'price' => 799],
            ['category_id' => '1', 'name' => 'Samsung Galaxy S23', 'description' => 'Samsung Galaxy S23 получил 6.1″ Dynamic AMOLED 2X экран с частотой 120 Гц, процессор Snapdragon 8 Gen 2, тройную камеру (50 МП основная, 12 МП ультраширокая, 10 МП телеобъектив), оптическую стабилизацию, батарею 3900 mAh и быструю зарядку 25 Вт.', 'price' => 749],
            ['category_id' => '2', 'name' => 'Google Pixel 7', 'description' => 'Google Pixel 7 оборудован 6.3″ OLED-дисплеем, фирменным чипом Google Tensor G2, двойной камерой 50 МП+12 МП с функциями ночного и астрофото, Android 13 «чистый» от Google, встроенным Titan M2 для защиты данных и батареей 4355 mAh.', 'price' => 599],
            ['category_id' => '3', 'name' => 'Sony WH-1000XM5', 'description' => 'Беспроводные наушники Sony WH-1000XM5 с лидирующим в отрасли активным шумоподавлением, 30 ч автономии, поддержкой LDAC, адаптивным звуком, сенсорным управлением, прозрачным режимом и комфортной посадкой с автопаузы при снятии.', 'price' => 349],
            ['category_id' => '4', 'name' => 'Bose QuietComfort Earbuds II', 'description' => 'Вакуумные наушники Bose QC Earbuds II с технологией Active Noise Cancelling, до 6 ч воспроизведения, до 24 ч с кейсом, адаптивной эквализацией, IPX4 влагозащитой и сенсорным управлением.', 'price' => 279],
            ['category_id' => '1', 'name' => 'Dell XPS 13', 'description' => 'Ноутбук Dell XPS 13: 13.4″ FHD+ InfinityEdge, Intel Core i7-1260P, 16 GB LPDDR5, 512 GB PCIe SSD, Intel Iris Xe Graphics, тонкий алюминиевый корпус, сканер отпечатка, Thunderbolt 4 и Wi-Fi 6E.', 'price' => 1099],
            ['category_id' => '4', 'name' => 'MacBook Air M2', 'description' => 'Apple MacBook Air M2: 13.6″ Liquid Retina, Apple M2 чип с 8-ядерным CPU и 8-ядерным GPU, 8 GB unified RAM, 256 GB SSD, MagSafe, два Thunderbolt 4 порта, до 18 ч автономии, вентилятор-less дизайн.', 'price' => 1199],
            ['category_id' => '1', 'name' => 'HP Spectre x360', 'description' => 'HP Spectre x360 2-в-1: 13.3″ FHD Touch, Intel Core i5-1240P, 8 GB RAM, 256 GB SSD, поворотный на 360° сенсорный экран, сканер отпечатка, поддержка HP Pen, Thunderbolt 4.', 'price' => 999],
            ['category_id' => '2', 'name' => 'Asus ROG Strix G15', 'description' => 'Игровой ноутбук Asus ROG Strix G15: 15.6″ QHD 165 Гц, AMD Ryzen 7 6800H, NVIDIA RTX 3060 6 GB, 16 GB DDR5, 1 TB PCIe SSD, улучшенное охлаждение и RGB-подсветка.', 'price' => 1499],
            ['category_id' => '3', 'name' => 'Lenovo ThinkPad X1 Carbon', 'description' => 'Lenovo ThinkPad X1 Carbon Gen 10: 14″ UHD Touch, Intel Core i7-1260P, 16 GB RAM, 1 TB SSD, MIL-STD-810G, сканер отпечатка, клавиатура TrackPoint и до 15 ч автономии.', 'price' => 1299],
            ['category_id' => '4', 'name' => 'Canon EOS R10', 'description' => 'Беззеркальная камера Canon EOS R10: 24.2 MP APS-C CMOS, DIGIC X, 4K 30p/6K oversample видео, Dual Pixel AF II, 15 fps серийная съемка, встроенный EVF и поворотный экран.', 'price' => 979],
            ['category_id' => '1', 'name' => 'Sony α7 IV', 'description' => 'Sony α7 IV: 33 MP полнокадровый BSI-CMOS, BIONZ XR, 4K/60p, 10-бит S-Log3 HLG, 759 точек фазового AF, 10 fps, 5-осевая стабилизация до 5.5 ступеней, улучшенный EVF.', 'price' => 2499],
            ['category_id' => '2', 'name' => 'Nikon Z50', 'description' => 'Nikon Z50: 20.9 MP DX-формат, EXPEED 6, 4K UHD/30p видео без кропа, гибридный AF с 209 точками, встроенный микрофонный вход, поворотный экран и компактный корпус.', 'price' => 859],
            ['category_id' => '3', 'name' => 'GoPro HERO11 Black', 'description' => 'Экшн-камера GoPro HERO11 Black: 5.3K/60fps, HyperSmooth 5.0, HindSight, TimeWarp 3.0, водонепроницаемость до 10 м, улучшенный динамический диапазон и фронтальный дисплей.', 'price' => 399],
            ['category_id' => '4', 'name' => 'DJI Mini 3 Pro', 'description' => 'Дрон DJI Mini 3 Pro: вес <249 г, 4K/60fps видео, 48 MP фото, Dual-Native ISO, до 34 мин полёта, три сенсора обхода препятствий, вертикальная съемка.', 'price' => 759],
            ['category_id' => '4', 'name' => 'Apple Watch Series 8', 'description' => 'Apple Watch Series 8: дисплей Always-On Retina, датчик температуры тела, ECG, Fall Detection, до 18 ч автономии, GPS, водозащита 50 м, семейный доступ.', 'price' => 399],
            ['category_id' => '2', 'name' => 'Samsung Galaxy Watch5', 'description' => 'Samsung Galaxy Watch5: 40 mm, AMOLED, BioActive Sensor (ECG, PPG, BIA), GPS, до 50 ч работы, быстрая зарядка и интеграция с Samsung Health.', 'price' => 279],
            ['category_id' => '3', 'name' => 'Fitbit Charge 5', 'description' => 'Фитнес-трекер Fitbit Charge 5: цветной AMOLED дисплей, встроенный GPS, EDA Scan, ECG, SpO₂, до 7 дн автономии, мониторинг сна и стресса.', 'price' => 149],
            ['category_id' => '2', 'name' => 'Kindle Paperwhite (11-gen)', 'description' => 'Amazon Kindle Paperwhite 11-го поколения: 6.8″ glare-free, adjustable warm light, waterproof IPX8, 8 GB, до 10 нед чтения.', 'price' => 129],
            ['category_id' => '2', 'name' => 'Samsung T7 Touch', 'description' => 'Портативный SSD Samsung T7 Touch: 1 TB, USB 3.2 Gen 2, до 1050 MB/s, встроенный сканер отпечатка, легкий алюминиевый корпус.', 'price' => 179],
            ['category_id' => '4', 'name' => 'Seagate Backup Plus 4TB', 'description' => 'Внешний HDD Seagate Backup Plus: 4 TB, USB 3.0, до 136 MB/s, комплект ПО для резервного копирования и совместимость с Mac/Windows.', 'price' => 99],
            ['category_id' => '4', 'name' => 'SanDisk Ultra microSDXC 64GB', 'description' => 'Карта памяти SanDisk Ultra microSDXC 64 GB, Class 10, UHS-I, A1 для быстрой загрузки приложений, до 120 MB/s чтения.', 'price' => 19],
            ['category_id' => '3', 'name' => 'Logitech MX Master 3', 'description' => 'Беспроволчная мышь Logitech MX Master 3: MagSpeed Scroll, 4000 DPI, до 70 дн работы, эргономичный дизайн и три сменных устройства.', 'price' => 99],
            ['category_id' => '3', 'name' => 'Razer BlackWidow V3', 'description' => 'Механическая клавиатура Razer BlackWidow V3: зелёные переключатели Razer, RGB Chroma, N-Key rollover, USB Passthrough, алюминиевая рамка.', 'price' => 139],
            ['category_id' => '3', 'name' => 'Anker PowerCore 20000', 'description' => 'Портативный аккумулятор Anker PowerCore 20000 mAh: PowerIQ 2.0, VoltageBoost, два порта USB-A, до 4 заряда iPhone 13.', 'price' => 49],
            ['category_id' => '3', 'name' => 'Belkin BoostCharge Pad', 'description' => 'Беспроводное зарядное устройство Belkin BoostCharge 15 W: Qi-совместимое, защитa от перегрева, скольжения и перегрузки.', 'price' => 39],
            ['category_id' => '4', 'name' => 'Philips Hue White A19', 'description' => 'Умная LED-лампочка Philips Hue White A19: 800 lm, совместимость с Alexa, Google Home, Apple HomeKit, диммирование и расписание.', 'price' => 24],
            ['category_id' => '4', 'name' => 'TP-Link Deco M5 (3-pack)', 'description' => 'Mesh-система TP-Link Deco M5: покрытие до 450 м², AC1300 двойной диапазон, антивирус Trend Micro, родительский контроль.', 'price' => 179],
            ['category_id' => '2', 'name' => 'Netgear Nighthawk AX12', 'description' => 'Wi-Fi 6 роутер Netgear Nighthawk AX12: 12 потоков, до 6 Gbps, 4 x Gigabit LAN, 2.5G WAN, 4 x external antennas, OFDMA, MU-MIMO.', 'price' => 299],
            ['category_id' => '2', 'name' => 'Ecovacs Deebot N8 Pro', 'description' => 'Робот-пылесос Ecovacs Deebot N8 Pro: TrueMapping 2.0 Lidar, OZMO mopping, 2600 Pa suction, автоматическая зарядка и карты многоэтажек.', 'price' => 329],
            ['category_id' => '2', 'name' => 'iRobot Roomba i3+', 'description' => 'Робот-пылесос iRobot Roomba i3+: Clean Base™ автоматическая очистка, 10× мощность всасывания, smart mapping, рекомендованные уборки.', 'price' => 399],
        ]);
    
    }

}
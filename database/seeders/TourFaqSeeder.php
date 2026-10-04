<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourFaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqsData = [
            'ha-giang-loop-4-days-3-nights' => [
                [
                    'question' => 'Tour có phù hợp cho người chưa từng đi xe máy đường đèo không?',
                    'answer' => 'Hoàn toàn phù hợp nếu bạn chọn gói Easy Rider (có tài xế địa phương dày dặn kinh nghiệm cầm lái và bảo vệ an toàn suốt hành trình). Nếu bạn muốn tự lái (Self-riding), bạn cần có bằng lái quốc tế hợp lệ (IDP) và đã có kinh nghiệm lái xe số/xe côn tay trên địa hình đồi dốc dốc đứng.',
                ],
                [
                    'question' => 'Cần mang theo những vật dụng gì khi tham gia Ha Giang Loop?',
                    'answer' => 'Bạn nên mang balo nhỏ gọn khoảng 5-7kg (hành lý lớn có thể gửi miễn phí và an toàn tại văn phòng Chestnut Travel ở TP Hà Giang), áo khoác ấm (nhiệt độ về đêm ở Đồng Văn và Mèo Vạc khá thấp), kem chống nắng, kính râm, đồ bơi (khi ghé tắm thác Du Già) và thuốc cá nhân cơ bản.',
                ],
                [
                    'question' => 'Điều kiện thời tiết xấu hoặc mưa thì tour có khởi hành không?',
                    'answer' => 'Tour vẫn diễn ra bình thường nếu chỉ có mưa rào nhẹ. Đội ngũ Chestnut Travel trang bị sẵn bộ quần áo mưa chuyên dụng cao cấp, bọc chống nước cho balo và ủng đi mưa cho từng khách. Trong trường hợp có bão lũ hoặc sạt lở nguy hiểm, chúng tôi sẽ linh hoạt đổi hướng tuyến đường hoặc bảo lưu/hoàn tiền theo chính sách an toàn.',
                ],
                [
                    'question' => 'Tour có bao gồm đưa đón từ Hà Nội lên Hà Giang không?',
                    'answer' => 'Có. Tour đã bao gồm vé xe giường nằm chất lượng cao (VIP Luxury Cabin) hai chiều khứ hồi giữa Hà Nội và Hà Giang. Xe đón bạn tại các khách sạn Phố Cổ Hà Nội hoặc sân bay Nội Bài lúc 20:30 tối hôm trước và đưa về lại Hà Nội an toàn.',
                ],
            ],

            'ha-giang-loop-3-days-2-nights' => [
                [
                    'question' => 'Lịch trình 3N2Đ khác gì so với 4N3Đ?',
                    'answer' => 'Lịch trình 3N2Đ tập trung vào các điểm tinh hoa nhất của Cao nguyên đá: Cổng trời Quản Bạ, Dốc Thẩm Mã, Nhà của Pao, Cột cờ Lũng Cú và Đèo Mã Pí Lèng - Chèo thuyền Sông Nho Quế. Bạn sẽ không ghé sâu vào làng thác Du Già như tour 4 ngày, rất phù hợp cho người có quỹ thời gian hạn chế cuối tuần.',
                ],
                [
                    'question' => 'Chỗ ở trong suốt chuyến đi 3N2Đ như thế nào?',
                    'answer' => 'Bạn sẽ nghỉ 1 đêm tại khách sạn tiện nghi ở Phố cổ Đồng Văn (phòng riêng khép kín, nước nóng, điều hòa) và 1 đêm tại homestay bản địa mộc mạc nhìn ra thung lũng tại Làng văn hóa du lịch Pả Vi (Mèo Vạc) để trải nghiệm ẩm thực và âm nhạc người Mông.',
                ],
                [
                    'question' => 'Tôi có thể ăn chay hoặc kiêng khem món ăn theo yêu cầu không?',
                    'answer' => 'Có, các bữa ăn trên tour đều được nấu nóng hổi với nguyên liệu tươi sạch của vùng cao. Bạn chỉ cần thông báo trước cho chúng tôi về chế độ ăn chay, kiêng thịt heo, thịt bò hoặc dị ứng hải sản để nhà bếp phục vụ thực đơn riêng biệt.',
                ],
                [
                    'question' => 'Tôi có được đổi xe máy hoặc tài xế nếu cảm thấy chưa thoải mái không?',
                    'answer' => 'Chắc chắn được. Toàn bộ xe máy của Chestnut Travel đều được bảo dưỡng mỗi ngày sau mỗi chuyến đi. Nếu bạn cảm thấy tài xế lái quá nhanh hoặc không hợp, vui lòng báo ngay cho tour leader để chúng tôi điều chỉnh hoặc đổi tài xế ngay lập tức.',
                ],
            ],

            'sapa-trekking-muong-hoa-valley-3d2n' => [
                [
                    'question' => 'Trekking thung lũng Mường Hoa có khó không, cần chuẩn bị thể lực như thế nào?',
                    'answer' => 'Cung đường trekking ở mức độ Vừa phải (Medium), mỗi ngày đi bộ từ 9 - 14km qua các thửa ruộng bậc thang, lối mòn đất và các bản làng mộc mạc. Bạn chỉ cần có sức khỏe bình thường, yêu thích vận động ngoài trời và chuẩn bị một đôi giày leo núi/thể thao có độ bám gai tốt.',
                ],
                [
                    'question' => 'Nghỉ đêm tại Homestay người bản địa có những tiện ích gì?',
                    'answer' => 'Homestay tại Tả Van và Bản Hồ là nhà sàn gỗ truyền thống của người Giáy và người Tày nhưng đã được trang bị tiện nghi sạch sẽ: đệm êm ấm áp, màn chống muỗi, phòng tắm nóng lạnh, wifi và nhà vệ sinh riêng biệt hiện đại.',
                ],
                [
                    'question' => 'Thời điểm nào trong năm trekking Sapa đẹp nhất?',
                    'answer' => 'Mùa thu (tháng 8 - tháng 10) là mùa lúa chín vàng rực rỡ nhất trên các thửa ruộng bậc thang. Mùa xuân (tháng 2 - tháng 4) là mùa hoa đào, hoa mận nở rộ và khí hậu khô ráo, trong lành rất thích hợp cho trekking săn mây.',
                ],
                [
                    'question' => 'Hành lý nặng có phải tự mang theo khi trekking không?',
                    'answer' => 'Không cần. Bạn chỉ cần mang balo nhỏ đựng nước uống, điện thoại, máy ảnh và đồ dùng cần thiết trong ngày. Vali lớn và hành lý cồng kềnh sẽ được xe trung chuyển chở thẳng đến điểm nghỉ homestay đón sẵn bạn.',
                ],
            ],

            'ninh-binh-trang-an-mua-cave-1-day' => [
                [
                    'question' => 'Leo Đỉnh Rồng Hang Múa có dốc và nguy hiểm không?',
                    'answer' => 'Đỉnh Ngọa Long - Hang Múa có gần 500 bậc thang đá uốn lượn được xây dựng kiên cố. Đoạn đỉnh mỏm đá tự nhiên cần bước cẩn thận và mang giày thể thao chống trơn. Tầm nhìn toàn cảnh 360 độ ngắm trọn thung lũng Tam Cốc và sông Ngô Đồng từ trên đỉnh rất ngoạn mục, hoàn toàn xứng đáng với công sức chinh phục!',
                ],
                [
                    'question' => 'Đi thuyền Tràng An ngồi trong bao lâu và có phải tự chèo không?',
                    'answer' => 'Chuyến thuyền nan Tràng An kéo dài khoảng 2.5 - 3 tiếng len lỏi qua 4 hang động kỳ ảo và 3 ngôi đền cổ linh thiêng giữa làn nước trong vắt. Người chèo đò bản địa dày dặn kinh nghiệm sẽ chèo suốt hành trình, bạn có thể xin chèo phụ trải nghiệm nếu thích.',
                ],
                [
                    'question' => 'Tour có đón và trả khách tại khách sạn ở Hà Nội không?',
                    'answer' => 'Có, xe limousine Dcar cao cấp đưa đón tận nơi tại sảnh các khách sạn trong khu vực Phố Cổ Hà Nội từ 7:30 - 8:00 sáng và đưa bạn về lại khách sạn an toàn vào khoảng 18:30 cùng ngày.',
                ],
                [
                    'question' => 'Bữa trưa trong tour gồm những món gì?',
                    'answer' => 'Bữa trưa là buffet thịnh soạn hoặc set menu đặc sản Ninh Bình tại nhà hàng sinh thái, với các món nổi tiếng như dê núi nướng tảng, cơm cháy sốt dê, gà đồi và các món chay thanh đạm.',
                ],
            ],

            'ta-xua-cloud-hunting-dinosaur-spine-2d1n' => [
                [
                    'question' => 'Tỉ lệ săn được biển mây tại Tà Xùa có cao không và mùa nào đẹp nhất?',
                    'answer' => 'Mùa săn mây đẹp nhất kéo dài từ tháng 10 đến tháng 4 năm sau, với tỉ lệ mây đạt trên 75-85% khi trời se lạnh, độ ẩm cao và có nắng ấm vào ban ngày. Đội ngũ dẫn tour luôn theo dõi dự báo khí tượng và thức dậy sớm để đưa bạn đến điểm đón bình minh ngắm mây trọn vẹn nhất.',
                ],
                [
                    'question' => 'Đi bộ trên Sống lưng Khủng Long Háng Đồng có an toàn không?',
                    'answer' => 'Đoạn đường mòn sống lưng khủng long có dốc thoai thoải và gió khá mạnh. Bạn nên mang giày có gai bám, đi chậm và tuân thủ chỉ dẫn của hướng dẫn viên. Với những ai ngại đi bộ, tại đầu dốc có dịch vụ xe ôm bản địa chở xuống tận chòi vọng cảnh.',
                ],
                [
                    'question' => 'Homestay tại Tà Xùa view có đẹp không?',
                    'answer' => 'Rất đẹp! Chúng tôi chọn các homestay gỗ view panorama hướng thẳng thung lũng mây (như May Home, Tà Xùa Lu Tre hoặc Pơ Mu). Bạn có thể săn mây và thưởng thức cà phê nóng ngay từ ban công phòng ngủ.',
                ],
            ],

            'northern-vietnam-package-combo-6-days' => [
                [
                    'question' => 'Tour combo 6 ngày có bị quá gấp hoặc mệt không?',
                    'answer' => 'Lịch trình combo 6 ngày được thiết kế tối ưu với sự kết hợp thông minh giữa các chuyến xe đêm giường nằm VIP riêng tư và các chặng nghỉ ngơi hợp lý. Bạn sẽ khám phá trọn vẹn 3 điểm đến hàng đầu miền Bắc (Sapa, Hà Giang, Ninh Bình) mà không tốn thời gian quay lại Hà Nội trung gian nhiều lần.',
                ],
                [
                    'question' => 'Nếu tôi muốn nâng cấp lên phòng khách sạn 4 sao hoặc 5 sao được không?',
                    'answer' => 'Có, bạn hoàn toàn có thể yêu cầu nâng cấp hạng phòng (tại Sapa và Ninh Bình). Hãy liên hệ với tư vấn viên trước khi thanh toán để nhận báo giá chênh lệch ưu đãi nhất theo yêu cầu gia đình hoặc cặp đôi.',
                ],
                [
                    'question' => 'Chính sách hoàn hủy và dời ngày của gói combo này như thế nào?',
                    'answer' => 'Bạn có thể đổi ngày khởi hành miễn phí trước 7 ngày. Hủy tour trước 10 ngày được hoàn 100% tiền cọc, từ 5-9 ngày hoàn 50%, và dưới 5 ngày sẽ áp dụng mức phí giữ phòng của hệ thống khách sạn đối tác.',
                ],
            ],

            'ha-giang-loop-5-days-deep-frontier' => [
                [
                    'question' => 'Tour 5 ngày có đi sâu vào những bản làng ít người biết không?',
                    'answer' => 'Có, cung đường 5 ngày mở rộng tới Thượng Phùng, Xín Mần, Làng dệt lanh Lùng Tám và đi sâu vào hẻm Tu Sản thượng nguồn sông Nho Quế – nơi các tour ngắn ngày không thể tiếp cận được, mang lại trải nghiệm phiêu lưu hoang sơ tuyệt đối.',
                ],
                [
                    'question' => 'Tour này phù hợp với đối tượng khách nào?',
                    'answer' => 'Rất phù hợp với những ai yêu thích nhiếp ảnh, thích văn hóa các dân tộc Lô Lô, H\'Mông, Tày, Dao đỏ và muốn sống chậm giữa thiên nhiên kỳ vĩ nguyên sơ không xô bồ.',
                ],
                [
                    'question' => 'Tôi có được trải nghiệm chợ phiên vùng cao không?',
                    'answer' => 'Có! Nếu ngày tour rơi vào cuối tuần, hướng dẫn viên sẽ đưa bạn ghé Chợ phiên Đồng Văn hoặc Chợ phiên Mèo Vạc vào sáng Chủ Nhật để chứng kiến cảnh tượng đồng bào các dân tộc xúng xính váy hoa xuống chợ buôn bán gia súc, thổ cẩm và thưởng thức thắng cố.',
                ],
            ],

            'sapa-fansipan-peak-trekking-2d1n' => [
                [
                    'question' => 'Tour này lên đỉnh Fansipan bằng cáp treo hay leo bộ?',
                    'answer' => 'Tour đã bao gồm trọn gói vé cáp treo Sun World Fansipan Legend 3 dây hiện đại và vé tàu hỏa leo núi ngắm thung lũng Mường Hoa. Chỉ mất khoảng 20 phút là bạn đã chạm tay vào cột mốc "Nóc nhà Đông Dương" 3.143m mà không cần tốn nhiều thể lực leo trèo.',
                ],
                [
                    'question' => 'Bản Cát Cát có nhiều điểm check-in không?',
                    'answer' => 'Rất nhiều! Bản Cát Cát có cụm cối xay nước khổng lồ, cầu treo gỗ si, thác nước Tiên Sa tung bọt trắng xóa, nhà trình tường truyền thống của người H\'Mông và nhiều góc cho thuê trang phục dân tộc lộng lẫy chụp ảnh lưu niệm.',
                ],
                [
                    'question' => 'Thời tiết trên đỉnh Fansipan như thế nào, cần mặc đồ gì?',
                    'answer' => 'Nhiệt độ trên đỉnh Fansipan thường thấp hơn thị xã Sapa từ 8 - 10 độ C và gió khá to. Bạn nên mang áo khoác giữ ấm, khăn choàng, mũ len ấm và găng tay để thoải mái chụp hình check-in.',
                ],
            ],

            'ninh-binh-tam-coc-hoa-lu-cycling-2d1n' => [
                [
                    'question' => 'Đi xe đạp ở Tam Cốc có an toàn không?',
                    'answer' => 'Rất an toàn và dễ chịu. Tuyến đạp xe đi qua đường làng bê tông bằng phẳng không có dốc cao, hai bên là đồng lúa và núi đá vôi hùng vĩ, phương tiện xe cơ giới qua lại rất ít.',
                ],
                [
                    'question' => 'Thời điểm nào ngắm đàn chim ở Vườn chim Thung Nham đẹp nhất?',
                    'answer' => 'Khoảng 16:30 - 17:30 chiều là khoảnh khắc hoàng hôn ngoạn mục nhất, khi từng đàn chim hàng vạn con gồm cò trắng, vạc, le le và phượng hoàng đất bay rợp trời trở về tổ sau một ngày kiếm ăn.',
                ],
                [
                    'question' => 'Tour có ghé thăm Cố đô Hoa Lư không?',
                    'answer' => 'Có, bạn sẽ được hướng dẫn viên giới thiệu chi tiết về lịch sử triều đại Đinh - Tiền Lê thế kỷ thứ 10 tại Đền Vua Đinh Tiên Hoàng và Đền Vua Lê Đại Hành với các kiến trúc điêu khắc gỗ cổ kính.',
                ],
            ],

            'lan-ha-bay-cat-ba-kayaking-3d2n' => [
                [
                    'question' => 'Tour này chèo thuyền kayak ở những khu vực nào?',
                    'answer' => 'Bạn sẽ chèo kayak tại Hang Tối - Hang Sáng, bãi biển Ba Trái Đào và các đầm phá hoang sơ nằm sâu trong vùng lõi Khu dự trữ sinh quyển thế giới Vườn Quốc gia Cát Bà, nơi nước biển trong vắt như ngọc bích.',
                ],
                [
                    'question' => 'Có hướng dẫn viên đi cùng khi chèo kayak không?',
                    'answer' => 'Luôn có hướng dẫn viên kayak chuyên nghiệp kèm áo phao cứu sinh đạt chuẩn quốc tế, túi chống nước và xuồng cao tốc cứu hộ hỗ trợ đi sau để đảm bảo an toàn tuyệt đối.',
                ],
                [
                    'question' => 'Hoạt động trekking trong Vườn Quốc gia Cát Bà có vất vả không?',
                    'answer' => 'Đoạn trekking khoảng 5km đường rừng nhiệt đới nguyên sinh lên Đỉnh Ngự Lâm ngắm toàn cảnh đảo Cát Bà từ trên cao. Cung đường rợp bóng mát cây xanh, phù hợp cho người có thể lực trung bình.',
                ],
            ],

            'ha-long-bay-luxury-day-escape' => [
                [
                    'question' => 'Tour trong ngày có đủ thời gian thăm quan trọn vẹn Vịnh Hạ Long không?',
                    'answer' => 'Tàu cao tốc siêu du thuyền hạng sang chạy theo hải trình dài 6 tiếng (tương đương hải trình tour ngủ đêm), đưa bạn đi đủ Hang Sửng Sốt (hang động thạch nhũ lớn nhất vịnh), Đảo Ti Tốp tắm biển ngắm toàn cảnh vịnh và chèo kayak tự do tại Hang Luồn.',
                ],
                [
                    'question' => 'Bữa trưa trên tàu phục vụ buffet hay set menu?',
                    'answer' => 'Tour phục vụ tiệc buffet hải sản cao cấp với hơn 50 món ăn Á - Âu tươi sống, có tôm hấp sả, hàu nướng phô mai, mực xào cay, bò lúc lắc và quầy sushi - sashimi tươi ngon cùng hoa quả tráng miệng.',
                ],
                [
                    'question' => 'Tàu có bể sục Jacuzzi hoặc sundeck tắm nắng không?',
                    'answer' => 'Có, siêu du thuyền trang bị bể sục Jacuzzi bốn mùa lộ thiên trên tầng thượng (Sundeck) cùng ghế nằm tắm nắng hiện đại để bạn vừa ngâm mình thư giãn vừa ngắm nhìn kỳ quan thiên nhiên thế giới.',
                ],
            ],
        ];

        foreach ($faqsData as $slug => $faqs) {
            $tour = Tour::where('slug', 'like', "%{$slug}%")->first();
            if ($tour) {
                $tour->update(['faqs' => $faqs]);
                $this->command->info("Updated FAQs for tour: {$tour->title}");
            }
        }
    }
}

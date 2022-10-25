<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    private array $reviews = [
        'short' => [
            'good' => [
                'Bạn biết vận dụng kiến thức đã học vào code, có khả năng tư duy tốt.',
                'Bạn học tập trung, chú ý nghe giảng',
                'Bạn hiểu bài nhanh tuy nhiên hơi ít giao tiếp',
                'Bạn hiểu bài nhanh, chủ động trao đổi với thầy và các bạn',
                'Bạn học tập trung, hiểu bài khá nhanh và chủ động hỏi những phần thắc mắc',
                'Bạn tiếp thu nhanh, tuy nhiên chưa thực sự biết cách vận dụng vào sản phẩm',
                'Bạn có ý thức tự giác học tập, tuy nhiên bài tập chưa làm đầy đủ',
                'Bạn rất chủ động trong học tập, tích cực trao đổi với thầy',
                'Bạn hiểu bài nhanh, biết cách vận dụng và sáng tạo',
                'Bạn hiểu bài nhanh, chắc kiến thức',
                'Bạn hiểu bài nhanh, chủ động trong học tập',
                'Bạn hiểu bài nhanh tuy nhiên chưa tích cực tham gia phát biểu',
                'Bạn hiểu bài nhanh, tích cực trao đổi với thầy và các bạn',
                'Bạn hiểu bài nhanh, học tập trung',
                'Bạn học tập trung, hiểu bài nhanh tuy nhiên thao tác còn hơi chậm',
                'Bạn hiểu bài nhanh, tuy nhiên chưa tích cực trao đổi',
                'Em có thái độ học tập tốt, tuy nhiên lại chưa bật cam. Em năng động và giao tiếp tốt, có sự chủ động học tập.',
                'Em cần năng động hơn, tương tác tốt hơn để bài giảng đạt hiệu quả cao.',
                'Em khá chăm chú nghe giảng, khi gặp vấn đề em chủ động hỏi.',
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->reviews as $type => $levels) {
            $isShort = $type === 'short';
            foreach ($levels as $level => $reviews) {
                foreach ($reviews as $review) {
                    Review::create([
                        'level' => $level,
                        'is_short' => $isShort,
                        'review' => $review,
                    ]);
                }
            }
        }
    }
}

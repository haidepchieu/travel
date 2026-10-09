<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'destination_id',
        'excerpt',
        'content',
        'featured_image',
        'author_name',
        'author_avatar',
        'tags',
        'is_published',
        'is_featured',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    protected $appends = [
        'image_url',
    ];

    /**
     * Post types. The key is stored on the post and shown to customers as the article label.
     */
    public const CATEGORIES = [
        'Travel Guide' => 'Travel Guide — Cẩm nang du lịch',
        'Food & Culture' => 'Food & Culture — Ẩm thực & Văn hóa',
        'News & Offers' => 'News & Offers — Tin tức & Ưu đãi',
        'About Us' => 'About Us — Trang giới thiệu',
    ];

    /**
     * Explanation shown to admins under the type field for the selected type.
     */
    public const CATEGORY_HINTS = [
        'Travel Guide' => 'Bài chia sẻ kinh nghiệm, cách chuẩn bị và lưu ý khi đi du lịch. Ví dụ: trekking cho người mới, đi Hà Giang cần mang gì, mùa lúa chín đẹp nhất khi nào. Nếu bài nói về một nơi cụ thể, hãy chọn thêm "Điểm đến liên quan" bên dưới.',
        'Food & Culture' => 'Bài về món ăn đặc sản, lễ hội, phong tục và đời sống người bản địa. Ví dụ: thắng cố Hà Giang, chợ phiên Đồng Văn.',
        'News & Offers' => 'Bài thông báo, khuyến mãi hoặc giới thiệu tour mới. Ví dụ: ưu đãi mùa thu, ra mắt tour Tà Xùa.',
        'About Us' => 'Trang giới thiệu công ty, chính sách. Không phải bài blog thông thường nên thường không cần chọn điểm đến.',
    ];

    public function destination(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->featured_image)) {
            return Str::startsWith($this->featured_image, ['http://', 'https://'])
                ? $this->featured_image
                : asset('storage/' . ltrim($this->featured_image, '/'));
        }

        return asset('storage/posts/trekking-beginners.png');
    }

    public function getFormattedDateAttribute(): string
    {
        $date = $this->published_at ?? $this->created_at;
        return $date ? $date->format('F j, Y') : now()->format('F j, Y');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

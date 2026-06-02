<?php

namespace App\Observers;

use App\Service;
use Illuminate\Support\Str;

class ProductObserver
{
    private const STORE_NAME = 'تيانيل';

    public function creating(Service $service): void
    {
        $this->fillSeoFields($service, true);
    }

    public function updating(Service $service): void
    {
        $this->fillSeoFields($service, false);
    }

    private function fillSeoFields(Service $service, bool $creating): void
    {
        $title = trim(strip_tags((string) $service->title));

        if ($creating || blank($service->slug) || ($service->isDirty('title') && !$service->isDirty('slug'))) {
            $service->slug = $this->uniqueSlug($this->baseSlug($title), $service->id);
        } elseif ($service->isDirty('slug')) {
            $service->slug = $this->uniqueSlug($this->baseSlug($service->slug), $service->id);
        }

        if ($creating || blank($service->meta_title) || ($service->isDirty('title') && !$service->isDirty('meta_title'))) {
            $service->meta_title = $this->metaTitle($title);
        }

        if (
            $creating
            || blank($service->meta_description)
            || (($service->isDirty('summry') || $service->isDirty('body') || $service->isDirty('title')) && !$service->isDirty('meta_description'))
        ) {
            $service->meta_description = $this->metaDescription($service, $title);
        }
    }

    private function baseSlug(?string $value): string
    {
        $value = trim(strip_tags((string) $value));
        $slug = Str::slug($value, '-', 'ar');

        if (blank($slug)) {
            $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}]+/u', '-', $value);
            $slug = trim((string) $slug, '-');
            $slug = Str::lower($slug);
        }

        $slug = preg_replace('/-+/u', '-', (string) $slug);

        return trim($slug, '-') ?: 'product';
    }

    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = Str::limit($baseSlug, 170, '');
        $candidate = $slug;
        $counter = 2;

        while ($this->slugExists($candidate, $ignoreId)) {
            $suffix = '-' . $counter++;
            $candidate = Str::limit($slug, 170 - strlen($suffix), '') . $suffix;
        }

        return $candidate;
    }

    private function slugExists(string $slug, ?int $ignoreId): bool
    {
        $query = Service::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '<>', $ignoreId);
        }

        return $query->exists();
    }

    private function metaTitle(string $title): string
    {
        $title = $title ?: 'منتج نسائي فاخر';

        return Str::limit($title . ' | ' . self::STORE_NAME, 70, '');
    }

    private function metaDescription(Service $service, string $title): string
    {
        $source = $service->summry ?: $service->body ?: $title;
        $description = html_entity_decode(strip_tags((string) $source), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $description = trim((string) preg_replace('/\s+/u', ' ', $description));

        if (blank($description)) {
            $description = 'تسوقي ' . ($title ?: 'منتجك المفضل') . ' من متجر تيانيل بتجربة راقية وشحن داخل المملكة العربية السعودية.';
        }

        return Str::limit($description, 155, '');
    }
}

<?php

namespace App\Support;

use Illuminate\Support\Str;

class EmailCompliance
{
    public static function cleanSubject(?string $subject): string
    {
        $subject = trim((string) $subject);
        $subject = preg_replace('/[\r\n]+/', ' ', $subject);

        return Str::limit($subject ?: config('app.name', 'تيانيل'), 120, '');
    }

    public static function plainText(?string $html): string
    {
        $text = (string) $html;
        $text = preg_replace('/<\s*br\s*\/?>/i', "\n", $text);
        $text = preg_replace('/<\/\s*(p|div|li|h1|h2|h3|h4)\s*>/i', "\n", $text);
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace("/[ \t]+/", ' ', $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        return trim($text);
    }

    public static function listId(): string
    {
        $domain = parse_url(config('app.url'), PHP_URL_HOST) ?: 'tyanil.com';
        $domain = preg_replace('/^www\./', '', $domain);

        return 'Tyanil Customers <customers.' . $domain . '>';
    }
}

<?php

namespace App\Support;

class SafeHtml
{
    public static function clean($html): string
    {
        $html = (string) $html;

        if (!class_exists(\HTMLPurifier::class)) {
            return e(strip_tags($html));
        }

        $cachePath = storage_path('framework/cache/htmlpurifier');
        if (!is_dir($cachePath)) {
            @mkdir($cachePath, 0755, true);
        }

        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', $cachePath);
        $config->set('HTML.Allowed', implode(',', [
            'p', 'br', 'strong', 'b', 'em', 'i', 'u',
            'ul', 'ol', 'li', 'blockquote',
            'h2', 'h3', 'h4', 'h5', 'h6',
            'a[href|target|rel]',
            'img[src|alt|title|width|height]',
            'table', 'thead', 'tbody', 'tr', 'th', 'td',
            'span[class]', 'div[class]',
        ]));
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true,
            'tel' => true,
        ]);

        return (new \HTMLPurifier($config))->purify($html);
    }
}

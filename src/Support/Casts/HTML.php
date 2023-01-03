<?php

namespace Support\Casts;

use DOMDocument;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class HTML implements CastsAttributes
{
    public function get($model, string $key, mixed $value, array $attributes): string
    {
        $dom = new DOMDocument();
        $dom->loadHTML('<html>' . $value . '</html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $scripts = $dom->getElementsByTagName('script');
        foreach ($scripts as $script) {
            $script->parentNode->removeChild($script);
        }

        return trim(str_replace(['<html>', '</html>'], '', $dom->saveHTML()));
    }

    public function set($model, string $key, mixed $value, array $attributes): string
    {
        $dom = new DOMDocument();
        $dom->loadHTML('<html>' . $value . '</html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $scripts = $dom->getElementsByTagName('script');
        foreach ($scripts as $script) {
            $script->parentNode->removeChild($script);
        }

        return trim(str_replace(['<html>', '</html>'], '', $dom->saveHTML()));
    }
}

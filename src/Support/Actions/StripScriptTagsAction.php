<?php

namespace Support\Actions;

use DOMDocument;
use DOMElement;
use DOMText;
use Illuminate\Support\Str;

class StripScriptTagsAction
{
    public function execute(?string $html): string
    {
        if (! $html) {
            return '';
        }

        $innerHTML = Str::of($html)
            ->after('</head>')
            ->before('</html>');

        $dom = new DOMDocument();
        $dom->loadHTML('<div>' . $innerHTML . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $scripts = $dom->getElementsByTagName('script');
        foreach ($scripts as $script) {
            $script->parentNode->removeChild($script);
        }

        return collect($dom->documentElement->childNodes)
            ->map(
                fn (DomElement | DomText $element) =>
                $dom->saveHTML($element)
            )->join('');
    }
}

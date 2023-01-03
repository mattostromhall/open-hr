<?php

namespace Support\Actions;

use DOMDocument;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class StripScriptTagsAction
{
    public function execute(string $html): Stringable
    {
        $innerHTML = Str::of($html)
            ->after('</head>')
            ->before('</html>');

        $dom = new DOMDocument();
        $dom->loadHTML('<html>' . $innerHTML . '</html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $scripts = $dom->getElementsByTagName('script');
        foreach ($scripts as $script) {
            $script->parentNode->removeChild($script);
        }

        return Str::of($dom->saveHTML())
            ->after('<html>')
            ->before('</html>')
            ->trim();
    }
}
